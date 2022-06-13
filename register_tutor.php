<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$username = $password = $firstname =$lastname = $email = $anumber = $confirm_password = "";
$username_err = $password_err = $firstname_err =$lastname_err = $email_err = $anumber_err = $confirm_password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = trim($_POST["username"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "This username is already taken.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }

    //validate A number
    if(empty(trim($_POST["anumber"]))){
        $anumber_err = "Please enter your Anumber.";     
    } elseif(strlen(trim($_POST["anumber"])) < 9){
        $anumber_err = "Enter valid A number";
    } else{
        $anumber = trim($_POST["anumber"]);
    }
    
     //validate First name
     if(empty(trim($_POST["firstname"]))){
        $firstname_err = "Please enter your First name.";     
    }
    else{
        $firstname = trim($_POST["firstname"]);
    }
    
    //validate last name
    if(empty(trim($_POST["lastname"]))){
        $lastname_err = "Please enter your last name.";     
    }
    else{
        $lastname = trim($_POST["lastname"]);
    }
    
    //validate email
    if(empty(trim($_POST["email"]))){
        $email_err = "Please enter your email.";     
    }
    else{
        $email = trim($_POST["email"]);
    }
    
    
    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
    
    // Check input errors before inserting in database
    if(empty($username_err) && empty($anumber_err) && empty($firstname_err) &&empty($lastname_err)&& empty($email_err) && empty($password_err) && empty($confirm_password_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO users (position, username, firstname, lastname, email, anumber, password) VALUES ('tutor',?,?,?,?,?,?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssssss", $param_username, $param_firstname, $param_lastname, $param_email, $param_anumber, $param_password);
            
            // Set parameters
            $param_username = $username;
            $param_firstname = $firstname;
            $param_lastname  = $lastname;
            $param_email = $email;
            $param_anumber = $anumber;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                // header("location: login.php");

                //Display Success in pop-up
                $message = "SUCCESS!!";
                echo "<script type='text/javascript'>alert('$message');</script>";
                header("location: remove_tutor.php");

            } else{
                echo "Something went wrong. Please try again.";
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
    <title>Sign Up</title>
    <script src="scripts/jquery-3.4.1.min.js"> </script>
    <link rel="stylesheet" href="styling.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">
</head>
<body>


<div class="addnewstudent">

<div id="title">
<a id="backbtn" href="remove_tutor.php" class="btn  btn-warning"></a><br><br>

    <h2 id="minititle">ADD A TUTOR</h2>
    <p>Please fill this form to create an account.</p>
</div>    



<div id="form1">
<div></div>
<div>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" autocomplete="off" >
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <input id="line" type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                <label id="editlabt">Username</label>
                <span class="help-block"><?php echo $username_err; ?></span>
            </div> 
            <div class="form-group <?php echo (!empty($anumber_err)) ? 'has-error' : ''; ?>">
                <input id="line" type="text" name="anumber" class="form-control" value="<?php echo $anumber; ?>">
                <label id="editlabt">A number</label>
                <span class="help-block"><?php echo $anumber_err; ?></span>
            </div>    
            <div class="form-group <?php echo (!empty($firstname_err)) ? 'has-error' : ''; ?>">
                <input id="line" type="text" name="firstname" class="form-control" value="<?php echo $firstname; ?>">
                <label id="editlabt">First Name</label>
                <span class="help-block"><?php echo $firstname_err; ?></span>
            </div> 
            <div class="form-group <?php echo (!empty($lastname_err)) ? 'has-error' : ''; ?>">
                <input id="line" type="text" name="lastname" class="form-control" value="<?php echo $lastname; ?>">
                <label id="editlabt">Last Name</label>
                <span class="help-block"><?php echo $lastname_err; ?></span>
            </div> 
            <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                <input id="line" type="email" name="email" class="form-control" value="<?php echo $email; ?>">
                <label id="editlabt">Email</label>
                <span class="help-block"><?php echo $email_err; ?></span>
            </div> 
            
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <input id="line" type="password" name="password" class="form-control" autocomplete="new password" value="<?php echo $password; ?>">
                <label id="editlabt">Password</label>
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                <input id="line" type="password" name="confirm_password" autocomplete="new password" class="form-control" value="<?php echo $confirm_password; ?>">
                <label id="editlabt">Confirm Password</label>
                <span class="help-block"><?php echo $confirm_password_err; ?></span>
            </div><br>
            <div class="form-group">
            <p id="reset1"><input type="reset" class="btn btn-default" value="Reset"></p>
                <p  id="submitbtn"><input type="submit" class="btn btn-primary" value="Submit"></p><br><br>
                <p id="reset"> <a href="index.php">Return to Dashboard</a></p>
            </div> 
</div>       
       
<div id="command">
<div class="form-group">
</div>
           
</div>       
              
</form>

</div>

</div>    
</body>
</html>