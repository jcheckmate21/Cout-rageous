
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
<body id="adminpage">
<div id="mainpage">

<div class="wrapper1">
    <h1>Hi Admin, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b> Welcome to MathLab</h1>
</div>

<div id="mainform">

    <div id="adminlist">
    
    <a id="aa" href="remove_tutor.php" class="btn  btn-danger" >Tutors</a><br>

<div id="register">

    <a id="aa" href="#">Registry</a>
    

    <div id="registercnt"> 
    <div id="registerlist">        
        <a id="reglist" href="view_all_students.php?sort=all" class="btn  btn-warning" >Students</a><br>
        <a id="reglist" href="view_instructors.php?sort=all" class="btn  btn-warning" >Instructors</a> <br>
        <a id="reglist" href="view_courses.php" class="btn  btn-warning" >Courses</a>
        
    </div>
    </div>  

</div><br><br>

             
    <a id="aa" href="#" class="btn  btn-danger" >attendance report</a><br>
    <a id="aa" href="#" class="btn  btn-danger" >import registry</a><br>
    <a id="stbtn" href="student_login.php" class="btn  btn-danger" >login</a>

    <a id="logoutbtn" href="logout.php" class="btn btn-danger"><</a><br><br><br><br>

    <p id="reset"><a href="reset_admin_password.php" class="btn btn-warning">Reset Password</a></p>

<div id="overlayer">yes</div>    
    </div>



</div>
</div> 

</body>
</html>