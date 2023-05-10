<?php

ini_set('display_errors', 'Off');
error_reporting(0);

require_once "../../class/Login.php";

$return = [
    'cod' => 999,
    'msg' => "N/A",
    'dad' => []
];

$usuario = "";
$senha = "";

try {

    //Validando Usuario
    if (isset($_POST['usuario'])) {
        $usuario = $_POST['usuario'];
    } else {
        throw new Exception("USUARIO - Não foi declarado");
    }
    
    //Validando Senha
    if (isset($_POST['senha'])) {
        $senha = $_POST['senha'];
    } else {
        throw new Exception("SENHA - Não foi declarado");
    }
    
    $usuario = str_replace(' ', '', $usuario);
    
    $login = new Login();
    $rrt = $login->FazerLogin($usuario, $senha);
    $return['cod'] = $rrt['cod'];
    $return['msg'] = $rrt['msg'];
    $return['dad'] = $rrt['dad'];
    
} catch (Exception $exc) {
    $return['cod'] = 500;
    $return['msg'] = $exc->getMessage();
    $return['dad'] = [];
}

http_response_code(200);
echo json_encode($return, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
exit();
