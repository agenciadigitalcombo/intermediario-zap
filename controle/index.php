<?php

http_response_code(404);
echo json_encode([
    "next" => false,
    "message" => "Página não encontrada",
    "payload" => []
]);
die;