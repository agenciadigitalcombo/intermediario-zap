<?php

namespace model;

class Aws
{
    public $header;

    function __construct()
    {
    }

    public function post(string $path, array $payload = [], $header = [], $show_error = false)
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
        }
    }

    public function get(string $path, array $payload = [], $header = [])
    {
        try {
            $options = [
                CURLOPT_HEADER         => 0,
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_FOLLOWLOCATION => 1,
                CURLOPT_URL            => $path,
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
                ]
            ]);
            die;
        }
    }
}
