<?php
// Include config file
require_once "config.php";

if(isset($_GET['anumber'])){
    $get_anumber  = trim($_GET['anumber']);
    
    
    // get results from database

    $result = mysqli_query($link,"select * from students where anumber= '$get_anumber'");

    while($row = mysqli_fetch_assoc($result)){

    // get data from db
    $id =$row['id'];
    $anumber = $row['anumber'];
    $firstname = $row['firstname'];
    $lastname = $row['lastname'];
    $email = $row['email'];
    $major = $row['major'];
    $classification = $row['classification'];
    $crn = $row['crn'];
    }

}
 
// Define variables and initialize with empty values

$anumber_err = $password_err = $firstname_err = $lastname_err = $email_err = $major_err = $classification_err = $crn_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    
    $anumber = $username = $password = $firstname =$lastname = $email = $major = $classification = $crn = $confirm_password = "";

     //save a copy of old anumber in case of change
    $id = trim($_POST["id"]);
     $result = mysqli_query($link, "SELECT * FROM students WHERE id = '$id'");

     if($row = mysqli_fetch_assoc($result)){
         $old_anumber = $row['anumber'];
     }

    // Validate anumber
    if(empty(trim($_POST["anumber"]))){
        $anumber_err = "Please enter an anumber.";
    } else{
        // Prepare a select statement
        $sql = "SELECT * FROM students WHERE anumber = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_anumber);
            
            // Set parameters
            $param_anumber = trim($_POST["anumber"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                // validate new anumber if user wants to make a change
                if($old_anumber != trim($_POST["anumber"]) ){
                    //check if new anumber exists 
                    if(mysqli_stmt_num_rows($stmt) >= 1){
                        $anumber_err = "This anumber is already registered.";
                        } else{
                        $anumber = trim($_POST["anumber"]);
                        }
                    }else{
                        //keep number if no change (basically updating the same anumber in the data base)
                        $anumber = trim($_POST["anumber"]);
                    }
            } else{
                echo "Oops! Something went wrong. Please try again later."; //error message if statement wasn't executed
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }

    // $anumber = trim($_POST["anumber"]);
    
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
        //estract username from email address
        $username = substr($email, 0, strpos($email, '@'));
    }
    
    //validate major
    if(empty(trim($_POST["major"]))){
        $major_err = "Please enter your major.";     
    } elseif(strlen(trim($_POST["major"])) < 2){
        $major_err = "Enter valid major";
    } else{
        $major = trim($_POST["major"]);
    }

    //validate classification
    if(empty(trim($_POST["classification"]))){
        $classification_err = "Please enter your classification.";     
    } elseif(strlen(trim($_POST["classification"])) < 2){
        $classification_err = "Enter valid classification";
    } else{
        $classification = trim($_POST["classification"]);
    }
    
     //validate CRN
     if(empty(trim($_POST["crn"]))){
        $crn_err = "Please enter your CRN.";     
    }
    else{
        $crn = trim($_POST["crn"]);
    }
    
    // Check input errors before inserting in database
    if(empty($anumber_err) && empty($major_err) && empty($firstname_err) &&empty($lastname_err)&& empty($email_err) && empty($password_err)  && empty($classification_err) && empty($crn_err)){
        
        // Prepare an insert statement
        $sql = "UPDATE students SET anumber = ?, username = ?, firstname = ?, lastname = ?, email = ?, major = ?, classification = ?, crn = ?  WHERE id = ?";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssssssss",$param_anumber, $param_username, $param_firstname, $param_lastname, $param_email, $param_major, $param_classification, $param_crn, $param_id);
            
            // Set parameters
            $param_id = $id; 
            $param_anumber = $anumber;
            $param_username = $username;
            $param_firstname = $firstname;
            $param_lastname  = $lastname;
            $param_email = $email;
            $param_major = $major;
            $param_classification = $classification;
            $param_crn = $crn;
           
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
               //Maybe::: create a log with entry (which updated)
                // Redirect to login page
                // header("location: login.php");

                //Display Success in pop-up
                $message = "SUCCESS!!";
                echo "<script type='text/javascript'>alert('$message');</script>";
                header("Location: view_all_students.php?sort=all");

            } else{
                echo "Something went wrong. Please try again later.";
            }
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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <?php echo "<h2><strong>".$firstname." ".$lastname." </strong></h2><hr>" ?>
        <h3>EDIT STUDENT DETAILS</h3>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <!-- hidden form to store old anumber if user decides to change it -->
           
            <div class="form-group <?php echo (empty($id)) ? 'has-error' : ''; ?>">
                <label>id</label>
                <input type="hidden" name="id" class="form-control" value="<?php echo $id; ?>">
                <span class="help-block"><?php echo "" ?></span>
            </div>

            <div class="form-group <?php echo (!empty($anumber_err)) ? 'has-error' : ''; ?>">
                <label>A number</label>
                <input type="text" name="anumber" class="form-control" value="<?php echo $anumber; ?>">
                <span class="help-block"><?php echo $anumber_err; ?></span>
            </div>    
            <div class="form-group <?php echo (!empty($firstname_err)) ? 'has-error' : ''; ?>">
                <label>First Name</label>
                <input type="text" name="firstname" class="form-control" value="<?php echo $firstname; ?>">
                <span class="help-block"><?php echo $firstname_err; ?></span>
            </div> 
            <div class="form-group <?php echo (!empty($lastname_err)) ? 'has-error' : ''; ?>">
                <label>Last Name</label>
                <input type="text" name="lastname" class="form-control" value="<?php echo $lastname; ?>">
                <span class="help-block"><?php echo $lastname_err; ?></span>
            </div> 
            <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="<?php echo $email; ?>">
                <span class="help-block"><?php echo $email_err; ?></span>
            </div> 
            <div class="form-group <?php echo (!empty($major_err)) ? 'has-error' : ''; ?>">
                <label>Major</label>
                <input type="text" name="major" class="form-control" value="<?php echo $major; ?>">
                <span class="help-block"><?php echo $major_err; ?></span>
            </div> 
            <div class="form-group <?php echo (!empty($classification_err)) ? 'has-error' : ''; ?>">
                <label>Classification</label>
                <input type="text" name="classification" class="form-control" value="<?php echo $classification; ?>">
                <span class="help-block"><?php echo $classification_err; ?></span>
            </div> 
            <div class="form-group <?php echo (!empty($crn_err)) ? 'has-error' : ''; ?>">
                <label>CRN</label>
                <input type="text" name="crn" class="form-control" value="<?php echo $crn; ?>">
                <span class="help-block"><?php echo $crn_err; ?></span>
            </div> 
           
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Update">
                <input type="reset" class="btn btn-default" value="Reset">
            </div>
        </form>
    </div>    
</body>
</html>