<?php

namespace controle;

class Event extends \core\Controle
{

    static public function start()
    {
        
        $dados = new \DTO\start();
        
        $db = new \core\Banco();
        $inst = new \model\Institution($db);

        $inst->register(
            $dados->name,
            $dados->color,
            $dados->logo,
            $dados->ref,
            $dados->site,
            $dados->phone,
            $dados->email
        );

        self::printSuccess(
            "Evento Estartado",
            [
                "nextMessage" => "2023-04-31 09:30:60",
                "debug" => $dados->name,
            ]
        );
    }
}
