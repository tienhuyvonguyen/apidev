<?php
session_start();
include '../auth/session.php';
include '../db/dbConnect.php';
$username = strtoupper($login_session);
try {
    $sql = "SELECT * FROM product ";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $product = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
try {
    $sql = "select * from users where username = :username";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':username', $username, PDO::PARAM_STR);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
$cart = $_SESSION['shopping_cart'];
$cartTotal = 0;
if ($cart != null && $cart != "") {
    foreach ($cart as $key => $value) {
        $cartTotal += $value['item_price'] * $value['item_quantity'];
    }
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //update user balance
    $newBalance = $user['balance'] - $cartTotal;
    if ($newBalance < 0) {
        echo "<script>alert('Insufficient funds! You should top up your wallet!'); window.location.href = '../profile/userProfile.php';</script>";
    } else {
        try {
            $sql = "UPDATE users SET
                        balance = :balance
                    WHERE username = :username ";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':balance', $newBalance);
            $stmt->bindParam(':username', $username);
            $stmt->execute();
            foreach ($cart as $item) {
                try {
                    $sql = "UPDATE product SET
                                stock = stock - :quantity
                            WHERE productID = :product_id ";
                    $stmt = $conn->prepare($sql);
                    $stmt->bindParam(':quantity', $item['item_quantity']);
                    $stmt->bindParam(':product_id', $item['item_id']);
                    $stmt->execute();
                } catch (PDOException $e) {
                    echo "Error: " . $e->getMessage();
                }
            }
            unset($_SESSION['shopping_cart']);
            echo "<script>alert('Order placed! Thank you for shopping with us!'); window.location.href = './main.php';</script>";
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>CHECKOUT ⤜($ ͟ʖ$)⤏</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
</head>

<body style="background-color: wheat;">
    <center>
        <h1>☜︎☹︎✋︎❄︎☜︎ 𝕸𝕰𝕸𝕰 𝕹𝕱𝕿 ⤜($ ͟ʖ$)⤏</h1>
    </center>
    <div class="container">
        <a href="./main.php" class="btn btn-primary float-left ">Main menu</a>
        <a href="../profile/userProfile.php" class="btn btn-primary float-lg-right ">Profile</a>
    </div>
    <!-- show user balance -->
    <center>
        <div class="container">
            <h3>Balance: $<?php echo $user['balance']; ?></h3>
        </div>
    </center>
    <div class="container">
        <a href="../services/cart.php" class="btn btn-primary float-lg-right">Cart</a>
    </div>
    <br><br>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Checkout</h1>
                <table class="table table-striped" style="background-color: white;">
                    <thead>
                        <tr>
                            <th scope="col">Product</th>
                            <th scope="col">Price</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $cartTotal = 0;
                        if (!empty($cart)) {
                            foreach ($cart as $item) {
                                $cartTotal += $item['item_price'] * $item['item_quantity'];
                                echo "<tr>";
                                echo "<td>" . $item['item_name'] . "</td>";
                                echo "<td>" . number_format($item['item_price'], 2) . "</td>";
                                echo "<td>" . $item['item_quantity'] . "</td>";
                                echo "<td>" . number_format(($item['item_price'] * $item['item_quantity']), 2) . "</td>";
                                echo "</tr>";
                            }
                        }
                        ?>
                    </tbody>
                </table>
                <h3>Total: <?php echo number_format($cartTotal, 2); ?> ฿฿฿</h3>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                    <div class="form-group ">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="<?php echo $user['name']; ?>">
                    </div>
                    <div class="form-group
                    ">
                        <label for="address">Address</label>
                        <input type="text" class="form-control" id="address" name="address" value="<?php echo $user['address']; ?>">
                    </div>
                    <div class="form-group
                    ">
                        <label for="phone">Phone</label>
                        <input type="text" class="form-control" id="phone" name="phone" value="<?php echo $user['phone']; ?>">
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
    <!-- Bootstrap core JavaScript -->
    <script src="
https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="
sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>

    <script src="
https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
    </script>

    <script src="
https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous">
    </script>
</body>