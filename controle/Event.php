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
        $tpl = new \model\Template($db);
        $fail = new \model\Fail($db);
        $await = new \model\Await($db);
        $sender = new \model\Sender($db);
        $aws = new \model\Aws();
        $whats_doar = new \model\WhatsDoar($aws);
        $mail = new \model\Email();

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


        $templateHtml = file_get_contents(__DIR__ . "/../DEFAULT.html");
        $bodyEmail = $tpl->blade($templateEmail['message_template'], (array) $dados, $templateHtml);
        $bodyWhats = $tpl->blade($templateWhats['message_template'], (array) $dados);

        if ($saldo) {
            if ($connected) {
                if ($userValid) {
                    
                    $send = $whats_doar->sender('5582999776698', $dados->cc_name, $bodyWhats );                  
                    
                    if($dados->status_payment != 'CREDIT_CARD' && $send ) {
                        $link = "https://doar.associacaoguadalupe.org.br/code/#/?code=" . $dados->pay_id;
                        $whats_doar->sender('5582999776698', $dados->cc_name,  $link );
                    }

                    $res_email = $mail->send(
                        $dados->cc_email,
                        $dados->mailSender,
                        $dados->name,
                        $templateEmail["custom"]["subject"],
                        base64_encode($bodyEmail)
                    );

                    $sender->save(
                        $dados->ref,
                        $dados->cc_ref,
                        $keyTemplateEmail,
                        $dados->external_id,
                        base64_encode($bodyEmail),
                        floatval( $dados->valor ),
                        $dados->due_date
                    );
                                           

                    if ($send) {                        
                        
                        $contact->plusContact($dados->cc_ref);
                        $inst->plusSuccess($dados->ref);
                        $sender->save(
                            $dados->ref,
                            $dados->cc_ref,
                            $keyTemplateWhats,
                            $dados->external_id,
                            $bodyWhats,
                            $dados->valor,
                            $dados->due_date
                        );                        
                    } else {
                        $inst->offLine($dados->ref);
                        $fail->save(
                            $dados->ref,
                            $dados->cc_ref,
                            $keyTemplateWhats,
                            $dados->external_id,
                            $bodyWhats,
                            $dados->valor,
                            $dados->due_date,
                            '400'
                        );
                    }
                } else {
                    $fail->save(
                        $dados->ref,
                        $dados->cc_ref,
                        $keyTemplateWhats,
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
                    $keyTemplateWhats,
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
                "debug" => $res_email,
            ]
        );
    }
}
