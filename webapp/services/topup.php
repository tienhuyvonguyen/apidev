<?php
// include database connection
include_once('../db/dbConnect.php');
include_once('../auth/session.php');
session_start();
// check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $sql = "SELECT * FROM users WHERE username = :username";
        $stmt = $conn->prepare($sql);
        $stmt->execute(array(':username' => $login_session));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $wallet = $row['balance'];
        $cre_Cvv = substr($row['creditCard'], -3);
        if ($cre_Cvv == null) {
            echo "<script>alert('You have no credit card! Please update it to use this function!');window.location.href='../profile/userProfile.php';</script>";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    try {
        $balance = htmlspecialchars(strip_tags($_POST['topup']));
        $cvv = htmlspecialchars(strip_tags($_POST['cvv']));
        if ($cvv == $cre_Cvv) {
            $wallet += $balance;
            $sql = "UPDATE users SET balance = :balance WHERE username = :username";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':balance', $wallet, PDO::PARAM_STR);
            $stmt->bindParam(':username', $login_session, PDO::PARAM_STR);
            $stmt->execute();
            echo "<script>alert('Top up success!');window.location.href='../profile/userProfile.php';</script>";
        } else {
            echo "<script>alert('CVV is incorrect! Last 3 digits of your card!');window.location.href='../profile/userProfile.php';</script>";
        }
    }
    // show error
    catch (PDOException $exception) {
        die('ERROR: ' . $exception->getMessage());
    }
}
