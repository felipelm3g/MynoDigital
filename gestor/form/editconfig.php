<?php

require_once "../../class/Database.php";

$regexnome = '/^[a-zA-ZÀ-ú0-9 ÃãÕõÑñ]*$/';

$retorno = [
    "status" => false,
    "mensagem" => "",
];

$index = "";
$value = "";
$empresa = "";

$conn = Database::conectar();

try {
    //Validando Empresa
    if (!isset($_SESSION['USER']['EMPR']['CODG'])) {
        session_start();
        if (!isset($_SESSION['USER']['EMPR']['CODG'])) {
            throw new Exception("Empresa não identificada");
        }
    }
    $empresa = $_SESSION['USER']['EMPR']['CODG'];

    //Validando Index
    if (!isset($_POST['index'])) {
        throw new Exception("Parametro Index não foi enviado");
    } else {
        if (empty($_POST['index'])) {
            throw new Exception("Parametro Index está vazio");
        }
    }
    $index = $_POST['index'];

    //Validando Value
    if (!isset($_POST['value'])) {
        throw new Exception("Parametro Value não foi enviado");
    } else {
        if ($_POST['value'] == "") {
            throw new Exception("Parametro Value está vazio");
        }
    }
    $value = $_POST['value'];

    switch ($index) {

        case "viewnameempresa":

            if (!preg_match($regexnome, $value)) {
                throw new Exception("Formato invalido");
            }

            $sql = "UPDATE T_EMPRESAS SET EMP_NOME = :NOME WHERE EMP_CODG = :CODG;";
            $stmt = $conn->prepare($sql);

            $stmt->bindParam(':CODG', $empresa);
            $stmt->bindParam(':NOME', $value);

            if (!$stmt->execute()) {
                throw new Exception("[!] - Erro Banco de Dados - Cadastro Usuario");
            }
            break;

        case "viewcliente":

            $value = intval($value);

            $sql = "UPDATE T_CONFIG SET CFG_CEXB = :CEXB WHERE CFG_CODE = :CODE;";
            $stmt = $conn->prepare($sql);

            $stmt->bindParam(':CODE', $empresa);
            $stmt->bindParam(':CEXB', $value);

            if (!$stmt->execute()) {
                throw new Exception("[!] - Erro Banco de Dados - Cadastro Usuario");
            }
            break;

        default:
            throw new Exception("Parametro index invalido");
            break;
    }

    $retorno["status"] = true;
    $retorno["mensagem"] = "Alterado com sucesso";
} catch (Exception $exc) {
    $retorno["status"] = false;
    $retorno["mensagem"] = $exc->getMessage();
}

$conn = Database::desconectar();

http_response_code(200);
echo json_encode($retorno, JSON_UNESCAPED_UNICODE, JSON_PRETTY_PRINT);
exit();
