<?php

date_default_timezone_set('America/Fortaleza');
session_start();
if (!isset($_SESSION['USER'])) {
    session_destroy();
    header("Location: index");
    exit();
} else {
    try {
        require_once "../../class/Database.php";

        $cod = $_GET['cod'];

        $conn = Database::conectar();
        $sql = "SELECT * FROM T_ACESSO AS A INNER JOIN T_EMPRESAS AS B ON A.ACC_CODE = B.EMP_CODG WHERE  A.ACC_CODE = {$cod} AND A.ACC_CODU = {$_SESSION['USER']['CODG']};";
        $stmt = $conn->query($sql);
        $empresa = $stmt->fetch(PDO::FETCH_ASSOC);
        $conn = Database::desconectar();

        if (empty($empresa)) {
            throw new Exception("[!] - Erro empresa não localizada para o Usuário");
        }

        $array = [
            'CODG' => $empresa['EMP_CODG'],
            'NOME' => $empresa['EMP_NOME'],
            'MESA' => boolval($empresa['EMP_MESA']),
            'COZI' => boolval($empresa['EMP_COZI']),
            'ENTR' => boolval($empresa['EMP_ENTR']),
            'INTG' => boolval($empresa['EMP_INTG']),
            'NIVL' => intval($empresa['ACC_NIVL']),
        ];

        $_SESSION['USER']['EMPR'] = $array;

        header("Location: ../index");
        exit();
    } catch (Exception $exc) {
        echo $exc->getTraceAsString();
        exit();
    }
}
?>