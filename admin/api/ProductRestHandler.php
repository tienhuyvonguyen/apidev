<?php
use OpenApi\Annotations as OA;
/**
 * @OA\Info(
 *     title="My First API",
 *     version="0.1"
 * )
 */
$root = $_SERVER['DOCUMENT_ROOT'];
require_once($root . '/config/Database.php');
require_once($root . '/class/Product.php');
require_once($root . '/api/SimpleRest.php');

class ProductRestHandler extends SimpleRest
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
