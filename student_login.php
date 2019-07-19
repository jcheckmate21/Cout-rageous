<?php

//function for clocking in








// Initialize the session
session_start();
 
// Save admin in charge at the time of login
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){

    $admin_name = $_SESSION["username"];
   
}
 
// Include config file
require_once "config.php";

 
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
        $username = substr($username, 0, strpos($username, '@'));
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
        $sql = "SELECT password FROM students WHERE username = ? OR anumber = ? ";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_username);
            
            // Set parameters
            $param_username = $username;
            
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
                            // If Password is correct

                            //find out if user is student or instructor
                            $result = mysqli_query($link, "SELECT type, firstname, lastname, anumber FROM students WHERE username = '$username' or anumber = '$username'");

                            if($row = mysqli_fetch_assoc($result)){
                               
                                $type = $row['type'];
                                $firstname = $row['firstname'];
                                $lastname = $row['lastname'];
                                $anumber = $row['anumber'];



                            }
                       
                                if($type=="instructor"){

                                    
                                //yet to create this function to clock students/ instructors in using their details
                                header("location: student_clock_in.php?username=$username");


                                


                                }else{





                                     header("location: student_clock_in.php?username=$username");
                                    //yet to create this function to clock students/ instructors in using their details
                                    //clock_in($firstname, $lastname, $anumber, $admin_name);

                                      

                                    // //save student username in session
                                    // $_SESSION["studentname"]= $username;
                                    

                                

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
    <title>Login</title>
   <script src="jquery/jquery-3.4.1.min.js"> </script>
    <link rel="stylesheet" href="styling.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">
     
</head>
<body>   
<div id="mainpage">

<div class="wrapper">
        <h2>mathlab</h2>
        <h4>Student / Instructor Login</h4>
        
        <br> 
        <!-- <p>Please fill in your credentials to login.</p> -->
</div> 

<div id="mainform">
 
<br> <br> 
        <form id="loginform" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">

                <input type="text" id="username" name="username" class="form-control" placeholder="A number / Username"> 
                <span class="help-block"><?php echo $username_err; ?></span>
            </div><br>
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label></label>
                <input type="password" id="password" name="password" class="form-control" placeholder="Password">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <input id="loginbtn" type="submit" class="btn btn-primary" value="">
            </div>
            <!-- <p>Don't have an account? <a href="register_tutor.php">Sign up now</a>.</p> -->

            <br> <br> <br> <br>
           <div class="form-group">
               <a href="scan_qr.php" id="reset"><img class="qrIcon"  src="images/qrcode.png" alt="Qr code icon"></a>
               <p id="reset"> <a href="logout.php">Return to Admin Dashboard</a></p>
               <!-- logout.php for security purposes. To prevent anybody from accessing the admin dashbord under any circumstance -->

               
            </div>
            
            
        </form>

           
</div>

</div>  


<script>
// $('.form-group').on('click', function(){
//     $(this).remove();
// });

// $("#contact").on('click', function() {
//     if($(this).hasClass("selected")) {
//         deselect();               
//     } else {
//         $(this).addClass("selected");
//         $.get(this.href, function(data) {
//             $(".pop").html(data).slideFadeToggle(function() { 
//                 $("input[type=text]:first").focus();
//             });
//         }
//     }
//     return false;
// });


</script>
</body>
</html>
