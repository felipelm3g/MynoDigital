<?php

require_once "../../class/Database.php";

if (!isset($_GET['ext'])) {
    header("Location: ../configuracoes");
    exit();
} else {
    if ($_GET['ext'] == "") {
        header("Location: ../configuracoes");
        exit();
    }
}

if (!isset($_GET['stt'])) {
    header("Location: ../configuracoes");
    exit();
} else {
    if ($_GET['stt'] == "") {
        header("Location: ../configuracoes");
        exit();
    }
}

if (!isset($_SESSION['USER']['EMPR']['CODG'])) {
    session_start();
    if (!isset($_SESSION['USER']['EMPR']['CODG'])) {
        header("Location: ../configuracoes");
        exit();
    }
}

$empresa = $_SESSION['USER']['EMPR']['CODG'];

$ext = $_GET['ext'];
$stt = $_GET['stt'];

$conn = Database::conectar();

switch ($ext) {
    case "mesa":
        $sql = "UPDATE T_EMPRESAS SET EMP_MESA = :MESA WHERE EMP_CODG = :CODG;";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':CODG', $empresa);
        $stmt->bindParam(':MESA', $stt);
        $stmt->execute();
        break;

    case "cozinha":
        $sql = "UPDATE T_EMPRESAS SET EMP_COZI = :COZI WHERE EMP_CODG = :CODG;";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':CODG', $empresa);
        $stmt->bindParam(':COZI', $stt);
        $stmt->execute();
        break;

    case "entrega":
        $sql = "UPDATE T_EMPRESAS SET EMP_ENTR = :ENTR WHERE EMP_CODG = :CODG;";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':CODG', $empresa);
        $stmt->bindParam(':ENTR', $stt);
        $stmt->execute();
        break;

    case "integracao":
        $sql = "UPDATE T_EMPRESAS SET EMP_INTG = :INTG WHERE EMP_CODG = :CODG;";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':CODG', $empresa);
        $stmt->bindParam(':INTG', $stt);
        $stmt->execute();
        break;
}

$conn = Database::desconectar();

header("Location: ../configuracoes");
exit();
