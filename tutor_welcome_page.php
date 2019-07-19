<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: index.php");
    exit;
}
?>






<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <script src="scripts/jquery-3.4.1.min.js"> </script>
    <link rel="stylesheet" href="styling.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet"> 
    <link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet"> 
</head>
<body>
<div id="mainpage">

<div class="wrapper1">
    <h1>Hi Tutor, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b> Welcome to MathLab</h1>
</div>

<div id="mainform">

    <div id="adminlist">
    <br>
    <div id="register">
    <div id="regbtn"><a href="#">Registry</a></div>

    <div id="registercnt">     
    <div id="registerlist">   
       
        <a id="reglist" href="view_all_students.php?sort=all" class="btn  btn-warning" >Students</a><br>
        <a id="reglist" href="view_instructors.php?sort=all" class="btn  btn-warning" >Instructors</a> <br>
        <a id="reglist" href="add_course.php" class="btn  btn-warning" >Courses</a>
    </div>
    </div>  

</div><br><br>                     

    <!-- <div id="adminbtn"><a href="#" class="btn  btn-danger" >print report</a></div><br>
    <div id="adminbtn"><a href="#" class="btn  btn-danger" >upload excel</a></div><br> -->
    <div id="instbtn"><a href="student_login.php" class="btn  btn-danger" > Student login</a></div>

    <a href="logout.php" class="btn btn-danger"><div id="logoutbtn"></div></a><br><br><br><br>

        <div id="reset"><a href="reset_admin_password.php" class="btn btn-warning">Reset Password</a></div>

    </div>

</div>

</div>  
</body>
</html>