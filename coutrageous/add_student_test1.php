<?php

/*

add_student.php

Allows user to create a new entry in the database

*/



// creates the new record form

// since this form is used multiple times in this file, I have made it a function that is easily reusable

function renderForm($anumber,$firstname, $lastname,$email, $major, $classification,$crn, $error)

{

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">

<html>

<head>

<title>New Student</title>

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

<div>

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

include('config.php');



// check if the form has been submitted. If it has, start to process the form and save it to the database

if (isset($_POST['submit']))

{

// get form data, making sure it is valid
$anumber = mysqli_real_escape_string($link, htmlspecialchars($_POST['anumber']));
$firstname = mysqli_real_escape_string($link, htmlspecialchars($_POST['firstname']));
$lastname = mysqli_real_escape_string($link, htmlspecialchars($_POST['lastname']));
$email = mysqli_real_escape_string($link, htmlspecialchars($_POST['email']));
$major = mysqli_real_escape_string($link, htmlspecialchars($_POST['major']));
$classification = mysqli_real_escape_string($link, htmlspecialchars($_POST['classification']));
$crn = mysqli_real_escape_string($link, htmlspecialchars($_POST['crn']));


// check to make sure both fields are entered

if ($anumber == '' || $firstname == '' || $lastname == '' || $email == '' || $major == '' || $classification == '' || $crn == '')

{

// generate error message

$error = 'ERROR: Please fill in all required fields!';



// if either field is blank, display the form again

renderForm($anumber,$firstname, $lastname,$email, $major, $classification,$crn, $error);

}

else

{

// save the data to the database

mysqli_query($link, "INSERT students SET anumber='$anumber', firstname='$firstname', lastname='$lastname', email='$email', major='$major', classification='$classification', crn='$crn'");

// or die(mysql_error());



// once saved, redirect back to the view page

header("Location: view_all_students.php");

}

}

else

// if the form hasn't been submitted, display the form

{

renderForm('','','', '','','','','');

}

?>