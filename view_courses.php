<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">

<html>

<head>

<title>Courses</title>

<!-- jQuery -->
<script src="scripts/jquery-3.4.1.min.js"> </script>

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


<br><br>
<?php

// connect to the database

include('config.php');


//Displays all data from 'Students' table


// get results from database
$result = mysqli_query($link,"SELECT * FROM courses ");

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

<p><a href="add_course.php">Add a new record</a></p>
<p id="old"> <a href="index.php">Return to Dashboard</a></p>



</body>

</html>



