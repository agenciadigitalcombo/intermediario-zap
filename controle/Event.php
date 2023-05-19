<?php

namespace controle;

class Event extends \core\Controle
{

    static public function start()
    {
       
        $dados = new \DTO\Start();                
       
        $db = new \core\Banco();
        $inst = new \model\Institution($db);
        $contact = new \model\Contact($db);        

        $inst->register(
            $dados->name,
            $dados->color,
            $dados->logo,
            $dados->ref,
            $dados->site,
            $dados->phone,
            $dados->email
        );

        $contact->register(
            $dados->ref,
            $dados->cc_name,
            $dados->cc_phone,
            $dados->cc_email,
            $dados->cc_ref
        );

        self::printSuccess(
            "Evento Estartado",
            [
                "nextMessage" => "2023-04-31 09:30:60",
                "debug" => [
                    $dados->ref,
                    $dados->cc_name,
                    $dados->cc_phone,
                    $dados->cc_email,
                    $dados->cc_ref
                ],
            ]
        );
    }
}
