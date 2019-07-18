<?php
   include_once 'connect.php';
   $query = "SELECT * FROM studentdata_temp ORDER BY FName ASC";
   $result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
      <title>Document</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="http://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
    <!-- <link rel="stylesheet" href="table.css"> -->
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    
</head>
<body>
   <div class="container">
      <div class="table-responsive">
         <table id="myTable" class="table table-striped table-bodered" cellspacing="0" width="100%">
            <thead class="line" >
                  <th>A Number</th>
                  <th>First name</th>
                  <th>Last name</th>
                  <th>Major</th>
                  <th>Course</th>
            </thead>
            <?php
            while($row = mysqli_fetch_array($result))  
            {  
                  echo '  
            <tr>  
                  <td>'.$row["number"].'</td>  
                  <td>'.$row["FName"].'</td>  
                  <td>'.$row["LName"].'</td>  
                  <td>'.$row["major"].'</td>  
                  <td>'.$row["course"].'</td>
            </tr>  
                  ';  
            }
            ?>
            
         </table>
      </div>
   </div>

    <form action="excel.php" method= "POST">
        <div class="btn" >
            <button class="button" name="export"> <span>Download</span></button>
        </div>
    </form>
    <form method= "POST" id="export_excel">
            <label for="">Select file</label>
            <input type="file" name="excel_file" id="excel_file">
        </form>
        <div id="result">

        </div>
    
</body>
</html>
<script>
      $(document).ready(function() {
         $('#myTable').DataTable();
      });
   </script>
<script>
   $(document).ready(function(){  
   $('#excel_file').change(function(){  
         $('#export_excel').submit();  
   });  
   $('#export_excel').on('submit', function(event){  
         event.preventDefault();  
         $.ajax({  
               url:"upload.php",  
               method:"POST",  
               data:new FormData(this),  
               contentType:false,  
               processData:false,  
               success:function(data){  
                  $('#result').html(data);  
                  $('#excel_file').val('');  
                  }  
            });  
         });  
   });
</script>