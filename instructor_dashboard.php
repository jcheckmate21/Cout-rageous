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



 // extract  user records for personalized Dashboard
 if(isset($_GET['anumber'])){
        
    $anumber = $_GET["anumber"];
    //query other user info 
    $result = mysqli_query($link, "SELECT type, firstname, lastname FROM students WHERE  anumber = '$anumber'");

   if($row = mysqli_fetch_assoc($result)){
       
        $type = $row['type'];
        $firstname = $row['firstname'];
        $lastname = $row['lastname'];

   }
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
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
    <p>
        <a href="reset_tutor_password.php" class="btn btn-warning">Reset Password</a>
        <a href="student_clock_in.php?username=<?php echo htmlspecialchars($anumber); ?>" class="btn btn-danger">Clock Out</a>
    </p>

     
    <p>
        
        <a href="#" class="btn btn-info">View Class Reports </a>
    </p>
    <p>
        
        <a href="student_login.php" class="btn btn-warning">Exit Dashboard </a>
    </p>
</body>
</html>