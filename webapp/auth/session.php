<?php
include("../db/dbConnect.php");
session_start();
$user_check = $_SESSION['login_user'];
try {
    $sql = "SELECT username FROM users WHERE username = :user_check limit 1";
    $ses_sql = $conn->prepare($sql);
    $ses_sql->bindParam(':user_check', $user_check);
    $ses_sql->execute();
    $row = $ses_sql->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
$login_session = strtoupper($row['username']);
if (time() - $_SESSION["login_time_stamp"] > 3600) { //subtract new timestamp from the old one
    session_unset();
    session_destroy();
    header("Location: ../sessionout.html");
}
if (!isset($login_session)) { //if login in session is not set
    header("location: ./login.php");
    session_unset();
    session_destroy();
    die();
}
