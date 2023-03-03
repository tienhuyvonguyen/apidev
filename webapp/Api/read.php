<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    include_once('../db/database.php');
    include_once('../class/user.php');
    $database = new Database();
    $db = $database->dbConnection();
    $items = new User($db);
    $stmt = $items->getAllUsers();
    $itemCount = $stmt->rowCount();

    echo json_encode($itemCount);
    if ($itemCount > 0) {
        $userArr = array();
        $userArr["body"] = array();
        $userArr["itemCount"] = $itemCount;
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            $e = array(
                "userID" => $userID,
                "username" => $username,
                "userPassword" => $userPassword,
                "userEmail" => $userEmail,
                "phone" => $phone,
                "firstname" => $firstname,
                "lastname" => $lastname,
                "creditCard" => $creditCard,
                "avatar" => $avatar,
                "balance" => $balance,
                "premiumTier" => $premiumTier,
                "premireExpire" => $premireExpire
            );
            array_push($userArr["body"], $e);
        }
        echo json_encode($userArr);
    } else {
        http_response_code(404);
        echo json_encode(
            array("message" => "No record found.")
        );
    }