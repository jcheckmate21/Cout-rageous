<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">

<html>

<head>

<title>View Records</title>

</head>

<body>



<?php

/*

view_students_in_chunks.php

Displays all data from 'players' table

This is a modified version of view_all_students.php that includes pagination

*/



// connect to the database

include('config.php');



// number of results to show per page

$per_page = 3;



// figure out the total pages in the database

$result = mysqli_query($connection, "SELECT * FROM players");

$total_results = mysqli_num_rows($result);

$total_pages = ceil($total_results / $per_page);



// check if the 'page' variable is set in the URL (ex: view_students_in_chunks.php?page=1)

if (isset($_GET['page']) && is_numeric($_GET['page']))

{

$show_page = $_GET['page'];



// make sure the $show_page value is valid

if ($show_page > 0 && $show_page <= $total_pages)

{

$start = ($show_page -1) * $per_page;

$end = $start + $per_page;

}

else

{

// error - show first set of results

$start = 0;

$end = $per_page;

}

}

else

{

// if page isn't set, show first set of results

$start = 0;

$end = $per_page;

}



// display pagination



echo "<p><a href='view_all_students.php'>View All</a> | <b>View Page:</b> ";

for ($i = 1; $i <= $total_pages; $i++)

{

echo "<a href='view_students_in_chunks.php?page=$i'>$i</a> ";

}

echo "</p>";



// display data in table

echo "<table border='1' cellpadding='10'>";

echo "<tr> <th>ID</th> <th>First Name</th> <th>Last Name</th> <th></th> <th></th></tr>";



// loop through results of database query, displaying them in the table

for ($i = $start; $i < $end; $i++)

{

// make sure that PHP doesn't try to show results that don't exist

if ($i == $total_results) { break; }



// echo out the contents of each row into a table

 // seek to row number
 mysqli_data_seek($result, $i);

 /* fetch row */
 $row = mysqli_fetch_assoc($result);

echo "<tr>";

echo '<td>' . $row["id"] . '</td>';

echo '<td>' . $row["firstname"] . '</td>';

echo '<td>' . $row["lastname"] . '</td>';

echo '<td><a href="edit_student.php?id=' . $row["id"]. '">Edit</a></td>';

echo '<td><a href="delete_student.php?id=' . $row["id"] . '&confirm=0">Delete</a></td>';

echo "</tr>";

}

// close table>

echo "</table>";



// pagination



?>

<p><a href="add_student.php">Add a new record</a></p>



</body>

</html>