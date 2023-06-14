<?php

namespace controle;

use core\Banco;

class Cron extends \core\Controle
{

    static function status()
    {

        $db = new Banco();
        $db->table('institution');
        $listAll = $db->orderByAsc('update_date');
        $listAll = $db->select();
        $topList = $listAll[0] ?? [];

        $channel = $topList['channel'];
        $token = $topList['session_token'];

        $aws = new \model\Aws();
        $whats = new \model\Whats($aws);
        $whats->channel = $channel;
        $whats->token = $token;
        $status = $whats->status();
        $date_update = date('Y-m-d H:i:s');

        $db->table('institution');
        $db->where([
            "id" => (int) $topList['id']
        ]);
        $db->update([
            "status" => $status,
            "update_date" => $date_update,
        ]);

        self::printSuccess(
            "Lista Institution",
            [
                "total" => count($listAll),
                "name" => $topList['name'],
                "ref" => $topList['ref'],
                "status" => $status,
                "date_update" => $date_update,
            ]
        );
    }

    static function fails()
    {

        $db = new Banco();
        $sql = "SELECT * FROM institution WHERE status=1 AND balance>0";
        $listAll = $db->query($sql);
        $ids = array_map(function ($inst) {
            return $inst['ref'];
        }, $listAll);
        $ids = array_values($ids);

        $sql = "SELECT * FROM fail WHERE status != '403' AND institution_ref IN('" . implode("','", $ids) . "') ORDER BY update_date ASC";
        $all_fails = $db->query($sql);


        $top = $all_fails[0];
        $update_date = date('Y-m-d H:i:s');

        $inst_ref = $top["institution_ref"];
        $contact_ref = $top["contact_ref"];

        $top['custom'] = unserialize($top['custom']);

        $link = $top['custom']['link'] ?? 'http://www.google.com';
        $code = $top['custom']['code'] ?? '0000 0000 0000 0000 0000 0000 0000 ';

        $inst = $db->query("SELECT channel, session_token, ref from institution WHERE ref='{$inst_ref}'");
        // pegar tokens inst 

        $contact = $db->query("SELECT ref, phone, name from contact WHERE ref='{$contact_ref}'")[0];

        $aws = new \model\Aws();
        $whats = new \model\WhatsDoar($aws);

        $phone = $contact['phone'];
        $name = $contact['name'];
        $message = $top['message'];
        $message = $top['message'];
        $message_type = $top['message_type'];

        $isSend = $whats->sender(
            '5582999776698',
            $name,
            $message
        );

        if ($isSend) {
            if ($message_type == 'BOLETO') {
                $whats->sender('5582999776698', $name,  $link);
            }

            if ($message_type == 'PIX') {
                $whats->sender('5582999776698', $name,  $code);
            }
        }

        self::printSuccess(
            "",
            [
                "inst_on" =>  $ids,
                "total" => count($all_fails),
                "update_date" => $update_date,
                "message" => $top,
                "contact" => $contact,
                "isSend" => $isSend,
            ]
        );
    }

    static function await()
    {
        self::printSuccess(
            "",
            []
        );
    }
}
