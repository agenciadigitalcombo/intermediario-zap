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

        self::printSuccess(
            "Lista Institution",
            $listAll
        );
    }

    static function fails()
    {
        self::printSuccess(
            "",
            []
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
