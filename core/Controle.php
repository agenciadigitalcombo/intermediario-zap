<?php

namespace core;

class Controle
{

    static function printError(string $message, array $payload, int $code = 400): void
    {
        http_response_code($code);
        echo json_encode([
            "next" => false,
            "message" => $message,
            "payload" => $payload
        ]);
        die;
    }

    static function printSuccess(string $message, array $payload, int $code = 200): void
    {
        http_response_code($code);
        echo json_encode([
            "next" => true,
            "message" => $message,
            "payload" => $payload
        ]);
        die;
    }

    static function requireInputs(array $payload): void
    {
        $requireInputsKeys = array_keys($payload);
        foreach ($requireInputsKeys as $inputName) {
            if (empty($_REQUEST[$inputName])) {
                self::printError(
                    $payload[$inputName],
                    []
                );
            }
        }
    }

    static function privateRouter(): void
    {
        $jwt = new \core\Jwt();
        $token = $_REQUEST['token'] ?? '';
        $isValidJwt = $jwt->valid($token);
        if(!$isValidJwt ) {
            http_response_code(401);
            self::printError(
                "Token Invalido",
                []
            );
        }
    }
}
