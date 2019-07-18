<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    
</head>
<body>
<?php
    
    if(!empty($_FILES["excel_file"])){
        $conn = mysqli_connect("localhost","root","","students");
        $file_array = explode(".",$_FILES["excel_file"]["name"]);
        if($file_array[1]=="xls"){ 
            include("PHPExcel/IOFactory.php");
            $output = ''; 
            $output .= "
            <label class='text-success'> Data Inserted</label>
                <table class='table table-bodered'>
                    <tr>
                        <th>A Number</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Major</th>
                        <th>course</th>
                    </tr>
            ";
            $object=PHPExcel_IOFactory::load($_FILES["excel-file"]["tmp_name"]);
            foreach($object->getWorkSheetIterator() as $worksheet){
                $highestRow=$worksheet->getHighestRow();
                for($row=2;$row<=$highestRow;$row++){
                    $a_number = mysqli_real_escape_string($conn, $worksheet->getCellByColumnAndRow(1,$row)->getValue());
                    $Fname = mysqli_real_escape_string($conn, $worksheet->getCellByColumnAndRow(2,$row)->getValue());
                    $Lname = mysqli_real_escape_string($conn, $worksheet->getCellByColumnAndRow(3,$row)->getValue());
                    $major = mysqli_real_escape_string($conn, $worksheet->getCellByColumnAndRow(4,$row)->getValue());
                    $course = mysqli_real_escape_string($conn, $worksheet->getCellByColumnAndRow(5,$row)->getValue());
                    $query="
                    INSERT INTO studentdata_temp (number, FName, LName, major, course) 
                    VALUES('".$a_number."','".$Fname."','".$Lname."','".$major."', '".$course."')    
                    ";
                    mysqli_query($conn,$query);
                    $output .='
                    <tr>  
                        <td>'.$a_number.'</td>  
                        <td>'.$Fname.'</td>  
                        <td>'.$Lname.'</td>  
                        <td>'.$major.'</td>  
                        <td>'.$course.'</td>
                    </tr>  
                    ';
                    
                }
            }
            $output .='</table>';
            echo $output;
        }
        else{
            echo '<label class="text-danger">Invalid file</label>';
        }
    }

?>
</body>
</html>

