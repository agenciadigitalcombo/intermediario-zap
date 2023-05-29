<?php

namespace model;

class whats
{

    private $aws;
    public $channel;
    public $token;

    public function __construct(\model\Aws $aws)
    {
        $this->aws = $aws;
    }

    public function status()
    {
        $channel = $this->channel;
        $token = $this->token;
        $path = "http://backz.digitalcombo.com.br/api/{$channel}/check-connection-session";
        $request =  $this->aws->post(
            $path,
            [],
            [
                "content-type: application/json",
                "Authorization: Bearer {$token}"
            ]
        );
        return empty($request['status']) ? 0 : (int) $request['status'];
    }

    public function sender($phone, string $name, string $body): bool
    {
        $channel = $this->channel;
        $token = $this->token;
        $path = "https://backz.digitalcombo.com.br/api/{$channel}/send-message";
        $res = $this->aws->post(
            $path,
            [
                "phone" => $phone,
                "message" => $body,
                "isGroup" => false
            ],
            [
                "content-type: application/json",
                "Authorization: Bearer {$token}"
            ]
        );
        $valid = $res['status'] == 'success' ? 1 : 0;
        return $valid;
    }

    public function sendHello($phone, $name): bool
    {
        $body = "Seja bem vindo {$name}";
        return $this->sender($phone, $name, $body);
    }
}
