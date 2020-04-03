
<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: index.php");
    exit;
}else{
   
    $id = htmlspecialchars($_SESSION["id"]) ;
    $position = htmlspecialchars($_SESSION["position"]);
    $username = htmlspecialchars($_SESSION["username"]);   
}


?>





<!DOCTYPE html>
<html id="admin" lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <script src="scripts/jquery-3.4.1.min.js"> </script>
    <link rel="stylesheet" href="styling.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet"> 
    <link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet"> 
</head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<body id="adminpage">
<div id="mainpage">

<div class="wrapper1">
    <h1>Hi&nbsp;<?php echo $position ;?>&nbsp;<b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>, welcome to MathLab</h1>
</div>

<div id="mainform">

    <div id="adminlist">

<?php   if($position === "admin"){ ?>    
    <a id="aa" href="remove_tutor.php" class="btn  btn-danger" >Tutors</a>
<?php } ?>    
    <br>

<div id="register">

    <a id="aa" href="#">Registry</a>
    

  

</div>

    <br>
    <br>

    <!--Admin rights  -->
<?php   if($position === "admin"){ ?>  

    <a id="aa" href="view_attendance.php" class="btn  btn-danger" >attendance report</a>
    <br>
 

    <a id="aa" href="read_excel.php" class="btn  btn-danger" >import registry</a>

<?php } ?>  
    
    <br>

    <a id="stbtn" href="student_login.php" class="btn  btn-danger" >login</a>

    <a id="logoutbtn" href="logout.php" class="btn btn-danger"><</a><br><br><br><br>

    <p id="reset"><a href="reset_admin_password.php" class="btn btn-warning">Reset Password</a></p>

    </div>



</div>
</div> 








<div id="myModal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    
    <div id="popup">
        
    <div id="registerlist">        
        <a id="reglist" href="view_registry.php?type=students" class="btn  btn-warning" >Students</a><br>
        <a id="reglist" href="view_registry.php?type=instructors" class="btn  btn-warning" >Instructors</a> <br>
        <a id="reglist" href="view_registry.php?type=courses" class="btn  btn-warning" >Courses</a>        
    </div> 

    </div>

     <span class="close"></span>
  </div>

</div>



<script>

$(document).ready(function(){
  $(".modal").hide();   

$("#register").click(function(){
  $(".modal").show();
});

$(document).click(function(event) {
  //if you click on anything except the modal itself or the "open modal" link, close the modal
  if (!$(event.target).closest("#popup,#register").length) {
    $("body").find(".modal").hide();
  }
});
});
</script>

</body>
</html>