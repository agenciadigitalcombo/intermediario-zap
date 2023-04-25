<?php

namespace core;

class Jwt
{
    static function maker(array $playload = []): string
    {
        $playload_pk = $playload;
        $playload_pk["segredo"] = SALT;
        $playload_pub_json = base64_encode(json_encode($playload));
        $salt = sha1(base64_encode(json_encode($playload_pk)));
        return "{$playload_pub_json}.{$salt}";
    }

    static function valid(string $jwt): bool
    {
        $bom = explode('.', $jwt);
        $playload = json_decode(base64_decode($bom[0]??'eyJ0cm9sbCI6dHJ1ZX0='), true);
        $playload["segredo"] = SALT;
        $playload = sha1(base64_encode(json_encode($playload)));
        $salt = $bom[1]??'00001';
        return $playload === $salt;
    }
    
    static function ler(string $jwt): array
    {
        $bom = explode('.', $jwt);
        return json_decode(base64_decode($bom[0]), true);
    }
}
