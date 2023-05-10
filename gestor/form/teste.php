<?php

//require_once '../../class/MySQL.php';
//
//$mysql = new MySQL();
//
//echo $mysql->insertEmpresa();
//echo "<br><br>";
//echo $mysql->updateEmpresa("CLI_CODG");

require_once "../../class/Empresa.php";

$empresa = new Empresa();
echo $empresa->GerarCodCard();
echo "<br>";
echo $empresa->GerarTokenApi();
