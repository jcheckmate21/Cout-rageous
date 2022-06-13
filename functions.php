

<?php
include_once "config.php";

    function validate_register (){
        // Processing form data when form is submitted
if(["REQUEST_METHOD"] == "POST"){
    //Automatically assign type as "student"
    $type = "student";
    
    // Validate anumber
    if(empty(trim($_POST["anumber"]))){
        $anumber_err = "Please enter an anumber.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM students WHERE anumber = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_anumber);
            
            // Set parameters
            $param_anumber = trim($_POST["anumber"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) >= 1){
                    $anumber_err = "This anumber is already registered.";
                } else{
                    $anumber = trim($_POST["anumber"]);
                    $anumber_ph = "";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }

    
     //validate First name
     if(empty(trim($_POST["firstname"]))){
        $firstname_err = "Please enter your First name.";     
    }
    else{
        $firstname = trim($_POST["firstname"]);
        $firstname_ph = "";
    }
    
    //validate last name
    if(empty(trim($_POST["lastname"]))){
        $lastname_err = "Please enter your last name.";     
    }
    else{
        $lastname = trim($_POST["lastname"]);
        $lastname_ph = "";
    }
    
    //validate email
    if(empty(trim($_POST["email"]))){
        $email_err = "Please enter your email.";     
    }
    else{
        $email = trim($_POST["email"]);
        $username = substr($email, 0, strpos($email, '@'));
        $email_ph = "";
    }
    
    //validate major
    if(empty(trim($_POST["major"]))){
        $major_err = "Please enter your major.";     
    } elseif(strlen(trim($_POST["major"])) < 2){
        $major_err = "Enter valid major";
    } else{
        $major = trim($_POST["major"]);
        $major_ph = "";
    }

    //validate classification
    if(empty(trim($_POST["classification"]))){
        $classification_err = "Please select your classification.";     
    } elseif(strlen(trim($_POST["classification"])) < 2){
        $classification_err = "Enter valid classification";
    } else{
        $classification = trim($_POST["classification"]);
        $classification_ph = "";
    }
    
     //validate CRN
     if(empty(trim($_POST["crn"]))){
        $crn_err = "Please select your CRN.";     
    }
    else{
        $crn = trim($_POST["crn"]);
        $crn_ph = "";
    }
    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["password"]);
        $password_ph = "";
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
    
    // Check input errors before inserting in database
    if(empty($anumber_err) && empty($major_err) && empty($firstname_err) &&empty($lastname_err)&& empty($email_err) && empty($password_err) && empty($confirm_password_err) && empty($classification_err) && empty($crn_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO students (type ,anumber, username, firstname, lastname, email, major, classification, crn, password) VALUES (?,?,?,?,?,?,?,?,?,?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssssssssss", $param_type, $param_anumber, $param_username, $param_firstname, $param_lastname, $param_email, $param_major, $param_classification, $param_crn, $param_password);
            
            // Set parameters
            $param_type = $type;
            $param_anumber = $anumber;
            $param_username = $username;
            $param_firstname = $firstname;
            $param_lastname  = $lastname;
            $param_email = $email;
            $param_major = $major;
            $param_classification = $classification;
            $param_crn = $crn;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                // header("location: login.php");

                //Display Success in pop-up
                echo "<script>alert('SUCCESS!!');</script>";
                return 1;
                

            } else{
                echo "Something went wrong. Please try again later.";
            }  

            // Close statement
             mysqli_stmt_close($stmt);

             echo "<script>alert('SUCCESS!!');</script>";
             header("location: facepage.php");
        }
       
    }
    
    // Close connection
    mysqli_close($link);

    //added this (test)
   // header("Location: view_all_students.php");
}



    }




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





// //function for clocking in
// function clock_in( $type, $anumber, $firstname, $lastname, $link){  
//         //determine with table to save to
//         if($type==="tutor" || $type === "admin"){
//             $table_name = "tutor_attendance";
//         }else
//             $table_name = "attendance";
//     // Prepare an insert statement

//            $sql = "INSERT INTO ". $table_name ." (type, anumber, firstname, lastname, time_in, time_out, memo) VALUES (?,?,?,?,NOW(), NOW(),?)";
   
            
//            if($stmt = mysqli_prepare($link, $sql)){
//                // Bind variables to the prepared statement as parameters
//                mysqli_stmt_bind_param($stmt, "sssss", $param_type, $param_anumber, $param_firstname, $param_lastname,  $param_memo);
               
//                // Set parameters
//                $param_type = $type;
//                $param_anumber = $anumber;
//                $param_firstname = $firstname;
//                $param_lastname  = $lastname;
//                //$param_in =  NOW(); 
   
