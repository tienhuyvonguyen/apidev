<?php
session_start();


$host = $_SERVER['DB_HOST'];
$user = $_SERVER['DB_USER'];
$pass = $_SERVER['DB_PASS'];
$db = $_SERVER['DB_NAME'];
try {
    $conn = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
