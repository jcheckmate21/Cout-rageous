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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Reset Password</h2>
        <p>Please fill out this form to reset your password.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"> 

       <!-- validate old password-->
        <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Old Password</label>
                <input type="password" name="password" class="form-control">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>

           <!-- enter new password--> 
            <div class="form-group <?php echo (!empty($new_password_err)) ? 'has-error' : ''; ?>">
                <label>New Password</label>
                <input type="password" name="new_password" class="form-control" value="<?php echo $new_password; ?>">
                <span class="help-block"><?php echo $new_password_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control">
                <span class="help-block"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <a class="btn btn-link" href="tutor_welcome_page.php">Cancel</a>
            </div>
        </form>
    </div>    
</body>
</html>