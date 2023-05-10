<?php

class Formatacoes {

    public function __construct() {
        
    }

    public function converterTel($number) {

        $tel = $number;
        $ddd = substr($tel, 0, 2);
        $temp = "";

        if (strlen($number) == 10) {
            $temp = substr($tel, 2);
        }

        if (strlen($number) == 11) {
            $temp = substr($tel, 3);
        }

        if (!empty($temp)) {
            $n = substr($temp, 0, 1);
            $n = intval($n);
            if ($n <= 5) {
                $tel = $ddd . "9" . $temp;
            } else {
                $tel = $ddd . $temp;
            }
        }

        return $tel;
    }
    
    public function formartTel($number) {
        $tel = $number;
        $tel = preg_replace('/[^0-9]/', '', $tel);
        $return = "";
        if (strlen($number) == 10) {
            $ddd = substr($tel, 0, 2);
            $resto = substr($tel, 2);
            $primeira = substr($resto, 0, 4);
            $segunda = substr($resto, 4, 4);
            $return = "(" . $ddd . ") " . $primeira . "-" . $segunda;
        } else if (strlen($number) == 11) {
            $ddd = substr($tel, 0, 2);
            $resto = substr($tel, 3);
            $ter = substr($tel, 2, 1);
            $primeira = substr($resto, 0, 4);
            $segunda = substr($resto, 4, 4);
            $return = "(" . $ddd . ") " . $ter . " " . $primeira . "-" . $segunda;
        } else {
            $return = $number;
        }
        return $return;
    }
    
    public function formartCep($number){
        $cep = substr($number, 0, 5) . "-" . substr($number, 5, 3);
        return $cep;
    }
}
