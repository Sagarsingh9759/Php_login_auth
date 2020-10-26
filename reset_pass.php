<?php 
session_start();

if(!isset($_SESSION["loggedin"] )|| $_SESSION["loggedin"]!== true)
{
   header("location: login.php");
   exit;
}

require_once "config.php";

$password=$cpassword="";
$password_err=$cpassword_err="";

$curr_time = time();
$logtime=$_SESSION["logtime"]; 
$min = floor(($curr_time - $logtime)/60);
echo $min;

if($min<1)
{
    if($_SERVER["REQUEST_METHOD"]=="POST")
    {    
        
           //validating new password
        if(empty(trim($_POST["password"])))
        {
            $password_err=" Enter New Password.";
        }
        elseif(strlen(trim($_POST["password"])) < 6 )
        {
            $password_err=" Password should be at least of 6 characters.";
        }
        else{
            $password= trim($_POST["password"]);
        }
    
        //validating confirm password.
        if(empty(trim($_POST["cpassword"])))
        {
            $cpassword_err="PLease Confirm Password";
        }
        else
        {
            $cpassword=$_POST["cpassword"];
            if(empty($cpassword_err) && ($password != $cpassword))
            {
                $cpassword_err="Password not matched!";
            }
        }
    
        if(empty($password_err) && empty($cpassword_err))
        {
            $username= $_SESSION["username"];
            $sql="UPDATE `UserAuth` SET `password` = '$password' where `username`= '$username'";
            $qry= mysqli_query($connection,$sql);
            if($qry)
            {
               session_destroy();
               header("location: login.php");
               exit;
            }
            else{
                echo " OPSS!! Something went wrong.";
            }
        }
        
    }
}
else
{
    session_destroy();
   header("location: login.php");
    exit();
}
?>


<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title> Reset Password </title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
<style type="text/css">
    body {
        font: 14px sans-serif;
    }

    .wrapper {
        width: 350px;
        padding: 20px;
    }
</style>
</head>
<body>
<div class="wrapper">
        <h2> Reset Password </h2>
        <p> Enter your new password. </p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label> New Password</label>
                <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($cpassword_err)) ? 'has-error' : ''; ?>">
                <label> Confirm Password</label>
                <input type="password" name="cpassword" class="form-control" value="<?php echo $cpassword; ?>">
                <span class="help-block"> <?php echo $cpassword_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Save">
                <a class="btn btn-link" href="welcome.php">Cancel</a>
            </div>
            
        </form>
    </div>
</body>
</html>
       