<?php


// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: index.php");
    exit;
}else{
   
    $id = htmlspecialchars($_SESSION["id"]) ;
    $position = htmlspecialchars($_SESSION["position"]);
    $username = htmlspecialchars($_SESSION["username"]);   
}

// Include config file
require_once "config.php";
require "functions.php";

$graph_msg = "";

if(isset($_GET['anumber']) || $_GET['anumber'] !=""){
    $get_anumber  = trim($_GET['anumber']);
    
    
    // get results from database

    $result = mysqli_query($link,"select * from students where anumber= '$get_anumber'");

    while($row = mysqli_fetch_assoc($result)){

    // get data from db
    $id =$row['id'];
    $type =$row['type'];
  
    $anumber = $row['anumber'];
    $firstname = $row['firstname'];
    $lastname = $row['lastname'];
    $email = $row['email'];
    $major = $row['major'];
    $classification = $row['classification'];
    $crn = $row['crn'];
    $type = $row['type'];
    
    }

}else{
    header("location; admin.php");
}
 
// Define variables and initialize with empty values

$anumber_err = $password_err = $firstname_err = $lastname_err = $email_err = $major_err = $classification_err = $crn_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    
    $anumber = $username = $password = $firstname =$lastname = $email = $major = $classification = $crn = $confirm_password = "";

     //save a copy of old anumber in case of change
    $id = trim($_POST["id"]);
     $result = mysqli_query($link, "SELECT * FROM students WHERE id = '$id'");

     if($row = mysqli_fetch_assoc($result)){
         $old_anumber = $row['anumber'];
     }

    // Validate anumber
    if(empty(trim($_POST["anumber"]))){
        $anumber_err = "Please enter an anumber.";
    } else{
        // Prepare a select statement
        $sql = "SELECT * FROM students WHERE anumber = ?";
        
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
        $username = substr($email, 0, strpos($email, '@'));
    }
    
    //validate major
    if(empty(trim($_POST["major"]))){
        $major_err = "Please enter your major.";     
    } elseif(strlen(trim($_POST["major"])) < 2){
        $major_err = "Enter valid major";
    } else{
        $major = trim($_POST["major"]);
    }

    //validate classification
    if(empty(trim($_POST["classification"]))){
        $classification_err = "Please enter your classification.";     
    } elseif(strlen(trim($_POST["classification"])) < 2){
        $classification_err = "Enter valid classification";
    } else{
        $classification = trim($_POST["classification"]);
    }
    
     //validate CRN
     if(empty(trim($_POST["crn"]))){
        $crn_err = "Please enter your CRN.";     
    }
    else{
        $crn = trim($_POST["crn"]);
    }
    
    // Check input errors before inserting in database
    if(empty($anumber_err) && empty($major_err) && empty($firstname_err) &&empty($lastname_err)&& empty($email_err) && empty($password_err)  && empty($classification_err) && empty($crn_err)){
        
        // Prepare an insert statement
        $sql = "UPDATE students SET anumber = ?, username = ?, firstname = ?, lastname = ?, email = ?, major = ?, classification = ?, crn = ?  WHERE id = ?";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssssssss",$param_anumber, $param_username, $param_firstname, $param_lastname, $param_email, $param_major, $param_classification, $param_crn, $param_id);
            
            // Set parameters
            $param_id = $id; 
            $param_anumber = $anumber;
            $param_username = $username;
            $param_firstname = $firstname;
            $param_lastname  = $lastname;
            $param_email = $email;
            $param_major = $major;
            $param_classification = $classification;
            $param_crn = $crn;
           
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                //Maybe::: create a log with entry (which updated)
             
            // Reload page
            $sql = "UPDATE attendance SET anumber = ?, firstname = ?, lastname = ?  WHERE anumber = ?";

            if($stmt = mysqli_prepare($link, $sql)){
            
             mysqli_stmt_bind_param($stmt, "ssss",$anumber, $firstname, $lastname, $old_anumber);

             if(mysqli_stmt_execute($stmt)){
                 $message = "SUCCESS!!";
                 echo "<script type='text/javascript'>alert('$message');</script>";
                
             }
         
             header("location: edit_student.php?anumber=$anumber" );
         }




             //Display Success in pop-up
             // $message = "SUCCESS!!";
             // echo "<script type='text/javascript'>alert('$message');</script>";
             // header("Location: view_all_students.php?sort=all");

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

 
<!DOCTYPE html>
<html id="editstud" lang="en">
<head>
    <meta charset="UTF-8">
    <title>REGISTRY</title>

   <!-- qr generator scripts -->
   <script type="text/javascript" src="qr_generator/jquery.min.js"></script>
    <script type="text/javascript" src="qr_generator/qrcode.min.js"></script>

    <!-- main jquery-->
    <script src="jquery/jquery-3.4.1.min.js"> </script>

    <!-- Main CSS -->
    <link rel="stylesheet" href="styling.css">

    <!-- Chartist -->
    <script src="Graph/chartist.min.js"></script>

    <!-- chartist CSS -->
    <link rel="stylesheet" href="Graph/chartist.min.css">

    <!-- Chart -->
    <script src="Graph/chart.min.js"></script>

    <!-- chart CSS -->
    <link rel="stylesheet" href="Graph/chart.min.css">
        
    <!-- DatePicker moment.js -->
    <script src="datepicker/moment.min.js"> </script>

    <!-- Datepicker JS -->
    <script type="text/javascript" src="datepicker/daterangepicker.min.js"></script>

    <!-- DatePicker CSS -->
    <link rel="stylesheet" type="text/css" href="datepicker/daterangepicker.css"/>
    
    <!-- select2 CSS -->
    <link href="Select2/select2.min.css" rel="stylesheet" />
    
    <!-- Select2 script -->
    <script src="Select2/select2.min.js"></script>
    <script>$(".modal").hide(); </script>

<link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet"> 
<link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet"> 

</head>
<body>

<div class="studentpage">

<div id="form2">
    <div><a id="backbtn1" href="view_registry.php?type=<?php echo $type.'s'; ?>" class="btn btn-default" ></a>
</div>
 <div></div>

    <div><p id="resetn"> <a href="index.php">Return to Dashboard</a></p>
</div>

</div>


<div id="title2">
<div id="title2_top">
<?php echo "<strong>".$firstname."&nbsp;".$lastname."&nbsp;- ".$anumber." </strong>" ?>


</div>
<div id="title2_bottom">
    <div id="title2a">
    <div id="title2am">
    <div id="myChart1"><canvas id="myChart"  ></canvas>
        <?php echo $graph_msg ?></div>
    </div>
    </div>

    <div id="title2b">
    <div id="title2a1">
        <h4>Date Interval: </h4>
        <div id="reportrange" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 50%">
        <i class="fa fa-calendar"></i>&nbsp;
        <span></span> <i class="fa fa-caret-down"></i>
        </div>

    </div>
    <div id="title2a2"></div>
    <div id="title2a3"></div>
    </div>
</div>
</div>


<div id="title3">


<div id="qr">
        <!-- <input id="text"  class"" type="text" value="" style="width:40%; height: 50px" /><br /> -->
        <div id="qrqr"></div>
</div>


    
    <div id="form2bottom" class="wrapper3 col-lg-6">
        <h5></h5>
        <form id="info" action="<?php echo 'edit_registry.php?anumber='.$_GET['anumber']; ?>" method="post">
        <div>
            <!-- hidden form to store old anumber if user decides to change it -->
            <div class="form-group <?php echo (empty($id)) ? 'has-error' : ''; ?>">
                <input id="line2" type="hidden" name="id" class="form-control" value="<?php echo $id; ?>">
            </div>

            <div class="form-group <?php echo (!empty($anumber_err)) ? 'has-error' : ''; ?>">
                <input type="text" id="anumber"name="anumber" class="form-control" value="<?php echo $anumber; ?>">
                <span class="help-block"><?php echo $anumber_err; ?></span><br>                
                <label id="editlab">A number</label>

            </div>    
            <div class="form-group <?php echo (!empty($firstname_err)) ? 'has-error' : ''; ?>">
                <input  id="line2" type="text" name="firstname" class="form-control" value="<?php echo $firstname; ?>">
                <span class="help-block"><?php echo $firstname_err; ?></span><br>
                <label id="editlab">First Name</label>

            </div> 
            <div class="form-group <?php echo (!empty($lastname_err)) ? 'has-error' : ''; ?>">
                <input id="line2" type="text" name="lastname" class="form-control" value="<?php echo $lastname; ?>">
                <span class="help-block"><?php echo $lastname_err; ?></span><br>
                <label id="editlab">Last Name</label>

            </div> 
            <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                <input id="line2" type="email" name="email" class="form-control" value="<?php echo $email; ?>">
                <span class="help-block"><?php echo $email_err; ?></span><br>
                <label id="editlab">Email</label>

            </div> 

<?php

if($type!=="instructor"){

?>

            <div class="form-group <?php echo (!empty($major_err)) ? 'has-error' : ''; ?>">
                <input id="line2" type="text" name="major" class="form-control" value="<?php echo $major; ?>">
                <span class="help-block"><?php echo $major_err; ?></span><br>
                <label id="editlab">Major</label>

            </div> 
            <div class="form-group <?php echo (!empty($classification_err)) ? 'has-error' : ''; ?>">
                <input id="line2" type="text" name="classification" class="form-control" value="<?php echo $classification; ?>">
                <span class="help-block"><?php echo $classification_err; ?></span><br>
                <label id="editlab">Classification</label>

            </div>

<?php
}
?>
            <div class="form-group <?php echo (!empty($crn_err)) ? 'has-error' : ''; ?>">
                <input id="line2" type="text" name="crn" class="form-control" value="<?php echo $crn; ?>">
                <span class="help-block"><?php echo $crn_err; ?></span><br>
                <label id="editlab">CRN(s)</label>

            </div> 
        </div>

            

        </form>
        <div id="control">
                <!-- <input id="updatebtn333" type="submit" class="" value="Update"> -->

                <form action="edit_<?php echo $type; ?>.php" method="POST">
                        <input type="hidden" name="anumber" value="<?php echo $anumber; ?>">
                        <input id="updatebtneditt" type="submit" class="editbtn" value="edit">

                </form>
                
            </div>
    </div> 
</div>


</div> 


<!-- The Modal -->
<div id="myModal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    
    <div id="qrpopup">

        <div id="qrcode"></div>

    </div>

     <span class="close"></span>
  </div>

</div>







<script>


$(document).ready(function(){
    
    $(".modal").hide();   

    $("#qr").click(function(){
    $(".modal").show();
    });

    $(document).click(function(event) {
    //if you click on anything except the modal itself or the "open modal" link, close the modal
    if (!$(event.target).closest("#qrpopup,#qr").length) {
        $("body").find(".modal").hide();
    }
    })


});











// Script for QR Generator ..Will later place it in a function    
var qrcode = new QRCode(document.getElementById("qrcode"),);
// var qrcod = new QRCode(document.getElementById("qrcod"),);


function makeCode () {		
	var elText = document.getElementById("anumber");
	
	if (!elText.value) {
		// alert("Input a text");
		elText.focus();
		return;
	}
	
	qrcode.makeCode(elText.value);
    // qrcod.makeCode(elText.value);
}

makeCode();

$("#anumber").
	on("blur", function () {
		makeCode();
	}).
	on("keydown", function (e) {
		if (e.keyCode == 13) {
			makeCode();
		}
	}); 


    //for Chart.js************************************

function getChart(graph_data){

    var ctx = $("#myChart")[0].getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'line',
        responsive: true,
        maintainAspectRatio: false,
        data: {
            labels: graph_data[0],
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
   

$(document).ready(function(){
    $("#line2 , #anumber").prop("readonly", true);
    $("#line2 , #anumber").attr("disabled", true);
    $('#updatebtn333').hide();

    $("#updatebtneditt").on('click', function(){

        window.location.replace("http://stackoverflow.com");
        // $('#updatebtneditt').hide();
        // $('#updatebtn333').show();
        // $("#line2 , #anumber").removeAttr('readonly');
        // $("#line2 , #anumber").removeAttr('disabled');
    });
            
});




$(function() {

var anum = "<?php echo $get_anumber;?>";

var start = moment().subtract(29, 'days');
var end = moment();

function cb(start, end) {
    $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
    $('.date').val(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));


    $.post("validate.php", {

                function: "validate_get_graph_data",
                type : "student",
                from : start.format('YYYY/MM/DD'),
                to : end.format('YYYY/MM/DD'),
                anumber : anum

           },function(data, status){
                //$(".load_table").html(data);

                //console.log(data);

                var graph_data = JSON.parse(data);
              

                if(data == ''){

                    alert("Cannot load graph");

                }else{
                    
                   getChart(graph_data);
                    
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

