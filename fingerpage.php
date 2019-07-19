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
    <h2>FINGERPRINT</h2>
    <p>Please place your finger on reader</p>
</div>        

<div id="form">
    <div id="fingerbox"></div>
    <div id="sub"><input id="submit" type="submit" name="confirm_password" class="form-control" placeholder="REGISTER FINGER"></div>
</div>

<div id="command">
    <div>
    <a href="cardpage.php"><div id="nextbtn">next</div></a>
    <!-- <div id="reset" type="reset"><a href="#" class="btn btn-default">Reset</a></div> -->    
    </div>

    <input id="resetbtn" type="reset" class="btn btn-default">
</div>

</div>    
</body>
</html>