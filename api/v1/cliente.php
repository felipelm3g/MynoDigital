<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Credentials: true');
header("Access-Control-Max-Age: 86400");
header('Content-Type: application/json');

ini_set('display_errors', 0);
error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
date_default_timezone_set('America/Fortaleza');

$sandbox = "J43W6p4WKvJ3X8YSceA8PvoM6DCuY8bky6SbN7DcU4A8dtz9MS";
$tokenApi = "";

try {
    //Validação Standard
    if (isset($_SERVER['HTTP_API_KEY'])) {
        $tokenApi = $_SERVER['HTTP_API_KEY'];
    } else {
        http_response_code(401);
        echo json_encode(array('error_message' => 'API-KEY não definida'), JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        exit;
    }
    if ($tokenApi == "" || empty($tokenApi)) {
        http_response_code(401);
        echo json_encode(array('error_message' => 'API-KEY está vazia'), JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        exit;
    } else {
        if (strlen($tokenApi) != 50) {
            http_response_code(401);
            echo json_encode(array('error_message' => 'API-KEY fora do padrão esperado'), JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
            exit;
        }
    }
    if ($tokenApi != $sandbox) {
        http_response_code(401);
        echo json_encode(array('error_message' => 'API-KEY é inválida'), JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        exit;
    }
    
    
    //Validação de Cliente
    if (isset($_GET['cnpj'])) {
        $cnpj = $_GET['cnpj'];
    } else {
        http_response_code(400);
        echo json_encode(array('error_message' => 'Número de CNPJ vazio'), JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        exit;
    }

    if (strlen($cnpj) !== 14) {
        http_response_code(400);
        echo json_encode(array('error_message' => 'Número não é um CNPJ válido'), JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        exit;
    }

    if ($cnpj != 74441289000110) {
        http_response_code(404);
        echo json_encode(array('error_message' => 'CNPJ não encontrado'), JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        exit;
    }

    $return = [
        "cnpj" => 74441289000110,
        "razao" => "string",
        "responsavel" => "string",
        "ativa" => false,
        "motivo" => "Devendo receita"
    ];

    http_response_code(200);
    echo json_encode($return, JSON_UNESCAPED_UNICODE, JSON_PRETTY_PRINT);
    exit;
} catch (Exception $exc) {
    http_response_code(500);
    echo json_encode(array('error_message' => 'Erro Interno'), JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    exit;
}