//                //later, maybe memo would only be entered on clock out
//                $param_memo = "signed in  ";
               
               
//                // Attempt to execute the prepared statement
//                if(mysqli_stmt_execute($stmt)){
//                    // Redirect to login page
//                    // header("location: login.php");
   
//                    //Display Success in pop-up
//                    return  "".$firstname."&nbsp;".$lastname." CLOCKED IN!!!'";
//                    // header("location: student_login.php");
                  
   
//                } else{
//                 return "failed";
//                }  
   
//                // Close statement
//                 mysqli_stmt_close($stmt);
   
//                //  echo "<script>alert('SUCCESS!!');</script>";
              
//          }         
            
//        //   echo "<script>alert('SUCCESS!!');</script>";
//    }
   




// //function for clocking out
// function clock_out($type, $anumber, $link){

//          //determine with table to save to
//          if($type === "tutor" || $type === "admin"){
//             $table_name = "tutor_attendance";
//         }else
//             $table_name = "attendance";


//             $result = mysqli_query($link, "SELECT  id, memo, firstname, lastname, time_in  FROM $table_name  WHERE anumber = '$anumber' AND date = CURDATE()  AND time_in = time_out order by id desc LIMIT 1 ");

//             if($row = mysqli_fetch_assoc($result)){
            
//                 $id = $row['id'];
//                 $memo = $row['memo'];
//                 $firstname = $row['firstname'];
//                 $lastname = $row['lastname'];
//                 $time_in = $row['time_in'];


//                   $sql = "UPDATE $table_name SET time_out = NOW(), memo = ? WHERE id = ?";

//         if($stmt = mysqli_prepare($link, $sql)){
//             // Bind variables to the prepared statement as parameters
//             mysqli_stmt_bind_param($stmt, "ss", $param_memo, $param_id);
            
//             // Set parameters
//             $param_memo = $memo . "Signed out";
//             $param_id = $id;
            
            
//             // Attempt to execute the prepared statement
//             if(mysqli_stmt_execute($stmt)){
//               // $time_spent = now() - $time_in;
               
//                 $result = mysqli_query($link, " SELECT time_format(SUM(abs(timediff(time_out, time_in))),'%H:%i:%s') as time_spent FROM $table_name WHERE id = '$id' ");

//                 if($row = mysqli_fetch_assoc($result)){
                    
//                     $time_spent = $row['time_spent'];
                        

//                 }
                   
//                 $time_str = explode(":", $time_spent );

//                     //Display Success in pop-up
//                 return "".$firstname."&nbsp;".$lastname." CLOCKED OUT!!! <br> Time spent: ".$time_str[0]." hours, ".$time_str[1]." minutes ".$time_str[2]." seconds " ;
                   
     
//                 } else{
//                     return "failed";
//                 }  
     
     
                
               

//             } else{
//                 return "failed";
//             }  

//             // Close statement
//              mysqli_stmt_close($stmt);

//         }else echo "User not clocked in";
    
      
//             //  echo "<script>alert('SUCCESS!!');</script>";
           
//       }    







//query for graph
// function display_graph($link, $get_anumber, $type, $start, $end){
//     //determine with table to save to
//     if($type==="tutor" || $type === "admin"){
//         $table_name = "tutor_attendance";
//     }else
//         $table_name = "attendance";
  
//     $result2 = mysqli_query($link,"
//         SELECT date, SUM( time_out - time_in ) as total FROM ". $table_name ." WHERE TIMESTAMPDIFF(DAY,date,now()) < 30 
//         and anumber='$get_anumber'
//         group by date");

//         if(mysqli_num_rows($result2) > 0){
//         while($row = mysqli_fetch_assoc($result2)){

//             // get data from db
//             $date[] =$row['date'];
//             $total[] = round($row['total']/3600,2);

           
            
//         }
        
//         //display nothing on graph if no record is captured
//         // if (!empty($date) || !empty($total)){
          
//          $graph_result = []; 
//          array_push($graph_result,('"'. implode('","',$date).'"'));   
//          array_push($graph_result,(implode(",",$total))); 
//          $graph_msg = "";
//          return $graph_result;
//         }
//         else{
//             return ["",""];
//             $graph_msg = "No Attendence Record available ";
//         }
//     }


//query for graph
// function tutors_gen_graph($link, $start , $end){
//     $hours = []; 
//     $username = [];
//     $anum = [];
//     $date_range = " and (date between '".$start."' and '".$end."') ";

    
//     // Selecting Database From Server.
//         $query = mysqli_query($link,"select username,anumber from users where not position ='admin'", );

