<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">

<html>

<head>

<title>View Records</title>

</head>

<body>

<!--Universal Search bar -->

<form action="search_students.php" method="GET">
    <input type="text" name="query" />
    <input type="submit" value="Search" />
</form>


<?php



   
//view_all_students.php







// connect to the database

include('config.php');


//Displays all data from 'Students' table
if (($_GET['sort'])=="all"){

// get results from database
$result = mysqli_query($link,"SELECT * FROM students where type = 'instructor' ");

// or die(mysql_error());



// display data in table

echo "<p><b>View All</b> | <a href='view_all_students.php?sort=group&page=1'>View Paginated</a></p>";
 


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
}



if (($_GET['sort'])=="group"){

// number of results to show per page
$per_page = 3;

// Determine the total pages in the database
$result = mysqli_query($link, "SELECT * FROM students where type = 'instructor' ");
//Number of records
$total_results = mysqli_num_rows($result);
//Total number of pages
$total_pages = ceil($total_results / $per_page);


// check if the 'page' variable is set in the URL (ex: view_students_in_chunks.php?page=1)
if (isset($_GET['page']) && is_numeric($_GET['page'])){
    
    //Get assigned page number 
    $show_page = $_GET['page'];
    // make sure the $show_page value is valid
    if ($show_page > 0 && $show_page <= $total_pages){
        //variables for range of records to display
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



// display pagination contol buttons
echo "<p><a href='view_all_students.php?sort=all'>View All</a> | <b>View Page:</b> ";
 // links to provide page numbers (particular set of records) to display
for ($i = 1; $i <= $total_pages; $i++)
{
    // link select page number (particular set of records) to display
    echo "<a href='view_all_students.php?sort=group&page=$i'>$i</a> ";
}
echo "</p>";



// display data in table

echo "<table border='0' cellpadding='10'>";

echo "<tr> <th>A Number</th> <th>First Name</th> <th>Last Name</th> <th>Email</th> <th>Major</th> <th>Classification</th> <th>CRN</th> <th></th> <th></th> </tr>";


// loop through results of database query, displaying them in the table

for ($i = $start; $i < $end; $i++)

{
    // make sure that PHP doesn't try to show results that don't exist
    if ($i == $total_results) { break; }

    // Display data set in table
    
    // Target record row to display from
    mysqli_data_seek($result, $i);

    //fetch record
    $row = mysqli_fetch_assoc($result);

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

}

?>

<p><a href="add_instructor.php">Add a new record</a></p>



</body>

</html>



