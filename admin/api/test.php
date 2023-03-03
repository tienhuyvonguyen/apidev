<?php
// set headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
// include database and object files
$root = $_SERVER['DOCUMENT_ROOT'];
require_once($root . '/config/Database.php');
require_once($root . '/class/User.php');
require_once($root . '/class/Product.php');

// instantiate database and User object
$database = new Database();
$db = $database->getConnection();
// initialize object
$product = new Product($db);
// query products
$stmt = $product->getAllProducts();
$num = $stmt->rowCount();
if ($num > 0) {
    $products_arr = array();
    $products_arr["records"] = array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $product_item = array(
            "productID" => $productID,
            "productName" => $name,
            "productPrice" => $price,
            "productImage" => $picture,
            "productQuantity" => $stock,
        );
        array_push($products_arr["records"], $product_item);
    }
    // set response code - 200 OK
    http_response_code(200);
    // show products data in json format
    echo json_encode($products_arr);
} else {
    // set response code - 404 Not found
    http_response_code(404);
    // tell the user no products found
    echo json_encode(
        array("message" => "No products found.")
    );
}
// $user = new User($db);
// $stmt = $user->getAllUsers();
// $num = $stmt->rowCount();
// if ($num > 0) {
//     $users_arr = array();
//     $users_arr["records"] = array();
//     while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
//         extract($row);
//         $user_item = array(
//             "userID" => $userID,
//             "username" => $username,
//             "userPassword" => $userPassword,
//             "userEmail" => $userEmail,
//             "phone" => $phone,
//             "firstname" => $firstname,
//             "lastname" => $lastname,
//             "creditCard" => $creditCard,
//             "avatar" => $avatar,
//             "balance" => $balance,
//             "premiumTier" => $premiumTier,
//             "premireExpire" => $premireExpire
//         );
//         array_push($users_arr["records"], $user_item);
//     }
//     http_response_code(200);
//     echo json_encode($users_arr);
// } else {
//     http_response_code(404);
//     echo json_encode(
//         array("message" => "No users found.")
//     );
// }
