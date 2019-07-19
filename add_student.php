<?php
// Include config file
require_once "config.php";
 
//  // Selecting list of crn From Database .
//  function view_courses(){
//       // Selecting list of crn From Database .
//       $query3 = mysqli_query($link,"select * from courses " );

//       // SQL query to fetch data to display in menu.
//       while ($row3  = mysqli_fetch_assoc($query3)) {
//       echo ' <option class="form-control" value="'.$row3['crn'].' ">'.$row3['crn'].' - '.$row3['class'].'</option> <a>';
//       }


//  }


//placeholders
$anumber_ph = ' placeholder = "A NUMBER"'; $password_ph = ' placeholder = "PASSWORD"'; $firstname_ph = ' placeholder = "FIRST NAME"'; $lastname_ph = ' placeholder = "LAST NAME"'; $email_ph = ' placeholder = "EMAIL"'; $major_ph = ' placeholder = "CLASS NUMBER"'; $classification_ph = ' placeholder = "CLASSIFICATION"'; $crn_ph = ' placeholder = "CRN"'; $confirm_password_ph = ' placeholder = "CONFIRM PASSWORD"'; 


// Define variables and initialize with empty values
$anumber = $type = $username = $password = $firstname =$lastname = $email = $major = $classification = $crn = $confirm_password = "";
$anumber_err = $password_err = $firstname_err =$lastname_err = $email_err = $major_err = $classification_err = $crn_err =  $confirm_password_err = "";

 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    //Automatically assign type as "student"
    $type = "student";
    
    // Validate anumber
    if(empty(trim($_POST["anumber"]))){
        $anumber_err = "Please enter an anumber.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM students WHERE anumber = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_anumber);
            
            // Set parameters
            $param_anumber = trim($_POST["anumber"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) >= 1){
                    $anumber_err = "This anumber is already registered.";
                } else{
                    $anumber = trim($_POST["anumber"]);
                    $anumber_ph = "";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }

    
     //validate First name
     if(empty(trim($_POST["firstname"]))){
        $firstname_err = "Please enter your First name.";     
    }
    else{
        $firstname = trim($_POST["firstname"]);
        $firstname_ph = "";
    }
    
    //validate last name
    if(empty(trim($_POST["lastname"]))){
        $lastname_err = "Please enter your last name.";     
    }
    else{
        $lastname = trim($_POST["lastname"]);
        $lastname_ph = "";
    }
    
    //validate email
    if(empty(trim($_POST["email"]))){
        $email_err = "Please enter your email.";     
    }
    else{
        $email = trim($_POST["email"]);
        $username = substr($email, 0, strpos($email, '@'));
        $email_ph = "";
    }
    
    //validate major
    if(empty(trim($_POST["major"]))){
        $major_err = "Please enter your major.";     
    } elseif(strlen(trim($_POST["major"])) < 2){
        $major_err = "Enter valid major";
    } else{
        $major = trim($_POST["major"]);
        $major_ph = "";
    }

    //validate classification
    if(empty(trim($_POST["classification"]))){
        $classification_err = "Please select your classification.";     
    } elseif(strlen(trim($_POST["classification"])) < 2){
        $classification_err = "Enter valid classification";
    } else{
        $classification = trim($_POST["classification"]);
        $classification_ph = "";
    }
    
     //validate CRN
     if(empty(trim($_POST["crn"]))){
        $crn_err = "Please select your CRN.";     
    }
    else{
        $crn = trim($_POST["crn"]);
        $crn_ph = "";
    }
    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["password"]);
        $password_ph = "";
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
    if(empty($anumber_err) && empty($major_err) && empty($firstname_err) &&empty($lastname_err)&& empty($email_err) && empty($password_err) && empty($confirm_password_err) && empty($classification_err) && empty($crn_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO students (type ,anumber, username, firstname, lastname, email, major, classification, crn, password) VALUES (?,?,?,?,?,?,?,?,?,?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssssssssss", $param_type, $param_anumber, $param_username, $param_firstname, $param_lastname, $param_email, $param_major, $param_classification, $param_crn, $param_password);
            
            // Set parameters
            $param_type = $type;
            $param_anumber = $anumber;
            $param_username = $username;
            $param_firstname = $firstname;
            $param_lastname  = $lastname;
            $param_email = $email;
            $param_major = $major;
            $param_classification = $classification;
            $param_crn = $crn;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                // header("location: login.php");

                //Display Success in pop-up
                echo "<script>alert('SUCCESS!!');</script>";
                

            } else{
                echo "Something went wrong. Please try again later.";
            }  

            // Close statement
             mysqli_stmt_close($stmt);

             echo "<script>alert('SUCCESS!!');</script>";
             header("location: facepage.php");
        }
       
    }
    
    // Close connection
    mysqli_close($link);

    //added this (test)
   // header("Location: view_all_students.php");
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
<a id="backbtn" href="view_all_students.php?sort=all" class="left" ></a><br><br>

    <h2 id="minititle">REGISTER STUDENT</h2>
    <p>Please fill this form to create an account</p>
