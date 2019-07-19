<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <!-- jQuery -->
<script src="jquery/jquery-3.4.1.min.js"> </script>

<!-- jQuery for DataTables 1.10.18-->
<script src="DataTables/jQuery-3.3.1/jquery-3.3.1.min.js"> </script>

<!-- DataTables Styling -->
<link rel="stylesheet" type="text/css" href="DataTables/datatables.min.css"/>
 
<!-- DataTables Script -->
<script type="text/javascript" src="DataTables/datatables.min.js"></script>

<!-- Jzip Script -->
<script type="text/javascript" src="DataTables/JSZip-2.5.0/jszip.min.js"></script>

<!-- PDFmake Script -->
<script src="DataTables/pdfmake-0.1.36/pdfmake.min.js"></script>
<script src='build/vfs_fonts.js'></script>

<!-- Main JavaScript -->
<script type="text/javascript" src="scripts.js"></script>

<link rel="stylesheet" href="styling.css">

<!-- Main CSS -->
<link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">

 

</head>
<body>
    
    
<!-- <a><a href="add_student.php">Add Student</a></p> -->
<p id="old"> <a href="index.php">Return to Dashboard</a></p>
<div class="wrapper">
        <h4>Import Records</h4>
</div>

<div id="mainform">
    <!-- <audio id="audio" src="http://www.soundjay.com/button/beep-07.wav" autoplay="false" ></audio> -->
    <!-- <a onclick="playSound();"> Play</a> -->

<div id="adminlist">
<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" enctype="multipart/form-data">
    <!-- Upload file :  -->
    <label for="">Upload file :</label>
    <input  id="adminbtn" type="file" name="uploadFile" value="" />
    <input id="adminbtn" type="submit" name="submit" value="Upload" />
</form>
<br><br>
<input  class="Search_All"  type="text" id=" line" placeholder="Search All" >

<!-- <label for="button"> Edit </label> -->
<!-- <input id="editable" type="button" > -->
<button class="editbtn" id="adminbtn" type="button"> Edit</button>
<button class="savebtn" id="adminbtn" type="button"> Save Changes</button>

</div>
</div>

<?php


// connect to the database
include('config.php');


echo '<div><br><br><br><br><br><br><br><br>';

//  *******************extra feature to find record****************************************

