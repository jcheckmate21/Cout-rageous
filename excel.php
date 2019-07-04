<?php
include_once 'connect.php';

$output = '';
if(isset($_POST["export"]))
{
 $query = "SELECT * FROM studentdata_temp ORDER BY FName ASC";
 $result = mysqli_query($conn, $query);
 if(mysqli_num_rows($result) > 0)
 {
  $output .= 'A NUMBER,FIRST NAME,LAST NAME, MAJOR, COURSE,';
  while($row = mysqli_fetch_array($result))
  {
   $output .= '
   '.$row["number"].','.$row["FName"].','.$row["LName"].','.$row["major"].','.$row["course"].'   ';
  }
  //$output .= '</table>';
  header('Content-Type: application/xls');
  header('Content-Disposition: attachment; filename=studentdata.csv');
  echo $output;
 }
}
?>
