<?php
// Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
   
        header("location: admin.php");
  
  exit;
}
 
// Include config file
require_once "config.php";
require "functions.php";
 
// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT id, position, username, firstname, lastname, anumber, password FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = $username;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $position, $username, $firstname, $lastname, $anumber, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session
                           //session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["position"] = $position;
                            $_SESSION["username"] = $username;                     
                            $_SESSION["firstname"] = $firstname;
                            $_SESSION["username"] = $username;                 
                            $_SESSION["anumber"] = $anumber;                            
                            
                            // clock tutor in
                            $output = clock_in( $position, $anumber, $firstname, $lastname, $link);
                            echo "<script>console.log( $output );</script>";
                          
                            header("location: admin.php");
                          
                            
                        } else{
                            // Display an error message if password is not valid
                            $password_err = "The password you entered was not valid.";
                        }
                    }
                } else{
                    // Display an error message if username doesn't exist
                    $username_err = "No account found with that username.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($link);
}
?>
 



<!DOCTYPE html>
<html id="landpage" lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <script src="scripts/jquery-3.4.1.min.js"> </script>
    <link rel="stylesheet" href="styling.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">
</head>
<body>   
<div id="mainpage">

<div class="wrapper">
        <h3 id="mathlab">mathlab</h3>
        <!-- <p>Please fill in your credentials to login.</p> -->
</div> 

<div id="mainform">
        <form id="loginform" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
            <label id="editlaba">Username</label>
            <span class="ibox"><input type="text" id="username" name="username" class="form-control"> </span>
                <span class="help-block"><?php echo $username_err; ?></span>
            </div><br>


            <div class="form-group1 <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
            <label id="editlaba">Password</label> 
            <span class="ibox"><input type="password" id="password" name="password" class="form-control"></span>
            <span class="help-block"><?php echo $password_err; ?></span>

            <input id="loginbtn" type="submit" class="btn btn-primary" value=">">
            </div> 

              

            <!-- <div class="form-group"> -->
               
            <!-- </div> -->
            <!-- <p>Don't have an account? <a href="register_tutor.php">Sign up now</a>.</p> -->
        </form>

</div>

</div>     
</body>
</html>
