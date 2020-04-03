


<!DOCTYPE html>

<head>

<title>Register Instructor</title>

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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">



</head>

<body>
<div class="registerstudent">
    
<div id="title">
<a id="backbtn" href="view_registry.php?type=instructors" class="btn  btn-warning"></a><br><br>

    <h2 id="minititle">REGISTER INSTRUCTOR</h2>
    <p id="subtitle">Please fill this form to create an account</p>
</div>
<div  id="form1" class="form">
<div></div>
    <div>
        <form autocomplete="off" action="validate.php" method="POST">
            <!-- hidden input to store instructor id if any -->
            <input type="hidden" name="inst_id" class="inst_id" >

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
                <input id="line" type="text" name="email" class="email"  required>
                <label id="editlabt">Email</label>
                <span class="email_err"></span>
            </div> 

            <div class="form-group">
                <select name="crn" id="line" class="selectcrn" multiple="multiple" required>
                </select>
                <label id="editlabtss">CRN(s)</label>
                <label id="editlabts">CRN(s)</label>
                <span class="crn_err"></span>
            </div> 

            <div class="form-group ">
                <input id="line" type="password" name="password" class="password" autocomplete="new-password" required>
                <label id="editlabt">Password</label>
                <span class="password_err"></span>
            </div> 

            <div class="form-group">
                <input id="line" type="password" name="confirm_password" class="confirm_password" required>
                <label id="editlabt">Confirm Password</label>
                <span class="confirm_password_err"></span>
            </div><br>
            <div class="form-group">
                <p id="reset1"><input type="reset" class="reset" value="Reset"></p>
                <p  id="submitbtn"><input type="button" class="btn btn-primary" value="Submit" class="next"></p><br><br>
                <p class="form-message"></p>
                <p id="reset"> <a href="index.php">Return to Dashboard</a></p>

            </div> 
</div>
<div id="command">
        <div class="form-group">
        </div>
</div>

    </form>
</div>

<script>
    
$(document).ready(function(){

    $('.selectcrn').select2({
        maximumSelectionLength: 10,
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
                function: "get_inst_crns", 
                anumber: " "
            };
        },
        processResults: function (response) {
            return {
                results: response
            };
        },
        formatNoMatches: function () {
  return "No Results Found <a href='#' class='btn btn-danger'>Use it anyway</a>";
  },                            
        cache: true
        },
       
    

        createTag: function (params) {
            // Don't offset to create a tag if there is no @ symbol
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


               //console.log(e.params.data.id); //
                var crn = e.params.data.id;
                // var a = $(".inst_anum").select2('val');
                // console.log(a);
               
                $.post("validate.php", {
                        function: "get_crns",
                        searchTerm : crn
          
                },function(data, status){
                        //$(".form-message").html(data);
                        var data = JSON.parse(data);
                        

                        if(data == ''){
                            // $(".ins_fname").val("");
                            // $(".ins_lname").val("");
                            alert("CRN "+crn+"  doesnt exist");
                            var selected_crns = $(".selectcrn").select2('val');
                            var removed = selected_crns.pop();
                            
                            $(".selectcrn").val(selected_crns).trigger('change');


                            var classname = prompt("Please enter Class Name for CRN: "+crn, "");
                            if (classname != null) {
                           
                                //create new course selection  
                                var value = removed+","+classname;  //for value of new selected course
                                var new_course = classname+" ("+ crn +")";
                                
                                var new_crn = '<option selected="selected" value="'+ value +'">'+new_course+'</option>';
                                $('.selectcrn').append(new_crn);
                            }
         
                        }else{ //autofill instructor fname and lname if anumber exist
                            // $(".ins_fname").val(data[0].firstname);
                            // $(".ins_lname").val(data[0].lastname);
                            //alert("CRN "+data[0].id+" exists in db as: "+data[0].id);
                        }
                        
                });
    });
    
    var old_anum  = "";
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
                            $("#minititle").html("UPDATE INSTRUCTOR");
                            $("#subtitle").html("Please fill form to edit instructor");
                            $(".reset").val("Cancel");

                            //prefill form with available info
                            $.post("validate.php", {
                                function: "get_instructor_record",
                                inst_anumber : anumber
                
                                },function(data, status){
                                        //$(".form-message").html(data);
                                        var data = JSON.parse(data);
                                        console.log(data);

                                        if(data == ''){
                                            // $(".firstname").val("");
                                            // $(".lastname").val("");
                                        }else{ //autofill instructor fname and lname if anumber exist
                                             old_anum  = data[0].anumber;
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

            



            //$(this).css("border", " 3px solid purple");
        });




        //when form is being submitted
        $("#submitbtn").on('click', function(event){
            //  event.preventDefault();
            var inst_id = $(".inst_id").val();
            var anumber = $(".anumber").val();
            var firstname = $(".firstname").val();
            var lastname = $(".lastname").val();
            var email = $(".email").val();
            var crn = $(".selectcrn").select2('val'); //array of selected crn(s)
            var password = $(".password").val();
            var confirm_password = $(".confirm_password").val();
            //alert(old_anum);
            //determine whether to update or insert a new record
            if(editrecord){

                //alert("update old");
                //Submit form to "update" record
                $.post("validate.php", {
                        function: "validate_complete_instructor_reg",
                        id : inst_id, //remember the id we saved earlier?
                        old_anum : old_anum,
                        anumber: anumber,
                        firstname: firstname,
                        lastname: lastname,
                        email: email,
                        crn : crn,
                        password : password,
                        confirm_password : confirm_password
                        // submit : submit

                },function(data, status){
                        $(".form-message").html(data);
                        
                        // if(data=="success"){ 
                            
                        //     alert(data);
                        //     location.reload();
                           
                        // }
                        if(success == "true"){
                            //alert(firstname+" "+lastname+ " Updated!!");
                        //window.location.replace("facepage.php");
                        //$( ".registerstudent" ).load( "facepage.php" );

                        //location.relod();
                        $("html").css({"background": "#fff", "transition": "background 0.2s linear", "color":"white !important"});

                        setTimeout(function(){
                            $("html").css({"background": "#f0f0f0", "transition": "background 0.2s linear"});
                        }, 500);
                        }
                        });

            }
            else{
                //alert("new");
               //Submit form to "insert" new record
                $.post("validate.php", {
                        function: "validate_reg_instructor",
                        anumber: anumber,
                        firstname: firstname,
                        lastname: lastname,
                        email: email,
                        crn : crn,
                        password : password,
                        confirm_password : confirm_password
                        // submit : submit

                },function(data, status){
                        $(".form-message").html(data);
        

                        if(success == "true"){
                            //alert(firstname+" "+lastname+ " Updated!!");
                        //window.location.replace("facepage.php");
                        //$( ".registerstudent" ).load( "facepage.php" );

                        //location.relod();
                        $("html").css({"background": "#fff", "transition": "background 0.2s linear", "color":"white !important"});

                        setTimeout(function(){
                            $("html").css({"background": "#f0f0f0", "transition": "background 0.2s linear"});
                        }, 500);
                        }
                });
            }
           


        });


        $('.reset').on('click',function(){
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


  //if you click on anything except the modal itself or the "open modal" link, close the modal
   
  
  

});
</script>

</body>

</html>