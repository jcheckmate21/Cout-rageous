<?php
// Include config file
require_once "config.php";
require "functions.php";

?>

<!DOCTYPE html>
<html id="tutor">
<head>
<title>Tutors</title>
<!-- main jquery-->
<script src="jquery/jquery-3.4.1.min.js"> </script>

<!-- DatePicker moment.js -->
<script src="datepicker/moment.min.js"> </script>

<!-- Datepicker JS -->
<script type="text/javascript" src="datepicker/daterangepicker.min.js"></script>

<!-- DatePicker CSS -->
<link rel="stylesheet" type="text/css" href="datepicker/daterangepicker.css"/>

<!-- Bootstrap -->
<link rel="stylesheet" href="styling.css">

<!-- Chartist -->
<script src="Graph/chartist.min.js"></script>

<!-- chartist CSS -->
<link rel="stylesheet" href="Graph/chartist.min.css">

<!-- Chart -->
<script src="Graph/chart.min.js"></script>

<!-- chart CSS -->
<link rel="stylesheet" href="Graph/chart.min.css">

<link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet"> 
<link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet"> 

</head>

<body id="tutorbody">

<div class="tutorpage">
  


<div id="lefttab">
  <div id="lefttabtop">
    <a id="backbtn2" href="index.php"  class="btn btn-default"></a>
  </div>

  <div id="lefttabbottom">

    <div id="tutortit"><a href="remove_tutor.php"><p id="tutortitle">Tutors</p></a></div> 

    <div id="listof">
    <?php


if (isset($_GET['del'])) {
    $del = $_GET['del'];
    //SQL query for deletion.
    $query1 = mysqli_query( $link, "delete from users where username='$del'");

    echo ' <script> alert("'.$del.' Deleted!!!")';
    // '. '<a href="remove_tutor.php?del='.$row1['username'].'">Undo delete </a> ';' </script>    ';

    // once saved, redirect back to the view page
    header("Location: remove_tutor.php");
    }

// Selecting Database From Server.
$query = mysqli_query($link,"select * from users where not position ='admin'", );

// SQL query to fetch data to display in menu.
while ($row  = mysqli_fetch_assoc($query)) {
echo '<div id="tutorlist" class="'.$row['username'].'"><a href="remove_tutor.php?username='.$row['username'].'"><p id="tutorss"> '.$row['username'].'</p></a></div>';
}


?>  
</div>

<div>
<a id="addbtn1" href="register_tutor.php">+</a>
</div>
   

  </div>




</div>

<div id="infotab">


<div id="inforight">
    <div id="inforighttop">
        
       <!-- date range picker div -->
    <div id="reportrange" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 50%">
        <i class="fa fa-calendar"></i>&nbsp;
        <span></span> <i class="fa fa-caret-down"></i>
    </div>
        
    <div>
    
    <?php
     if (isset($_GET['username'])) {
         echo "<strong>".$_GET['username']." </strong>" ; 
        }
         
         ?>   
   
    </div>

    </div>

    <div id="inforightbot">
    <div id="myChart1"><canvas id="myChart"  ></canvas>
       </div>
    </div>
  </div>
  

  <div id="infoleft">


<?php
 
