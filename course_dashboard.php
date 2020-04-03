<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">

<html>

<head>

<title>Courses</title>
<!-- jQuery for DataTables -->
<script src="DataTables/jQuery-3.3.1/jquery-3.3.1.min.js"> </script>

<!-- jQuery -->
<script src="jquery /jquery-3.4.1.min.js"> </script>



<!-- DataTables Styling -->
<link rel="stylesheet" type="text/css" href="DataTables/datatables.min.css"/>
 
<!-- DataTables Script -->
<script type="text/javascript" src="DataTables/datatables.min.js"></script>

<!-- DatePicker moment.js -->
<script src="datepicker/moment.min.js"> </script>

<!-- Datepicker JS -->
<script type="text/javascript" src="datepicker/daterangepicker.min.js"></script>

<!-- DatePicker CSS -->
<link rel="stylesheet" type="text/css" href="datepicker/daterangepicker.css"/>
 
<!-- BootStrap Datepicker JS -->
<!-- <script type="text/javascript" src="datepicker/bootstrap-datepicker.min.js"></!--> 

<!-- BootStrap DatePicker CSS -->
<!-- <link rel="stylesheet" type="text/css" href="datepicker/bootstrap-datepicker.min.css"/> -->
 

<!-- Jzip Script -->
<script type="text/javascript" src="DataTables/JSZip-2.5.0/jszip.min.js"></script>

<!-- PDFmake Script -->
<script src="DataTables/pdfmake-0.1.36/pdfmake.min.js"></script>
<script src='build/vfs_fonts.js'></script>

<!-- Main JavaScript -->
<script type="text/javascript" src="scripts.js"></script>

<!-- Main CSS -->
<link rel="stylesheet" href="styling.css">

<!-- select2 CSS -->
<link href="Select2/select2.min.css" rel="stylesheet" />
    
<!-- Select2 script -->
<script src="Select2/select2.min.js"></script>

<link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">

 

</head>

<body>

<div id="allstudentspage">
<div class="wrapper2">
<a id="backbtn" href="admin.php" class="left"></a><br>



    <h2 id="minititle2">ATTENDANCE</h2>
  
</div>

<div id="mainform2">

        <!-- hidden inputs to store dates -->
        <input type="hidden" class="from">
        <input type="hidden"  class="to">

            <div class="form-group ">
                <select id="line" type="text" name="type" class="type" >
                    <!-- <option value=""></option> -->
                    <option value="student">Students</option>
                    <option value="instructor">Instructors</option>
                    
                </select>
                
                <label id="editlabt">Type</label>
                <span class="class_err"></span>
            </div>  
            <!-- <div class="form-group ">
                <select id="line" type="text" name="classification" class="classification" required>
                    <option value=""></option>
                    <option value="freshman">freshman</option>
                    <option value="sophomore">sophomore</option>
                    <option value="junior">junior</option>
                    <option value="senior">senior</option>
                </select>
                <label id="editlabt">Classification</label>
                <span class="class_err"></span>
            </div>   -->

            <div class="form-group">
                <select name="crn" id="line" class="selectcrn" required>
                <option value=""></option>
                </select>
                <label id="editlabtss">CRN(s)</label>
                <label id="editlabts">CRN(s)</label>
                <span class="crn_err"></span>
            </div> 

            <div id="line" class="reportrange" >
                 <i class="fa fa-calendar"></i>&nbsp;
                <span id="" ></span> <i class="fa fa-caret-down"></i>
            </div>

<!-- loads table -->
<div class="load_table">

</div>


<p id="reset"> <a href="index.php">Return to Dashboard</a></p>
</div>

</div>

<script>
// $('.date').daterangepicker({
//     autoApply : true,
//     // autoUpdateInput: false,
//     // locale: {
//     //       cancelLabel: 'Clear'
//     // }
// });


$(function get_att() {

    $('.selectcrn').select2();
    var start = moment().subtract(29, 'days');
    var end = moment();

function cb(start, end) {
    $('.reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));

    // sets value of hidden inputs
    $('.from').val(start.format('YYYY/MM/DD'));
    $('.to').val(end.format('YYYY/MM/DD'));

  
    $.post("validate.php", {
        
                function: "validate_get_attendance_test",
                type : $(".type").val(),
                from : start.format('YYYY/MM/DD'),
                to : end.format('YYYY/MM/DD'),
                crn : $(".selectcrn").select2('val')
               

           },function(data, status){
                $(".load_table").html(data);
             
           });
}

$('.reportrange').daterangepicker({
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



$(document).ready(function(){

$('.selectcrn').select2({
        allowClear: true,
        placeholder :'', 
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
    

            var from1 = $('.from').val();
            var to1 = $('.to').val();
  

            $.post("validate.php", {
                
                        function: "validate_get_attendance_test",
                        type : $(".type").val(),
                        from : from1,
                        to : to1,
                        crn : $(".selectcrn").select2('val')
                    

                },function(data, status){
                        $(".load_table").html(" ");
                        $(".load_table").html(data);
                    
                });
        
           
}).on("select2:clear", function (e) {

    var from1 = $('.from').val();
    var to1 = $('.to').val();
    $.post("validate.php", {
                
                function: "validate_get_attendance_test",
                type : $(".type").val(),
                from : from1,
                to : to1,
                crn : $(".selectcrn").select2('val')
            

        },function(data, status){
                $(".load_table").html(" ");
                $(".load_table").html(data);
            
        });
    // alert();
 });


    $('.type').change(function() {
       
        var from1 = $('.from').val();
            var to1 = $('.to').val();
  

            $.post("validate.php", {
                
                        function: "validate_get_attendance_test",
                        type : $(".type").val(),
                        from : from1,
                        to : to1,
                        crn : $(".selectcrn").select2('val')
                    

                },function(data, status){
                        $(".load_table").html(" ");
                        $(".load_table").html(data);
                        // alert(data);
                        
                        // if(success == "true"){
                        // //    alert(data);
                        // //    window.location.replace("facepage.php");
                        // //    $( ".registerstudent" ).load( "facepage.php" );
                        // }
                });

                //alert(from1);
        
    });

});
</script>

</body>

</html>



