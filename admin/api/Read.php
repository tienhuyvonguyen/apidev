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

$view = "";
if(isset($_GET["view"]))
    $view = $_GET["view"];

switch ($view) {
    case 'all':
        $user_rest_handler = new UserRestHandler();
        $user_rest_handler->getAllUsers();
        break;
    case 'single':
        $user_rest_handler = new UserRestHandler();
        $user_rest_handler->getUser($_GET["username"]);
        break;
    case "":
        //404 - not found;
        break;
}