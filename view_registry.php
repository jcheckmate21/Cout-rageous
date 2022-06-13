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

// connect to the database
include('config.php');

?>

<!DOCTYPE html >

<html>

<head>
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

<!-- Main CSS -->
<link rel="stylesheet" href="styling.css">

<link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">
  

</head>

<body>


<!-- *******************************INSTRUCTORS***************************** -->
<?php
if (($_GET['type'])=="instructors"){
?>

<div id="allstudentspage">
<div class="wrapper2">
<a id="backbtn" href="admin.php" class="left" ></a><br>

    <h2 id="minititle2">INSTRUCTORS</h2>
    <!-- <p>| Please fill this form to create an account yes |</p> -->
</div>

<div id="mainform2">
<a href="add_instructor.php" id="addbtn">+</a>
<?php






// get results from database
$result = mysqli_query($link,"SELECT * FROM students where type = 'instructor' and status= 'active'");

// or die(mysql_error());
// display data in table
echo '<table border="0" class="hover" id="table" style="width:100%">';

echo "<thead> <tr> <th>A Number</th> <th>First Name</th> <th>Last Name</th> <th>Email</th>   <th>Courses</th> <th></th>  </tr> </thead> <tbody>";

// loop through results of database query, displaying them in the table
while($row = mysqli_fetch_array( $result )) {
// fetch the contents of each row into a table
echo '<a href="edit_registry.php?anumber=' . $row['anumber'] . '"><tr>';
echo '<td><a href="edit_registry.php?anumber=' . $row['anumber'] . '">' . $row['anumber'] . '</a></td>';
echo '<td>' . $row['firstname'] . '</td>';
echo '<td>' . $row['lastname'] . '</td>';
echo '<td>' . $row['email'] . '</td>';
//echo '<td>' . $row['major'] . '</td>';
//echo '<td>' . $row['classification'] . '</td>';
echo '<td>' . $row['crn'] . '</td>';
echo '<td><a href="edit_registry.php?anumber=' . $row['anumber'] . '">View</a></td>';
//echo '<td><a href="delete_student.php?anumber=' . $row['anumber'] . '&confirm=0">Delete</a></td>';
echo "</tr></a>";
}

// close table>
echo "</tbody> </table>";




?>

<p id="reset"> <a href="index.php">Return to Dashboard</a></p>


</div>
</div>

<?php
}
?>


<!-- *******************************STUDENTS***************************** -->

<?php
if (($_GET['type'])=="students"){
?>

<div id="allstudentspage">
<div class="wrapper2">
<a id="backbtn" href="admin.php" class="left" ></a><br>

    <h2 id="minititle2">STUDENTS</h2>
    <!-- <p>| Please fill this form to create an account yes |</p> -->
</div>

<div id="mainform2">
<a href="add_student.php" id="addbtn">+</a>
<?php






// get results from database
$result = mysqli_query($link,"SELECT * FROM students where type = 'student' and status= 'active'");

// or die(mysql_error());
// display data in table
echo '<table border="0" class="hover" id="table" style="width:100%">';

echo "<thead><tr> <th>A Number</th> <th>First Name</th> <th>Last Name</th> <th>Email</th> <th>Major</th> <th>Classification</th> <th>CRN</th> <th></th>  </tr></thead> <tbody>";


// loop through results of database query, displaying them in the table
while($row = mysqli_fetch_array( $result )) {
// fetch the contents of each row into a table
echo '<a href="edit_registry.php?anumber=' . $row['anumber'] . '"><tr>';
echo '<td><a href="edit_registry.php?anumber=' . $row['anumber'] . '">' . $row['anumber'] . '</a></td>';
echo '<td>' . $row['firstname'] . '</td>';
echo '<td>' . $row['lastname'] . '</td>';
echo '<td>' . $row['email'] . '</td>';
echo '<td>' . $row['major'] . '</td>';
echo '<td>' . $row['classification'] . '</td>';
echo '<td>' . $row['crn'] . '</td>';
echo '<td><a href="edit_registry.php?anumber=' . $row['anumber'] . '">View</a></td>';
//echo '<td><a href="delete_student.php?anumber=' . $row['anumber'] . '&confirm=0">Delete</a></td>';
echo "</tr></a>";
}

// close table>
echo "</tbody> </table>";




?>

<p id="reset"> <a href="index.php">Return to Dashboard</a></p>


</div>
</div>

<?php
}
?>





<!-- *******************************COURSES***************************** -->

<?php
if (($_GET['type'])=="courses"){
?>

<div id="allstudentspage">
<div class="wrapper2">
<a id="backbtn" href="admin.php" class="left" ></a><br>

<h2 id="minititle2">COURSES</h2>
    <!-- <p>| Please fill this form to create an account yes |</p> -->
</div>

<div id="mainform2">
<a href="add_course.php" id="addbtn">+</a>
<?php






// get results from database
$result = mysqli_query($link,"SELECT * FROM courses where status = 'active' ");

// or die(mysql_error());



// display data in table

echo '<table border="0" class="hover" id="table" style="width:100%"> ';

echo "<thead> <tr> <th>CRN</th> <th>Class No.</th> <th>Instructor</th>  <th></th> <th></th> </tr> </thead> <tbody>";



// loop through results of database query, displaying them in the table

while($row = mysqli_fetch_array( $result )) {
// fetch the contents of each row into a table
echo "<tr>";
echo '<td>' . $row['crn'] . '</td>';
echo '<td>' . $row['class'] . '</td>';
echo '<td>' . $row['instructor'] . '</td>';

echo '<td><a href="#?crn=' . $row['crn'] . '">Edit</a></td>';
echo '<td><a href="#?crn=' . $row['crn'] . '&confirm=0">Delete</a></td>';
echo "</tr>";
}



// close table>
echo "</tbody> </table>";




?>

<p id="reset"> <a href="index.php">Return to Dashboard</a></p>


</div>
</div>

<?php
}
?>






</body>

</html>



