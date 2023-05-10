<?php

ini_set('display_errors', 'Off');
error_reporting(0);

require_once "../../class/Cliente.php";

$return = [
    'cod' => 999,
    'msg' => "N/A",
    'dad' => []
];

try {

    if (isset($_POST['tel'])) {
        if (empty($_POST['tel'])) {
            throw new Exception("EMAIL - Vazio");
        }
        $tel = $_POST['tel'];
    } else {
        throw new Exception("EMAIL - Não foi declarado");
    }

    $cliente = new Cliente();
    $rrt = $cliente->CheckTelExist($tel);
    if ($rrt) {
        $return['cod'] = 200;
        $return['msg'] = "Já cadastrado";
    } else {
        $return['cod'] = 401;
        $return['msg'] = "Não cadastrado";
    }
} catch (Exception $exc) {
    $return['cod'] = 500;
    $return['msg'] = $exc->getMessage();
}

http_response_code(200);
echo json_encode($return, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
exit();
