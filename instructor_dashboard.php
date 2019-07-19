<?php

  // Include config file
  require_once "config.php";

// Initialize the session
session_start();
 

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}



  //function for clocking out
  function clock_out($id, $firstname, $lastname, $link){  
    $sql = "UPDATE attendance SET time_out = NOW(), memo = ? WHERE id = ?";

    if($stmt = mysqli_prepare($link, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "ss", $param_memo, $param_id);
        
        // Set parameters
        $param_memo ="Signed in Signed out";
        $param_id = $id;
        
        
        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
           
            //Display Success in pop-up
            echo "<script>alert('".$firstname."".$lastname." CLOCKED OUT!!!');</script>";
            // header("location: student_login.php");
           

        } else{
            echo "Something went wrong. Please try again later.";
        }  

        // Close statement
         mysqli_stmt_close($stmt);
        //  echo "<script>alert('SUCCESS!!');</script>";  
  }    

} 




 // extract  user records for personalized Dashboard and id for clockout
 if(isset($_GET['id']) && isset($_GET['anumber'])){
    $id = $_GET["id"];    
    $anumber = $_GET["anumber"];
    //query other user info 
    $result = mysqli_query($link, "SELECT type, firstname, lastname FROM students WHERE  anumber = '$anumber'");

   if($row = mysqli_fetch_assoc($result)){
       
        $type = $row['type'];
        $firstname = $row['firstname'];
        $lastname = $row['lastname'];

   }
}

//for clockout
if(isset($_GET['clockout'])){
    
    //clock out if value is set to 1
    if($_GET['clockout']=='1'){
        clock_out($id, $firstname, $lastname, $link);

        header("location: student_login.php");
    }

}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <script src="scripts/jquery-3.4.1.min.js"> </script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; text-align: center; }
    </style>
</head>
<body>
    <div class="page-header">
        <h1>Welcome Instructor <b><?php echo $firstname." . ".$lastname; ?></b></h1>
        <hr>
        <h3>DASHBOARD</h3>
    </div>


<!-- Div to display available courses -->
<div>     
<?php

echo "Courses: ";
// get courses available under instructor's anumber
$result = mysqli_query($link,"SELECT * FROM courses where anumber = '$anumber'  ");

// fetch each course
while($row = mysqli_fetch_array( $result )) {
//display each course
echo '<a href="#?crn=' . $row['crn'] . '" class="btn btn-primary">'. $row['class'] . '</a>';

}

?>  
<br> <br>
</div> 
     



    <p>
        
        <a href="#" class="btn btn-info">View Class Reports </a>
    </p>
    <p>
        
        <a href="student_login.php" class="btn btn-warning">Exit Dashboard </a>
    </p>
     <p>
       
        <a href="instructor_dashboard.php?anumber=<?php echo htmlspecialchars($anumber); ?>&id=<?php echo htmlspecialchars($id); ?>&clockout=1" class="btn btn-danger">Clock Out</a>
    </p>
    <a href="reset_tutor_password.php" class="btn btn-link">Reset Password</a>
</body>
</html>