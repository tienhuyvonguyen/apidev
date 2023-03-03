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
require_once($root.'/api/RestController.php');
require_once($root.'/api/UserRestHandler.php');
require_once($root.'/api/ProductRestHandler.php');

$method = $_SERVER['REQUEST_METHOD'];

if ('PUT' === $method) {
    parse_str(file_get_contents('php://input'), $_PUT);
}

if (isset($_PUT['username']) && isset($_PUT['email'])) {
    $username = strtoupper($_PUT['username']);
    $userEmail = $_PUT['email'];
    $userRestHandler = new UserRestHandler();
    $userRestHandler->updateUser($username, $userEmail);
}