<!DOCTYPE html>
<html>
<head>
  <title>JQuery HTML5 QR Code Scanner using Instascan JS Example - ItSolutionStuff.com</title>
  

  <!-- jQuery 3.3.1 -->
  <script src="jquery/jquery-3.3.1.min.js"> </script>
  <script src="qr_scanner/interscan.js"></script>
  
  <link rel="stylesheet" href="styling.css">
  <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">
</head>
<body>

<div id="mainpage">

<div class="wrapper">
        <h2>mathlab</h2>
        <h4>QR CODE Login</h4>
        
        <br> 
        <!-- <p>Please fill in your credentials to login.</p> -->
</div> 
  
<div id="mainform">
    <video class="qrscanner" id="preview"></video>
</div>


    <script type="text/javascript">
      let scanner = new Instascan.Scanner({ video: document.getElementById('preview') });
      scanner.addListener('scan', function (content) {
        alert(content);
        window.location.href="student_clock_in.php?username="+ content ;
      });

      Instascan.Camera.getCameras().then(function (cameras) {
        if (cameras.length > 0) {
          scanner.start(cameras[0]);
        } else {
          console.error('No cameras found.');
        }
      }).catch(function (e) {
        console.error(e);
      });
    </script>
   
</body>
</html>