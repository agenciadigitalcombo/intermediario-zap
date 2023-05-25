<?php

namespace model;

class WhatsDoar extends \model\Whats
{
    public function __construct(\model\Aws $aws)
    {
        parent::__construct($aws);
        $this->channel = CHANNEL_DEFAULT;
        $this->token = SESSION_DEFAULT;
    }
}
