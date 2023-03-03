<?php
include('../auth/session.php');
try {
    $sql = "select * from users where username = :username";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':username', $login_session, PDO::PARAM_STR);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
$balance = $row['balance'];
$premiumTier = $row['premiumTier'];
$username  = $row['username'];

if (isset($_GET['tier'])) {
    $tier = htmlspecialchars($_GET['tier']);
    if ($tier < $premiumTier) {
        echo "<script>alert('You cannot downgrade your premium tier!');window.location.href='premium.php';</script>";
        die();
    } elseif ($tier == $premiumTier) {
        header("Location: premium.php");
        die();
    }
    $warning = "<script>window.confirm('Are you sure to subscribe $tier')</script>";
    echo $warning;
    if ($warning) {
        $prepareBalance = $balance;
        if ($tier == 1) {
            $price = 500;
            $expireDate = date('Y-m-d', strtotime('+1 month'));
            $priceOffer = 20;
        } elseif ($tier == 2) {
            $price = 1000;
            $expireDate = date('Y-m-d', strtotime('+6 month'));
            $priceOffer = 30;
        } elseif ($tier == 3) {
            $price = 2000;
            $expireDate = date('Y-m-d', strtotime('+12 month'));
            $priceOffer = 40;
        }
        if ($prepareBalance >= $price) {
            $prepareBalance = $prepareBalance - $price;
            $sql = "UPDATE users SET
                            balance = :balance,
                            premiumTier = :tier,
                            premireExpire = :expireDate
                        WHERE username = :username  ";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':balance', $prepareBalance);
            $stmt->bindParam(':tier', $tier);
            $stmt->bindParam(':expireDate', $expireDate);
            $stmt->bindParam(':username', $username);
            $stmt->execute();
            $_SESSION['premiumTier'] = $tier;
            echo "<script>alert('You have successfully upgraded to premium tier $tier!');window.location.href='premium.php';</script>";
        } elseif ($prepareBalance < $price) {
            echo "<script>alert('You do not have enough balance to upgrade to premium tier $tier!');window.location.href='premium.php';</script>";
        } else {
            // set header 500 error
            header("HTTP/1.0 500 Internal Server Error");
        }
    } else {
        header("location: premium.php");
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Premium Register</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1,
		shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
</head>

<body style="background-color: wheat;">
    <!-- welcome -->
    <h1>
        <center>Premium register</center>
    </h1>

    <!-- anchor -->
    <div class="container">
        <div class="row">
            <div class="col">
                <a href="../services/main.php" class="btn btn-primary float-lg-right ">Main menu</a>
                <a href="../profile/userProfile.php" class="btn btn-primary float-lg-right ">Profile</a>
                <medium>User: <strong style=color:red><?php echo htmlspecialchars($login_session) ?></strong></medium>
                <br>
                <medium>Tier: <em style=color:red><?php echo htmlspecialchars($premiumTier) ?></em></medium>
                <br>
                <medium>Balance: <em style=color:red><?php echo htmlspecialchars($balance) ?></em> ฿฿฿</medium>
            </div>
        </div>
    </div>
    <!--  premmium options -->
    <div class="container">
        <div class="row">
            <center>
                <div class="col">
                    <div class="card" style="width: 18rem;">
                        <img src="../uploads/699013.jpg" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title`">Premium 1</h5>
                            <p class="card-text">Price: 500฿฿฿</p>
                            <p class="card-text">Expire date: 1 month</p>
                            <p>Benefits: 20% off</p>
                            <a href="./premium.php?tier= <?= $tier = 1 ?>" class="btn btn-primary">Subscribe</a>
                        </div>
                    </div>
                </div>
            </center>
            <center>
                <div class="col">
                    <div class="card" style="width: 18rem;">
                        <img src="../uploads/satan.jpeg" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title ">Premium 2</h5>
                            <p class="card-text">Price: 1000฿฿฿</p>
                            <p class="card-text">Expire date: 6 months</p>
                            <p>Benefits: 30% off </p>
                            <a href="./premium.php?tier=<?= $tier = 2 ?>" class="btn btn-primary">Subscribe</a>
                        </div>
                    </div>
                </div>
            </center>

            <center>
                <div class="col">
                    <div class="card" style="width: 18rem;">
                        <img src="../uploads/baphomet-satanic-pentagram-black-red-sofia-metal-queen.jpg" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title ">Premium 3</h5>
                            <p class="card-text">Price: 2000฿฿฿</p>
                            <p class="card-text">Expire date: 1 year</p>
                            <p>Benefits: Tier 2 + .onion site</p>
                            <a href="./premium.php?tier=<?= $tier = 3 ?>" class="btn btn-primary">Subscribe</a>
                        </div>
                    </div>
                </div>
            </center>

        </div>
    </div>

</body>