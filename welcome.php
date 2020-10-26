<?php

//session start.
session_start();

//check if the user is logged in , if not then redirect it to the login page.
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}


?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title> Welcome </title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body {
            font: 14px sans-serif;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="page-header">
        <h1>Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Welcome to our site.</h1>
        <h1> You are logged in at time : <b><?php echo htmlspecialchars($_SESSION["logtime_h"]); ?></b> </h1>
    </div>
    <p>
        <a href="reset_pass.php"class='btn btn-warning'>Reset Your Password</a>
        <a href="logout.php" class="btn btn-danger">Sign Out of Your Account</a>
    </p>
</body>
</html>