function findGroups($sheet)
 {
     $b = false;
     $row_num = 1;
     $rowIterator = $sheet->getRowIterator();
     foreach ($rowIterator as $row) {

        
         //поучаем итератор ячеек
         $cellIterator = $row->getCellIterator();
         //проходимся по всем ячейкам
         foreach ($cellIterator as $cell) {
             // mb_strtoupper(
             $cell_value =trim($cell->getFormattedValue());
             if ($b) {
                 echo $cell_value."...";
                 //echo $cell->getRow();
             }
             if ($cell_value == "Student ID") {
                 // echo $cell_value;
                 $b = true;
                 //получаем индекс строки ДЕНЬ
                 echo  $cell_value.'found at:'. $cell->getRow();
             }
         }
         //        echo $this->i++;
         if ($b) {
             return;
         }

         $row_num++;
     }

    
     // $filter=$this->createFilter();
 }


 if(isset($_POST['submit'])) {
    if(isset($_FILES['uploadFile']['name']) && $_FILES['uploadFile']['name'] != "") {



        $allowedExtensions = array("xls","xlsx");
        $ext = pathinfo($_FILES['uploadFile']['name'], PATHINFO_EXTENSION);
        if(in_array($ext, $allowedExtensions)) {
           $file_size = $_FILES['uploadFile']['size'] / 1024;
           if($file_size < 5000) {
               $file = "files/".$_FILES['uploadFile']['name'];
               $isUploaded = copy($_FILES['uploadFile']['tmp_name'], $file);

               if($isUploaded) {
                    
                    try {
                        
                        //include PhpSpreadsheet library
                    require 'phpSpreadsheet/vendor/autoload.php';
                        /**  Identify the type of $inputFileName  **/
                    $inputFileType = \PhpOffice\PhpSpreadsheet\IOFactory::identify($file);
                    /**  Create a new Reader of the type that has been identified  **/
                    $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
                    /**  Advise the Reader that we only want to load cell data  **/
                    $reader->setReadDataOnly(true);
                    /**  Load $inputFileName to a Spreadsheet Object  **/
                  
                   
                   



// **********************************
// $inputFileType = 'Xlsx';
// $inputFileName = 'files/jay2.xlsx';



//$worksheet = $spreadsheet->getActiveSheet();

 

 $spreadsheet = $reader->load($file);
 $row_num = 1;
  $rn = 0;
  $fld = 0;
   $sheet_num = 1;
//loop through each worksheet
foreach ($spreadsheet->getWorkSheetIterator() as $worksheet) {
   //findGroups($worksheet);
    $row_num = 1;
  
    //display sheet number and file name
    echo '<h2> File : '.$_FILES['uploadFile']['name']. '<br> Sheet : '.$sheet_num. '</h2>';

    echo '<table border="0" class="hover dtables"  id="read_excel_table'.$sheet_num.'" style="width:90%">' . PHP_EOL;
    
    foreach ($worksheet->getRowIterator() as $row) {
        $fld = 0;
        //Display table headers for first row
       if($row_num === 1){
            
       echo '<thead><tr>'. PHP_EOL;
        $cellIterator = $row->getCellIterator();
        $cellIterator->setIterateOnlyExistingCells(FALSE); 
        foreach ($cellIterator as $cell) {

            echo '<th>' .
                 $cell->getValue() .
                '</th>' . PHP_EOL;
        }
        echo '</tr></thead><tbody>';

       }
       else{
       
        echo '<tr>' . PHP_EOL;
        $cellIterator = $row->getCellIterator();
        $cellIterator->setIterateOnlyExistingCells(FALSE); 
        foreach ($cellIterator as $cell) {

            echo '<td><input class="inputtext" id="row'.$rn.'_fld'.$fld.'_in" value="' .
              $cell->getValue() .
                '" ><span id="row'.$rn.'_fld'.$fld.'_dt" class="displaytext">'.$cell->getValue().'</span> </td> ' . PHP_EOL;
                $fld++;
            }
        echo '</tr>' . PHP_EOL;
    }
        $row_num++;
        $rn++;
       
     }


 $sheet_num++;
echo '</tbody></table>' . PHP_EOL;

}
//here 
} catch (Exception $e) {
    die('Error loading file "' . pathinfo($file, PATHINFO_BASENAME). '": ' . $e->getMessage());
}

}
else {
    echo '<span class="msg">File not uploaded!</span>';
}
} else {
echo '<span class="msg">Maximum file size should not cross 5 MB on size!</span>';  
}
} else {
echo '<span class="msg">This type of file not allowed!</span>';
}
} else {
echo '<span class="msg">Select an excel file first!</span>';
}

    
}

echo '</div>';
?>


<script>

// var tables_num = <?php echo $sheet_num-1 ?>;
//     //dataTables formatting
//     console.log( "Sheet available: " + tables_num + " ");
// var table_name = ", #read_excel_table";
// var table_ids = "#read_excel_table1";

//  for(var i =2; i<= tables_num ; i++){
    
//     table_ids = table_ids + table_name + i +  ' ';
//     console.log(table_ids);
//  }

