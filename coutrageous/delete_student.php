<?php

/*

delete_student.php

Deletes a specific entry from the 'players' table

*/



// connect to the database

include('config.php');



// check if the 'id' variable is set in URL, and check that it is valid

if (isset($_GET['id']) && is_numeric($_GET['id']) && isset($_GET['confirm']))

{

// get id value

$id = $_GET['id'];
$confirm = $_GET['confirm'];


$confirm_msg ="Delete ".$id."'s records?";

echo '  <script>  alert("'.$confirm_msg.'")  </script>  ';

if($confirm== 0){
    // delete the entry

 $result = mysqli_query($connection, "DELETE FROM players WHERE id=$id");
 echo '  <script>  alert("'.'DELETED!!!!!!!'.'")  </script>  ';
 $confirm = 1;
 
}

// delete the entry

// $result = mysqli_query($connection, "DELETE FROM players WHERE id=$id");

// or die(mysql_error());

   if ($confirm==1){
    echo '  <script>  alert("'.'DELETED!!!!!!!'.'")  </script>  ';
    header("Location: view_all_students.php");
   }

// redirect back to the view page
// else{
// header("Location: view_all_students.php");
// }
}

else

// if id isn't set, or isn't valid, redirect back to view page

{

header("Location: view_all_students.php");

}



?>