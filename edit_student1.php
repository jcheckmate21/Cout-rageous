<?php

/*

edit_student.php

Allows user to edit specific entry in database

*/



// creates the edit record form

// since this form is used multiple times in this file, I have made it a function that is easily reusable

function renderForm($anumber,$firstname, $lastname,$email, $major, $classification,$crn, $error, $link)
{

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">

<html>

<head>

<title>Edit Record</title>

</head>

<body>

<?php

// if there are any errors, display them

if ($error != '')

{

echo '<div style="padding:4px; border:1px solid red; color:red;">'.$error.'</div>';

}

?>



<form action="" method="post">

<input type="hidden" name="anumber" value="<?php echo $anumber; ?>"/>

<div>

<p><strong>anumber:</strong> <?php echo $anumber; ?></p>

<strong>A number: *</strong> <input type="text" name="anumber" value="<?php echo $anumber; ?>" /><br/>

<strong>First Name: *</strong> <input type="text" name="firstname" value="<?php echo $firstname; ?>" /><br/>

<strong>Last Name: *</strong> <input type="text" name="lastname" value="<?php echo $lastname; ?>" /><br/>

<strong>Email: *</strong> <input type="email" name="email" value="<?php echo $email; ?>" /><br/>

<strong>Major: *</strong> <input type="text" name="major" value="<?php echo $major; ?>" /><br/>

<strong>Classification: *</strong> <input type="text" name="classification" value="<?php echo $classification; ?>" /><br/>

<strong>CRN: *</strong> <input type="text" name="crn" value="<?php echo $crn; ?>" /><br/>

<p>* required</p>


<input type="submit" name="submit" value="Submit">

</div>

</form>

</body>

</html>

<?php

}







// connect to the database

include('test_config.php');



// check if the form has been submitted. If it has, process the form and save it to the database

if (isset($_POST['submit']))

{

// confirm that the 'id' value is a valid integer before getting the form data

if (is_numeric($_POST['anumber']))

{

// get form data, making sure it is valid

$anumber = $_POST['anumber'];
$anumber = mysqli_real_escape_string($link, htmlspecialchars($_POST['anumber']));
$firstname = mysqli_real_escape_string($link, htmlspecialchars($_POST['firstname']));
$lastname = mysqli_real_escape_string($link, htmlspecialchars($_POST['lastname']));
$email = mysqli_real_escape_string($link, htmlspecialchars($_POST['email']));
$major = mysqli_real_escape_string($link, htmlspecialchars($_POST['major']));
$classification = mysqli_real_escape_string($link, htmlspecialchars($_POST['classification']));
$crn = mysqli_real_escape_string($link, htmlspecialchars($_POST['crn']));




// check that firstname/lastname fields are both filled in

if ($anumber == '' || $firstname == '' || $lastname == '' || $email == '' || $major == '' || $classification == '' || $crn == '')
{

// generate error message

$error = 'ERROR: Please fill in all required fields!';



//error, display form

renderForm($anumber,$firstname, $lastname,$email, $major, $classification,$crn, $error, $link);

}

else

{

// save the data to the database

mysqli_query($link, "INSERT students SET anumber='$anumber', firstname='$firstname', lastname='$lastname', email='$email', major='$major', classification='$classification', crn='$crn'");
// or die(mysql_error());



// once saved, redirect back to the view page

header("Location: view_all_students.php?sort=all");

}

}

else

{

// if the 'id' isn't valid, display an error

echo 'Error!';

}

}

else

// if the form hasn't been submitted, get the data from the db and display the form

{



// get the 'id' value from the URL (if it exists), making sure that it is valid (checing that it is numeric/larger than 0)

if (isset($_GET['anumber']))

{
// query db
$anumber = $_GET['anumber'];

$result = mysqli_query($link,"select * from users where anumber=$anumber");



// success! check results
$row = mysqli_fetch_assoc( $result ) ;


// get data from db
$anumber = $row['anumber'];
$firstname = $row['firstname'];
$lastname = $row['lastname'];
$email = $row['email'];
$major = $row['major'];
$classification = $row['classification'];
$crn = $row['crn'];
// show form

renderForm($anumber,$firstname, $lastname,$email, $major, $classification,$crn, $error);



// check that the 'anumber' matches up with a row in the databse
// if($row)

// {



// // get data from db
// $anumber = $row['anumber'];
// $firstname = $row['firstname'];
// $lastname = $row['lastname'];
// $email = $row['email'];
// $major = $row['major'];
// $classification = $row['classification'];
// $crn = $row['crn'];
// show form

renderForm($anumber,$firstname, $lastname,$email, $major, $classification,$crn, $error);

}



else{

// if the 'anumber' in the URL isn't valid, or if there is no 'anumber' value, display an error



echo 'Error!';

}

}

?>