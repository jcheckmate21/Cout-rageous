<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$crn = $class = $instructor = $anumber = "";
$crn_err = $class_err = $inst_err =$anumber_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Validate crn
    if(empty(trim($_POST["crn"]))){
        $anumber_err = "Please enter a crn.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM courses WHERE crn = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_crn);
            
            // Set parameters
            $param_crn = trim($_POST["crn"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) >= 1){
                    $crn_err = "This crn is already registered.";
                } else{
                    $crn = trim($_POST["crn"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }

    
     //validate class number
     if(empty(trim($_POST["class"]))){
        $class_err = "Please enter the Class Number";     
    }
    else{
        $class = trim($_POST["class"]);
    }

     //validate instructor anumber
    // Validate anumber
    if(empty(trim($_POST["anumber"]))){
        $anumber_err = "Please enter an anumber.";
    } else{ 
        
        $param_anumber = trim($_POST["anumber"]);
        // Prepare a select statement
        $sql = "SELECT id, firstname, lastname, crn FROM students WHERE anumber = '$param_anumber' and type='instructor'";
        
        $result = mysqli_query($link,$sql);


                
        if ($stmt = mysqli_prepare($link, $sql)) {

            /* execute statement */
            mysqli_stmt_execute($stmt);

            /* bind result variables */
            mysqli_stmt_bind_result($stmt, $id, $fname, $lname, $crn);

            /* fetch values */
            while (mysqli_stmt_fetch($stmt)) {
            echo "$id . $fname . $lname . $crn";
            }

            /* close statement */
            mysqli_stmt_close($stmt);
        }

        $anumber_err = $id . $fname . $lname . $crn;
//   // fetch each course
//         while($row = mysqli_fetch_array( $result )) {
//         //display each course
//          $id = $row['id'];
//          $fname = $row['firstname'];
//          $lname = $row['lastname'];
//          $crn = $row['crn'];

//         }
        
      
    }


    

    //validate instructor
    if(empty(trim($_POST["instructor"]))){
        $inst_err = "Please enter your Instructor's name";     
    }
    else{
        $instructor = trim($_POST["instructor"]);
    }
    
   
    
    

    
    // Check input errors before inserting in database
    if(empty($crn_err) && empty($class_err) && empty($inst_err) && empty($anumber_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO courses (crn, class, instructor, anumber ) VALUES (?,?,?,?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssss", $param_crn, $param_class, $param_inst, $param_anumber);
            
            // Set parameters
            $param_crn= $crn;
            $param_class = $class;
            $param_inst = $instructor;
            $param_anumber = $anumber;
           
            
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

            
             
             header("Location: add_course.php");
            //  header("location: view_all_instructors.php?sort=all");
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
    <title>ADD COURSE</title>
    <script src="scripts/jquery-3.4.1.min.js"> </script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ left: 30%; width: 350px; padding: 20px; }
    </style>
</head>
<body>
    <a id="" href="view_courses.php" class="btn  btn-warning" >back</a><br>
    <div class="wrapper">
        <hr>
        <h2>ADD COURSE</h2>
        <hr>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($crn_err)) ? 'has-error' : ''; ?>">
                <label>CRN</label>
                <input type="text" name="crn" class="form-control" value="<?php echo $crn; ?>">
                <span class="help-block"><?php echo $crn_err; ?></span>
            </div>    
            <div class="form-group <?php echo (!empty($class_err)) ? 'has-error' : ''; ?>">
                <label>Class Number</label>
                <input type="text" name="class" class="form-control" value="<?php echo $class; ?>">
                <span class="help-block"><?php echo $class_err; ?></span>
            </div> 
            <div class="form-group <?php echo (!empty($anumber_err)) ? 'has-error' : ''; ?>">
                <label>Instructor's A number</label>
                <input type="text" name="anumber" class="form-control" value="<?php echo $anumber; ?>">
                <span class="help-block"><?php echo $anumber_err; ?></span>
            </div> 
            <div class="form-group <?php echo (!empty($inst_err)) ? 'has-error' : ''; ?>">
                <label>Instructor Name</label>
                <input type="text" name="instructor" class="form-control" value="<?php echo $instructor; ?>">
                <span class="help-block"><?php echo $inst_err; ?></span>
            </div> 
           
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-default" value="Reset">
            </div>
            <p> <a href="index.php">Back to Dashboard</a>.</p>
        </form>
    </div>    
</body>
</html>