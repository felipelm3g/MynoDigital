<?php

ini_set('display_errors', 'Off');
error_reporting(0);

require_once "../../class/Login.php";

$return = [
    'cod' => 999,
    'msg' => "N/A",
    'dad' => []
];

$empresa = "";
$nome = "";
$plan = "";
$email = "";
$usuario = "";
$senha = "";
$senha2 = "";

try {
    //Validando Empresa
    if (isset($_POST['empresa'])) {
        $empresa = $_POST['empresa'];
    } else {
        throw new Exception("EMPRESA - Não foi declarado");
    }
    
    //Validando Nome
    if (isset($_POST['nome'])) {
        $nome = $_POST['nome'];
    } else {
        throw new Exception("NOME - Não foi declarado");
    }
    
    //Validando Plano
    if (isset($_POST['plan'])) {
        $plan = $_POST['plan'];
    } else {
        throw new Exception("NOME - Não foi declarado");
    }

    //Validando Email
    if (isset($_POST['email'])) {
        $email = $_POST['email'];
    } else {
        throw new Exception("EMAIL - Não foi declarado");
    }
    
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
    
    //Validando Senha2
    if (isset($_POST['senha2'])) {
        $senha2 = $_POST['senha2'];
    } else {
        throw new Exception("SENHA2 - Não foi declarado");
    }
    
    $usuario = str_replace(' ', '', $usuario);
    
    $login = new Login();
    $rrt = $login->NovoCadastro($empresa, $nome, $plan, $email, $usuario, $senha, $senha2);
    
    $login->FazerLogin($usuario, $senha);
    
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