//         // SQL query to fetch data to display in menu.
//         while ($row  = mysqli_fetch_assoc($query)) {
            
//             //get list of tutors in array for general graph
//             array_push($username, $row['username']);
//             $anum = $row['anumber'];

//             $result2 = mysqli_query($link," 
//             SELECT sum(TIMESTAMP
//             DIFF(SECOND, time_in, time_out)) as hours  FROM tutor_attendance WHERE anumber ='$anum' ". $date_range." ");

          
//             if (mysqli_num_rows($result2) > 0) {
            
//              while($row = mysqli_fetch_assoc($result2)){
        
//                     // get data from db
                  
//                     $total = round($row['hours']/3600,2);

                   
//                     array_push($hours, $total);
                   
                    
//                 }
//             } else {
//                 array_push($hours, 0);
//             }
 
//         }

       
        
            

//                     $graph_result = []; 
//             array_push($graph_result,('"'. implode('","',$username).'"'));   
        
//             array_push($graph_result,(implode(",",$hours))); 
//             $graph_msg = "";
            

//         // }
    
//         //display nothing on graph if no record is captured
//         // if (!empty($date) || !empty($total)){
          
        
         
//          return $graph_result;
        
    
   
// }

//check if anumber exists
function anumber_exists($link, $anumber){
    // Prepare a select statement
    $sql = "SELECT id FROM students WHERE anumber = ? and status = 'active'";
                    
    if($stmt = mysqli_prepare($link, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "s", $param_anumber);
        
        // Set parameters
        $param_anumber = $anumber;
        
        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            /* store result */
            mysqli_stmt_store_result($stmt);
            
            if(mysqli_stmt_num_rows($stmt) >= 1){
                return true;
                
            } else{
                return false;
            
            }
        } else{
            return "Oops! Could not fetch records for $anumber. Please try again later.";
        }
    }
    
    // Close statement
    mysqli_stmt_close($stmt);
}

//check if student/ instructor record complete
function student_record_complete($link, $anumber){
    
    $sql = "SELECT complete FROM students WHERE anumber = '$anumber' and status = 'active'";
                    
    $result = mysqli_query($link,$sql);

    if($row = mysqli_fetch_assoc($result)){

        $complete = $row['complete'];
        
        if($complete == 1){
            return true;
        }else if($complete == 0){
            return false;
        }
        
        
    }else{
        echo "Could not verify record completion for $anumber. Please try again later.";
    } 


    // Close statement
    mysqli_stmt_close($stmt);
}

function crn_exists($link, $crn){
     // Prepare a select statement
     $sql = "SELECT id FROM courses WHERE crn = ?";
                
     if($stmt = mysqli_prepare($link, $sql)){
         // Bind variables to the prepared statement as parameters
         mysqli_stmt_bind_param($stmt, "s", $param_crn);
         
         // Set parameters
         $param_crn = trim($_POST["crn"]);
         
         // Attempt to execute the prepared statement
         if(mysqli_stmt_execute($stmt)){
             /* store result */
             mysqli_stmt_store_result($stmt);
             
             if(mysqli_stmt_num_rows($stmt) >= 1){
                 return true;
             } else{
                 return false;
             }
         } else{
             echo "Oops! Could not verify CRN. Please try again later";
         }
     }
     
     // Close statement
     mysqli_stmt_close($stmt);
}

//function to update student crn
function update_student_crn($link, $id, $crn, $firstname, $lastname){

    // Prepare an insert statement
    $sql = "UPDATE students SET  crn = ?  WHERE id = ?";
        
    if($stmt = mysqli_prepare($link, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "ss", $param_crn, $param_id);
        
        // Set parameters
        $param_id = $id; 
        $param_crn = $crn;
       
        
        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){

           echo "<script>alert('crn updated for $firstname $lastname');</script>";
           

        } else{
            echo "Could not update crn at id: $id. Please try again later.";
        }
    }
     
} 

//function to get crn records(returns an object)
function get_crn_record($link, $crn){

    $result = mysqli_query($link,"select * from courses where crn = '$crn'");
    
    while ($row = mysqli_fetch_array($result)) { 
          
        $id = $row['id'];
        $crn = $row['crn'];
        $class = $row['class'];
        $instructor = $row['instructor'];
        $anumber = $row['anumber'];
        $status = $row['status'];
        $complete = $row['complete'];
 
      }

    //   //create object with all records
    //   $crn_records = (object)['id'=>$id , 'crn'=>$crn , 'classnme'=>$class , 'instructor'=>$instructor , 'anumber'=>$anumber , 'status'=>$status , 'complete'=>$complete ];

      //return object
      return $result;
}



?>