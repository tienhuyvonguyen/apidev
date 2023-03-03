<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Cart</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
</head>

<!-- show user cart in session -->

<body class="text-center" style="background-color: wheat;">
    <center>
        <h1>☜︎☹︎✋︎❄︎☜︎ 𝕸𝕰𝕸𝕰 𝕹𝕱𝕿 ⤜($ ͟ʖ$)⤏</h1>
    </center>
    <center>
        <h1>Cart</h1>
    </center>
    <div class="container">
        <a href="./main.php" class="btn btn-primary float-left ">Main menu</a>
        <a href="../auth/logout.php" class="btn btn-primary float-lg-right bg-danger">Logout</a>
    </div>
    <br>
    <br>
    <div class="container">
        <div class="row">
            <div class="col">
                <a href="../profile/userProfile.php" class="btn btn-primary float-lg-right ">Profile</a>
            </div>
        </div>
    </div>
    <br>
    <div class="container">
        <div class="row">
            <?php
            if (isset($_SESSION['shopping_cart'])) {
                $cart = $_SESSION['shopping_cart'];
                foreach ($cart as $key => $value) {
                    $total += $value['item_quantity'] * $value['item_price'];
            ?>
                    <div class="col-md-3">
                        <div class="product">
                            <form action="removeCart.php?action=remove&id=<?php echo $value['item_id']; ?>" method="POST">
                                <div class="product">
                                    <img src="<?php echo $value['item_picture']; ?>" class="img-responsive" height="200px" width="200px" />
                                    <h5 class="text-info"><?php echo $value['item_name']; ?></h5>
                                    <h5 class="text-danger">฿฿฿ <?php echo number_format($value['item_price'], 2); ?></h5>
                                    <h5 class="text-danger">Quantity: <?php echo $value['item_quantity']; ?></h5>
                                    <h5 class="text-danger">Total: <?php echo number_format($value['item_quantity'] * $value['item_price'], 2); ?> ฿฿฿</h5>
                                    <!-- pass through item -->
                                    <input type="hidden" name="hidden_name" value="<?php echo $value['item_name']; ?>" />
                                    <input type="hidden" name="hidden_price" value="<?php echo $value['item_price']; ?>" />
                                    <input type="hidden" name="hidden_quantity" value="<?php echo $value['item_quantity']; ?>" />
                                    <input type="hidden" name="hidden_picture" value="<?php echo $value['item_picture']; ?>" />
                                    <input type="hidden" name="hidden_id" value="<?php echo $value['item_id']; ?>" />
                                    <!-- pass through item -->
                                    <!-- number to remove -->
                                    <input type="number" name="numberRemove" min="1" max="<?php echo $value['item_quantity']; ?>" value="1" />
                                    <input type="submit" name="remove" style="margin-top:5px;" class="btn btn-danger" value="Remove" />
                                    <br> <br>
                                </div>
                            </form>
                        </div>
                    </div>
            <?php
                }
            } elseif (empty($_SESSION['shopping_cart'])) {
                echo "<center><h1>Cart is empty</h1></center>";
            }
            ?>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col">
                <h1>Total: <?php echo number_format($total, 2); ?> ฿฿฿</h1>
            </div>
        </div>
    </div>
    <br>

    <div class="container">
        <center>
            <a href="./checkout.php" class="btn btn-primary">Checkout</a>
        </center>
    </div>
    <br>
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