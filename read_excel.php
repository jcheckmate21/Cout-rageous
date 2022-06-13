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

<!-- DataTables buttons extension -->
<script type="text/javascript" src="DataTables/dataTables.buttons.min.js"></script>


<!-- Jzip Script -->
<script type="text/javascript" src="DataTables/JSZip-2.5.0/jszip.min.js"></script>

<!-- PDFmake Script -->
<script src="DataTables/pdfmake-0.1.36/pdfmake.min.js"></script>
<script src='build/vfs_fonts.js'></script>

<!-- Main JavaScript -->
<!-- <script type="text/javascript" src="scripts.js"></script> -->

<link rel="stylesheet" href="styling.css">

<!-- Main CSS -->
<link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">

 

</head>
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script> -->

<body>
    
    
<div id="allstudentspage">
<div class="wrapper2">
<!-- <a id="backbtn" href="view_all_students.php?sort=all" class="left" ></a> -->

    <h2 id="minititle2">IMPORT RECORDS</h2>
    <!-- <p>| Please fill this form to create an account yes |</p> -->
</div>

<div id="mainform2">
    <!-- <audio id="audio" src="http://www.soundjay.com/button/beep-07.wav" autoplay="false" ></audio> -->
    <!-- <a onclick="playSound();"> Play</a> -->

<div id="import">
<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" enctype="multipart/form-data">
    <!-- Upload file :  -->
    <input  id="choose" type="file" name="uploadFile" value="" />
    <!-- upload_button -->
    <input id="uploadbtn" type="submit" name="submit" value="Upload" />
</form>
<!-- <input  class="Search_All"  type="text" id=" line" placeholder="Search All" > -->





</div>
<!-- <label for="button"> Edit </label> -->
<!-- <input id="editable" type="button" > -->
<button class="savebtn" id="saveebtn" type="button"> Save</button>
<button class="editbtn" id="edittbtn" type="button"> Edit</button>
<!-- <button class="exportAll" id="adminbtn">Export All</button> -->
<p id="import_reset"> <a href="index.php">Return to Dashboard</a></p>

</div>
</div>


<?php


// connect to the database
include('config.php');
$sheet_num = 1;

echo '<div><br><br><br><br><br><br><br><br>';



 if(isset($_POST['submit'])) {
    if(isset($_FILES['uploadFile']['name']) && $_FILES['uploadFile']['name'] != "") {



        $allowedExtensions = array("xls","xlsx");
        $ext = pathinfo($_FILES['uploadFile']['name'], PATHINFO_EXTENSION);
        if(in_array($ext, $allowedExtensions)) {
           $file_size = $_FILES['uploadFile']['size'] / 1024;
           if($file_size < 5000) {
               $file = "files/".$_FILES['uploadFile']['name'];
               $isUploaded = copy($_FILES['uploadFile']['tmp_name'], $file);
               $sheet_num = 1;

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
   

//$worksheet = $spreadsheet->getActiveSheet();

 

 $spreadsheet = $reader->load($file);
 $row_num = 1;
  $rn = 0;
  $fld = 0;
    // $sheet_num = 1;
//loop through each worksheet
foreach ($spreadsheet->getWorkSheetIterator() as $worksheet) {
   //findGroups($worksheet);
    $row_num = 1;
  
    //display sheet number and file name
    echo '<h2> File : '.$_FILES['uploadFile']['name']. '<br> Sheet : '.$sheet_num. '</h2>';

    echo '<table class="dataTables_scroll" id="read_excel_table" '.$sheet_num.'">' . PHP_EOL;
    
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

            echo '<td ><input class="inputtext" id="row'.$rn.'_fld'.$fld.'_in" value="' .
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
    echo '<span class="error_msg">File not uploaded!</span>';
}
} else {
echo '<span class="error_msg">Maximum file size should not cross 5 MB on size!</span>';  
}
} else {
echo '<span class="error_msg">This type of file not allowed!</span>';
}
} else {
?>
<script>
    $(document).ready(function(){
  $(".modal").hide();   
    });
</script>

<?php
echo '<span class="error_msg">Select an excel file first!</span>';
}

    
}

echo '</div>';
?>

<!-- <div id="myModal" class="modal">

  <div class="modal-content">
    
    <div id="bigpopup">
        
  



heyyyy





    

    </div>

     <span class="close">cancel</span>
  </div>

</div> -->


<script>

// $(document).ready(function(){
//   $(".modal").hide();   

// $("#uploadbtn").click(function(){
//   $(".modal").show();
// });
// $("#close").click(function(){
//   $(".modal").hide();
// });

