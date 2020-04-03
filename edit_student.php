
<?php 

if(isset($_POST['anumber'])){
        
    $old_anumber = $_POST["anumber"];

} 
?>

<!DOCTYPE html>

<html>

<head>

<title>EDIT STUDENT</title>

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
<a id="backbtn" href="registry.php" class="left" ></a><br><br>

    <h2 id="minititle">EDIT STUDENT</h2>
    <p>Please fill this form to edit Record</p>
</div>
<div  id="form1" class="form">
<div></div>
    <div>
        <form autocomplete="off" action="validate.php" method="POST">
             <!-- hidden input to store id  -->
             <input type="hidden" name="id" class="id" >
           
             <input type="hidden" name="type" class="type" >
             
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
                <label id="editlabtss">Classification</label>
                <span class="class_err"></span>
            </div>    
              
            <div class="form-group">
                <select name="crn" id="line" class="selectcrn" multiple="multiple" required>
                </select>
                <label id="editlabtss">CRN(s)</label>
                <label id="editlabts">CRN(s)</label>
                <span class="crn_err"></span>
            </div> 

            <!-- <div class="form-group pw_div">
                <label id="editlabt">Password</label>
                <input id="line" type="password" name="password" class="password" autocomplete="new-password">
                <span class="password_err"></span>
            </div> 
            <div class="form-group pw_div">
                <label id="editlabt">Confirm Password</label>
                <input id="line" type="password" name="confirm_password" class="confirm_password">
                <span class="confirm_password_err"></span>
            </div>  -->
            <br> <p id="reset1"><input type="reset" class="btn btn-default"></p>
            <p id="reset1"><input type="button" class="changepw" value="Change Password"></p><p id="reset"><a href="index.php">Return to Dashboard</a></p>
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
    
    // $(".changepw").on("click", function(){
    //     $(".pw_div").toggle(); 
    // });
        
    //prefill form with available info
    $.post("validate.php", {
        function: "get_anumber_record",
        inst_anumber : '<?php echo $old_anumber ?>'

        },function(data, status){
                //$(".form-message").html(data);
                var data = JSON.parse(data);
                console.log(data);

                if(data == ''){
                    alert("Record unavailable for selected user")
                    window.location.replace("view_registry.php?type=students");
                }else{ 
                    
                    $(".id").val(data[0].id);//keep id in hidden input for update purposes
                    $(".type").val(data[0].type);//keep type in hidden input for update purposes
                    $(".anumber").val(data[0].anumber);
                    $(".firstname").val(data[0].firstname);
                    $(".lastname").val(data[0].lastname);
                    $(".email").val(data[0].email);
                    $(".classification").val(data[0].classification);
                    $(".major").val(data[0].major);
                   // $(".password , .confirm_password").val(data[0].password);
                
                    
                    //case of CRN section with select2
                    $('.selectcrn').append(data[0].crn);
                    
                }
                
        });

    // $(".reset").on('click', function(event){
    //     location.reload();
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
        }
    
    }).on("select2:select", function (e) {
        
        //clear error codes if any
        if($(".selectcrn").select2('val')){
                $(".crn_err").html("");
                }

    });
    
            

        $(".next").on('click', function(event){
            // event.preventDefault();
            var id = $(".id").val();
            var anumber = $(".anumber").val();
            var firstname = $(".firstname").val();
            var lastname = $(".lastname").val();
            var email = $(".email").val();
            var classification = $(".classification").val();
            var major = $(".major").val();
            var crn = $(".crn").val();
            // var password = $(".password").val();
            // var confirm_password = $(".confirm_password").val();
            
             var crn = $(".selectcrn").select2('val');
            
            // alert(crn);

           $.post("validate.php", {
                function: "validate_edit_student",
                action : "edit",
                id : id,
                anumber: anumber,
                firstname: firstname,
                lastname: lastname,
                email: email,
                classification: classification,
                major: major,
                crn : crn,
                old_anumber : '<?php echo $old_anumber; ?>'
                // password : password,
                // confirm_password : confirm_password,
               

           },function(data, status){
                $(".form-message").html(data);
                // alert(data);
                
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
           
        });


        // $('.reset').on('click',function(){
        //    location.reload();
        // });


        $('#reset1').on('click',function(){
            event.preventDefault();
            location.reload();
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

        //dynamic back button to student page if anumber is updated
        $("#backbtn").on('click', function(event){
             event.preventDefault();
             window.location.href = "edit_registry.php?anumber="+$(".anumber").val();
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