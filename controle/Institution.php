<?php

namespace controle;

class Institution extends \core\Controle
{
    static public function report() {
        $db = new \core\Banco();
        $inst = new \model\Institution($db);
        self::printSuccess(
            "Relatório",
            $inst->report()
        );
    }
}