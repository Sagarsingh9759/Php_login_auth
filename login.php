<?php

//starting session.
session_start();

//checking if the user is already logged in, if yeas then redirect it to the welcome page.
if (isset($_SESSION["loggedin"]) && ($_SESSION["loggedin"] === true)) {
    header("location: welcome.php");
    exit;
}

//including config file for connection access to database.
require_once "config.php";

//defining variables.
$username = $password = "";
$username_err = $password_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //Checking if username is empty.
    if (empty(trim($_POST["username"]))) {
        $username_err = "Please Enter a Username.";
    } else {
        $username = trim($_POST["username"]);
    }

    //checking if password id empty.
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please Enter a Password.";
    } else {
        $password = trim($_POST["password"]);
    }

    //Validating Credentials.
    if (empty($username_err) && empty($password_err))
    {
        $sql = "SELECT `id` FROM `UserAuth` WHERE (`username`='$username')";
        $qry = mysqli_query($connection, $sql);
        if ($qry)
        {
            if (mysqli_num_rows($qry) > 0)
            {
                $data = mysqli_fetch_assoc($qry);
                $userid = $data['id'];
                $sql1 = "SELECT `username`,`email` FROM `UserAuth` WHERE `id`='$userid' AND `password`='$password'";
                $qry1 = mysqli_query($connection, $sql1);

                if ($qry1)
                { 
                    if (mysqli_num_rows($qry1) > 0)
                     {

                        //fetching data from $qry.
                        $data1 = mysqli_fetch_assoc($qry1);
    
                        //storing values in session variable.
                        $_SESSION["loggedin"] = true;
                        $_SESSION["username"] = $data1["username"];
                        $_SESSION["email"] = $data1["email"];
                        $_SESSION["logtime_h"]= date("h:i:s");
                        $_SESSION["logtime"]=time();
                        setcookie("username",$data1["username"]);
                        setcookie("password",$password);
                      
                        //redirecting user to welcome page.
                       // header("location: welcome.php");
                    }
                    else
                    {
                       $password_err=" Wrong Password";
                    }
                } 
                else 
                {
                    echo "OPSS!!!!. Something went wrong.";
                }
            }  
            else
            {
                $username_err="Wrong Username";
            }
        }
        else
        {
            echo " OPSS!!!!. Something Went Wrong.";
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
<title> Login </title>
<!-- including css to the html script -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
<!-- declaring style for the css  -->
<style type="text/css">
    body {
        font: 14px sans-serif;
    }

    .wrapper {
        width: 350px;
        padding: 20px;
    }
</style>

<body>
    <div class="wrapper">
        <h2> Login </h2>
        <p> Please fill in your credentials to login. </p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label> Username</label>
                <input type="text" name="username" class="form-control" value="<?php if(isset($_COOKIE["username"])) { echo $_COOKIE["username"]; } ?>">
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label> Password</label>
                <input type="password" name="password" class="form-control" value=" <?php if(isset($_COOKIE["password"])) { echo $_COOKIE["password"]; } ?>">
                <span class="help-block"> <?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Login">
            </div>
            <p> Don't have an account? <a href="register.php"> Sign Up now </a>. </p>
        </form>
    </div>
</body>

</html>