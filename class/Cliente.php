<?php

require_once "Database.php";

class Cliente {

    private $CLI_CODG;
    private $CLI_CODE;
    private $CLI_NOME;
    private $CLI_TELF;
    private $CLI_ADRS;
    private $CLI_NUMB;
    private $CLI_CPLT;
    private $CLI_BAIR;
    private $CLI_CITY;
    private $CLI_ESTD;
    private $CLI_REFR;
    private $CLI_NCEP;
    private $CLI_PED1;
    private $CLI_FIDL;
    private $CLI_WALT;
    private $CLI_ULTP;
    private $CLI_PASS;
    private $CLI_STTS;
    private $CLI_KEYE;
    private $CLI_KEYM;
    private $CLI_RATE;
    private $CLI_DATC;
    private $CLI_DATA;

    public function __construct() {
        
    }

    public function get($stt = 'all') {
        $conn = Database::conectar();
        if ($stt == 'all') {
            
        } else {
            
        }
        $conn = Database::desconectar();
    }

    public function CheckTelExist($tel) {
        $rtt = true;

        $telefone = preg_replace("/[^0-9]/", "", $tel);

        try {
            $conn = Database::conectar();

            if (!isset($_SESSION['USER']['EMPR']['CODG'])) {
                session_start();
                if (!isset($_SESSION['USER']['EMPR']['CODG'])) {
                    throw new Exception("Empresa não identificada");
                }
            }

            $sql = "SELECT COUNT(CLI_CODG) FROM T_CLIENTE WHERE CLI_TELF = '{$telefone}' AND CLI_CODE = '{$_SESSION['USER']['EMPR']['CODG']}'";
            $stmt = $conn->query($sql);

            if ($stmt->fetchColumn() > 0) {
                $rtt = true;
            } else {
                $rtt = false;
            }

            $conn = Database::desconectar();
        } catch (Exception $exc) {
            $rtt = true;
        }

        return $rtt;
    }

    public function ModifyCliente($array, $c = "I") {

        $retorno = [
            "status" => false,
            "mensagem" => "",
        ];

        $types = ["I", "U"];

        if (!in_array($c, $types)) {
            throw new Exception("Parâmetros errados");
        }

        $conn = Database::conectar();

        try {
            if (!isset($_SESSION['USER']['EMPR']['CODG'])) {
                session_start();
                if (!isset($_SESSION['USER']['EMPR']['CODG'])) {
                    throw new Exception("Empresa não identificada");
                }
            }

            $this->CLI_CODE = $_SESSION['USER']['EMPR']['CODG'];

            $this->CLI_NOME = $array['NOME'];
            $this->CLI_TELF = $array['TELF'];
            $this->CLI_ADRS = $array['ADRS'];
            $this->CLI_NUMB = $array['NUMB'];
            $this->CLI_CPLT = $array['CPLT'];
            $this->CLI_BAIR = $array['BAIR'];
            $this->CLI_CITY = $array['CITY'];
            $this->CLI_ESTD = $array['ESTD'];
            $this->CLI_REFR = $array['REFR'];
            $this->CLI_NCEP = $array['NCEP'];
            $this->CLI_DATC = date("ymdhis");
            $this->CLI_DATA = date("ymdhis");

            if ($c == "I") {
                $this->CLI_CODG = date("ymdhis");
                $sql = "INSERT INTO T_CLIENTE (CLI_CODG, CLI_CODE, CLI_NOME, CLI_TELF, CLI_ADRS, CLI_NUMB, CLI_CPLT, CLI_BAIR, CLI_CITY, CLI_ESTD, CLI_REFR, CLI_NCEP, CLI_DATC, CLI_DATA) VALUES (:CLI_CODG, :CLI_CODE, :CLI_NOME, :CLI_TELF, :CLI_ADRS, :CLI_NUMB, :CLI_CPLT, :CLI_BAIR, :CLI_CITY, :CLI_ESTD, :CLI_REFR, :CLI_NCEP, :CLI_DATC, :CLI_DATA);";
            }
            if ($c == "U") {
                $this->CLI_CODG = $array['CODG'];
                $sql = "UPDATE T_CLIENTE SET CLI_NOME = :CLI_NOME, CLI_TELF = :CLI_TELF, CLI_ADRS = :CLI_ADRS, CLI_NUMB = :CLI_NUMB, CLI_CPLT = :CLI_CPLT, CLI_BAIR = :CLI_BAIR, CLI_CITY = :CLI_CITY, CLI_ESTD = :CLI_ESTD, CLI_REFR = :CLI_REFR, CLI_NCEP = :CLI_NCEP, CLI_DATA = :CLI_DATA WHERE CLI_CODG = :CLI_CODG AND CLI_CODE = :CLI_CODE;";
            }

            $stmt = $conn->prepare($sql);

            $stmt->bindParam(':CLI_CODG', $this->CLI_CODG);
            $stmt->bindParam(':CLI_CODE', $this->CLI_CODE);
            $stmt->bindParam(':CLI_NOME', $this->CLI_NOME);
            $stmt->bindParam(':CLI_TELF', $this->CLI_TELF);
            $stmt->bindParam(':CLI_ADRS', $this->CLI_ADRS);
            $stmt->bindParam(':CLI_NUMB', $this->CLI_NUMB);
            $stmt->bindParam(':CLI_CPLT', $this->CLI_CPLT);
            $stmt->bindParam(':CLI_BAIR', $this->CLI_BAIR);
            $stmt->bindParam(':CLI_CITY', $this->CLI_CITY);
            $stmt->bindParam(':CLI_ESTD', $this->CLI_ESTD);
            $stmt->bindParam(':CLI_REFR', $this->CLI_REFR);
            $stmt->bindParam(':CLI_NCEP', $this->CLI_NCEP);
            if ($c == "I") {
                $stmt->bindParam(':CLI_DATC', $this->CLI_DATC);
            }
            $stmt->bindParam(':CLI_DATA', $this->CLI_DATA);

            if (!$stmt->execute()) {
                throw new Exception("[!] - Erro Banco de Dados");
            }

            $retorno["status"] = true;
            $retorno["mensagem"] = $this->CLI_CODG;
        } catch (Exception $exc) {
            $retorno["status"] = false;
            $retorno["mensagem"] = $exc->getMessage();
        }
        $conn = Database::desconectar();

        return $retorno;
    }

}
