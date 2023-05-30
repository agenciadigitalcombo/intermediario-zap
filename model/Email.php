<?php

namespace model;

class Email
{
    public function post(string $path, array $payload = [], $header = [])
    {
        $content = json_encode($payload, JSON_UNESCAPED_UNICODE);
        try {
            $options = [
                CURLOPT_POST           => true,
                CURLOPT_HEADER         => 0,
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_URL            => $path,
                CURLOPT_POSTFIELDS     => $content,
                CURLOPT_HTTPHEADER     => $header,
            ];
            $con = curl_init();
            curl_setopt_array($con, $options);
            $ex = curl_exec($con);
            $message = curl_error($con);
            curl_close($con);
            return json_decode($ex, true);
        } catch (\Throwable $th) {
            echo json_encode([
                "next" => false,
                "message" => "Erro ao se conectar a API",
                "payload" => [
                    "path" => $path,
                    "header" => $header,
                    "body" => $payload
                ]
            ]);
            die;
        }
    }

    public function send(
        string $to,
        string $from,
        string $from_name,
        string $subject,
        string $body
    ): array {
        $path = "https://1m3jyue8eh.execute-api.us-east-1.amazonaws.com/default/EnviadorEmailBurro";

        $to = "br.rafael@outlook.com";
        $from = "contato@digitalcombo.com.br";
        
        return $this->post(
            
            $path,
            [
                "recipient" => $to,
                "sender_name" => $from_name,
                "sender_email" => $from,
                "subject" => $subject,
                "message" => $body,
            ],
            [
                "content-type: application/json",
            ]
        );
    }
}
