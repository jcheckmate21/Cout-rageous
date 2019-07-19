
<!DOCTYPE html>
<html>
<head>
<title>Tutors</title>
<meta charset="UTF-8">
<script src="scripts/jquery-3.4.1.min.js"> </script>
<link href="css/style.css" rel="stylesheet" type="text/css">
</head>
<body>
<div class="maindiv">
<div class="divA">
<div class="title">
<h2> TUTORS</h2>
</div>


<div class="divB">
<div class="divD">
<p>Select Tutor</p>

<?php
// Include config file
require_once "config.php";

if (isset($_GET['del'])) {
    $del = $_GET['del'];
    //SQL query for deletion.
    $query1 = mysqli_query( $link, "delete from users where username='$del'");

    echo ' <script> alert("'.$del.' Deleted!!!")';
    // '. '<a href="remove_tutor.php?del='.$row1['username'].'">Undo delete </a> ';' </script>    ';

    // once saved, redirect back to the view page
    header("Location: remove_tutor.php");
    }


// Selecting Database From Server.
$query = mysqli_query($link,"select * from users where not position ='admin'", );

// SQL query to fetch data to display in menu.
while ($row  = mysqli_fetch_assoc($query)) {
echo '<a href="remove_tutor.php?username='.$row['username'].'"> '.$row['username'].'</a> <br>';
}


?>
 <p> <a href="register_tutor.php">Add Tutor</a></p>

</div>

<?php
if (isset($_GET['username'])) {
$username = $_GET['username'];
// SQL query to Display Details.
$result = mysqli_query( $link, "select * from users where username='$username'");
$row1 = mysqli_fetch_assoc($result);


echo $row1['firstname']; 
echo "<br>";
echo $row1['lastname'];
echo "<br>";
echo $row1['anumber']; 
echo "<br>";
echo $row1['position'];
echo "<br>";
echo $row1['email']; 
echo "<br>";

?> 

<?php
  echo '<a href="remove_tutor.php?del='.$row1['username'].'">Delete </a> ';
  
  echo '<a href="remove_tutor.php?del='.$row1['username'].'">Undo delete </a> ';
  ?>

<?php

}

// Closing Connection with Server.
//mysql_close($link);
?>


<div class="clear">
  hgfggc
</div>
</div>
<div class="clear"></div>
</div>
</body>
</html>
