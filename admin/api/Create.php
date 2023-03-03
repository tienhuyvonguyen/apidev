<?php

use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *     title="My First API",
 *     version="0.1"
 * )
 */
class OpenApi
{
    /**
     * @OA\Get(
     *     path="/api/data.json",
     *     @OA\Response(
     *         response="200",
     *         description="The data"
     *     )
     * )
     */
}
$root = $_SERVER['DOCUMENT_ROOT'];
require_once($root . '/api/RestController.php');
require_once($root . '/api/UserRestHandler.php');
require_once($root . '/api/ProductRestHandler.php');

if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['email'])) {
    $username = strtoupper($_POST['username']);
    $password = $_POST['password'];
    $email = $_POST['email'];
    $userRestHandler = new UserRestHandler();
    $userRestHandler->createUser($username, $password, $email);
}
