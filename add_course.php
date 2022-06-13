<?php
// Include config file
require_once "config.php";
 

?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ADD COURSE</title>
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

    <!-- select2 CSS -->
    <link href="Select2/select2.min.css" rel="stylesheet" />
    
    <!-- Select2 script -->
    <script src="Select2/select2.min.js"></script>

    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet"> 
    <link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet"> 

</head>
<body>

<div class="addnewstudent">

<div id="title">
<a id="backbtn" href="view_registry.php?type=courses" class="btn  btn-warning"></a><br><br>

    <h2 id="minititle">ADD COURSE</h2>
    <p>Please fill this form to add a course.</p>
</div>    



<div id="form1">
<div></div>
<div>
        <form action="validate.php" method="POST">
        <div class="form-group ">
                <input id="line" type="text" name="crn" class="crn" required >
                <label id="editlabt">CRN</label>
                <span class="crn_err"></span>
            </div> 

            <div class="form-group ">
                <input id="line" type="text" name="classname" class="classname" required>
                <label id="editlabt">Class Name</label>
                <span class="classname_err"></span>
            </div> 

            <div class="form-group ">
                <select name="anum" id="line" class="inst_anum" required>
                </select>
                <label id="editlabtss">Instructor A number</label>
                <label id="editlabts">Instructor A number</label>
                <span class="anum_err"></span>
            </div>    
            <div class="form-group ">
                <input id="line" type="text" name="ins_fname" class="ins_fname" required>
                <label id="editlabt">Instructor First Name</label>
                <span class="ins_fname_err"></span>
            </div>  

            <div class="form-group ">
                <input id="line" type="text" name="ins_lname" class="ins_lname" required>
                <label id="editlabt">Instructor Last Name</label>
                <span class="ins_lname_err"></span>
            </div>    
               <br> 
        

            <div class="form-group">
            <p id="reset1"><input type="reset" class="reset1" value="Reset"></p>
                <p  id="submitbtn"><input type="button" class="next" value="SUBMIT"></p><br>
                <p class="form-message"></p>
                <br>
                <p id="reset"> <a href="index.php">Return to Dashboard</a></p>
            </div> 
</div>       
       
<div id="command">
<div class="form-group">
</div>
           
</div>       
              
</form>

</div>

</div>   


<script>
    
$(document).ready(function(){
   
    $('.inst_anum').select2({
       // maximumSelectionLength: 1,
        allowClear: true,
        tags: true,
        tokenSeparators: [',', ' '],

        
        ajax: { 
        url: "validate.php",
        type: "post",
        dataType: 'json',
        delay: 250,
        data: function (params) {
            return {
            searchTerm: params.term,
            function: "get_instructors_anum" // search term
            };
        },
        processResults: function (response) {
          
             return {
                results: response
               
            };
        },
        cache: true
        },
       
    
        createTag: function (params) {
        // Don't offset to create a tag if nothing but a crn(number) is entered
        if (params.term.match(/^[0-9aA]+$/) == null) {
        // Return null to disable tag creation
        return null;
        }

        return {
        id: params.term,
        text: params.term
        }
        }
    }).on("select2:select", function (e) {
               //console.log(e.params.data.id); //
                var inst_anumber = e.params.data.id;
                // var a = $(".inst_anum").select2('val');
                // console.log(a);
               
                $.post("validate.php", {
                        function: "get_instructor_record",
                        inst_anumber : inst_anumber
          
                },function(data, status){
                        //$(".form-message").html(data);
                        var data = JSON.parse(data);
                        

                        if(data == ''){
                            $(".ins_fname").val("");
                            $(".ins_lname").val("");
                         
                        }else{ //autofill instructor fname and lname if anumber exist
                            $(".ins_fname").val(data[0].firstname);
                            $(".ins_lname").val(data[0].lastname);
                        }
                        
                });
    });
    
            
});



    $(document).ready(function(){
        $(".next").on('click', function(event){
            // event.preventDefault();
            var crn = $(".crn").val();
            var classname = $(".classname").val();
            var anumber = $(".inst_anum").select2('val');
            var ins_fname = $(".ins_fname").val();
            var ins_lname = $(".ins_lname").val();
            

           $.post("validate.php", {

                function: "validate_add_course",
                crn: crn,
                classname: classname,
                anumber: anumber,
                ins_fname: ins_fname,
                ins_lname: ins_lname                

           },function(data, status){
                $(".form-message").html(data);
                
                if(data=="success"){
                   alert(data);
                }
           });
           
        });

        $('.reset1').on('click',function(event){
             event.preventDefault();
            $(".crn, .classname, .inst_anum, .ins_fname,  .ins_lname ").val("");

            var selected_crns = $(".inst_anum").select2('val').pop();
                            
                            $(".inst_anum").val(selected_crns).trigger('change');

            location.reload();
        });


    });

</script>

<script>

$(document).ready(function(){
  $("#editlabtss").hide();  
  $("#editlabts").show();    

$(".select2-selection--single").click(function(){
  $("#editlabtss").show();
  $("#editlabts").hide();
//   $(".select2-selection--multiple").css({'border':'1.5px solid #760ce2'})
});

$(document).click(function(event) {
  //if you click on anything except the modal itself or the "open modal" link, close the modal
  if (!$(event.target).closest(".select2-selection--single,#editlabts").length) {
    $("#editlabtss").hide();
    $("#editlabts").show();
  }
});
});
</script>

</body>
</html>