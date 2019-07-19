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
<a id="backbtn" href="fingerpage.php" class="left" ></a><br><br>

    <h2 id="minititle">CARD</h2>
    <p>Please show card in front of camera</p>
</div>        

<div id="form">
    <div id="cardbox"></div>
    <div id="sub"><input id="submit" type="submit" name="confirm_password" class="form-control" placeholder="REGISTER FINGER"></div>
</div>

<div id="command">
    <div>
        <a href="admin.php" id="finishbtn"><div  type="button" class="btn btn-primary">finish</div></a><br>
        <!-- <div id="reset" type="reset"><a href="#" class="btn btn-default">Reset</a></div> -->    
    </div>

    <input id="resetbtn" type="reset" class="btn btn-default">
</div>

</div> 


</body>
</html> 