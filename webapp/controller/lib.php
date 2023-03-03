<?php
ini_set("display_errors", "0");
require("../db/dbConnect.php");
session_start();

// captcha function 
function captcha($secret_key, $recaptcha)
{
    $url = 'https://www.google.com/recaptcha/api/siteverify?secret='
        . $secret_key . '&response=' . $recaptcha;
    $response = file_get_contents($url);
    $response = json_decode($response);
    return $response;
}
function rememberMe()
{
    if (!empty($_POST["remember"])) {
        //COOKIES for username set httpdonly
        setcookie("user_login", htmlspecialchars($_POST["username"]), time() + (86400 * 7),  NULL, NULL, NULL, TRUE); // 86400 = 1 day
        //COOKIES for password
        setcookie("user_password", htmlspecialchars($_POST["password"]), time() + (86400 * 7),  NULL, NULL, NULL, TRUE);
    } else {
        if (isset($_COOKIE["user_login"])) {
            setcookie("user_login", "", NULL, NULL, NULL, NULL, TRUE);
            if (isset($_COOKIE["userpassword"])) {
                setcookie("userpassword", "", NULL, NULL, NULL, NULL, TRUE);
            }
        }
    }
}

function login()
{
    global $conn;
    $showError = false;
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $myusername = strtoupper($_POST['username']);
        $mypassword = $_POST['password'];

        // captcha
        $recaptcha = $_POST['g-recaptcha-response'];
        $secret_key = $_SERVER['RECAPTCHA_SECRET_KEY'];
        $response = captcha($secret_key, $recaptcha);
        // captcha

        try {
            $sql = "SELECT * FROM users WHERE username = :myusername";
            $result = $conn->prepare($sql);
            $result->bindParam(':myusername', $myusername, PDO::PARAM_STR);
            $result->execute();
            $num = $result->rowCount();
            $data = $result->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }

        $premium = $data['premiumTier'];
        //If result matched $myusername and $mypassword, table row must be 1 row & check captcha
        if ($response->success == false) { //vercode is the session variable that holds the captcha code
            $showError = "Invalid Captcha";
        } elseif ($num == 1 && password_verify($mypassword, $data['userPassword'])) {
            rememberMe();
            $_SESSION['login_user'] = htmlspecialchars($myusername); // set username in session
            $_SESSION["login_time_stamp"] = time(); //set login time
            $_SESSION['premiumTier'] =  $premium;
            header("location: ../services/main.php");
        } elseif ($num == 0) {
            $showError = "Invalid Username or Password";
        } else {
            $showError = "Invalid Username or Password";
        }
    }
    return $showError;
}

function signup()
{
    global $conn;
    $showError = false;
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = strtoupper($_POST['username']);
        $password = $_POST['password'];
        $cpassword = $_POST['cpassword'];
        $email = $_POST['email'];
        $sql = "Select * from users where username= :username limit 1";
        try {
            $result = $conn->prepare($sql);
            $result->bindParam(':username', $username, PDO::PARAM_STR);
            $result->execute();
            $num = $result->rowCount();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
        // If username already exists
        if ($num == 0) {
            // deepcode ignore PhpSameEvalBinaryExpressiontrue: Accepted
            if ($password == $cpassword) {
                $hash = password_hash($password, PASSWORD_DEFAULT);
                $sql = "INSERT INTO `users` ( `username`,
            	`userPassword`, `userEmail`) VALUES (:username, :password, :email)";
                try {
                    $result = $conn->prepare($sql);
                    $result->bindParam(':username', $username, PDO::PARAM_STR);
                    $result->bindParam(':password', $hash, PDO::PARAM_STR);
                    $result->bindParam(':email', $email, PDO::PARAM_STR);
                    $result->execute();
                } catch (PDOException $e) {
                    echo "Error: " . $e->getMessage();
                }
                if ($result) {
                    $showError = true;
                }
                echo "<script>alert('Sign up Successful!'); window.location.href='./login.php';</script>";
            } else {
                $showError = "Passwords do not match";
            }
        }
        if ($num > 0) {
            $showError = "Username not available";
        }
    }
    return $showError;
}


