<?php
include('../db/dbConnect.php');
include('../auth/session.php');
try {
    $sql = "select avatar from users where username = :username";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':username', $login_session);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $oldAvatar = $row['avatar'];
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

if (isset($_POST["submit"])) {
    $target_dir  = "../uploads/avatars/";
    // $userUniq = md5($login_session); // md5 hash of the username to create a unique folder for each user
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;

    //explode the file name to get the extension
    $fileType = pathinfo($target_file, PATHINFO_EXTENSION);
    $whiteList = array('jpg', 'png', 'jpeg', 'gif'); // list of allowed file extensions
    if (!in_array($fileType, $whiteList)) {
        echo "<script>alert('Sorry, only JPG, JPEG, PNG & GIF files are allowed!');window.location.href='userProfile.php';</script>";
        $uploadOk = 0;
    }

    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"], $fileType); // check image
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        echo "<script>alert('File is not an image!');window.location.href='userProfile.php';</script>";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["fileToUpload"]["size"] > 500000) { // 500kb
        echo "<script>alert('Sorry, your file is too large!');window.location.href='userProfile.php';</script>";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "<script>alert('Sorry, your file was not uploaded!');window.location.href='userProfile.php';</script>";
        // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            if ($oldAvatar == $target_file) {
                echo "<script>alert('You have already uploaded this file!');window.location.href='userProfile.php';</script>";
            } else {
                try {
                    $sql = "update users set avatar = :avatar where username = :username";
                    $stmt = $conn->prepare($sql);
                    $stmt->bindParam(':avatar', $target_file);
                    $stmt->bindParam(':username', $login_session);
                    $stmt->execute();
                    echo "<script>alert('Update avatar successful!');window.location.href='userProfile.php';</script>";
                } catch (PDOException $e) {
                    echo "Error: " . $e->getMessage();
                }
            }
        } else {
            echo "<script>alert('Sorry, there was an error uploading your file!');window.location.href='userProfile.php';</script>";
        }
    }
}
