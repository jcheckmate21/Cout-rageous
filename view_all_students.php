<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">

<html>

<head>

<title>View Records</title>

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

<body>

<div id="allstudentspage">
<div class="wrapper2">
<!-- <a id="backbtn" href="view_all_students.php?sort=all" class="left" ></a> -->

    <h2 id="minititle2">REGISTER STUDENT</h2>
    <!-- <p>| Please fill this form to create an account yes |</p> -->
</div>

<div id="mainform2">
<a href="add_student.php" id="addbtn">+</a>



<?php



// connect to the database

include('config.php');


//Displays all data from 'Students' table
if (($_GET['sort'])=="all"){

// get results from database
$result = mysqli_query($link,"SELECT * FROM students");

// or die(mysql_error());

// display data in table
echo '<table border="0" class="hover" id="table" style="width:100%">';

echo "<thead><tr> <th>A Number</th> <th>First Name</th> <th>Last Name</th> <th>Email</th> <th>Major</th> <th>Classification</th> <th>CRN</th> <th></th> <th></th> </tr></thead> <tbody>";



// loop through results of database query, displaying them in the table

while($row = mysqli_fetch_array( $result )) {
// fetch the contents of each row into a table
echo "<tr>";
echo '<td>' . $row['anumber'] . '</td>';
echo '<td>' . $row['firstname'] . '</td>';
echo '<td>' . $row['lastname'] . '</td>';
echo '<td>' . $row['email'] . '</td>';
echo '<td>' . $row['major'] . '</td>';
echo '<td>' . $row['classification'] . '</td>';
echo '<td>' . $row['crn'] . '</td>';
echo '<td><a href="edit_student.php?anumber=' . $row['anumber'] . '">Edit</a></td>';
echo '<td><a href="delete_student.php?anumber=' . $row['anumber'] . '&confirm=0">Delete</a></td>';
echo "</tr>";
}



// close table>
echo "</tbody> </table>";
}


?>


<p id="reset"> <a href="index.php">Return to Dashboard</a></p>


</div>

</div> 



<script>
   $(document).ready( function () {
    $('#table').DataTable();
} );

</script>
</body>

</html>