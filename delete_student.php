<?php

/*

delete_student.php

Deletes a specific entry from the 'players' table

*/



// connect to the database

include('config.php');

$confirm_msg ="Confirm Delete ";

echo '  <script>  alert("'.'$confirm_msg'.'")  </script>  ';
echo '  <script>  alert("'.'DELETED!!!!!!!'.'")  </script>  ';

// check if the 'anumber' variable is set in URL, and check that it is valid

if (isset($_GET['anumber']) && isset($_GET['confirm']))

{

// get anumber value

$anumber = $_GET['anumber'];
$confirm = $_GET['confirm'];


$confirm_msg ="Confirm Delete ";

echo '  <script>  alert("'.$confirm_msg.'")  </script>  ';

if($confirm== 0){
    // delete the entry

 if(mysqli_query($link, "DELETE FROM students WHERE anumber='$anumber'")){
 echo '  <script>  alert("'.'DELETED!!!!!!!'.'")  </script>  ';
 $confirm = 1;

 
 if ($confirm==1){
    echo '  <script>  alert("'.'DELETED!!!!!!!'.'")  </script>  ';
    header("Location: view_all_students.php?sort=all");
 }
 }
 else{
     echo "Error: ".mysqli_error($link);
 }

}

// delete the entry

// $result = mysqli_query($connection, "DELETE FROM players WHERE anumber=$anumber");

// or die(mysql_error());

   if ($confirm==1){
    echo '  <script>  alert("'.'DELETED!!!!!!!'.'")  </script>  ';
    header("Location: view_all_students.php?sort=all");
   }

// redirect back to the view page
// else{
// header("Location: view_all_students.php");
// }
}

else

// if anumber isn't set, or isn't valid, redirect back to view page

{

 echo "Failed";

}



?>