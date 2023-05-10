<?php

require_once "../../class/Cliente.php";

$retorno = [
    "status" => false,
    "mensagem" => "",
];

try {

    if (!isset($_POST['nome'])) {
        throw new Exception("Parametro Nome não foi enviado");
    }

    if (!isset($_POST['tel'])) {
        throw new Exception("Parametro Telefone não foi enviado");
    }

    if (!isset($_POST['cep'])) {
        throw new Exception("Parametro CEP não foi enviado");
    }

    if (!isset($_POST['rua'])) {
        throw new Exception("Parametro Rua não foi enviado");
    }

    if (!isset($_POST['num'])) {
        throw new Exception("Parametro Numero não foi enviado");
    }

    if (!isset($_POST['cmp'])) {
        throw new Exception("Parametro Complemento não foi enviado");
    }

    if (!isset($_POST['ref'])) {
        throw new Exception("Parametro Referencia não foi enviado");
    }

    if (!isset($_POST['bai'])) {
        throw new Exception("Parametro Bairro não foi enviado");
    }

    if (!isset($_POST['cid'])) {
        throw new Exception("Parametro Cidade não foi enviado");
    }

    if (!isset($_POST['est'])) {
        throw new Exception("Parametro Estado não foi enviado");
    }

    $nom = $_POST['nome'];
    $tel = $_POST['tel'];
    $cep = $_POST['cep'];
    $rua = $_POST['rua'];
    $num = $_POST['num'];
    $cmp = $_POST['cmp'];
    $ref = $_POST['ref'];
    $bai = $_POST['bai'];
    $cid = $_POST['cid'];
    $est = $_POST['est'];

    //Validando Nome
    $tel = preg_replace("/[^0-9]/", "", $tel);
    if (strlen($tel) != 10) {
        if (strlen($tel) != 11) {
            throw new Exception("Telefone inválido");
        }
    }

    //Validando CEP
    $cep = preg_replace("/[^0-9]/", "", $cep);
    if (!empty($cep)) {
        if (strlen($cep) != 8) {
            throw new Exception("CEP inválido");
        }
    }

    //Validando estado
    $est = strtoupper($est);
    if (!empty($est)) {
        if (strlen($est) != 2) {
            throw new Exception("UF inválido");
        }
    }

    $dados = [
        "CODG" => "",
        "NOME" => $nom,
        "TELF" => $tel,
        "ADRS" => $rua,
        "NUMB" => $num,
        "CPLT" => $cmp,
        "BAIR" => $bai,
        "CITY" => $cid,
        "ESTD" => $est,
        "REFR" => $ref,
        "NCEP" => $cep,
    ];

    $cliente = new Cliente();
    if ($cliente->CheckTelExist($tel)) {
        throw new Exception("Telefone já cadastrado");
    }
    
    $retorno = $cliente->ModifyCliente($dados, "I");
} catch (Exception $exc) {
    $retorno["status"] = false;
    $retorno["mensagem"] = $exc->getMessage();
}

http_response_code(200);
echo json_encode($retorno, JSON_UNESCAPED_UNICODE, JSON_PRETTY_PRINT);
exit();

