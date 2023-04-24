<?php

header("Access-Control-Allow-Headers: Authorization, Content-Type");
header("Access-Control-Allow-Origin: *");
// header('content-type: application/json; charset=utf-8');

ini_set('memory_limit', '-1');
set_time_limit(0);

set_time_limit(20);

date_default_timezone_set('America/Sao_Paulo');

$getJson = file_get_contents('php://input');
$getJson = (array) json_decode($getJson, true);
$_REQUEST = array_merge($getJson, $_REQUEST);

if(!empty($_REQUEST['debug'])){    
    error_reporting(E_ALL);
    ini_set('display_errors',1);
}

include __DIR__ . "/../config.php";

function autoload($classe) {
    $DS_BASE = DIR_APP . DS;
    $classe = $DS_BASE  . str_replace('\\', DS , $classe ) . ".php";
    if(file_exists($classe) && !is_dir($classe)){
        require_once $classe;
    }
}

spl_autoload_register('autoload');

require_once __DIR__ . "/router.php";