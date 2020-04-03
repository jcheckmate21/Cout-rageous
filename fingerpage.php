<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <script src="scripts/jquery-3.4.1.min.js"> </script>
    <link rel="stylesheet" href="styling.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">
</head>
<body>
<div class="registerstudent">
<div id="title">
<a id="backbtn" href="facepage.php" class="left" ></a><br><br>

    <h2 id="minititle">FINGERPRINT</h2>
    <p>Please place your finger on reader</p>
</div>        

<div id="form1">
    <div></div>
<div>
    <div id="fingerbox"></div>
    <div id="sub"><input id="submit" type="submit" name="confirm_password" class="form-control" placeholder="REGISTER FINGER"></div><br>
    <p id="reset1"><input type="reset" class="btn btn-default"></p>
</div>

<div id="command">
    <div>
    <a href="cardpage.php"><div id="nextbtn">next</div></a>
    <!-- <div id="reset" type="reset"><a href="#" class="btn btn-default">Reset</a></div> -->    
    </div>

</div>
</div>

</div>    
</body>
</html>