<?php
include('../auth/session.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = strtoupper($login_session);
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];
    try {
        $sql = "SELECT * FROM users WHERE username = :username";
        $result = $conn->prepare($sql);
        $result->bindParam(':username', $username);
        $result->execute();
        $row = $result->fetch(PDO::FETCH_ASSOC);

        $oldMail = $row['userEmail'];
        $newMail = ($_POST['email']);
        if ($newMail == $oldMail) {
            $newMail = $oldMail;
        }
        $oldPhone = $row['phone'];
        $newPhone = $_POST['phone'];
        if ($newPhone == $oldPhone) {
            $newPhone = $oldPhone;
        }
        $ollFirstName = $row['firstname'];
        $newFirstName = $_POST['firstname'];
        if ($newFirstName == $ollFirstName) {
            $newFirstName = $ollFirstName;
        }
        $oldLastName = $row['lastname'];
        $newLastName = $_POST['lastname'];
        if ($newLastName == $oldLastName) {
            $newLastName = $oldLastName;
        }
        $oldCreditCard = $row['creditCard'];
        $newCreditCard = $_POST['creditCard'];
        if ($newCreditCard == $oldCreditCard) {
            $newCreditCard = $oldCreditCard;
        }
        // working right here LOGIC error
        if (isset($password) && isset($cpassword) && $password != "" && $cpassword != "") {
            $sql = "select userPassword from users where username = :username";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':username', $username, PDO::PARAM_STR);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $oldpassword = $row['userPassword'];
            if ($password == $cpassword && $oldpassword != $password) {
                $sql = "UPDATE users SET
                                    userEmail = :email,
                                    userPassword = :password,
                                    phone = :phone,
                                    firstname = :firstname,
                                    lastname = :lastname,
                                    creditCard = :card
                                WHERE username = :username";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':password', $password);
                $stmt->bindParam(':email', $newMail);
                $stmt->bindParam(':phone', $newPhone);
                $stmt->bindParam(':firstname', $newFirstName);
                $stmt->bindParam(':lastname', $newLastName);
                $stmt->bindParam(':card', $newCreditCard);
                $stmt->bindParam(':username', $username);
                $stmt->execute();
                echo "<script>alert('Profile updated successfully!1');window.location.href='userProfile.php';</script>";
            } elseif ($oldpassword == $password) {
                echo "<script>alert('New password cannot be the same as the old password!1');window.location.href='userProfile.php';</script>";
            } else {
                echo "<script>alert('Password does not match!1');window.location.href='userProfile.php';</script>";
            }
        } elseif ($password == "" && $cpassword == "") {
            $sql = "UPDATE users SET
                                    userEmail = :email,
                                    phone = :phone,
                                    firstname = :firstname,
                                    lastname = :lastname,
                                    creditCard = :card
                                WHERE username = :username";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':email', $newMail);
            $stmt->bindParam(':phone', $newPhone);
            $stmt->bindParam(':firstname', $newFirstName);
            $stmt->bindParam(':lastname', $newLastName);
            $stmt->bindParam(':card', $newCreditCard);
            $stmt->bindParam(':username', $username);
            $stmt->execute();
            echo "<script>alert('Profile updated successfully!2');window.location.href='userProfile.php';</script>";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
