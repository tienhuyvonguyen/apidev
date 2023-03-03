<?php
$root = $_SERVER['DOCUMENT_ROOT'];
require_once($root . '/config/Database.php');
require_once($root . '/class/User.php');

class Library
{   
    public $db;
    public $conn;
    public function __construct()
    {
        $this->db = new Database();
        $this->conn = $this->db->getConnection();
    }

    public function testData($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    public function login($username, $password) {
        $user = new User($this->conn);
        $stmt = $user->getAdmin($username, $password);
        $count = $stmt->rowCount();
        if ($count > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            extract($row);
            session_start();
            $_SESSION['userID'] = $userID;
            $_SESSION['username'] = $username;
            $_SESSION['userPassword'] = $userPassword;
            $_SESSION['userEmail'] = $userEmail;
            $_SESSION['phone'] = $phone;
            $_SESSION['firstname'] = $firstname;
            $_SESSION['lastname'] = $lastname;
            $_SESSION['creditCard'] = $creditCard;
            $_SESSION['avatar'] = $avatar;
            $_SESSION['balance'] = $balance;
            $_SESSION['premiumTier'] = $premiumTier;
            $_SESSION['premireExpire'] = $premireExpire;
            $_SESSION['status'] = $status;
            return true;
        } else {
            return false;
        }
    }


}
