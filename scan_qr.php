<html>
<head>
  <meta charset="utf-8">
  <title>jsQR Demo</title>
  <script src="jsQR/jsQR.js"></script>
  <link rel="stylesheet" href="styling.css">
  <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">

  <style>
    
    

   

    #loadingMessage {
      text-align: center;
      padding: 40px;
      background-color: #eee;
    }

    /* #canvas {
      width: 100%;
    } */

    #output {
      margin-top: 20px;
      background: #eee;
      padding: 10px;
      padding-bottom: 0;
    }

    #output div {
      padding-bottom: 10px;
      word-wrap: break-word;
    }

    #noQRFound {
      text-align: center;
    }
  </style>
</head>
<body>


<div id="mainpage">    
<div class="wrapper">
        <h2>mathlab</h2>
        <h4>QR CODE Login</h4>
        
        <br> 
        <!-- <p>Please fill in your credentials to login.</p> -->
</div> 
  
<div  id="mainform">
  <div id="loadingMessage">🎥 Unable to access video stream (please make sure you have a webcam enabled)</div>
  <canvas class="qrscanner" id="canvas" hidden></canvas> 
  <div id="output" hidden>
    <div id="outputMessage">No QR code detected.</div>
    <div hidden><b>Data:</b> <span id="outputData"></span></div>
  </div>
</div>  
</div>


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
      canvas.lineWidth = 8;
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
        loadingMessage.hidden = true;
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
          alert(code.data);
          window.location.href="student_clock_in.php?username="+ code.data ;
        } else {
          outputMessage.hidden = false;
          outputData.parentElement.hidden = true;
        }
      }
      requestAnimationFrame(tick);
    }
  </script>
</body>
</html>
