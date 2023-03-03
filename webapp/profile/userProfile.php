<?php
require_once("../auth/session.php");
session_start();
$username = strtoupper($login_session);
try {
  $sql = "SELECT * FROM users WHERE username = :username";
  $result = $conn->prepare($sql);
  $result->bindParam(':username', $username, PDO::PARAM_STR);
  $result->execute();
  $num = $result->rowCount();
  if ($num == 1) {
    $row = $result->fetch(PDO::FETCH_ASSOC);
    $password = $row['userPassword'];
    $firstname = $row['firstname'];
    $lastname = $row['lastname'];
    $creditCard = $row['creditCard'];
    $userEmail = $row['userEmail'];
    $phone = $row['phone'];
    $avatar_path = $row['avatar'];
    $balance = $row['balance'];
    $premium = $row['premiumTier'];
    $preExpireDate = $row['premireExpire'];
    $preExpireDate = date("d-m-Y", strtotime($preExpireDate));
    if ($preExpireDate == "01-01-1970") {
      $preExpireDate = "N/A";
    }
  }
} catch (PDOException $e) {
  echo "Error: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Profile</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1,
		shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
  <!-- Bootstrap CSS -->
  <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css'>
  <!-- Font Awesome CSS -->
  <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css'>
</head>

<body style="background-color: wheat;">
  <!-- welcome -->
  <center>
    <h1>☜︎☹︎✋︎❄︎☜︎ 𝕸𝕰𝕸𝕰 𝕹𝕱𝕿 ⤜($ ͟ʖ$)⤏</h1>
  </center>
  <h3>
    <center>Welcome <?php echo "<em style=color:red font: bold;>" . $username . "</em>"; ?>!</center>
  </h3>
  <!-- logout -->
  <div class="container">
    <div class="row">
      <div class="col">
        <a href="../auth/logout.php" class="btn btn-primary float-lg-left bg-danger">Logout</a>
        <a href="../services/main.php" class="btn btn-primary float-lg-right ">Main menu</a>
      </div>
    </div>
  </div>
  <br>
  <div class="container">
    <div class="row">
      <div class="col">
        <a href="../services/transaction.php" class="btn btn-primary float-lg-left ">Send Money</a>
        <a href="../services/cart.php" class="btn btn-primary float-lg-right ">Cart</a>
      </div>
    </div>
  </div>
  <!--  premium  -->
  <h2>
    <center>Premium Tier: <?php echo htmlspecialchars($premium) ?></center>
    <center><small class="text-muted d-sm-table-cell">Premium expire date: <?php echo htmlspecialchars($preExpireDate) ?></small></center>
    <center><a href="./premium.php?tier=<?php echo htmlspecialchars($premium) ?>" class="btn small">Click here to upgrade</a></center>
  </h2>
  <!-- display balance -->
  <h2>
    <center>Balance: <?php echo htmlspecialchars($balance) ?> ฿฿฿</center>
  </h2>
  <!-- top up balance -->

  <!-- test overflow bruh -->
  <form action="../services/topup.php" method="POST">
    <!-- amount -->
    <center>
      <input type="number" id="topup" name="topup" placeholder="Top up amount of ฿฿฿" required="required" min="0" step="0.01">
    </center>
    <br>
    <!-- CVV -->
    <center>
      <input type="number" id="cvv" name="cvv" placeholder="CVV" required="required" step="000" min="0" max="999">
      <button type="submit" name="submit">Confirm</button>
    </center>
  </form>
  <!-- top up balance -->
  <?php
  if ($premium === 3) {
    echo "<br><a href=''><center><small class='text-muted d-sm-table-cell'>Link to our onion site</small></center></a>";
  }
  ?>
  <!-- update avatar -->
  <div class="container my-4 ">
    <form method="POST" action="./avaHandle.php" enctype="multipart/form-data">
      <div class="form-group">
        <img src="<?php echo htmlspecialchars($avatar_path) ?>" alt="avatar" width="100" height="100">
        <input type="file" name="fileToUpload" id="fileToUpload" accept="image/png, image/jpeg, image/jpg, image/gif" required>
        <input type="submit" value="Change avatar" name="submit" id="submit">
      </div>
    </form>
  </div>
  <!-- update avatar -->
  <!-- update profile -->
  <div class="container my-4 ">
    <form method="POST" action="./updateProfile.php">
      <div class="form-group">
        <label for="username">Username</label>
        <small id="emailHelp" class="form-text text-muted"> Unique </small>
        <input type="text" class="form-control" id="username" name="username" value="<?php echo  htmlspecialchars($username) ?>" readonly>
      </div>

      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" class="form-control" id="password" name="password">
      </div>

      <div class="form-group">
        <label for="cpassword">Confirm Password</label>
        <input type="password" class="form-control" id="cpassword" name="cpassword">
        <small id="emailHelp" class="form-text text-muted">
          Make sure to type the same password
        </small>
      </div>

      <div class="form-group">
        <label>Firstname</label>
        <input type="text" class="form-control" id="firstname" name="firstname" value="<?php echo  htmlspecialchars($firstname) ?>" maxlength="50" />
      </div>

      <div class="form-group">
        <label>Lastname</label>
        <input type="text" class="form-control" id="lastname" name="lastname" value="<?php echo  htmlspecialchars($lastname) ?>" maxlength="50" />
      </div>

      <div class="form-group">
        <label>Credit Card</label>
        <input type="number" class="form-control" id="creditCard" name="creditCard" value="<?php echo  htmlspecialchars($creditCard) ?>" min="0" maxlength="16" />
      </div>

      <div class="form-group">
        <label>Email</label>
        <input type="text" class="form-control" id="email" name="email" value="<?php echo  htmlspecialchars($userEmail) ?>" maxlength="100" />
      </div>

      <div class="form-group">
        <label>Phone</label>
        <input type="text" class="form-control" id="phone" name="phone" value="<?php echo  htmlspecialchars($phone) ?>" min="0" maxlength="12" />
      </div>

      <center><button class="btn btn-primary" id="save" name="save">Save</button></center>
    </form>
  </div>
  <!-- update profile -->
  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->

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