
<?php

// Include config file
require_once "config.php";
 
//get json file 
$postVarsJSON = $_POST['records'];
$postVars = json_decode( $postVarsJSON );

// echo "<pre>";
// //echo $postVarsJSON;
// var_dump($postVars);


// echo "<script>console.log( 'Debug Objects: " . json_encode($postVars) . "' );</script>";


//analyze each record from json

//function to verify if Anumber is already registered
function verify_anumber($anumber, $link){

    $sql = "SELECT id FROM students WHERE anumber = '$anumber'";
    $result = mysqli_query($link, $sql);
    $num_rows = mysqli_num_rows($result);

    if($num_rows>=1){

        while($row = mysqli_fetch_assoc($result)){

            // get data from db
            $id =$row['id'];
            }
        return $id;

    }else{
        return "false";
     }
     

}


//function to query courses registered by anumber
function get_courses($anumber, $link){

    $result = mysqli_query($link, "SELECT crn, firstname, lastname, anumber FROM students WHERE anumber = '$anumber'");

                            if($row = mysqli_fetch_assoc($result)){
                               
                                $crn = $row['crn'];
                                $firstname = $row['firstname'];
                                $lastname = $row['lastname'];
                                $anumber = $row['anumber'];

                               

                            }

                            //if no substantial course, return 0
                            if($crn === "0" || $crn === 0 || $crn === "" || $crn === NULL){
                                return 0;
                            }else return $crn;

}

//function to check if course already registered,if not, add 
function update_courses($db_crn, $excel_crn){

    if($db_crn === "0" || $db_crn === 0 || $db_crn === "" || $db_crn === NULL){
        return $excel_crn;
    } else{
        $db_courses = explode(",", $db_crn);


        if(!in_array($excel_crn,$db_courses)){
        
            return ( $db_crn .",".$excel_crn); 

        }else{
            return $excel_crn;
        } 

    }
}


//function to add new student if not registered
function add_record($link, $anumber, $firstname, $lastname, $crn){

     // Prepare an insert statement
     $sql = "INSERT INTO students (type ,anumber, firstname, lastname, crn, password) VALUES (?,?,?,?,?,?)";
         
     if($stmt = mysqli_prepare($link, $sql)){
         // Bind variables to the prepared statement as parameters
         mysqli_stmt_bind_param($stmt, "ssssss", $param_type, $param_anumber, $param_firstname, $param_lastname, $param_crn, $param_password);
         
         // Set parameters
         $param_type = "student";
         $param_anumber = $anumber;
         $param_firstname = $firstname;
         $param_lastname  = $lastname;
         $param_crn = $crn;
         $param_password = password_hash("111111", PASSWORD_DEFAULT); // Creates a password hash
         
         // Attempt to execute the prepared statement
         if(mysqli_stmt_execute($stmt)){
             // Redirect to login page
             // header("location: login.php");

             //Display Success in pop-up
             echo "<script>alert('SUCCESS!!');</script>";
             

         } else{
             echo "Something went wrong. Please try again later.";
         }  

         // Close statement
          mysqli_stmt_close($stmt);

         
         
     }

}


//function to update student info if already registered
function update_record($link, $id, $crn){


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

            //do something

         } else{
             echo "Something went wrong. Please try again later.";
         }
     }
      
} 

//make sure the right spreadsheet is uploaded based on the requirement
if (sizeof($postVars->header) ===6 && $postVars->header[0]==="Student ID" && $postVars->header[1]==="Student Name" && $postVars->header[2]==="Class No" && $postVars->header[3]==="CRN" && $postVars->header[4]==="Instructor Name" && $postVars->header[5]==="Semester" ){




//analyze each record before updating database
foreach ($postVars->body as $record){

    //verify the number of fields
    if(sizeof($record)===6){
  
    echo " <hr><br><br><br>Anumber:    ".$record[0]. "<br>";
    echo "<h5>Record from EXCEL:</h5>";

    //split "Student into firstname and Lastname
    $name_split = explode(" ", $record[1]);
    $firstname = $name_split[0];
    $lastname = $name_split[1];

    

        foreach($record as $data){
                echo $data ."<br>";
            }

    echo '<h5>from DATABASE: </h5>';
    //verify if anumber exists --- if yes, return "1" ,else return '0'
    $db_id = verify_anumber($record[0],$link );
    echo 'Exists? ID :'.$db_id.'<br>';

    //get courses if student is already registered
    if($db_id!=="false"){
        $courses = get_courses($record[0],$link);
        echo 'Courses Registered: '.$courses.'<br>';
        $crn_update = update_courses($courses, $record[3] );
       echo ' ID from Database: '.$db_id.'<br>';

       if($crn_update !==$record[3]){
       //Update crn in database
       update_record($link, $db_id, $crn_update);
        echo " <h3>".$firstname.$lastname." Exists, CRN updated to ".$crn_update." </h3>";
       }else{
           echo " <h3>".$firstname.$lastname." Exists, CRN also exists </h3>";
       }



    }else{
        echo "No courses Registered <br>";
        add_record($link, $record[0], $firstname, $lastname, $record[3]);
        echo " <h3>".$firstname.$lastname." ADDED TO DATABASE!!!!</h3>";
    }

    }
 
   
}

}else{
    echo "<h3>Records do not meet the requirements</h3>";
}
// var_dump(json_decode($json, true));
echo "</pre>";

echo '<a id="reglist" href="view_registry.php?type=students" class="btn  btn-warning" >View Students</a>';
?>