if (isset($_GET['username'])) {
    
?>    
  <div id="infolefttop">
<div id="facebox1"></div>
</div>

<div id="infoleftbot">

<?php

  $username = $_GET['username'];
  // SQL query to Display Details.
  $result = mysqli_query( $link, "select * from users where username='$username'");
  while($row = mysqli_fetch_assoc($result)){
  
  
  
      // get data from db
      $id =$row['id'];
      $anumber = $row['anumber'];
      $firstname = $row['firstname'];
      $lastname = $row['lastname'];
      $email = $row['email'];
      $position = $row['position'];

  }   


// Define variables and initialize with empty values
$username_err = $anumber_err = $firstname_err = $lastname_err = $email_err = $position_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    
    $anumber = $username = $firstname =$lastname = $email = $position = "";

     //save a copy of old anumber in case of change
    $id = trim($_POST["id"]);
     $result = mysqli_query($link, "SELECT * FROM users WHERE id = '$id'");

     if($row = mysqli_fetch_assoc($result)){
         $old_anumber = $row['anumber'];
         $old_username = $row['username'];

     }

    // Validate anumber
    if(empty(trim($_POST["anumber"]))){
        $anumber_err = "Please enter an anumber.";
    } else{
        // Prepare a select statement
        $sql = "SELECT * FROM users WHERE anumber = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_anumber);
            
            // Set parameters
            $param_anumber = trim($_POST["anumber"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                // validate new anumber if user wants to make a change
                if($old_anumber != trim($_POST["anumber"]) ){
                    //check if new anumber exists 
                    if(mysqli_stmt_num_rows($stmt) >= 1){
                        $anumber_err = "This anumber is already registered.";
                        } else{
                        $anumber = trim($_POST["anumber"]);
                        }
                    }else{
                        //keep number if no change (basically updating the same anumber in the data base)
                        $anumber = trim($_POST["anumber"]);
                    }
            } else{
                echo "Oops! Something went wrong. Please try again later."; //error message if statement wasn't executed
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }


    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    } else{
        // Prepare a select statement
        $sql = "SELECT * FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_anumber);
            
            // Set parameters
            $param_username = trim($_POST["username"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                // validate new username if user wants to make a change
                if($old_username != trim($_POST["username"]) ){
                    //check if new username exists 
                    if(mysqli_stmt_num_rows($stmt) >= 1){
                        $username_err = "This username is already registered.";
                        } else{
                        $username = trim($_POST["username"]);
                        }
                    }else{
                        //keep number if no change (basically updating the same username in the data base)
                        $username = trim($_POST["username"]);
                    }
            } else{
                echo "Oops! Something went wrong. Please try again later."; //error message if statement wasn't executed
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }

    // $anumber = trim($_POST["anumber"]);
    
     //validate First name
     if(empty(trim($_POST["firstname"]))){
        $firstname_err = "Please enter your First name.";     
    }
    else{
        $firstname = trim($_POST["firstname"]);
    }
    
    //validate last name
    if(empty(trim($_POST["lastname"]))){
        $lastname_err = "Please enter your last name.";     
    }
    else{
        $lastname = trim($_POST["lastname"]);
    }
    
    //validate email
    if(empty(trim($_POST["email"]))){
        $email_err = "Please enter your email.";     
    }
    else{
        $email = trim($_POST["email"]);
        //estract username from email address
        //$username = substr($email, 0, strpos($email, '@'));
    }
    
    //validate major
    if(empty(trim($_POST["position"]))){
        $position_err = "Please enter position.";     
    } else{
        $position = trim($_POST["position"]);
    }

  
    
    
    // Check input errors before inserting in database
    if(empty($username_err) && empty($anumber_err) && empty($firstname_err) &&empty($lastname_err)&& empty($email_err) && empty($position_err) ){
        
        // Prepare an insert statement
        $sql = "UPDATE users SET anumber = ?, username = ?, firstname = ?, lastname = ?, email = ?, position = ?  WHERE id = ?";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssssss",$param_anumber, $param_username, $param_firstname, $param_lastname, $param_email, $param_position, $param_id);
            
            // Set parameters
            $param_id = $id; 
            $param_anumber = $anumber;
            $param_username = $username;
            $param_firstname = $firstname;
            $param_lastname  = $lastname;
            $param_email = $email;
            $param_position = $position;
           
           
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
               //Maybe::: create a log with entry (which updated)
                        // Reload page
                $sql = "UPDATE tutor_attendance SET anumber = ?, firstname = ?, lastname = ? WHERE anumber = ?";

                if($stmt = mysqli_prepare($link, $sql)){
                    
                    mysqli_stmt_bind_param($stmt, "ssss",$anumber, $firstname, $lastname, $old_anumber);

                    if(mysqli_stmt_execute($stmt)){
                        $message = "SUCCESS!!";
                        echo "<script type='text/javascript'>alert('$message');</script>";
                        
                    }
                
                    header("location: remove_tutor.php?username=$username");
                }


            } else{
                echo "Something went wrong. Please try again later.";
            }
        }
         
      
    }
    
    // Close connection
    mysqli_close($link);

    //added this (test)
   // header("Location: view_all_students.php");
}
?>

<form id="info3" action="remove_tutor.php?username=<?php echo $username; ?>" method="post">
        <div>
            <!-- hidden form to store old anumber if user decides to change it -->
            <div class="form-group <?php echo (empty($id)) ? 'has-error' : ''; ?>">
                <input id="line3" type="hidden" name="id" class="form-control" value="<?php echo $id; ?>" required>
            </div>

            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <input type="text" id="line3"name="username" class="form-control" value="<?php echo $username; ?>" required>
                <span class="help-block"><?php echo $username_err; ?></span><br>                
                <label id="editlab3">Username</label>

            </div>    
            <div class="form-group <?php echo (!empty($anumber_err)) ? 'has-error' : ''; ?>">
                <input type="text" id="anumber3"name="anumber" class="form-control" value="<?php echo $anumber; ?>" required>
                <span class="help-block"><?php echo $anumber_err; ?></span><br>                
                <label id="editlab3">A number</label>

            </div>    
            <div class="form-group <?php echo (!empty($firstname_err)) ? 'has-error' : ''; ?>">
                <input id="line3" type="text" name="firstname" class="form-control" value="<?php echo $firstname; ?>" required>
                <span class="help-block"><?php echo $firstname_err; ?></span><br>
                <label id="editlab3">First Name</label>

            </div> 
            <div class="form-group <?php echo (!empty($lastname_err)) ? 'has-error' : ''; ?>">
                <input id="line3" type="text" name="lastname" class="form-control" value="<?php echo $lastname; ?>" required>
                <span class="help-block"><?php echo $lastname_err; ?></span><br>
                <label id="editlab3">Last Name</label>

            </div> 
            <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                <input id="line3" type="email" name="email" class="form-control" value="<?php echo $email; ?>" required>
                <span class="help-block"><?php echo $email_err; ?></span><br>
                <label id="editlab3">Email</label>

            </div> 
            <div class="form-group <?php echo (!empty($position_err)) ? 'has-error' : ''; ?>">
                <input id="line3" type="text" name="position" class="form-control" value="<?php echo $position; ?>" required>
                <span class="help-block"><?php echo $position_err; ?></span><br>
                <label id="editlab3">Position</label>

            </div> 
            
        </div><br><br>

            <div id="control">
                <input id="updatebtn33" type="submit" class="" value="Update">
                <input id="updatebtnedit" type="button" class="editbtn" value="edit">
            </div>

</form>


        <br>
<?php
  echo '<p id="reset"><a href="remove_tutor.php?del='.$username.'">Delete </a></p> ';
  
  // echo '<a href="remove_tutor.php?del='.$row1['username'].'">Undo delete </a> ';
 

}
// Closing Connection with Server.
//mysql_close($link);