$.fn.dataTableExt.oApi.fnFilterAll = function(oSettings, sInput, iColumn, bRegex, bSmart) {
                var settings = $.fn.dataTableSettings;

                for (var i = 0; i < settings.length; i++) {
                    settings[i].oInstance.fnFilter(sInput, iColumn, bRegex, bSmart);
                }
            };

 
     
     $(document).ready(function() {
       
  $allTables =  $(".dtables").dataTable({
                    "bPaginate": false, 
                    dom: 'Bfrtip',
        stateSave: true,
        select: true,
        buttons: [
            {
               
                text: 'JSON',
                className: 'datatablebtn',
                action: function ( e, dt, button, config ) {
                    var data = dt.buttons.exportData();
 
                    $.fn.dataTable.fileSave(
                        new Blob( [ JSON.stringify( data ) ] ),
                        'Export.json'
                    );
                }
            }
        ],
      });
               
 
  
   $(".Search_All").keyup(function () {
     $allTables.fnFilterAll(this.value);              
    
  });



$("tr .inputtext").css('display','none');
	$('.editbtn').on("click",function(){
        $("tr .inputtext").toggle();
        $("tr .displaytext").toggle();
    });
    
	$('.inputtext').on("keyup",function(){
       
        var input_id = $(this).attr("id");
        var input_val = $(this).val();
        var inputnm_ar = input_id.split("_");
        var span_nm = inputnm_ar[0] + "_"+inputnm_ar[1] + "_dt";
      //alert(input_val);
        $("#"+span_nm).html(input_val);



        
        $('.dtables').each(function() {
        $(this).dataTable().fnDestroy();
        })

//     $allTables.fnClearTable();
// $allTables.fnDraw();

       // $allTables.fnDestroy();


        // $(".dtables").addClass('dd');
        // $(".dtables").dataTable();
        $(".dtables").dataTable({
                    "bPaginate": false, 
                    dom: 'Bfrtip',
        stateSave: true,
        select: true,
        buttons: [
            {
               
                text: 'JSON',
                className: 'datatablebtn',
                action: function ( e, dt, button, config ) {
                    var data = dt.buttons.exportData();
 
                    $.fn.dataTable.fileSave(
                        new Blob( [ JSON.stringify( data ) ] ),
                        'Export.json'
                    );
                }
            }
        ],
      });
            
        alert("Changes Saved!!!");
            
    });


    $('.savebtn').on("click",function(){
      
        $('.dtables').each(function() {
        $(this).dataTable().fnDestroy();
        })

//     $allTables.fnClearTable();
// $allTables.fnDraw();

       // $allTables.fnDestroy();


        // $(".dtables").addClass('dd');
        // $(".dtables").dataTable();
        $(".dtables").dataTable({
                    "bPaginate": false, 
                    dom: 'Bfrtip',
        stateSave: true,
        select: true,
        buttons: [
            {
               
                text: 'JSON',
                className: 'datatablebtn',
                action: function ( e, dt, button, config ) {
                    var data = dt.buttons.exportData();
 
                    $.fn.dataTable.fileSave(
                        new Blob( [ JSON.stringify( data ) ] ),
                        'Export.json'
                    );
                }
            }
        ],
      });
            
        alert("Changes Saved!!!");
       
    });
});
 


</script>


<!-- 
<script>
var tables_num = <?php echo $sheet_num-1 ?>;
    //dataTables formatting
    console.log( "Sheet available: " + tables_num + " ");
var table_name = ", #read_excel_table";
var table_ids = "#read_excel_table1";

 for(var i =2; i<= tables_num ; i++){
    
    table_ids = table_ids + table_name + i +  ' ';
    console.log(table_ids);
 }
//"'"+ table_ids +"'"


$(document).ready(function () {
  
  var oTable0 = $("#read_excel_table1").dataTable();
  var oTable1 = $("#read_excel_table2").dataTable();
  
   $("#Search_All").keyup(function () {
     oTable0.fnFilterAll(this.value);              
     oTable1.fnFilterAll(this.value);
  });
 })





$(document).ready(function() {
    $( table_ids ).DataTable( {
        dom: 'Bfrtip',
        select: true,
        buttons: [
            {
               
                text: 'JSON',
                className: 'datatablebtn',
                action: function ( e, dt, button, config ) {
                    var data = dt.buttons.exportData();
 
                    $.fn.dataTable.fileSave(
                        new Blob( [ JSON.stringify( data ) ] ),
                        'Export.json'
                    );
                }
            }
        ],
        // stateSave: true,
         responsive: true,
         scrollY:        '60vh',
		scrollCollapse: true,
		paging:         false
        // columnDefs: [
		// 	{ "width": "10%", "targets": [0,1,2,3,4] },
		// 	{
		// 		targets: [ 0 ],
		// 		orderData: [ 0, 1 ]
		// 	},
		// 	{
		// 		targets: [ 1 ],
		// 		orderData: [ 1, 0 ]
		// 	},
		// 	{
		// 		targets: [ 4 ],
		// 		orderData: [ 4, 0 ]
		// 	}
		// ]
    } );
} );

  //  
</script> -->


</body>
</html>