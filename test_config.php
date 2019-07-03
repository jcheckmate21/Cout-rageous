<?php

/*

test_config.php

Allows PHP to connect to your database

*/



// Database Variables (edit with your own server information)

$server = 'localhost';

$user = 'root';

$pass = '';

$db = '';



// Connect to Database

$connection = mysqli_connect($server, $user, $pass, $db);

// Check connection
if($connection === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}





?>