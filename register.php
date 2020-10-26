<?php

//including congig file script.
require_once"config.php";

//declaring variables/
$username=$email=$password=$cpassword="";
$username_err=$email_err=$password_err=$cpassword_err="";

if($_SERVER["REQUEST_METHOD"]=="POST")
{
    //validating username.
    if(empty(trim($_POST["username"])))
    {
        $username_err="Please Enter a Username.";
    }
    else
    {   
        $username=$_POST["username"];

        $sql1 = "SELECT `username` FROM `UserAuth` WHERE `username`='$username'";
        $qry1 = mysqli_query($connection, $sql1);

        if (mysqli_num_rows($qry1) > 0) {
        
            $username_err = "Username already exists.";   

        }

    }
    
    //validating Email.
    if(empty(trim($_POST["email"])))
    {
        $email_err="Please Enter a email.";
    }
    else
    {
        $email=$_POST["email"];
    }
    
    
    //validating password.
    if(empty(trim($_POST["password"])))
    {
        $password_err="Please Enter a Password.";
    }
    elseif(strlen(trim($_POST["password"])) < 6)
    {
         $password_err="Password should be of atleast 6 characters";
    }
    else
    {
        $password=trim($_POST["password"]);
    }

    //validating confirm password.
    if(empty(trim($_POST["cpassword"])))
    {
        $cpassword_err="Please Confirm Password.";
    }
    else
    {
        $cpassword=trim($_POST["cpassword"]);
        if(empty($password_err) && ($password!=$cpassword))
        {
            $cpassword_err="Password did not match.";
        }
    }

    //checking input error before inserting into database.
    if(empty($username_err) && empty($email_err) && empty($password_err) && empty($cpassword_err))
    {
        //creating sql query.
       $sql= "INSERT INTO `UserAuth`(`username`,`email`,`password`) VALUES ('$username','$email','$password')";

        //executing query in database.
        $qry= mysqli_query($connection,$sql);
        
        if($qry){

            // Redirect to login page
            header("location: login.php");
        } else{
            echo "Something went wrong. Please try again later.";
        }
    
    }
    //closing connection.
    mysqli_close($connection);
}

?>



<!DOCTYPE html>
<html>  
<!-- Specify the character encoding for the HTML document:    -->
<meta charset="UTF-8">
<title> User Registration </title>
<!-- including css to the html script -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
<!-- declaring style for the css  -->
<style type="text/css">
    body{ font: 14px sans-serif; }
    .wrapper{ width: 350px; padding: 20px; }
</style>
<body>
<div class="wrapper">
  <h2> Sign Up</h2>
  <p> Fill this form to create an account. </p>
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
  <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
    <label> Username</label>
    <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
    <span class="help-block"><?php echo $username_err ;?></span> 
  </div>
  <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
    <label> Email</label>
    <input type="email" name="email" class="form-control" value="<?php echo $email; ?>">
    <span class="help-block"><?php echo $email_err ;?></span> 
  </div>
  <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
    <label> Password</label>
    <input type="password" name="password" class="form-control" value="<?php echo $password ;?>"> 
    <span class="help-block"> <?php echo $password_err ;?></span>
  </div>
  <div class="form-group <?php echo (!empty($cpassword_err)) ? 'has-error' : '';?>">
    <label> Confirm Password</label>
    <input type="password" name="cpassword" class="form-control" value="<?php echo $cpassword ;?>">
    <span class="help-block"> <?php echo $cpassword_err; ?></span>
  </div>
  <div class="form-group">
    <input type="submit" class="btn btn-primary" value="Submit"> 
    <input type="reset" class="btn btn-default" value="Reset"> 
  </div>
  <p> Already have an account? <a href="login.php"> Login Here </a>. </p>
  </form>
</div>
</body>
</html>