<?php

function router()
{

    $uri = $_SERVER['REQUEST_URI'];
    $path = parse_url($uri, PHP_URL_PATH);
    
    $explode_method = explode('/', $path);
    $explode_method = array_values( array_filter( $explode_method, function($value) {
        return strlen($value) > 2;
    } ) );

    $nameClass = 'controle\\'. $explode_method[0] .'::';
    $methodClass = $explode_method[1];

    if( is_callable($nameClass . $methodClass)) {
        call_user_func( $nameClass . $methodClass );
        die;
    }

}

router();

http_response_code(404);
echo json_encode([
    "next" => false,
    "message" => "Página não encontrada",
    "payload" => []
]);
die;