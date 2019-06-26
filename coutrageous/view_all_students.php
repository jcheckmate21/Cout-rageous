<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">

<html>

<head>

<title>View Records</title>

</head>

<body>



<?php

/*

view_all_students.php

Displays all data from 'players' table

*/



// connect to the database

include('config.php');



// get results from database

$result = mysqli_query($connection,"SELECT * FROM players");

// or die(mysql_error());



// display data in table

echo "<p><b>View All</b> | <a href='view_students_in_chunks.php?page=1'>View Paginated</a></p>";



echo "<table border='1' cellpadding='10'>";

echo "<tr> <th>ID</th> <th>First Name</th> <th>Last Name</th> <th></th> <th></th></tr>";



// loop through results of database query, displaying them in the table

while($row = mysqli_fetch_array( $result )) {



// echo out the contents of each row into a table

echo "<tr>";

echo '<td>' . $row['id'] . '</td>';

echo '<td>' . $row['firstname'] . '</td>';

echo '<td>' . $row['lastname'] . '</td>';

echo '<td><a href="edit_student.php?id=' . $row['id'] . '">Edit</a></td>';

echo '<td><a href="delete_student.php?id=' . $row['id'] . '&confirm=0">Delete</a></td>';

echo "</tr>";

}



// close table>

echo "</table>";

?>

<p><a href="add_student.php">Add a new record</a></p>



</body>

</html>