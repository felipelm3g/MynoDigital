<?php

require_once "Database.php";

class Empresa {

    public function __construct() {
        
    }

    private function GerarCod($n) {
        $caracteres = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        $codigo = '';

        for ($i = 0; $i < $n; $i++) {
            $posicao = rand(0, strlen($caracteres) - 1);
            $codigo .= $caracteres[$posicao];
        }

        return $codigo;
    }

    public function GerarCodCard() {
        $conn = Database::conectar();
        while (true) {
            $cod = $this->GerarCod(5);
            $sql = "SELECT COUNT(EMP_CODG) FROM T_EMPRESAS WHERE EMP_CARD = '{$cod}';";
            $stmt = $conn->query($sql);
            if ($stmt->fetchColumn() <= 0) {
                break;
            }
        }
        $conn = Database::desconectar();
        return $cod;
    }

    public function GerarTokenApi() {
        $conn = Database::conectar();
        while (true) {
            $cod = $this->GerarCod(50);
            $sql = "SELECT COUNT(EMP_CODG) FROM T_EMPRESAS WHERE EMP_TOKN = '{$cod}';";
            $stmt = $conn->query($sql);
            if ($stmt->fetchColumn() <= 0) {
                break;
            }
        }
        $conn = Database::desconectar();
        return $cod;
    }

}
