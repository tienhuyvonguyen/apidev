<?php
include '../auth/session.php';
include '../db/dbConnect.php';
session_start();
$userTier = $_SESSION['premiumTier'];
if ($userTier == 1) {
  $saleOff = 0.2;
} elseif ($userTier == 2) {
  $saleOff = 0.3;
} elseif ($userTier == 3) {
  $saleOff = 0.4;
} else {
  $saleOff = 0;
}

// show products from database
try {
  $sql = "SELECT * FROM product";
  $stmt = $conn->prepare($sql);
  $stmt->execute();
  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
  echo "Error: " . $e->getMessage();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title> ⤜($ ͟ʖ$)⤏</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
</head>

<body class="text-center" style="background-color: wheat;">
  <center>
    <h1>☜︎☹︎✋︎❄︎☜︎ 𝕸𝕰𝕸𝕰 𝕹𝕱𝕿 ⤜($ ͟ʖ$)⤏</h1>
  </center>
  <?php
  if ($userTier != 0) {
    echo "<h>You are a premium member! You get " . $saleOff * 100 . "% off on all product!</h>";
  } else {
    echo "<a href='../profile/premium.php'>Upgrade to premium to get promotion on all product!</a>";
  }
  ?>
  <div class="container">
    <div class="row">
      <div class="col">
        <a href="../auth/logout.php" class="btn btn-primary float-lg-left bg-danger" >Logout</a>
        <a href="./checkout.php" class="btn btn-primary float-lg-right ">Checkout</a>
      </div>
    </div>
  </div>
  <br>
  <div class="container">
    <div class="row">
      <div class="col">
        <a href="../profile/userProfile.php" class="btn btn-primary float-lg-left ">Profile</a>

        <a href="./cart.php" class="btn btn-primary float-lg-right ">Cart</a>
      </div>
    </div>
  </div>
  <br>
  <div class="container">
    <div class="row">
      <?php foreach ($result as $row) {
        $price = $row["price"];
        $price -= ($price * $saleOff); ?>
        <div class="col-md-3">
          <form method="POST" action="addToCart.php?id=<?php echo htmlspecialchars($row["productID"]); ?>">
            <div class="product">
              <!-- item to show -->
              <img src="<?php echo htmlspecialchars($row["picture"]); ?>" class="img-responsive" height="250px" width="250px">
              <h5 class="text-info"><?php echo htmlspecialchars($row["name"]); ?></h5>
              <?php
              if ($userTier != 0) {
                echo "<h5 class='text-danger'  style='text-decoration: line-through;'>฿฿฿ " . number_format($row["price"], 2) . "</h5>";
              }
              ?>
              <h5 class="text-danger">฿฿฿ <?php
                                          echo number_format($price, 2);  ?></h5>
              <h5 class="text-center">Stock: <?php if ($row["stock"] > 0) {
                                                echo htmlspecialchars($row["stock"]);
                                              } else {
                                                echo "Out of stock";
                                              } ?></h5>
              <!-- item to show -->
              <!-- hidden item to pass through -->
              <input type="hidden" name="hidden_name" value="<?php echo htmlspecialchars($row["name"]); ?>">
              <input type="hidden" name="hidden_price" value="<?php echo htmlspecialchars($price); ?>">
              <input type="hidden" name="hidden_stock" value="<?php echo htmlspecialchars($row["stock"]); ?>">
              <input type="hidden" name="hidden_id" value="<?php echo htmlspecialchars($row["productID"]); ?>">
              <input type="hidden" name="hidden_picture" value="<?php echo htmlspecialchars($row["picture"]); ?>">
              <!-- hidden item to pass through -->
              <input type="number" name="quantity" class="form-control" value="1" min="0" maxlength="10" max="<?php echo $row["stock"] ?>">
              <?php if ($row["stock"] > 0) { ?>
                <input type="submit" name="add_to_cart" style="margin-top:5px;" class="btn btn-success" value="Add to Cart">
              <?php } else { ?>
                <input type="submit" name="add_to_cart" style="margin-top:5px;" class="btn btn-success" value="Add to Cart" disabled>
              <?php } ?>
              <br> <br>
            </div>
          </form>
        </div>
      <?php } ?>
    </div>
  </div>
  <br>
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

</html>
<style>
  * {
    -moz-box-sizing: border-box;
    -webkit-box-sizing: border-box;
    box-sizing: border-box;
    margin: 0;
    padding: 0;
  }

  .HoverDiv {
    position: relative;
    overflow: hidden;
    border: 1px solid black;
    width: 360px;
    margin: 10px;
  }

  .HoverDiv img {
    max-width: 100%;
    text-align: center;
    -moz-transition: all 0.3s;
    -webkit-transition: all 0.3s;
    transition: all 0.3s;
  }

  .HoverDiv:hover img {
    -moz-transform: scale(1.1);
    -webkit-transform: scale(1.1);
    transform: scale(1.1);
  }

  img {
    display: inline-block;
    border: 1px solid #ddd;
    border-radius: 4px;
    padding: 5px;
    transition: 0.3s;
    position: relative;
    z-index: 1;
  }

  img:hover {
    transform: scale(1.5);
  }
</style>