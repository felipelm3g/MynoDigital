<?php

date_default_timezone_set('America/Fortaleza');

require_once "Database.php";
require_once "Empresa.php";

class Login {

    private $return = [
        'cod' => 999,
        'msg' => "N/A",
        'dad' => []
    ];

    private function ClearReturn() {
        $this->return['cod'] = 999;
        $this->return['msg'] = "N/A";
        $this->return['dad'] = [];
    }

    public function __construct() {
        
    }

    public function CheckEmailExist($e) {
        $rtt = true;

        $email = strtoupper($e);

        try {
            $conn = Database::conectar();

            $sql = "SELECT COUNT(USR_CODG) FROM T_USUARIO WHERE UPPER(USR_EMAL) = '{$email}'";
            $stmt = $conn->query($sql);

            if ($stmt->fetchColumn() > 0) {
                $rtt = true;
            } else {
                $rtt = false;
            }

            $conn = Database::desconectar();
        } catch (Exception $exc) {
            $rtt = false;
        }

        return $rtt;
    }

    public function CheckUserExist($u) {
        $rtt = true;

        $user = strtoupper($u);
        
        try {
            $conn = Database::conectar();

            $sql = "SELECT COUNT(USR_CODG) FROM T_USUARIO WHERE UPPER(USR_NICK) = '{$user}'";
            $stmt = $conn->query($sql);

            if ($stmt->fetchColumn() > 0) {
                $rtt = true;
            } else {
                $rtt = false;
            }

            $conn = Database::desconectar();
        } catch (Exception $exc) {
            $rtt = false;
        }

        return $rtt;
    }

    public function NovoCadastro($emp, $nom, $p, $mail, $user, $pass, $pass2) {
        $this->ClearReturn();

        $conn = Database::conectar();
        $conn->beginTransaction();

        try {

            if (base64_encode($pass) !== base64_encode($pass2)) {
                throw new Exception("Senhas não condizem");
            }
            
            $empresa = new Empresa();
            
            $codigo = date("ymdhis");
            $senha = base64_encode($pass);
            $cardapio = $empresa->GerarCodCard();
            $tokenApi = $empresa->GerarTokenApi();

            $sql = "INSERT INTO T_EMPRESAS (EMP_CODG, EMP_NOME, EMP_CARD, EMP_PLNO, EMP_TOKN) VALUES (:COD, :NOME, :CARD, :PLNO, :TOKN)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':COD', $codigo);
            $stmt->bindParam(':NOME', $emp);
            $stmt->bindParam(':CARD', $cardapio);
            $stmt->bindParam(':PLNO', $p);
            $stmt->bindParam(':TOKN', $tokenApi);
            if (!$stmt->execute()) {
                throw new Exception("[!] - Erro Banco de Dados - Cadastro Empresa");
            }

            if ($this->CheckEmailExist($mail)) {
                throw new Exception("E-mail já cadastrado");
            }

            if ($this->CheckUserExist($user)) {
                throw new Exception("Usuário já cadastrado");
            }

            $stmt = $conn->prepare("INSERT INTO T_USUARIO (USR_CODG, USR_EMAL, USR_NOME, USR_NICK, USR_PASS) VALUES (:CODG, :EMAL, :NOME, :NICK, :PASS)");
            $stmt->bindParam(':CODG', $codigo);
            $stmt->bindParam(':EMAL', $mail);
            $stmt->bindParam(':NOME', $nom);
            $stmt->bindParam(':NICK', $user);
            $stmt->bindParam(':PASS', $senha);
            if (!$stmt->execute()) {
                throw new Exception("[!] - Erro Banco de Dados - Cadastro Usuario");
            }

            $stmt = $conn->prepare("INSERT INTO T_ACESSO (ACC_CODE, ACC_CODU) VALUES (:CODE, :CODU)");
            $stmt->bindParam(':CODE', $codigo);
            $stmt->bindParam(':CODU', $codigo);
            if (!$stmt->execute()) {
                throw new Exception("[!] - Erro Banco de Dados - Cadastro Acesso");
            }

            $conn->commit();
            $this->return['cod'] = 200;
            $this->return['msg'] = "Criado com Sucesso";
            $this->return['dad'] = [];
        } catch (Exception $exc) {

            $conn->rollBack();
            $this->return['cod'] = 500;
            $this->return['msg'] = $exc->getMessage();
        }

        $conn = Database::desconectar();

        return $this->return;
    }

