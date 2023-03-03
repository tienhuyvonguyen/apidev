<?php
include "../controller/lib.php";
session_start();
$showError = login();
?>

<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1,
		shrink-to-fit=no">
    <title>Login</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>

<body style="background-color: burlywood;">
    <center>
        <h1>☜︎☹︎✋︎❄︎☜︎ 𝕸𝕰𝕸𝕰 𝕹𝕱𝕿 ⤜($ ͟ʖ$)⤏</h1>
    </center>

    <?php

    if ($showAlert) {

        echo ' <div class="alert alert-success
			alert-dismissible fade show" role="alert">
	
			<strong>Success!</strong> Your account is
			now created and you can login.
			<button type="button" class="close"
				data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">×</span>
			</button>
		</div> ';
    }

    if ($showError) {

        echo ' <div class="alert alert-danger
			alert-dismissible fade show" role="alert">
		<strong>Error!</strong> ' . $showError . '
	
	<button type="button" class="close"
			data-dismiss="alert aria-label="Close">
			<span aria-hidden="true">×</span>
	</button>
	</div> ';
    }

    if ($exists) {
        echo ' <div class="alert alert-danger
			alert-dismissible fade show" role="alert">
	
		<strong>Error!</strong> ' . $exists . '
		<button type="button" class="close"
			data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">×</span>
		</button>
	</div> ';
    }

    ?>

    <div class="container my-4 ">
        <h1 class="text-center">Login</h1>
        <form action="login.php" method="POST">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" name="username" aria-describedby="emailHelp" required="required" value="<?php if (isset($_COOKIE["user_login"])) {
                                                                                                                                                    echo htmlspecialchars($_COOKIE["user_login"]);
                                                                                                                                                } ?>">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" required="required" value="<?php if (isset($_COOKIE["userpassword"])) {
                                                                                                                            echo htmlspecialchars($_COOKIE["userpassword"]);
                                                                                                                        } ?>">
            </div>
            <!-- captcha -->
            <div class="g-recaptcha" data-sitekey="6LfPILkkAAAAAPLQr-ZlDqxIelWJN1QyvFCEGv6U">
            </div>
            <br>
            <!-- captcha -->

            <!-- remember me -->
            <div class="field-group">
                <div><input type="checkbox" name="remember" id="remember" <?php if (isset($_COOKIE["user_login"])) { ?> checked <?php } ?> /> </div>
                <label for="remember-me">Remember me</label>
            </div>
            <!-- remember me -->

            <button type="submit" class="btn btn-primary">
                Login
            </button>
            <a href="signup.php" class="btn btn-primary">
                Signup
            </a>
            <a href="../index.php" class="btn btn-primary">
                Home
            </a>
            <!-- forgot password -->
            <a href="forgotPassword.php" class="btn btn-primary disabled">
                Forgot Password
            </a>
        </form>
    </div>
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
<style>
    .container1 {
        border: 1px solid rgb(73, 72, 72);
        border-radius: 10px;
        margin: auto;
        padding: 10px;
        text-align: center;
    }

    h1 {
        margin-top: 10px;
    }

    button {
        border-radius: 5px;
        padding: 10px;
        color: #fff;
        background-color: #167deb;
        border-color: #0062cc;
        font-weight: bolder;
        cursor: pointer;
    }

    button:hover {
        text-decoration: none;
        background-color: #0069d9;
        border-color: #0062cc;
    }

    .g-recaptcha {
        margin-left: 0px;
    }
</style>