</div>



<div id="form1">
    <div>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($anumber_err)) ? 'has-error' : ''; ?>">

                <input id="line" type="text" name="anumber" class="form-control" <?php echo $anumber_ph; ?> value="<?php echo $anumber; ?>">
                <span class="help-block"><?php echo $anumber_err; ?></span>
            </div>    
            <div class="form-group <?php echo (!empty($firstname_err)) ? 'has-error' : ''; ?>">

                <input id="line" type="text" name="firstname" class="form-control" <?php echo $firstname_ph; ?> value="<?php echo $firstname; ?>">
                <span class="help-block"><?php echo $firstname_err; ?></span>
            </div> 
            <div class="form-group <?php echo (!empty($lastname_err)) ? 'has-error' : ''; ?>">

                <input id="line" type="text" name="lastname" class="form-control" <?php echo $lastname_ph; ?> value="<?php echo $lastname; ?>">
                <span class="help-block"><?php echo $lastname_err; ?></span>
            </div> 
            <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">

                <input id="line" type="email" name="email" class="form-control" <?php echo $email_ph; ?> value="<?php echo $email; ?>">
                <span class="help-block"><?php echo $email_err; ?></span>
            </div> 
            <div class="form-group <?php echo (!empty($major_err)) ? 'has-error' : ''; ?>">

                <input id="line" type="text" name="major" class="form-control" <?php echo $major_ph; ?> value="<?php echo $major; ?>">
                <span class="help-block"><?php echo $major_err; ?></span>
            </div> 
            <div class="form-group <?php echo (!empty($classification_err)) ? 'has-error' : ''; ?>">

                <input id="line" type="text" name="classification" class="form-control" <?php echo $classification_ph; ?> value="<?php echo $classification; ?>">
                <span class="help-block"><?php echo $classification_err; ?></span>
            </div> 
            <div class="form-group <?php echo (!empty($crn_err)) ? 'has-error' : ''; ?>">

                <input id="line" type="text" name="crn" class="form-control" <?php echo $crn_ph; ?> value="<?php echo $crn; ?>">
                <span class="help-block"><?php echo $crn_err; ?></span>
            </div> 

            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <input id="line" type="password" name="password" class="form-control" <?php echo $password_ph; ?> value="<?php echo $password; ?>">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>

            <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">

                <input id="line" type="password" name="confirm_password" class="form-control" <?php echo $confirm_password_ph; ?>>
                <span class="help-block"><?php echo $confirm_password_err; ?></span>
            </div>
</div>

<div id="command">
        <div class="form-group">
                <!-- <input id="submitbtn" type="submit" class="btn btn-primary" value="Submit"> -->
                
                <input id="nextbtn" type="submit" class="btn btn-primary" value="Next">

                <!-- <a href="facepage.php"><div id="nextbtn">next</div></a><br> -->
                <input id="resetbtn" type="reset" class="btn btn-default">
                <!-- <div id="reset" type="reset"><a href="#" class="btn btn-default">Reset</a></div> -->    
            </div>
            <br>
            <br>

            <p id="reset"> <a href="index.php">Return to Dashboard</a></p>
</div>

</form>
</div>


</div>   
</body>
</html> 