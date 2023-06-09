<?php

namespace model;

class Gateway
{
    function __construct()
    {
        $this->header = [
            "content-type: application/json",
        ];
    }
    public function post(string $path, array $payload = [], $header = [])
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
            curl_close($con);
            return json_decode($ex, true) ?? [];
        } catch (\Throwable $th) {
        }
    }
    public function get(string $path, array $payload = [], $header = [])
    {

        $this->header = array_merge($this->header, $header);
        try {
            $options = [
                CURLOPT_HEADER         => 0,
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_URL            => $path,
                CURLOPT_HTTPHEADER     => $this->header,
            ];
            $con = curl_init();
            curl_setopt_array($con, $options);
            $ex = curl_exec($con);
            curl_close($con);
            return json_decode($ex, true) ?? [];
        } catch (\Throwable $th) {
        }
    }
}
