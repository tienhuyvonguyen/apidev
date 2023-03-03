<?php
// remove item from cart (remove the item from the session)
session_start();
if (isset($_GET["action"])) {
    if ($_GET["action"] == "remove") {
        $removeQuantity = $_POST["numberRemove"];
        $removeID = $_POST["hidden_id"];
        $cart = $_SESSION["shopping_cart"];
        if (!empty($cart)) {
            foreach ($cart as $key => $value) {
                if ($value["item_id"] == $removeID) {
                    if ($value["item_quantity"] == $removeQuantity) {
                        unset($_SESSION["shopping_cart"][$key]);
                        echo '<script>alert("Item Removed")</script>';
                        echo '<script>window.location="cart.php"</script>';
                    } else {
                        $_SESSION["shopping_cart"][$key]["item_quantity"] -= $removeQuantity;
                        echo '<script>alert("Item Removed")</script>';
                        echo '<script>window.location="cart.php"</script>';
                    }
                }
            }
        }
    }
}
