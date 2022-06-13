<!DOCTYPE HTML>

<html>

<head>

<title>View Records</title>

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
<div class="registerstudent">  

<div id="title">
<a id="backbtn" href="view_registry.php?type=students" class="left" ></a><br><br>

    <h2 id="minititle">REGISTER STUDENT</h2>
    <p>Please fill this form to create an account</p>
</div>
<div  id="form1" class="form">
<div></div>
    <div>
        <form autocomplete="off" action="validate.php" method="POST">
            <input type="hidden" name="show_modal" value="<?php echo $show_modal; ?>">
            <div class="form-group ">
                <input id="line" type="text" name="anumber" class="anumber" required>
                <label id="editlabt">A number</label>
                <span class="anum_err"></span>
            </div>    
            <div class="form-group ">
                <input id="line" type="text" name="firstname" class="firstname" required>
                <label id="editlabt">First Name</label>
                <span class="fname_err"></span>
            </div>    
            <div class="form-group ">
                <input id="line" type="text" name="lastname" class="lastname" required>
                <label id="editlabt">Last Name</label>
                <span class="lname_err"></span>
            </div>    
            <div class="form-group ">
                <input id="line" type="text" name="email" class="email" required>
                <label id="editlabt">Email</label>
                <span class="email_err"></span>
            </div> 
            <div class="form-group ">
                <input id="line" type="text" name="major" class="major" required>
                <label id="editlabt">Major</label>
                <span class="major_err"></span>
            </div>     
            <div class="form-group ">
                <!-- <input id="line" type="text" name="classification" class="classification" > -->
                <select id="line" type="text" name="classification" class="classification" required>
                    <option value=""></option>
                    <option value="freshman">freshman</option>
                    <option value="sophomore">sophomore</option>
                    <option value="junior">junior</option>
                    <option value="senior">senior</option>
                </select>
                <label id="editlabt">Classification</label>
                <span class="class_err"></span>
            </div>    
              
            <div class="form-group">
                <select name="crn" id="line" class="selectcrn" multiple="multiple" required>
                </select>
                <label id="editlabtss">CRN(s)</label>
                <label id="editlabts">CRN(s)</label>
                <span class="crn_err"></span>
            </div> 

            <div class="form-group pw_div ">
                <input id="line" type="password" name="password" class="password" autocomplete="new-password" required>
                <label id="editlabt">Password</label>
                <span class="password_err"></span>
            </div> 
            <div class="form-group pw_div  ">
                <input id="line" type="password" name="confirm_password" class="confirm_password" required>
                <label id="editlabt">Confirm Password</label>
                <span class="confirm_password_err"></span>
            </div> 
            <br> <p id="reset1"><input type="reset" class="btn btn-default"></p>
            <!-- <p id="reset1"><input type="button" class="changepw" value="Add Password"></p> -->
                        <p id="reset"><a href="index.php">Return to Dashboard</a></p>
    </div>        
    <div id="command">
        <div class="form-group">

                <!-- <input id="submitbtn" type="submit" class="btn btn-primary" value="Submit"> -->
                
                <!-- <input id="nextbtn" type="submit" class="btn btn-primary" value="Next"><br> -->
                <input id="nextbtn" type="button" class="next" name="submit" value="next">
                    <p class="form-message"></p>
                <!-- <a href="facepage.php"><div id="nextbtn">next</div></a><br> -->
                <!-- <div id="reset" type="reset"><a href="#" class="btn btn-default">Reset</a></div> -->    
            </div>
    </div>
    <br> <br>
    <!-- <textarea name="message" id="mail-message" cols="30" rows="10" placeholder="Message"></textarea>
    <br> -->
  

</form>
</div>
</div>


<script>
    
