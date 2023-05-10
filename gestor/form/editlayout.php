<?php

require_once "../../class/Database.php";

if (!isset($_GET['lyt'])) {
    header("Location: ../configuracoes#viewsistema");
    exit();
} else {
    if ($_GET['lyt'] == "") {
        header("Location: ../configuracoes#viewsistema");
        exit();
    }
}

if (!isset($_SESSION['USER']['EMPR']['CODG'])) {
    session_start();
    if (!isset($_SESSION['USER']['EMPR']['CODG'])) {
        header("Location: ../configuracoes#viewsistema");
        exit();
    }
}

$empresa = $_SESSION['USER']['EMPR']['CODG'];

$layout = $_GET['lyt'];
$layout = intval($layout);

$conn = Database::conectar();

$sql = "UPDATE T_CONFIG SET CFG_LTCD = :LTCD WHERE CFG_CODE = :CODE;";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':CODE', $empresa);
$stmt->bindParam(':LTCD', $layout);
$stmt->execute();

$conn = Database::desconectar();

header("Location: ../configuracoes#viewsistema");
exit();
