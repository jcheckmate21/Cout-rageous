<!DOCTYPE html >

<html>

<head>

<title>View Records</title>
<script src="scripts/jquery-3.4.1.min.js"> </script>

</head>

<body>



<!--Universal Search bar -->
<form action="search_students.php" method="GET">
    <input type="text" name="query" />
    <input type="submit" value="Search" />
</form>




<?php
// connect to the database

include('config.php');

//Displays all searched data from 'Students' table

$query = ($_GET['query']);
// get results from database
$result = mysqli_query($link,"SELECT * FROM students WHERE  (`anumber` LIKE '%".$query."%') OR (`firstname` LIKE '%".$query."%') OR (`lastname` LIKE '%".$query."%')  OR (`email` LIKE '%".$query."%') OR (`major` LIKE '%".$query."%')  OR (`classification` LIKE '%".$query."%') OR (`crn` LIKE '%".$query."%') ");

// or die(mysql_error());


// display button to view all records
echo "<p><a href='view_all_students.php?sort=all'>View All</a>  ";
 

echo "<table border='0' cellpadding='10'>";

echo "<tr> <th>A Number</th> <th>First Name</th> <th>Last Name</th> <th>Email</th> <th>Major</th> <th>Classification</th> <th>CRN</th> <th></th> <th></th> </tr>";



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
echo "</table>";



// pagination



?>

<p><a href="add_student.php">Add a new record</a></p>



</body>

</html>