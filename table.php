<?php

//include_once 'connect.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="table.css">
    <title>Document</title>
</head>
<body>
    <h2>Data</h2>
    <table class="table">
        <tr class="line" >
            <th>A Number</th>
            <th>First name</th>
            <th>Last name</th>
            <th>Major</th>
            <th>Course</th>
        </tr>
    <?php
    include_once 'connect.php';
      $query = "SELECT * FROM studentdata_temp ORDER BY FName ASC";
      $result = mysqli_query($conn, $query);
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

    <form action="excel.php" method= "POST">
        <div class="btn" >
            <button class="button" name="export"> <span>Download</span></button>
        </div>
    </form>
    
</body>
</html>