<?php


// // Initialize the session
// session_start();
    // Include config file
require_once "config.php";



//function for clocking in
function clock_in( $type, $anumber, $firstname, $lastname, $link){
    // Prepare an insert statement
           $sql = "INSERT INTO attendance (type, anumber, firstname, lastname, time_in, time_out, memo) VALUES (?,?,?,?,NOW(), NOW(),?)";
   
            
           if($stmt = mysqli_prepare($link, $sql)){
               // Bind variables to the prepared statement as parameters
               mysqli_stmt_bind_param($stmt, "sssss", $param_type, $param_anumber, $param_firstname, $param_lastname,  $param_memo);
               
               // Set parameters
               $param_type = $type;
               $param_anumber = $anumber;
               $param_firstname = $firstname;
               $param_lastname  = $lastname;
               //$param_in =  NOW(); 
   
               //later, maybe memo would only be entered on clock out
               $param_memo = "signed in  ";
               
               
               // Attempt to execute the prepared statement
               if(mysqli_stmt_execute($stmt)){
                   // Redirect to login page
                   // header("location: login.php");
   
                   //Display Success in pop-up
                   echo "<script>alert('".$firstname."".$lastname." CLOCKED IN!!!');</script>";
                   // header("location: student_login.php");
                  
   
               } else{
                   echo "Something went wrong. Please try again later.";
               }  
   
               // Close statement
                mysqli_stmt_close($stmt);
   
               //  echo "<script>alert('SUCCESS!!');</script>";
              
         }         
            
       //   echo "<script>alert('SUCCESS!!');</script>";
   }
   




  //function for clocking out
  function clock_out($id, $firstname, $lastname, $memo, $link){

    
        $sql = "UPDATE attendance SET time_out = NOW(), memo = ? WHERE id = ?";

        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ss", $param_memo, $param_id);
            
            // Set parameters
            $param_memo = $memo . "Signed out";
            $param_id = $id;
            
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
               
                //Display Success in pop-up
                echo "<script>alert('".$firstname."".$lastname." CLOCKED OUT!!!');</script>";
                // header("location: student_login.php");
               

            } else{
                echo "Something went wrong. Please try again later.";
            }  

            // Close statement
             mysqli_stmt_close($stmt);

            //  echo "<script>alert('SUCCESS!!');</script>";
           
      }    


  } 




   // extract  user records for attendance entry
if(isset($_GET['username'])){
        
         $username = $_GET["username"];
         //query user info for clockin
         $result = mysqli_query($link, "SELECT type, firstname, lastname, anumber FROM students WHERE username = '$username' or anumber = '$username'");

        if($row = mysqli_fetch_assoc($result)){
            
             $type = $row['type'];
             $firstname = $row['firstname'];
             $lastname = $row['lastname'];
             $anumber = $row['anumber'];

        }
 

        $sql = "SELECT  id, memo  FROM attendance  WHERE anumber = ? AND date = CURDATE()  AND time_in = time_out order by id desc LIMIT 1 ";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_anumber);
            
            // Set parameters
            $param_anumber = $anumber;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                   echo "Found entry:  ".mysqli_stmt_num_rows($stmt);
                   mysqli_stmt_bind_result($stmt, $res_id, $res_memo);


                   while(mysqli_stmt_fetch($stmt)){
                       $id = $res_id;
                       $memo = $res_memo;

                   }

                   //check if an instructor
                   //if instructor, redirect him to dashboard where he can manually clock out
                    if($type == "instructor"){
                        header("location: instructor_dashboard.php?anumber=$anumber&id=$id"); //sends id via GET for manual clock-out
                    }else{
                        //call clock out function if not instructor
                    clock_out($id, $firstname, $lastname, $memo, $link);
                    }

                } else{
                   echo "None found: ".mysqli_stmt_num_rows($stmt);

                   //call clock in function
                   clock_in( $type, $anumber, $firstname, $lastname, $link);

                   //open Instructor dashboard if an instructor clocks in  (will personalize it soon)
                   if($type == "instructor"){
                     header("location: instructor_dashboard.php?anumber=$anumber&id=$id"); //sends id via GET for manual clock-out
                   }


                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
         
        // // Close statement
        // mysqli_stmt_close($stmt);    
            
         
 }      
 
 // Redirect to login page
               // header("location: student_login.php");


?>    