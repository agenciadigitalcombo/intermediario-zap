<?php

namespace controle;

class Test extends \core\Controle 
{
    static function debug() {

        $aws = new \model\Aws();
        $whats  = new \model\Whats($aws);
        $whats->sendHello();

        $payload = [];

        self::printSuccess(
            "Debug",
            $payload
        );
    }
}