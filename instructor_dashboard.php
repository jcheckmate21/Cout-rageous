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
 if(isset($_GET['anumber'])){
    //$id = $_GET["id"];    
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
   
<!-- jQuery -->
<script src="jquery/jquery-3.4.1.min.js"> </script>

<!-- jQuery for DataTables -->
<script src="DataTables/jQuery-3.3.1/jquery-3.3.1.min.js"> </script>

<!-- DataTables Styling -->
<link rel="stylesheet" type="text/css" href="DataTables/datatables.min.css"/>
 
<!-- DataTables Script -->
<script type="text/javascript" src="DataTables/datatables.min.js"></script>

<!-- Jzip Script -->
<script type="text/javascript" src="DataTables/JSZip-2.5.0/jszip.min.js"></script>

<!-- PDFmake Script -->
<script src="DataTables/pdfmake-0.1.36/pdfmake.min.js"></script>
<script src='build/vfs_fonts.js'></script>

<!-- Main JavaScript -->
<script type="text/javascript" src="scripts.js"></script>

<link rel="stylesheet" href="styling.css">

<!-- Main CSS -->
<link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">

</head>
<body id="adminpage">
<div id="mainpage">

<div class="wrapper1">
    <h1>Welcome Instructor <b><?php echo "$firstname." . ".$lastname"; ?></b></h1>
    <p class="form-message"></p> <!-- Space to display clock in or clock out message -->

</div>

<div id="mainform">

    <div id="adminlist">

<div id="courses">

<a id="aa" href="#" class="btn  btn-danger" >courses</a>

</div><br>

    <a id="aa" href="#" class="btn  btn-danger" >View Class Reports</a><br>

    <a id="stbtn" href="student_login.php" class="btn  btn-danger">Exit</a>

    <!-- clock out button -->
    <input id="logoutbtn" type="button" class="btn btn-primary">


    <!-- <a id="logoutbtn" href="" class="btn btn-danger"><</a> -->
    <br>
    <br>
    <br>
    <br>
    <p id="reset"><a href="reset_tutor_password.php" class="btn btn-link">Reset Password</a></p>

    </div>

</div>
</div> 


<div id="myModal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    
    <div id="popup">
        
    <div id="courseslist">        
     
            <!-- Div to display available courses -->
<div id="listt">     
<?php
// get courses available under instructor's anumber
$result = mysqli_query($link,"SELECT * FROM courses where anumber = '$anumber'  ");

// fetch each course
while($row = mysqli_fetch_array( $result )) {
//display each course
echo '<a href="course_dashboard.php?crn=' . $row['crn'] . '" class="btn btn-primary">'. $row['class'] . '</a>';}

?>  
<br> <br>
</div> <br><br>
    </div> 
    </div>
     <span class="close"></span>
  </div>
</div>



<script type="text/javascript">

$(document).ready(function(){
  $(".modal").hide();   

$("#courses").click(function(){
  $(".modal").show();
});

$(document).click(function(event) {
  //if you click on anything except the modal itself or the "open modal" link, close the modal
  if (!$(event.target).closest("#popup,#courses").length) {
    $("body").find(".modal").hide();
  }
});
});



$(document).ready(function(){
        $("#logoutbtn").on('click', function(event){
            // event.preventDefault();
            var username = "<?php echo $anumber;?>";
            var password = $(".password").val();
           
           

           $.post("validate.php", {

                function: "clock_out_instructor",
                username: username
               
           },function(data, status){

                $(".form-message").html("<div>" + data + "</div>");
                
                if( status =="success"){
                   alert(data);
                   
                }
           });
           
        });




    });


</script>


</body>
</html>