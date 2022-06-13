<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, otherwise redirect to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
 
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$new_password = $confirm_password = $username = $password = "";
$new_password_err = $confirm_password_err = $username_err = $password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
     // Check if password is empty
     if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }


    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT password FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username =  $_SESSION["username"];
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session
                           

                            echo "heyyyyyy";

                                                    // Validate new password
                            if(empty(trim($_POST["new_password"]))){
                                $new_password_err = "Please enter the new password.";     
                            } elseif(strlen(trim($_POST["new_password"])) < 6){
                                $new_password_err = "Password must have atleast 6 characters.";
                            } else{
                                $new_password = trim($_POST["new_password"]);
                            }
                            
                            // Validate confirm password
                            if(empty(trim($_POST["confirm_password"]))){
                                $confirm_password_err = "Please confirm the password.";
                            } else{
                                $confirm_password = trim($_POST["confirm_password"]);
                                if(empty($new_password_err) && ($new_password != $confirm_password)){
                                    $confirm_password_err = "Password did not match.";
                                }
                            }
                                
                            // Check input errors before updating the database
                            if(empty($new_password_err) && empty($confirm_password_err)){
                                // Prepare an update statement
                                $sql = "UPDATE users SET password = ? WHERE id = ?";
                                
                                if($stmt = mysqli_prepare($link, $sql)){
                                    // Bind variables to the prepared statement as parameters
                                    mysqli_stmt_bind_param($stmt, "si", $param_password, $param_id);
                                    
                                    // Set parameters
                                    $param_password = password_hash($new_password, PASSWORD_DEFAULT);
                                    $param_id = $_SESSION["id"];
                                    
                                    // Attempt to execute the prepared statement
                                    if(mysqli_stmt_execute($stmt)){
                                        // Password updated successfully. Destroy the session, and redirect to login page
                                        session_destroy();
                                        header("location: login.php");
                                        exit();
                                    } else{
                                        echo "Oops! Something went wrong. Please try again later.";
                                    }
                                }
                                
                                // Close statement
                                mysqli_stmt_close($stmt);
                            }
                            










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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
    <script src="scripts/jquery-3.4.1.min.js"> </script>
<link rel="stylesheet" href="styling.css">
<link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet"> 
<link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">
</head>
<body>   
<div class="resetpassword">

<div id="title">
    <h2>RESET PASSWORD</h2>
    <p>Please reset password here</p>
</div>

<div id="mainform">

    <form id="resetform" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"> 
    <!-- validate old password-->
    <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
    <label id="editlaba">Old Password</label>
        <input id="oldpassword" type="password" name="password" class="form-control">
        <span class="help-block"><?php echo $password_err; ?></span>
    </div><br>

    <!-- enter new password--> 
    <div class="form-group <?php echo (!empty($new_password_err)) ? 'has-error' : ''; ?>">
    <label id="editlaba">New Password</label>
        <input id="newpassword" type="password" name="new_password" class="form-control">
        <span class="help-block"><?php echo $new_password_err; ?></span>
    </div><br>


    <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
    <label id="editlaba">Confirm Password</label>
        <input id="confirmpassword" type="password" name="confirm_password" class="form-control">
        <span class="help-block"><?php echo $confirm_password_err; ?></span>
    </div>

    <div class="form-group">
        <input id="applybtn" type="submit" class="btn btn-primary" value=""><br><br><br><br>
        <div  id="reset"><a class="btn btn-link" href="admin.php">Cancel</a></div>
    </div>
    </form>

</div>

</div>
</body>
</html> 