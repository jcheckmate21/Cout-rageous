<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">

<html>

<head>

<title>Courses</title>

<!-- jQuery -->
<script src="jquery /jquery-3.4.1.min.js"> </script>

<!-- jQuery for DataTables -->
<script src="DataTables/jQuery-3.3.1/jquery-3.3.1.min.js"> </script>

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
<!-- <input type="text" name="date" class="date"> -->

<div id="reportrange" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 50%">
    <i class="fa fa-calendar"></i>&nbsp;
    <span></span> <i class="fa fa-caret-down"></i>
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


$(function() {

var start = moment().subtract(29, 'days');
var end = moment();

function cb(start, end) {
    $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
    $('.date').val(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
    //alert('New date range selected: ' + start.format('YYYY/MM/DD') + ' to ' + end.format('YYYY/MM/DD') );

    $.post("validate.php", {
        
                function: "validate_get_attendance",
                type : "student",
                from : start.format('YYYY/MM/DD'),
                to : end.format('YYYY/MM/DD')
               

           },function(data, status){
                $(".load_table").html(data);
                // alert(data);
                
                // if(success == "true"){
                // //    alert(data);
                // //    window.location.replace("facepage.php");
                // //    $( ".registerstudent" ).load( "facepage.php" );
                // }
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



