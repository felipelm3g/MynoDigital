<?php

class Database {

    protected static $db;

    private function __construct() {

        $db_host = "";
        $db_nome = "";
        $db_usuario = "";
        $db_senha = "";
        $db_driver = "mysql";

        # Informações sobre o sistema:
        $sistema_titulo = "LDE Sistemas";
        $sistema_email = "contato@ldesistemas.com";

        try {
            self::$db = new PDO("$db_driver:host=$db_host; dbname=$db_nome", $db_usuario, $db_senha, array(PDO::MYSQL_ATTR_FOUND_ROWS => true));
            self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$db->exec('SET NAMES utf8');
        } catch (PDOException $e) {
            die("Connection Error: " . $e->getMessage());
        }
    }

    public static function conectar() {
        #Verificar se a conexão já está estabelecida antes de tentar criar uma nova
        if (!isset(self::$db)) {
            #Iniciar a conexão caso ela ainda não tenha sido iniciada
            new Database();
        }
        #Retornar a conexão existente ou recém criada
        return self::$db;
    }

    public static function desconectar() {
        #Verificar se a conexão está estabelecida antes de tentar desconectar
        if (isset(self::$db)) {
            self::$db = null;
        }
        return self::$db;
    }

}

?>