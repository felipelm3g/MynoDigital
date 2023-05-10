<?php

class MySQL {

    public function __construct() {
        
    }

    public function insertEmpresa() {
        $sql = "";

        $fields = [
            "CLI_CODG",
            "CLI_CODE",
            "CLI_NOME",
            "CLI_TELF",
            "CLI_ADRS",
            "CLI_NUMB",
            "CLI_CPLT",
            "CLI_BAIR",
            "CLI_CITY",
            "CLI_ESTD",
            "CLI_REFR",
            "CLI_NCEP",
            "CLI_PED1",
            "CLI_FIDL",
            "CLI_WALT",
            "CLI_ULTP",
            "CLI_PASS",
            "CLI_STTS",
            "CLI_KEYE",
            "CLI_KEYM",
            "CLI_RATE",
            "CLI_DATC",
            "CLI_DATA",
        ];

        $tam = count($fields);
        $last = $tam - 1;

        $txtsql = "";
        $sql = "INSERT INTO T_EMPRESAS (";
        for ($i = 0; $i < $tam; $i++) {
            $txtsql = $fields[$i];
            if ($last != $i) {
                $sql = $sql . $txtsql . ", ";
            } else {
                $sql = $sql . $txtsql;
            }
        }
        $sql = $sql . ") VALUES (";
        $txtsql = "";
        for ($i = 0; $i < $tam; $i++) {
            $txtsql = $fields[$i];
            if ($last != $i) {
                $sql = $sql . ":" . $txtsql . ", ";
            } else {
                $sql = $sql . ":" . $txtsql;
            }
        }
        $sql = $sql . ");";

        return $sql;
    }

    public function updateEmpresa($chave) {

        $key = $chave;

        $fields = [
            "CLI_CODG",
            "CLI_CODE",
            "CLI_NOME",
            "CLI_TELF",
            "CLI_ADRS",
            "CLI_NUMB",
            "CLI_CPLT",
            "CLI_BAIR",
            "CLI_CITY",
            "CLI_ESTD",
            "CLI_REFR",
            "CLI_NCEP",
            "CLI_PED1",
            "CLI_FIDL",
            "CLI_WALT",
            "CLI_ULTP",
            "CLI_PASS",
            "CLI_STTS",
            "CLI_KEYE",
            "CLI_KEYM",
            "CLI_RATE",
            "CLI_DATC",
            "CLI_DATA",
        ];

        $tam = count($fields);
        $last = $tam - 1;

        $txtsql = "";
        $sql = "UPDATE T_EMPRESA SET ";
        for ($i = 0; $i < $tam; $i++) {
            if ($key == $fields[$i]) {
                continue;
            }
            $txtsql = $fields[$i];
            if ($last != $i) {
                $sql = $sql . $fields[$i] . " = :" . $fields[$i] . ", ";
            } else {
                $sql = $sql . $fields[$i] . " = :" . $fields[$i];
            }
        }
        $sql = $sql . "  WHERE ";
        for ($i = 0; $i < $tam; $i++) {
            if ($key == $fields[$i]) {
                $sql = $sql . $fields[$i] . " = :" . $fields[$i];
                break;
            }
        }
         $sql = $sql . ";";
        
        return $sql;
    }

}
