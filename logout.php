<?php

include "functions.php";
// Initialize the session
session_start();
 
 // Store data in session variables
 
    

 if(isset($_SESSION["position"])){
    $position = $_SESSION["position"];
 }
 if(isset($_SESSION["anumber"])){
    $anumber = $_SESSION["anumber"];
 }

 // clock tutor out
 $output = clock_out( $position, $anumber, $link);
 echo "<script>console.log( $output );</script>";

// Unset all of the session variables
$_SESSION = array();
 
// Destroy the session.
session_destroy();
 
// Redirect to login page
header("location: index.php");
exit;
?>