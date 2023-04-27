<?php

namespace model;

class whats
{

    private $aws;

    public function __construct( \model\Aws $aws )
    {
        $this->aws = $aws;
    }

    public function status( string $session, string $token)
    {
        $path = "http://backz.digitalcombo.com.br/api/{$session}/check-connection-session";       
        $request =  $this->aws->get(
            $path,
            [],
            ["Authorization: Bearer {$token}"]
        );  
        return $request['status'] ?? false;
    }

}