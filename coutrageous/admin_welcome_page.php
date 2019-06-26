<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
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
        <h1>Hi Admin, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Welcome to the COUTRAGEOUS site.</h1>
    </div>
    <p>
        <a href="reset_admin_password.php" class="btn btn-warning">Reset Password</a>
        <a href="logout.php" class="btn btn-danger">Sign Out </a>
    </p>
    <p> <a href="register_tutor.php" class="btn  btn-warning" >Register Tutor</a>
    <a href="#" class="btn  btn-warning" >Register Student</a>
    <a href="#" class="btn  btn-warning" >Register Instructor</a></p>

    <p> <a href="remove_tutor.php" class="btn  btn-danger" >Remove Tutor</a>
    <a href="#" class="btn  btn-danger" >Remove Student</a>
    <a href="#" class="btn  btn-danger" >Remove Instructor</a></p>

    <p> <a href="view_all_students.php" class="btn  btn-primary" >View Students-Test</a>
    <a href="add_student.php" class="btn  btn-primary" >Add Student-Test</a></p>
</body>
</html>