?>


</div>

  </div>


</div>

</div>

<script>

  $(document).ready(function(){
    $("#line3 , #anumber3").prop("readonly", true);
    $("#line3 , #anumber3").attr("disabled", true);
    $("#updatebtn33").hide();

    $("#updatebtnedit").on('click', function(){
    $('#updatebtnedit').hide();
    $('#updatebtn33').show();
    $("#line3 , #anumber3").removeAttr('readonly');
    $("#line3 , #anumber3").removeAttr('disabled');
    });

        //highlight which tutor selected 
    <?php if (isset($_GET['username'])) {

        $tutor_selector = ".".$_GET['username'];
    ?>
    
    $(" <?php echo $tutor_selector; ?>").css({ 'color': 'black', 'background': 'white' });

    <?php } ?>  
     
     
});


function showgraph(graph_data, graph_type){ //for Chart.js************************************
    var ctx = $("#myChart")[0].getContext('2d');
    var myChart = new Chart(ctx, {
    type: graph_type, 
    responsive: true,
    maintainAspectRatio: false,
    data: {
        labels:graph_data[0],
        datasets: [{
            label: 'Number of hours',
            data: graph_data[1],
            backgroundColor: [
                'rgba(119, 12, 226, 0.2)',
                'rgba(119, 12, 226, 0.9)',
                'rgba(119, 12, 226, 0.5)',
                'rgba(119, 12, 226, 0.6)',
                'rgba(119, 12, 226, 0.8)',
                'rgba(119, 12, 226, 0.9)'
            ],
            borderColor: [
                'rgba(119, 12, 226, 1)',
                'rgba(119, 12, 226, 1)',
                'rgba(119, 12, 226, 1)',
                'rgba(119, 12, 226, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(119, 12, 226, 1)'
            ],
            borderWidth: 3
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    }
});
   
}

//showgraph();
var func ="<?php 
            if (isset($_GET['username'])) {
                echo "validate_get_graph_data";
                // $anumber = $_GET['anumber'];
                // echo display_graph($link, $anumber, $position, $start, $end)[1];

            } else{
                echo "validate_tutor_gen_graph_data";
                // echo tutors_gen_graph($link, $start, $end)[1];
            }
                    
            ?>";
//console.log(func);
var graph_type ="<?php 
            if (isset($_GET['username'])) {
                echo "line";
                // $anumber = $_GET['anumber'];
                // echo display_graph($link, $anumber, $position, $start, $end)[1];

            } else{
                echo "bar";
                // echo tutors_gen_graph($link, $start, $end)[1];
            }
                    
            ?>";

//console.log(graph_type);


$(function() {
    var anum = "<?php if (isset($_GET['username'])) {
               echo $anumber; 
            }?>";
    var start = moment().subtract(29, 'days');
    var end = moment();

function cb(start, end) {
    $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
    $('.date').val(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
    //alert('New date range selected: ' + start.format('YYYY/MM/DD') + ' to ' + end.format('YYYY/MM/DD') );

   // showgraph();
    $.post("validate.php", {

    function: func,
    type : "tutor",
    from : start.format('YYYY/MM/DD'),
    to : end.format('YYYY/MM/DD'),
    anumber : anum

    },function(data, status){
 
    var graph_data = JSON.parse(data);
        //console.log(data);
        //console.log(graph_data);

    if(data == ''){

        alert("Cannot load graph");

    }else{
        showgraph(graph_data, graph_type);
    //getChart(graph_data);
        
    }
    });

}

$('#reportrange').daterangepicker({
    autoApply : true,
    startDate: start,
    endDate: end,
    ranges: {
       'Today': [moment(), moment()],
       'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
       'Last 7 Days': [moment().subtract(6, 'days'), moment()],
       'Last 30 Days': [moment().subtract(29, 'days'), moment()],
       'This Month': [moment().startOf('month'), moment().endOf('month')],
       'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
    }
}, cb);

cb(start, end);

});
</script>

</body>
</html>
