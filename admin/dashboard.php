<!-- simple dashboard -->
<?php
echo "<script>alert('Welcome to the dashboard')</script>";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="login.css">
    <title>Dashboard</title>
</head>

<body>
    <h1>Dashboard</h1>
    <!-- create a logout button -->
    <form action="logout.php" method="POST">
        <input class="button" type="submit" name="logout" value="Logout">
    </form>
</body>