<?php
$root = $_SERVER['DOCUMENT_ROOT'];
require($root . '/vendor/autoload.php');

use Firebase\JWT\JWT;

class User
{
    //connection
    private $conn;
    //table
    private $db_table = "users";
    // columns
    public $userID;
    public $username;
    public $userPassword;
    public $userEmail;
    public $phone;
    public $firstname;
    public $lastname;
    public $creditCard;
    public $avatar;
    public $balance;
    public $premiumTier;
    public $premireExpire;
    //db connection
    public function __construct($db)
    {
        $this->conn = $db;
    }
    // get all users
    public function getAllUsers()
    {
        $sqlQuery = "SELECT * FROM " . $this->db_table . "";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $num = $stmt->rowCount();
        if ($num > 0) {
            $users_arr = array();
            $users_arr["records"] = array();
            foreach ($result as $row) {
                extract($row);
                $user_item = array(
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
                array_push($users_arr["records"], $user_item);
            }
            return $users_arr;
        }
    }

    // get single user
    public function getSingleUser($username)
    {
        $sqlQuery = "SELECT * FROM " . $this->db_table . " WHERE username = ? limit 1";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->bindParam(1, $username);
        $stmt->execute();
        $stmt = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($stmt) {
            $user_item = array(
                "userID" => $stmt['userID'],
                "username" => $stmt['username'],
                "userPassword" => $stmt['userPassword'],
                "userEmail" => $stmt['userEmail'],
                "phone" => $stmt['phone'],
                "firstname" => $stmt['firstname'],
                "lastname" => $stmt['lastname'],
                "creditCard" => $stmt['creditCard'],
                "avatar" => $stmt['avatar'],
                "balance" => $stmt['balance'],
                "premiumTier" => $stmt['premiumTier'],
                "premireExpire" => $stmt['premireExpire']
            );
            return $user_item;
        }
    }
    public function getAdmin($username, $password)
    {
        $sqlQuery = "SELECT * FROM " . $this->db_table . " WHERE username = ? AND userPassword = ? AND status = '1' limit 1";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->bindParam(1, $username);
        $stmt->bindParam(2, $password);
        $stmt->execute();
        return $stmt;
    }

    public function getAdmin2($username, $password)
    {
        $sqlQuery = "SELECT * FROM " . $this->db_table . " WHERE username = ? AND status = '1' limit 1";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->bindParam(1, $username);
        $stmt->bindParam(2, $password);
        $stmt->execute();
        $stmt = $stmt->fetch(PDO::FETCH_ASSOC);
        // verify password
        $password2 = $stmt['userPassword'];
        if (password_verify($password, $password2)) {
            $secret_key = "hello";
            $issuer_claim = "THE_CLAIM"; // this can be the servername
            $audience_claim = "THE_AUDIENCE";
            $issuedat_claim = time(); // issued at
            $notbefore_claim = $issuedat_claim + 5; //not before in seconds
            $expire_claim = $issuedat_claim + 30; // expire time in seconds
            $token = array(
                "iss" => $issuer_claim,
                "aud" => $audience_claim,
                "iat" => $issuedat_claim,
                "nbf" => $notbefore_claim,
                "exp" => $expire_claim,
                "data" => array(
                    "userID" => $stmt['userID'],
                    "username" => $stmt['username'],
                    "userPassword" => $stmt['userPassword'],
                    "userEmail" => $stmt['userEmail']
                )
            );
            $jwt = JWT::encode($token, $secret_key, 'HS512');
            return $jwt;
        }
    }
    public function deleteUser($username)
    {
        $sqlQuery = "DELETE FROM " . $this->db_table . " WHERE username = ?";
        $stmt = $this->conn->prepare($sqlQuery);
        $this->username = htmlspecialchars(strip_tags($username));
        $stmt->bindParam(1, $this->username);
        $stmt->execute();
        $stmt = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($stmt) {
            $user_item = array(
                "userID" => $stmt['userID'],
                "username" => $stmt['username'],
                "userPassword" => $stmt['userPassword'],
                "userEmail" => $stmt['userEmail'],
                "phone" => $stmt['phone'],
                "firstname" => $stmt['firstname'],
                "lastname" => $stmt['lastname'],
                "creditCard" => $stmt['creditCard'],
                "avatar" => $stmt['avatar'],
                "balance" => $stmt['balance'],
                "premiumTier" => $stmt['premiumTier'],
                "premireExpire" => $stmt['premireExpire']
            );
            return $user_item;
        }
    }

    public function updateUser($username, $userEmail)
    {
        $sqlQuery = "UPDATE " . $this->db_table . " SET userEmail = ? WHERE username = ?";
        $stmt = $this->conn->prepare($sqlQuery);
        $this->username = htmlspecialchars(strip_tags($username));
        $this->userEmail = htmlspecialchars(strip_tags($userEmail));
        $stmt->bindParam(1, $this->userEmail);
        $stmt->bindParam(2, $this->username);
        $stmt->execute();
        $stmt = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($stmt) {
            $user_item = array(
                "userID" => $stmt['userID'],
                "username" => $stmt['username'],
                "userPassword" => $stmt['userPassword'],
                "userEmail" => $stmt['userEmail'],
                "phone" => $stmt['phone'],
                "firstname" => $stmt['firstname'],
                "lastname" => $stmt['lastname'],
                "creditCard" => $stmt['creditCard'],
                "avatar" => $stmt['avatar'],
                "balance" => $stmt['balance'],
                "premiumTier" => $stmt['premiumTier'],
                "premireExpire" => $stmt['premireExpire']
            );
            return $user_item;
        }
    }

    public function createUser($username,  $userPassword, $userEmail)
    {
        $sqlQuery = "INSERT INTO " . $this->db_table . " SET username = ?, userPassword = ?, userEmail = ?";
        $stmt = $this->conn->prepare($sqlQuery);
        $this->username = htmlspecialchars(strip_tags($username));
        $userPassword = password_hash($userPassword, PASSWORD_DEFAULT);
        $this->userPassword = htmlspecialchars(strip_tags($userPassword));
        $this->userEmail = htmlspecialchars(strip_tags($userEmail));
        $stmt->bindParam(1, $this->username);
        $stmt->bindParam(2, $this->userPassword);
        $stmt->bindParam(3, $this->userEmail);
        $stmt->execute();
        $stmt = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($stmt) {
            $user_item = array(
                "userID" => $stmt['userID'],
                "username" => $stmt['username'],
                "userPassword" => $stmt['userPassword'],
                "userEmail" => $stmt['userEmail'],
                "phone" => $stmt['phone'],
                "firstname" => $stmt['firstname'],
                "lastname" => $stmt['lastname'],
                "creditCard" => $stmt['creditCard'],
                "avatar" => $stmt['avatar'],
                "balance" => $stmt['balance'],
                "premiumTier" => $stmt['premiumTier'],
                "premireExpire" => $stmt['premireExpire']
            );
            return $user_item;
        }
    }
}
