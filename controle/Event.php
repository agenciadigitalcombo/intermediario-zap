<?php

namespace controle;

class Event extends \core\Controle
{

    static public function start()
    {

        // verify status valid

        $dados = new \DTO\Start();

        $db = new \core\Banco();
        $inst = new \model\Institution($db);
        $contact = new \model\Contact($db);
        $tpl = new \model\Template($db);
        $fail = new \model\Fail($db);
        $await = new \model\Await($db);

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

        $contactInfo = $contact->getContact($dados->cc_ref);
        $instInfo = $inst->getInst($dados->ref);
        $saldo =  (int) $instInfo['balance'] ?? 0;
        $connected = (int) $instInfo['status'] ?? 0;
        $userValid = (int) $contactInfo['status'] ?? 0;

        $keyTemplateEmail = 'EMAIL:' . $dados->type_payment . ':' . $dados->status_payment;
        $keyTemplateWhats = 'WHATS:' . $dados->type_payment . ':' . $dados->status_payment;

        $tpl->register(
            $keyTemplateEmail,
            $dados->ref
        );

        $tpl->register(
            $keyTemplateWhats,
            $dados->ref
        );

        $templateEmail = $tpl->getTemplate($keyTemplateEmail, $dados->ref);
        $templateWhats = $tpl->getTemplate($keyTemplateWhats, $dados->ref);
        
        $templateHtml = file_get_contents(__DIR__."/../DEFAULT.html");
        $bodyEmail = $tpl->blade($templateEmail['message_template'], (array) $dados, $templateHtml);
        $bodyWhats = $tpl->blade($templateWhats['message_template'], (array) $dados);

        



        if ($saldo) {
            if ($connected) {
                if ($userValid) {
                    
                    $send = 0; // send api
                    if ($send) {
                        // save sender 
                        // increment sender user
                        // increment sender inst
                        // decrement balance inst
                    } else {
                        // save fail 
                        // update status inst
                    }
                } else {
                    $fail->save(
                        $dados->ref,
                        $dados->cc_ref,
                        $bodyWhats,
                        $dados->external_id,
                        $bodyWhats,
                        $dados->valor,
                        $dados->due_date
                    );
                }
            } else {
                $await->save(
                    $dados->ref,
                    $dados->cc_ref,
                    $bodyWhats,
                    $dados->external_id,
                    $bodyWhats,
                    $dados->valor,
                    $dados->due_date
                );
            }
        }

        self::printSuccess(
            "Evento Estartado",
            [
                "nextMessage" => "2023-04-31 09:30:60",
                "debug" => $userValid,
            ]
        );
    }
}
