<?php

namespace controle;

class Test extends \core\Controle 
{
    static function debug() {

        $db = new \core\Banco();
        $inst = new \model\Institution($db);

        $inst->register(
            "BRC 1",
            "#C00",
            "brc.png",
            "inst_642d98697d8e6",
            "Bruno Criações",
            "5582999776698",
            "br.rafael@outlook.com"
        );

        self::printSuccess(
            "testa cadastro institution ",
            []
        );
       
    }
}