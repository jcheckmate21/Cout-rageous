<?php

//function for clocking in








// Initialize the session
session_start();
 
// Save admin in charge at the time of login
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){

    $admin_name = $_SESSION["username"];
   
}
 
// Include config file
require_once "config.php";

 

?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
   <script src="jquery/jquery-3.4.1.min.js"> </script>
   <script src="jsQR/jsQR.js"></script>
    <link rel="stylesheet" href="styling.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">
     
</head>
<body>   
<div id="mainpage">

<div class="wrapper">
       
        <h1>Student / Instructor Login</h1>
        
</div> 
<div id="qrpopup">
<div id="loadingMessage">🎥 Unable to access video stream (please make sure you have a webcam enabled)</div>
  <canvas class="qrscanner" id="canvas" hidden></canvas> 
  <div id="output" hidden>
  <div id="outputMessage">Scanning</div>
    <div hidden><b>Data:</b> <span id="outputData"></span></div>
  </div>
</div>

<div id="mainform">



<p class="form-message"></p> <!-- Space to display clock in or clock out message -->


        <form id="loginform" >

            <div class="form-group">
            <label id="editlaba">Username / A number</label>
                <input type="text" id="username" name="anumber" class="username"> 
                <span class="anum_err"></span>
            </div>
            <br>
            <div class="form-group">
            <label id="editlaba">Password</label> 
                <input type="password" id="password" name="password" class="password">
                <span class="password_err"></span>
            </div>
            <div class="form-group">
                <input id="loginbtn" type="button" class="btn btn-primary">
            </div>

            <br> <br> <br> <br><br>
           <div class="form-group">
               <p id="reset"><a href="logout.php">Return to Admin Dashboard</a></p>
               <!-- logout.php for security purposes. To prevent anybody from accessing the admin dashbord under any circumstance -->
               <p id="reset"><a href="scan_qr.php" id="reset">Scan QR code</a></p>

               
            </div>
            
            
        </form>
           
</div>

</div>  


<script>
$(document).ready(function(){
        $("#loginbtn").on('click', function(event){
            // event.preventDefault();
            var username = $(".username").val();
            var password = $(".password").val();
           
           

           $.post("validate.php", {

                function: "log_in_student",
                username: username,
                password : password
               
           },function(data, status){

                $(".form-message").html("<div>" + data + "</div>");
                
                if( status =="success"){
                   alert(data);
                   
                }
           });
           
        });




    });

    
</script>

<script>
    var video = document.createElement("video");
    var canvasElement = document.getElementById("canvas");
    var canvas = canvasElement.getContext("2d");
    var loadingMessage = document.getElementById("loadingMessage");
    var outputContainer = document.getElementById("output");
    var outputMessage = document.getElementById("outputMessage");
    var outputData = document.getElementById("outputData");

    function drawLine(begin, end, color) {
      canvas.beginPath();
      canvas.moveTo(begin.x, begin.y);
      canvas.lineTo(end.x, end.y);
      canvas.lineWidth = 4;
      canvas.strokeStyle = color;
      canvas.stroke();
    }

    // Use facingMode: environment to attemt to get the front camera on phones
    navigator.mediaDevices.getUserMedia({ video: { facingMode: "environment" } }).then(function(stream) {
      video.srcObject = stream;
      video.setAttribute("playsinline", true); // required to tell iOS safari we don't want fullscreen
       video.play();
      requestAnimationFrame(tick);
    });

    function tick() {

      loadingMessage.innerText = "⌛ Loading video..."
      if (video.readyState === video.HAVE_ENOUGH_DATA) {
       // loadingMessage.hidden = false;
        canvasElement.hidden = false;
        outputContainer.hidden = false;

        canvasElement.height = video.videoHeight;
        canvasElement.width = video.videoWidth;
        canvas.drawImage(video, 0, 0, canvasElement.width, canvasElement.height);
        var imageData = canvas.getImageData(0, 0, canvasElement.width, canvasElement.height);
        var code = jsQR(imageData.data, imageData.width, imageData.height, {
          inversionAttempts: "dontInvert",
        });
        if (code) {
         
          canvasElement.hidden = false;
          drawLine(code.location.topLeftCorner, code.location.topRightCorner, "#760ce2");
          drawLine(code.location.topRightCorner, code.location.bottomRightCorner, "#760ce2");
          drawLine(code.location.bottomRightCorner, code.location.bottomLeftCorner, "#760ce2");
          drawLine(code.location.bottomLeftCorner, code.location.topLeftCorner, "#760ce2");
          outputMessage.hidden = false;
          outputData.parentElement.hidden = false;
          outputData.innerText = code.data;
          //alert(code.data);

          $("#qrpopup").show();

          // setTimeout(function(){
          //   $("#qrpopup").hide();
          //   //window.location.href="student_clock_in.php?username="+ code.data ;

               
          // }, 1500);
          
           var username = code.data;                       

              // $.post("validate.php", {

              //       function: "qr_login",
              //       username: username,
                  
              // },function(data, status){

              //       $(".form-message").html("<div>" + data + "</div>");
                    
              //         // if( status =="success"){
              //         //   alert(data);
                        
              //         // }
              // });

              $(".form-message").load("student_clock_in.php?username="+ code.data);
          //window.location.href="student_clock_in.php?username="+ code.data ;
        } else {
          outputMessage.hidden = false;
          outputData.parentElement.hidden = true;
        }
      }
      requestAnimationFrame(tick);
    }

    setTimeout(function(){
            $("#qrpopup").hide();
          }, 1500);


    $(document).ready(function(){
        $("#qrpopup").hide();
    });

  </script>
</body>
</html>
