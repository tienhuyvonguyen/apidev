<?php
include '../auth/session.php';
session_start();
// save the cart to the session
if (isset($_POST["add_to_cart"])) {
    $stock = $_POST["hidden_stock"];
    $quantity = $_POST["quantity"];
    if ($quantity <= 0) {
        echo "<script>alert('Quantity must be greater than 0!'); window.location.href = './main.php';</script>";
    }
    if ($quantity > $stock) {
        echo "<script>alert('Not enough stock!')</script>";
        echo "<script>window.location='main.php'</script>";
    } else {
        if (isset($_SESSION["shopping_cart"])) { // if the cart is not empty
            $item_array_id = array_column($_SESSION["shopping_cart"], "item_id");
            // if the item is not in the cart
            if (!in_array($_GET["id"], $item_array_id)) {
                $count = count($_SESSION["shopping_cart"]);
                $item_array = array(
                    'item_id' => $_GET["id"],
                    'item_name' => $_POST["hidden_name"],
                    'item_price' => $_POST["hidden_price"],
                    'item_quantity' => $_POST["quantity"],
                    'item_picture' => $_POST["hidden_picture"]
                );
                $_SESSION["shopping_cart"][$count + 1] = $item_array;
                echo "<script>alert('Item added to cart!'); window.location.href = './main.php';</script>";
            } else { // if the item is already in the cart 
                // update the quantity of the item in the cart to the new quantity (add the new quantity to the old quantity)
                foreach ($_SESSION["shopping_cart"] as $keys => $values) {
                    if ($values["item_id"] == $_GET["id"]) {
                        $_SESSION["shopping_cart"][$keys]["item_quantity"] += $_POST["quantity"];
                        echo "<script>alert('Item Added to Cart')</script>";
                        echo "<script>window.location='../services/main.php'</script>";
                    }
                }
            }
        } else { // if the cart is empty
            $item_array = array(
                'item_id' => $_GET["id"],
                'item_name' => $_POST["hidden_name"],
                'item_price' => $_POST["hidden_price"],
                'item_quantity' => $_POST["quantity"],
                'item_picture' => $_POST["hidden_picture"]
            );
            $_SESSION["shopping_cart"][0] = $item_array;
            echo "<script>alert('Item Added to Cart')</script>";
            echo "<script>window.location='../services/main.php'</script>";
        }
    }
}