// $(document).click(function(event) {
//   //if you click on anything except the modal itself or the "open modal" link, close the modal
//   if (!$(event.target).closest("#bigpopup,#uploadbtn").length) {
//     $("body").find(".modal").hide();
//   }
// });
// });




 

// $(document).ready(function(){
//     $('#saveebtn').hide();
//     $("tr .inputtext").hide();

//     $("#edittbtn").on('click', function(){
//     $('#edittbtn').hide();
//     $('#saveebtn').show();
//     $("tr .inputtext").show();
//     $("tr .displaytext").hide();
//     });

//     $("#saveebtn").on('click', function(){
//     $('#saveebtn').hide();
//     $('#edittbtn').show();
//     $("tr .displaytext").show();
//     $("tr .inputtext").hide();
//     });
            
// });






$(document).ready(function() {
    //    Settings for datatable
        var settings = {
                        // "ordering": false,
                        "order": [],
                        "aaSorting": [],
                            "bPaginate": false, 
                            dom: 'Bfrtip',
                stateSave: true,
                select: true,
                buttons: [
                    {
                    
                        text: 'Import',
                        className: 'datatablebtn',
                        action: function ( e, dt, button, config ) {
                            var data = dt.buttons.exportData();
                            //var a = JSON.stringify( data );
                            console.log(data);
                            

                            /*
                    submit JSON as 'post' to a new page
                    Parameters:
                    path        (URL)   path to the new page
                    data        (obj)   object to be converted to JSON and passed
                    postName    (str)   name of the POST parameter to send the JSON
                */
                
                submitJSON("import_to_database.php", data, "records");
                            
                        }
                    } 
                ],

            };  



  var allTables =  $("#read_excel_table").dataTable(settings);
  

//   $.fn.dataTableExt.oApi.fnFilterAll = function(oSettings, sInput, iColumn, bRegex, bSmart) {
//                     var settings = $.fn.dataTableSettings;

//                     for (var i = 0; i < settings.length; i++) {
//                         settings[i].oInstance.fnFilter(sInput, iColumn, bRegex, bSmart);
//                     }
//                 };
  
//    $(".Search_All").keyup(function () {
//      $allTables.fnFilterAll(this.value);              
    
//   });


    //toggle between edit and read-only features
    $("tr .inputtext").css('display','none');
        $('.editbtn').on("click",function(){
            $("tr .inputtext").toggle();
            $("tr .displaytext").toggle();
        });
        
    //update tatble content while editing    
    $('.inputtext').on("keyup",function(){
        
            var input_id = $(this).attr("id");
            var input_val = $(this).val();
            var inputnm_ar = input_id.split("_");
            var span_nm = inputnm_ar[0] + "_"+inputnm_ar[1] + "_dt";
        
            $("#"+span_nm).html(input_val);
    
    });


// function to send desired records to url as post for database update
function submitJSON( path, data, postName ) {
            // convert data to JSON
            var dataJSON = JSON.stringify(data);

            // create the form
            var form = document.createElement('form');
            form.setAttribute('method', 'post');
            form.setAttribute('action', path);

            // create hidden input containing JSON and add to form
            var hiddenField = document.createElement("input");
            hiddenField.setAttribute("type", "hidden");
            hiddenField.setAttribute("name", postName);
            hiddenField.setAttribute("value", dataJSON);
            form.appendChild(hiddenField);

            // add form to body and submit
            document.body.appendChild(form);
            form.submit();
        }




   





            $('.savebtn').on("click",function(){
            
                $('.dtables').each(function() {
                $(this).dataTable().fnDestroy();
                })

                $(".dtables").dataTable(settings);

            });


            $(document).on('click', '.exportAll', function() {

                
                var tables_num = <?php echo $sheet_num -1 ?>;
                    //dataTables formatting
                //for(var i =1; i<= tables_num ; i++){
                    
                    //var table_name = "#read_excel_table" + i;
                    //$(table_name).dataTable().fnDestroy();
                   //$(table_name).dataTable(settings).buttons('.datatablebtn').trigger();
                    
                  
                    
                    var heads = [];
                    $("thead").find("th").each(function () {
                    heads.push($(this).text().trim());
                    });


                    var rows = [];
                    $("tbody tr").each(function () {
                    cur = {};

                    $(this).find("td").each(function(i, v) {
                        cur[heads[i]] = $(this).text().trim();
                    });
                    rows.push(cur);
                    cur = {};
                    });


                   // console.log(heads);
                    console.log(rows);
                    submitJSON("import_to_database.php", rows, "records");


                   
                    
               // }

                        

                    });


    });
     


</script>




</body>
</html>