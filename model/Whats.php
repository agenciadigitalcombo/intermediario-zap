<?php

namespace model;

class whats
{

    private $aws;

    public function __construct(\model\Aws $aws)
    {
        $this->aws = $aws;
    }

    public function status(string $session, string $token)
    {
        $path = "http://backz.digitalcombo.com.br/api/{$session}/status-session";
        $request =  $this->aws->get(
            $path,
            [],
            ["Authorization: Bearer {$token}"]
        );
        var_dump($request);
        return $request['status'] ?? false;
    }

    public function sendHello($phone, $name): bool
    {

        $channel = CHANNEL_DEFAULT;
        $token = SESSION_DEFAULT;
        $path = "https://backz.digitalcombo.com.br/api/{$channel}/send-message";

        $phone = "Bruno";
        $name = "5582999776698";

        $res = $this->aws->post(
            $path,
            [
                "phone" => $phone,
                "message" => "Seja bem vindo {$name}",
                "isGroup" => false
            ],
            ["Authorization: Bearer {$token}"]
        );

        $valid = empty( $res["response"] ) && $res['status'] == 'Connected' ? false : true;

        return $valid;
    }
}