    public function FazerLogin($u, $p) {
        $this->ClearReturn();

        try {

            $regex = '/^[a-zA-Z0-9_.-]{3,15}$/';

            $user = strtoupper($u);

            if (!preg_match($regex, $u)) {
                throw new Exception("Usuário em formato inválido");
            }

            $conn = Database::conectar();
            $sql = "SELECT * FROM T_USUARIO WHERE UPPER(USR_NICK) = '{$user}'";
            $stmt = $conn->query($sql);
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
            $conn = Database::desconectar();

            if (empty($usuario)) {
                throw new Exception("Usuário não cadastrado");
            } else {
                if (base64_encode($p) === $usuario['USR_PASS']) {

                    $array = [
                        'CODG' => $usuario['USR_CODG'],
                        'EMPR' => [],
                        'EMAL' => $usuario['USR_EMAL'],
                        'NOME' => $usuario['USR_NOME'],
                        'IMAG' => $usuario['USR_IMAG'],
                        'NICK' => $usuario['USR_NICK'],
                        'CNFR' => $usuario['USR_CNFR'],
                        'STTS' => $usuario['USR_STTS'],
                    ];

                    try {
                        session_start();
                    } catch (Exception $exc) {
                        
                    }
                    $_SESSION['USER'] = $array;
                } else {
                    throw new Exception("Senha incorreta");
                }
            }

            $this->return['cod'] = 200;
            $this->return['msg'] = "Sucesso";
            $this->return['dad'] = [];
        } catch (Exception $exc) {
            $this->return['cod'] = 500;
            $this->return['msg'] = $exc->getMessage();
        }

        return $this->return;
    }

    public function RefreshLogin() {
        try {

            $conn = Database::conectar();
            $sql = "SELECT * FROM T_ACESSO AS A INNER JOIN T_USUARIO AS B ON A.ACC_CODU=B.USR_CODG INNER JOIN T_EMPRESAS AS C ON A.ACC_CODE=C.EMP_CODG WHERE A.ACC_CODU = {$_SESSION['USER']['CODG']} AND A.ACC_CODE = {$_SESSION['USER']['EMPR']['CODG']};";
            $stmt = $conn->query($sql);
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
            $conn = Database::desconectar();

            if (empty($usuario)) {
                throw new Exception("[!] - Erro cadastro não localizado para o Usuário na empresa logada");
            }

            $array = [
                'CODG' => $usuario['USR_CODG'],
                'EMPR' => [],
                'EMAL' => $usuario['USR_EMAL'],
                'NOME' => $usuario['USR_NOME'],
                'IMAG' => $usuario['USR_IMAG'],
                'NICK' => $usuario['USR_NICK'],
                'CNFR' => $usuario['USR_CNFR'],
                'STTS' => $usuario['USR_STTS'],
            ];

            $_SESSION['USER'] = $array;

            $array = [
                'CODG' => $usuario['EMP_CODG'],
                'NOME' => $usuario['EMP_NOME'],
                'MESA' => boolval($usuario['EMP_MESA']),
                'COZI' => boolval($usuario['EMP_COZI']),
                'ENTR' => boolval($usuario['EMP_ENTR']),
                'INTG' => boolval($usuario['EMP_INTG']),
                'NIVL' => $usuario['ACC_NIVL'],
            ];

            $_SESSION['USER']['EMPR'] = $array;
        } catch (Exception $exc) {
            session_start();
            $_SESSION['USER'] = array();
            session_unset();
            session_destroy();

            header('Location: main');
            exit();
        }
    }

    public function getConfig() {
        if (!isset($_SESSION['USER']['EMPR']['CODG'])) {
            session_start();
            if (!isset($_SESSION['USER']['EMPR']['CODG'])) {
                return "";
            }
        }
        $emp = $_SESSION['USER']['EMPR']['CODG'];
        $conn = Database::conectar();
        $sql = "SELECT * FROM T_CONFIG WHERE CFG_CODE = '{$emp}'";
        $stmt = $conn->query($sql);
        $config = $stmt->fetch(PDO::FETCH_ASSOC);
        if (empty($config)) {
            $stmt = $conn->prepare("INSERT INTO T_CONFIG (CFG_CODE) VALUES (:CODE)");
            $stmt->bindParam(':CODE', $emp);
            if ($stmt->execute()) {
                $sql = "SELECT * FROM T_CONFIG WHERE CFG_CODE = '{$emp}'";
                $stmt = $conn->query($sql);
                $config = $stmt->fetch(PDO::FETCH_ASSOC);
            } else {
                return "";
            }
        }
        $conn = Database::desconectar();
        return $config;
    }

}
