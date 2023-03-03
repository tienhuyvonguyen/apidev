<?php

$root = $_SERVER['DOCUMENT_ROOT'];
require($root . '/vendor/autoload.php');
require_once($root . '/api/RestController.php');
require_once($root . '/api/UserRestHandler.php');
require_once($root . '/api/ProductRestHandler.php');

$secret_key = "hello";
$token = null;
$headers = apache_request_headers();
if (isset($headers['Authorization'])) {
    $token = $headers['Authorization'];
    // substring the Bearer part
    $token = substr($token, 7);
    $userRestHandler = new UserRestHandler();
    $result = $userRestHandler->protectedAPI($token, $secret_key);
}