$(document).ready(function(){
   

    // $(".pw_div").hide(); //to hide passwords
    // var addpw = false;
    // alert("addpw : "+ addpw);
    
    // $(".changepw").on("click", function(){
    //     $(".pw_div").toggle();
    //     addpw = !addpw;
    //     alert("addpw : "+ addpw);
    // });



    $('.selectcrn').select2({
      
        maximumSelectionLength: 9,
        allowClear: true,
        //tags: true,
        tokenSeparators: [',', ' '],

        
        ajax: { 
        url: "validate.php",
        type: "post",
        dataType: 'json',
        delay: 250,
        data: function (params) {
            return {
            searchTerm: params.term,
            function: "get_crns" // search term
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
        if (params.term.match(/^[0-9]+$/) == null) {
        // Return null to disable tag creation
        return null;
        }

        return {
        id: params.term,
        text: params.term
        }
        }
    }).on("select2:select", function (e) {
        
        //clear error codes if any
        if($(".selectcrn").select2('val')){
                $(".crn_err").html("");
                }

    });
    
         
    var editrecord = false;
        //if anumber is entered, make ajax call to verify stuff
        $(".anumber").focusout(function(){

            var anumber = $(".anumber").val();

            if(anumber != ''){//if anumber entered, and  right length(I will add that)
                //make ajax call

                $.post("validate.php", {
                        function: "check_inst_anumber_complete",
                        anumber : anumber
          
                },function(data, status){
                    $(".form-message").html(data);

                    if(data == "incomplete"){
                      
                         editrecord = confirm("Incomplete A number record found. Do you wish to complete it?");

                        if(editrecord){//REconstruct page to edit/ update instructor record
                            //alert("Redirecting to edit page......");
                            $("#minititle").html("UPDATE STUDENT");
                            $("#subtitle").html("Please fill form to edit student");
                            $(".reset").val("Cancel");

                            //prefill form with available info
                            $.post("validate.php", {
                                function: "get_anumber_record",
                                inst_anumber : anumber
                
                                },function(data, status){
                                        //$(".form-message").html(data);
                                        var data = JSON.parse(data);
                                        alert(data);
                                        console.log(data);

                                        if(data == ''){
                                            // $(".firstname").val("");
                                            // $(".lastname").val("");
                                        }else{ //autofill instructor fname and lname if anumber exist
                                           
                                            $(".inst_id").val(data[0].id);//keep id in hidden input for update purposes
                                            $(".firstname").val(data[0].firstname);
                                            $(".lastname").val(data[0].lastname);
                                            $(".email").val(data[0].email);
                                            $(".password").val(data[0].password);

                                           
                                            //case of CRN section with select2
                                            $('.selectcrn').append(data[0].crn);
                                            
                                        }
                                        
                                });

                                $(".reset").on('click', function(event){
                                    location.reload();
                                });

                        }else{
                            // $("#line").val("");
                            location.reload();
                        }
                       
                    }
                      

                });


            }

      
        });




        $(".next").on('click', function(event){
            // event.preventDefault();
            var anumber = $(".anumber").val();
            var firstname = $(".firstname").val();
            var lastname = $(".lastname").val();
            var email = $(".email").val();
            var classification = $(".classification").val();
            var major = $(".major").val();
            var crn = $(".crn").val();
            var password = $(".password").val();
            var confirm_password = $(".confirm_password").val();
            // var submit = $(".submit").val();
            
             var crn = $(".selectcrn").select2('val');
            
            // alert(crn);
            //determine whether to update or insert a new record
            if(editrecord){

           $.post("validate.php", {
                function: "validate_edit_student",
                action : "complete",
                anumber: anumber,
                firstname: firstname,
                lastname: lastname,
                email: email,
                classification: classification,
                major: major,
                crn : crn,
                password : password,
                confirm_password : confirm_password,
                // submit : submit

           },function(data, status){
                $(".form-message").html(data);
                // alert(data);
                
                if(success == "true"){
                //    alert(data);
                   window.location.replace("facepage.php");
                   $( ".registerstudent" ).load( "facepage.php" );
                }
           });
        }else{
                //alert("new");
               //Submit form to "insert" new record
                $.post("validate.php", {
                        function: "validate_reg_student",
                        anumber: anumber,
                        firstname: firstname,
                        lastname: lastname,
                        email: email,
                        classification: classification,
                        major: major,
                        crn : crn,
                        password : password,
                        confirm_password : confirm_password
                        // submit : submit

                },function(data, status){
                        $(".form-message").html(data);
                        if(success == "true"){
                        //    alert(data);
                        window.location.replace("facepage.php");
                        $( ".registerstudent" ).load( "facepage.php" );
                        }
                });
            }
           
        });







        $('#reset').on('click',function(){
            $(".selectcrn").select2("val", "");
            $(".selectcrn").val('').trigger('change');
        });

       

        $('input').on('click keyup',function(event){
           if($(".anumber").val()){
            $(".anum_err").html("");
           }
           if($(".firstname").val()){
            $(".fname_err").html("");
           }
           if($(".lastname").val()){
            $(".lname_err").html("");
           }
           if($(".email").val()){
            $(".email_err").html("");
           }
           if($(".major").val()){
            $(".major_err").html("");
           }
           if($(".classification").val()){
            $(".class_err").html("");
           }
           if($(".password").val()){
            $(".password_err").html("");
           }
           if($(".confirm_password").val()){
            $(".confirm_password_err").html("");
           }
           

           //$(".selectcrn").val('').trigger('change');
            
        });


    });

</script>

<script>

$(document).ready(function(){
  $("#editlabtss").hide();  
  $("#editlabts").show();    

$(".select2-selection--multiple").click(function(){
  $("#editlabtss").show();
  $("#editlabts").hide();
//   $(".select2-selection--multiple").css({'border':'1.5px solid #760ce2'})
});

$(document).click(function(event) {
  //if you click on anything except the modal itself or the "open modal" link, close the modal
  if (!$(event.target).closest(".select2-selection--multiple,#editlabts").length) {
    $("#editlabtss").hide();
    $("#editlabts").show();
  }
});
});
</script>
</body>

</html>