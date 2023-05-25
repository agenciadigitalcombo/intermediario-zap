<?php

namespace model;

class Aws
{
    public $header;

    function __construct()
    {
        $this->header = [
            "content-type: application/json",
        ];
    }
    public function post(string $path, array $payload = [], $header = [], $show_error = false)
    {
        $content = json_encode($payload, JSON_UNESCAPED_UNICODE);
        $this->header = array_merge($this->header, $header);
        try {
            $options = [
                CURLOPT_POST           => true,
                CURLOPT_HEADER         => 0,
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_URL            => $path,
                CURLOPT_POSTFIELDS     => $content,
                CURLOPT_HTTPHEADER     => $this->header,
            ];
            $con = curl_init();
            curl_setopt_array($con, $options);
            $ex = curl_exec($con);
            $message = curl_error($con);
            if ($show_error) {
                echo $message;
            }
            curl_close($con);
            $error = [
                "next" => false,
                "message" =>  json_decode($ex, true) ?? $message,
                "payload" => []

            ];
            return json_decode($ex, true) ?? $error;
        } catch (\Throwable $th) {
            echo json_encode([
                "next" => false,
                "message" => "Erro ao se conectar a API",
                "payload" => [
                    "path" => $path,
                    "header" => $this->header,
                    "body" => $payload
                ]
            ]);
            die;
        }
    }
    public function get(string $path, array $payload = [], $header = [])
    {

        $this->header = array_merge($this->header, $header);
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
            $error = [
                "next" => false,
                "message" => json_decode($ex, true) ?? $message,
                "payload" => []
            ];
            return json_decode($ex, true) ?? $error;
        } catch (\Throwable $th) {
            echo json_encode([
                "next" => false,
                "message" => "Erro ao se conectar a API",
                "payload" => [
                    "path" => $path,
                    "header" => $this->header,
                ]
            ]);
            die;
        }
    }
}
