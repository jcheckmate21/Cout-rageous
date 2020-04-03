<?php

// Include config file
require_once "config.php";
//include functions file
require "functions.php";


//determine which function to run
if(isset($_POST['function'])){
    $function = $_POST['function'];

    switch($function){

        //Student registration validation
    case "validate_reg_student":{
   

    $success = "false";
    $anumber_err = $password_err = $firstname_err =$lastname_err = $email_err = $major_err = $classification_err = $crn_err =  $confirm_password_err = "";

         //Automatically assign type as "student"
        $type = "student";

        // Validate anumber
        if(empty(trim($_POST["anumber"]))){
            $anumber_err = "Please enter an anumber.";
        } else{

            if(anumber_exists($link, trim($_POST["anumber"]))){
                $anumber_err = "This anumber is already registered.";
            }else{
                $anumber = trim($_POST["anumber"]);
            }
        }

         //validate First name
     if(empty(trim($_POST["firstname"]))){
        $firstname_err = "Please enter your First name.";     
    }
    else{
        $firstname = trim($_POST["firstname"]);
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
    else if (!filter_var(trim($_POST["email"]), FILTER_VALIDATE_EMAIL)){
        $email_err = "Please enter valid email.";
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
    //validate CRN
    if(empty($_POST["crn"])){
        $crn_err = "Please select your CRN.";     
    }
    else{
        $courses = $_POST["crn"];
        
        //get lists of crns
        $result = mysqli_query($link, "SELECT crn FROM courses ");

            while($row = mysqli_fetch_assoc($result)){
                            
                $db_crns[] = $row['crn'];              
                
                }

            foreach($courses as $course){
                $crn = explode(",", $course);   
                $crn_arr[] = $crn[0];
                
                    if(!in_array($crn[0], $db_crns)){
                
                        echo $crn[0]." not registered yet";
                        $courses_unreg[] = $course;
                    }
    
            }     

        

        $crn = implode(",",$crn_arr);
        $crn_ph = "";
        // echo $crn;
        //print_r($crn_unreg);
        
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
    $sql = "INSERT INTO students (type ,anumber, username, firstname, lastname, email, major, classification, crn, password,status) VALUES (?,?,?,?,?,?,?,?,?,?,?)";
     
    if($stmt = mysqli_prepare($link, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "sssssssssss", $param_type, $param_anumber, $param_username, $param_firstname, $param_lastname, $param_email, $param_major, $param_classification, $param_crn, $param_password, $param_status);
        
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
        $param_status = "active";
        
        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            
            echo "success";
            $success = "true";
          ?>  
            <script> $(".anumber, .firstname, .lastname, .email, .classification, .major, .crn, .password, .confirm_password ").val("");
            $(".selectcrn").select2("val", "");
            $(".selectcrn").val('').trigger('change')
            </script>

            <?php
        } else{
            echo "Something went wrong. Please try again later.";
        }  

        // Close statement
         mysqli_stmt_close($stmt);

        // echo "<script>alert('SUCCESS!!');</script>";
        
    }
   


// Close connection
mysqli_close($link);

//added this (test)
// header("Location: view_all_students.php");
}

?>

    <script>
       

        var success = "<?php echo $success; ?>";
        var anumber_err = "<?php echo $anumber_err; ?>";
        var firstname_err = "<?php echo $firstname_err; ?>";
        var lastname_err = "<?php echo $lastname_err; ?>";
        var email_err = "<?php echo $email_err; ?>";
        var major_err = "<?php echo $major_err; ?>";
        var classification_err = "<?php echo $classification_err; ?>";
        var crn_err = "<?php echo $crn_err; ?>";
        var password_err = "<?php echo $password_err; ?>";
        var confirm_password_err = "<?php echo $confirm_password_err; ?>";
        
        $(".anum_err").html(anumber_err);
        $(".fname_err").html(firstname_err);
        $(".lname_err").html(lastname_err);
        $(".email_err").html(email_err);
        $(".class_err").html(classification_err);
        $(".major_err").html(major_err);
        $(".crn_err").html(crn_err);
        $(".password_err").html(password_err);
        $(".confirm_password_err").html(confirm_password_err);
      
           
    </script>

    <?php



    }break;

 case "validate_edit_student":{

   
        $success = "false";
        $anumber_err = $password_err = $firstname_err =$lastname_err = $email_err =  $crn_err =  $confirm_password_err = "";

            //Automatically assign type as "instructor"
            $type = "student";

        // Validate anumber
        if(empty(trim($_POST["anumber"]))){//if no anumber entered
            $anumber_err = "Please enter an anumber.";
        }  
        else{

           
            if(anumber_exists($link, trim($_POST["anumber"])) && ($_POST["action"] == "complete")){

                if(!student_record_complete($link, trim($_POST["anumber"]))){//just to make sure the instructor anumber and records to be updated isnt changed

                    $anumber = trim($_POST["anumber"]);

                }else{
                    
                    $anumber_err = "This anumber is already registered.";

                }
            }else{
                $anumber = trim($_POST["anumber"]);
            }
        }
       
   
            //validate First name
        if(empty(trim($_POST["firstname"]))){
            $firstname_err = "Please enter First name."; 

        }
        else{
            $firstname = trim($_POST["firstname"]);
        }
        
        //validate last name
        if(empty(trim($_POST["lastname"]))){
            $lastname_err = "Please enter last name.";     
        }
        else{
            $lastname = trim($_POST["lastname"]);
            $lastname_ph = "";
        }
        
        //validate email
        if(empty(trim($_POST["email"]))){
            $email_err = "Please enter your email.";     
        }
        else if (!filter_var(trim($_POST["email"]), FILTER_VALIDATE_EMAIL)){
            $email_err = "Please enter valid email.";
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
        if(empty($_POST["crn"])){
            $crn_err = "Please select your CRN.";     
        }
        else{
            $courses = $_POST["crn"];
            
            //get lists of crns
            $result = mysqli_query($link, "SELECT crn FROM courses ");

                while($row = mysqli_fetch_assoc($result)){
                                
                    $db_crns[] = $row['crn'];              
                    
                    }

                foreach($courses as $course){
                    $crn = explode(",", $course);   
                    $crn_arr[] = $crn[0];
                    
                        if(!in_array($crn[0], $db_crns)){
                    
                            //echo " not registered yet";
                            $crn_err = "CRN: ". $crn[0]." not registered <br>";
                            $courses_unreg[] = $course;
                        }
        
                }     

            

            $crn = implode(",",$crn_arr);
            $crn_ph = "";
            // echo $crn;
            //print_r($crn_unreg);
            
        }
            
        // Validate password
        // if(empty(trim($_POST["password"]))){
        //     $password_err = "Please enter a password.";     
        // } elseif(strlen(trim($_POST["password"])) < 6){
        //     $password_err = "Password must have atleast 6 characters.";
        // } else{
        //     $password = trim($_POST["password"]);
        //     $password_ph = "";
        // }
        
        // Validate confirm password
        // if(empty(trim($_POST["confirm_password"]))){
        //     $confirm_password_err = "Please confirm password.";     
        // } else{
        //     $confirm_password = trim($_POST["confirm_password"]);
        //     if(empty($password_err) && ($password != $confirm_password)){
        //         $confirm_password_err = "Password does not match.";
        //     }
        // }
        


 //empty($password_err) && empty($confirm_password_err) &&
    // Check input errors before inserting in database
    if(empty($anumber_err) && empty($firstname_err) &&empty($lastname_err)&& empty($email_err) && empty($crn_err) && empty($major_err)){
         
        // Prepare an insert statement
        $sql = "UPDATE students SET type = ?, anumber = ?, username = ?, firstname = ?, lastname = ?, email = ?, major = ?, classification = ?, crn = ?, status = ?, complete = ?  WHERE id = ?";

        // Prepare an insert statement
        // $sql = "INSERT INTO students (type ,anumber, username, firstname, lastname, email, major, classification, crn, password, status, complete) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            // mysqli_stmt_bind_param($stmt, "sssssssss",$param_anumber, $param_username, $param_firstname, $param_lastname, $param_email, $param_major, $param_classification, $param_crn, $param_id);
           
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssssssssssii", $param_type, $param_anumber, $param_username, $param_firstname, $param_lastname, $param_email, $param_major, $param_classification, $param_crn, $param_status, $param_complete,$param_id );
            
            // Set parameters
            $param_id = trim($_POST["id"]);
            $param_type = $type;
            $param_anumber = $anumber;
            $param_username = $username;
            $param_firstname = $firstname;
            $param_lastname  = $lastname;
            $param_email = $email;
            $param_major = $major;
            $param_classification = $classification;
            $param_crn = $crn;
            //$param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            $param_status = "active";
            $param_complete = 1;
            $student = $firstname." ".$lastname;
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                
                 echo " Student Record Updated Successfully <br>";
                // $success = "true";

                //update attendance table
                $sql = "UPDATE attendance SET anumber = ?, firstname = ?, lastname = ?  WHERE anumber = ?";

                if($stmt = mysqli_prepare($link, $sql)){
                
                    mysqli_stmt_bind_param($stmt, "ssss",$anumber, $firstname, $lastname, $_POST["old_anumber"]);

                    if(mysqli_stmt_execute($stmt)){
                        echo "Attendance Record Updated Successfully <br>";
                        
                        echo "<script type='text/javascript'>alert('Record Updated Successfully');</script>";
                        $success = "true";

                        $_POST["anumber"] = $anumber;
                    }
                
                    // header("location: edit_student.php?anumber=$anumber" );
                }else{
                    echo "Could not update Attendance Record <br>";
                }


            ?>  
                <!-- <script> $(".anumber, .firstname, .lastname, .email,  .password, .confirm_password ").val("");
                $(".selectcrn").select2("val", "");
                $(".selectcrn").val('').trigger('change');
                </script> -->

                <?php
            } else{
                echo "Could not update Student Record. Please try again later.<br>";
            }  

        
            
        }
    


    // Close connection
    mysqli_close($link);


    }

    ?>

        <script>
            // $(".anumber, .firstname, .lastname, .email, .classification, .major ").removeClass("input-error");
            
            var success = "<?php echo $success; ?>";
            var anumber_err = "<?php echo $anumber_err; ?>";
            var firstname_err = "<?php echo $firstname_err; ?>";
            var lastname_err = "<?php echo $lastname_err; ?>";
            var email_err = "<?php echo $email_err; ?>";
            var major_err = "<?php echo $major_err; ?>";
            var class_err = "<?php echo $classification_err; ?>";
            var crn_err = "<?php echo $crn_err; ?>";
         
            
            $(".anum_err").html(anumber_err);
            $(".fname_err").html(firstname_err);
            $(".lname_err").html(lastname_err);
            $(".email_err").html(email_err);
            $(".crn_err").html(crn_err);
            $(".major_err").html(major_err);
            $(".class_err").html(class_err);
        
            
        
        </script>

        <?php



}break;


    case "check_inst_anumber_complete":{
            
        $anumber = trim($_POST["anumber"]);

         if(anumber_exists($link, $anumber)){//if anumber exists
                
            
            if(!student_record_complete($link, $anumber)){//if records assoc. with anumber incomplete

                //prefill available field records in input boxes
                echo "incomplete";

            }else{//if anumber doesn't exist
                
                echo "complete";

                //further confirm if they want to edit record
                //if yes, redirect to edit record page with prefilled info
                //if not, exit?
            }

        }

    }
    break;


        //Instructor registration validation
    case "validate_reg_instructor":{
   
            $success = "false";
            $anumber_err = $password_err = $firstname_err =$lastname_err = $email_err =  $crn_err =  $confirm_password_err = "";

                //Automatically assign type as "instructor"
                $type = "instructor";

            // Validate anumber
            if(empty(trim($_POST["anumber"]))){//if no anumber entered
                $anumber_err = "Please enter an anumber.";
            }  
            else{

                if(anumber_exists($link, trim($_POST["anumber"]))){
                    $anumber_err = "This anumber is already registered.";
                }else{
                    $anumber = trim($_POST["anumber"]);
                }
            }
 

                //validate First name
            if(empty(trim($_POST["firstname"]))){
                $firstname_err = "Please enter First name.";     
            }
            else{
                $firstname = trim($_POST["firstname"]);
            }
            
            //validate last name
            if(empty(trim($_POST["lastname"]))){
                $lastname_err = "Please enter last name.";     
            }
            else{
                $lastname = trim($_POST["lastname"]);
                $lastname_ph = "";
            }
            
            //validate email
            if(empty(trim($_POST["email"]))){
                $email_err = "Please enter your email.";     
            }
            else if (!filter_var(trim($_POST["email"]), FILTER_VALIDATE_EMAIL)){
                $email_err = "Please enter valid email.";
            } 
            else{
                $email = trim($_POST["email"]);
                $username = substr($email, 0, strpos($email, '@'));
                $email_ph = "";
            }
            
            //validate major
            $major= "";

            //Automatically add classification
            $classification  = "instructor";
            
            //validate CRN
            if(empty($_POST["crn"])){
                $crn_err = "Please select your CRN.";     
            }
            else{
                $courses = $_POST["crn"];
                
                //get lists of crns
                $result = mysqli_query($link, "SELECT crn FROM courses ");

                    while($row = mysqli_fetch_assoc($result)){
                                    
                        $db_crns[] = $row['crn'];              
                        
                        }

                    foreach($courses as $course){
                        $crn = explode(",", $course);   
                        $crn_arr[] = $crn[0];
                        
                            if(!in_array($crn[0], $db_crns)){
                        
                                echo $crn[0]." not registered yet";
                                $courses_unreg[] = $course;
                            }
            
                    }     

                

                $crn = implode(",",$crn_arr);
                $crn_ph = "";
                // echo $crn;
                //print_r($crn_unreg);
                
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
                    $confirm_password_err = "Password does not match.";
                }
            }
            



        // Check input errors before inserting in database
        if(empty($anumber_err) && empty($firstname_err) &&empty($lastname_err)&& empty($email_err) && empty($password_err) && empty($confirm_password_err) && empty($crn_err)){
                
            // Prepare an insert statement
            $sql = "INSERT INTO students (type ,anumber, username, firstname, lastname, email, major, classification, crn, password, status, complete) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)";
            
            if($stmt = mysqli_prepare($link, $sql)){
                // Bind variables to the prepared statement as parameters
                mysqli_stmt_bind_param($stmt, "sssssssssssi", $param_type, $param_anumber, $param_username, $param_firstname, $param_lastname, $param_email, $param_major, $param_classification, $param_crn, $param_password, $param_status, $param_complete );
                
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
                $param_status = "active";
                $param_complete = 1;
                $instructor = $firstname." ".$lastname;
                // Attempt to execute the prepared statement
                if(mysqli_stmt_execute($stmt)){
                    
                    echo "success";
                    $success = "true";
                    //now add new unregistered courses to database
                        if(!empty($courses_unreg)){
                            foreach($courses_unreg as $course){
                                $crn = explode(",", $course);
                                // Prepare an insert statement
                                $sql = "INSERT INTO courses (crn, class, instructor, anumber, status, complete ) VALUES (?,?,?,?,?,?)";
                                
                                if($stmt = mysqli_prepare($link, $sql)){
                                    // Bind variables to the prepared statement as parameters
                                    mysqli_stmt_bind_param($stmt, "sssssi", $param_crn,$param_class, $param_inst, $param_anumber, $param_status, $param_complete);
                                    
                                    // Set parameters
                                    $param_crn = $crn[0];
                                    $param_class = $crn[1];
                                    $param_inst = $instructor;
                                    $param_anumber = $anumber;
                                    $param_status = "active";
                                    $param_complete = 1;
                                            
                                    
                                    // Attempt to execute the prepared statement
                                    if(mysqli_stmt_execute($stmt)){
                                        // Redirect to login page
                                        // header("location: login.php");

                                        //Display Success in pop-up
                                        echo "&nbsp;".$crn[0]."registered with ".$anumber."&nbsp;".$instructor."\n";
                                    

                                    } else{
                                        echo "Could not add course. Please try again later.";
                                    }  

                                    // Close statement
                                    mysqli_stmt_close($stmt);

                                    
                                }
            
                            }
                        }

                ?>  
                    <script> 
                  
                    $(".anumber, .firstname, .lastname, .email,  .password, .confirm_password ").val("");
                    $(".selectcrn").select2("val", "");
                    $(".selectcrn").val('').trigger('change');
                    </script>

                    <?php
                } else{
                    echo "Something went wrong. Please try again later.";
                }  

            
                
            }
        


        // Close connection
        mysqli_close($link);


        }

        ?>

            <script>
                // $(".anumber, .firstname, .lastname, .email, .classification, .major ").removeClass("input-error");

                var success = "<?php echo $success; ?>";
                var anumber_err = "<?php echo $anumber_err; ?>";
                var firstname_err = "<?php echo $firstname_err; ?>";
                var lastname_err = "<?php echo $lastname_err; ?>";
                var email_err = "<?php echo $email_err; ?>";
                var crn_err = "<?php echo $crn_err; ?>";
                var password_err = "<?php echo $password_err; ?>";
                var confirm_password_err = "<?php echo $confirm_password_err; ?>";
                
                $(".anum_err").html(anumber_err);
                $(".fname_err").html(firstname_err);
                $(".lname_err").html(lastname_err);
                $(".email_err").html(email_err);
                $(".crn_err").html(crn_err);
                $(".password_err").html(password_err);
                $(".confirm_password_err").html(confirm_password_err);
            
                
            
            </script>

            <?php



    }break;
        //Instructor registration validation
    case "validate_complete_instructor_reg":{

            $success = "false";
            $anumber_err = $password_err = $firstname_err =$lastname_err = $email_err =  $crn_err =  $confirm_password_err = "";

                //Automatically assign type as "instructor"
                $type = "instructor";

            // Validate anumber
            if(empty(trim($_POST["anumber"]))){//if no anumber entered
                $anumber_err = "Please enter an anumber.";
            }  
            else{

                if(anumber_exists($link, trim($_POST["anumber"]))){

                    if(!student_record_complete($link, trim($_POST["anumber"]))){//just to make sure the instructor anumber and records to be updated isnt changed

                        $anumber = trim($_POST["anumber"]);

                    }else{
                        
                        $anumber_err = "This anumber is already registered.";

                    }
                }else{
                    $anumber = trim($_POST["anumber"]);
                }
            }
           
       
                //validate First name
            if(empty(trim($_POST["firstname"]))){
                $firstname_err = "Please enter First name.";     
            }
            else{
                $firstname = trim($_POST["firstname"]);
            }
            
            //validate last name
            if(empty(trim($_POST["lastname"]))){
                $lastname_err = "Please enter last name.";     
            }
            else{
                $lastname = trim($_POST["lastname"]);
                $lastname_ph = "";
            }
            
            //validate email
            if(empty(trim($_POST["email"]))){
                $email_err = "Please enter your email.";     
            }
            else if (!filter_var(trim($_POST["email"]), FILTER_VALIDATE_EMAIL)){
                $email_err = "Please enter valid email.";
            } 
            else{
                $email = trim($_POST["email"]);
                $username = substr($email, 0, strpos($email, '@'));
                $email_ph = "";
            }
            
            //validate major
            $major= "";

            //Automatically add classification
            $classification  = "instructor";
            
            //validate CRN
            if(empty($_POST["crn"])){
                $crn_err = "Please select your CRN.";     
            }
            else{
                $courses = $_POST["crn"];
                
                //get lists of crns
                $result = mysqli_query($link, "SELECT crn FROM courses ");

                    while($row = mysqli_fetch_assoc($result)){
                                    
                        $db_crns[] = $row['crn'];              
                        
                        }

                    foreach($courses as $course){
                        $crn = explode(",", $course);   
                        $crn_arr[] = $crn[0];
                        
                            if(!in_array($crn[0], $db_crns)){
                        
                               // echo $crn[0]." not registered yet";
                                $courses_unreg[] = $course;
                            }
            
                    }     

                

                $crn = implode(",",$crn_arr);
                $crn_ph = "";
                // echo $crn;
                //print_r($crn_unreg);
                
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
                    $confirm_password_err = "Password does not match.";
                }
            }
            



        // Check input errors before inserting in database
        if(empty($anumber_err) && empty($firstname_err) &&empty($lastname_err)&& empty($email_err) && empty($password_err) && empty($confirm_password_err) && empty($crn_err) && empty($crn_err)){
             
            // Prepare an insert statement
            $sql = "UPDATE students SET type = ?, anumber = ?, username = ?, firstname = ?, lastname = ?, email = ?, major = ?, classification = ?, crn = ?, password = ?, status = ?, complete = ?  WHERE id = ?";

            // Prepare an insert statement
            // $sql = "INSERT INTO students (type ,anumber, username, firstname, lastname, email, major, classification, crn, password, status, complete) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)";
            
            if($stmt = mysqli_prepare($link, $sql)){
                // Bind variables to the prepared statement as parameters
                // mysqli_stmt_bind_param($stmt, "sssssssss",$param_anumber, $param_username, $param_firstname, $param_lastname, $param_email, $param_major, $param_classification, $param_crn, $param_id);
               
                // Bind variables to the prepared statement as parameters
                mysqli_stmt_bind_param($stmt, "sssssssssssii", $param_type, $param_anumber, $param_username, $param_firstname, $param_lastname, $param_email, $param_major, $param_classification, $param_crn, $param_password, $param_status, $param_complete,$param_id );
                
                // Set parameters
                $param_id = trim($_POST["id"]);
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
                $param_status = "active";
                $param_complete = 1;
                $instructor = $firstname." ".$lastname;
                // Attempt to execute the prepared statement
                if(mysqli_stmt_execute($stmt)){
                    
                    echo "<strong>SUCCESS</strong>";
                    $success = "true";

                    echo " Instructor Record Updated Successfully <br>";
                    // $success = "true";
    
                    //update attendance table
                    $sql = "UPDATE attendance SET anumber = ?, firstname = ?, lastname = ?  WHERE anumber = ?";
    
                    if($stmt = mysqli_prepare($link, $sql)){
                    
                        mysqli_stmt_bind_param($stmt, "ssss",$anumber, $firstname, $lastname, $_POST["old_anum"]);
    
                        if(mysqli_stmt_execute($stmt)){
                            echo "Attendance Record Updated Successfully <br>";
                            
                            echo "<script type='text/javascript'>alert('Record Updated Successfully');</script>";
                            $success = "true";
    
                            $_POST["anumber"] = $anumber;
                        }
                    
                        // header("location: edit_student.php?anumber=$anumber" );
                    }else{
                        echo "Could not update Attendance Record <br>";
                    }
    

                    //now add new unregistered courses to database
                        if(!empty($courses_unreg)){
                            foreach($courses_unreg as $course){
                                $crn = explode(",", $course);
                                // Prepare an insert statement
                                $sql = "INSERT INTO courses (crn, class, instructor, anumber, status, complete ) VALUES (?,?,?,?,?,?)";
                                
                                if($stmt = mysqli_prepare($link, $sql)){
                                    // Bind variables to the prepared statement as parameters
                                    mysqli_stmt_bind_param($stmt, "sssssi", $param_crn,$param_class, $param_inst, $param_anumber, $param_status, $param_complete);
                                    
                                    // Set parameters
                                    $param_crn = $crn[0];
                                    $param_class = $crn[1];
                                    $param_inst = $instructor;
                                    $param_anumber = $anumber;
                                    $param_status = "active";
                                    $param_complete = 1;
                                            
                                    
                                    // Attempt to execute the prepared statement
                                    if(mysqli_stmt_execute($stmt)){
                                        // Redirect to login page
                                        // header("location: login.php");

                                        echo "<br> Course: ".$crn[1]." ( ".$crn[0]." ) added to registry <br>";
                                    

                                    } else{
                                        echo "Could not add course. Please try again later.<br>";
                                    }  

                                    // Close statement
                                    mysqli_stmt_close($stmt);

                                    
                                }
            
                            }
                        }

                ?>  
                    <script> $(".anumber, .firstname, .lastname, .email,  .password, .confirm_password ").val("");
                    $(".selectcrn").select2("val", "");
                    $(".selectcrn").val('').trigger('change');
                    </script>

                    <?php
                } else{
                    echo "Something went wrong. Please try again later.";
                }  

            
                
            }
        


        // Close connection
        mysqli_close($link);


        }

        ?>

            <script>
                // $(".anumber, .firstname, .lastname, .email, .classification, .major ").removeClass("input-error");

                var success = "<?php echo $success; ?>";
                var anumber_err = "<?php echo $anumber_err; ?>";
                var firstname_err = "<?php echo $firstname_err; ?>";
                var lastname_err = "<?php echo $lastname_err; ?>";
                var email_err = "<?php echo $email_err; ?>";
                var crn_err = "<?php echo $crn_err; ?>";
                var password_err = "<?php echo $password_err; ?>";
                var confirm_password_err = "<?php echo $confirm_password_err; ?>";
                
                $(".anum_err").html(anumber_err);
                $(".fname_err").html(firstname_err);
                $(".lname_err").html(lastname_err);
                $(".email_err").html(email_err);
                $(".crn_err").html(crn_err);
                $(".password_err").html(password_err);
                $(".confirm_password_err").html(confirm_password_err);
            
                
            
            </script>

            <?php



    }break;

    case "validate_edit_instructor":{

        $success = "false";
        $anumber_err = $password_err = $firstname_err =$lastname_err = $email_err =  $crn_err =  $confirm_password_err = "";

            //Automatically assign type as "instructor"
        $type = "instructor";

        // Validate anumber
        if(empty(trim($_POST["anumber"]))){//if no anumber entered
            $anumber_err = "Please enter an anumber.";
        }  
        else{

        
        if(anumber_exists($link, trim($_POST["anumber"]))){

                if((trim($_POST["anumber"])) === (trim($_POST["old_anum"]))){//just to make sure the instructor anumber and records to be updated isnt changed

                    $anumber = trim($_POST["anumber"]);
            

                }else{
                    
                    $anumber_err = "This anumber is already registered.";

                }
            }else{
                $anumber = trim($_POST["anumber"]);
            }
        }
   
            //validate First name
        if(empty(trim($_POST["firstname"]))){
            $firstname_err = "Please enter First name.";     
        }
        else{
            $firstname = trim($_POST["firstname"]);
        }
        
        //validate last name
        if(empty(trim($_POST["lastname"]))){
            $lastname_err = "Please enter last name.";     
        }
        else{
            $lastname = trim($_POST["lastname"]);
            $lastname_ph = "";
        }
        
        //validate email
        if(empty(trim($_POST["email"]))){
            $email_err = "Please enter your email.";     
        }
        else if (!filter_var(trim($_POST["email"]), FILTER_VALIDATE_EMAIL)){
            $email_err = "Please enter valid email.";
        } 
        else{
            $email = trim($_POST["email"]);
            $username = substr($email, 0, strpos($email, '@'));
            $email_ph = "";
        }
        
        //validate major
        $major= "";

        //Automatically add classification
        $classification  = "instructor";
        
        //validate CRN
        if(empty($_POST["crn"])){
            $crn_err = "Please select your CRN.";     
        }
        else{
            $courses = $_POST["crn"];
            
            //get lists of crns
            $result = mysqli_query($link, "SELECT crn FROM courses ");

                while($row = mysqli_fetch_assoc($result)){
                                
                    $db_crns[] = $row['crn'];              
                    
                    }

                foreach($courses as $course){
                    $crn = explode(",", $course);   
                    $crn_arr[] = $crn[0];
                    
                        if(!in_array($crn[0], $db_crns)){
                    
                           // echo $crn[0]." not registered yet";
                            $courses_unreg[] = $course;
                        }
        
                }     

            

            $crn = implode(",",$crn_arr);
            $crn_ph = "";
            // echo $crn;
            //print_r($crn_unreg);
            
        }
            
        // // Validate password
        // if(empty(trim($_POST["password"]))){
        //     $password_err = "Please enter a password.";     
        // } elseif(strlen(trim($_POST["password"])) < 6){
        //     $password_err = "Password must have atleast 6 characters.";
        // } else{
        //     $password = trim($_POST["password"]);
        //     $password_ph = "";
        // }
        
        // // Validate confirm password
        // if(empty(trim($_POST["confirm_password"]))){
        //     $confirm_password_err = "Please confirm password.";     
        // } else{
        //     $confirm_password = trim($_POST["confirm_password"]);
        //     if(empty($password_err) && ($password != $confirm_password)){
        //         $confirm_password_err = "Password does not match.";
        //     }
        // }
        

    //&& empty($password_err) && empty($confirm_password_err)

    // Check input errors before inserting in database
    if(empty($anumber_err) && empty($firstname_err) &&empty($lastname_err) && empty($email_err)  && empty($crn_err)){
         
        // Prepare an insert statement
        $sql = "UPDATE students SET type = ?, anumber = ?, username = ?, firstname = ?, lastname = ?, email = ?, major = ?, classification = ?, crn = ?, status = ?, complete = ?  WHERE id = ?";

        // Prepare an insert statement
        // $sql = "INSERT INTO students (type ,anumber, username, firstname, lastname, email, major, classification, crn, password, status, complete) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            // mysqli_stmt_bind_param($stmt, "sssssssss",$param_anumber, $param_username, $param_firstname, $param_lastname, $param_email, $param_major, $param_classification, $param_crn, $param_id);
           
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssssssssssii", $param_type, $param_anumber, $param_username, $param_firstname, $param_lastname, $param_email, $param_major, $param_classification, $param_crn, $param_status, $param_complete,$param_id );
            
            // Set parameters
            $param_id = $_POST["id"];
            $param_type = $type;
            $param_anumber = $anumber;
            $param_username = $username;
            $param_firstname = $firstname;
            $param_lastname  = $lastname;
            $param_email = $email;
            $param_major = $major;
            $param_classification = $classification;
            $param_crn = $crn;
            // $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            $param_status = "active";
            $param_complete = 1;
            $instructor = $firstname." ".$lastname;
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                
                echo "<strong>SUCCESS</strong>";
                $success = "true";

                echo " Student Record Updated Successfully <br>";
                // $success = "true";

                //update attendance table
                $sql = "UPDATE attendance SET anumber = ?, firstname = ?, lastname = ?  WHERE anumber = ?";

                if($stmt = mysqli_prepare($link, $sql)){
                
                    mysqli_stmt_bind_param($stmt, "ssss",$anumber, $firstname, $lastname, $_POST["old_anumber"]);

                    if(mysqli_stmt_execute($stmt)){
                        echo "Attendance Record Updated Successfully <br>";
                        
                        echo "<script type='text/javascript'>alert('Record Updated Successfully');</script>";
                        $success = "true";

                        $_POST["anumber"] = $anumber;
                    }
                
                    // header("location: edit_student.php?anumber=$anumber" );
                }else{
                    echo "Could not update Attendance Record <br>";
                }


                //now add new unregistered courses to database
                    if(!empty($courses_unreg)){
                        foreach($courses_unreg as $course){
                            $crn = explode(",", $course);
                            // Prepare an insert statement
                            $sql = "INSERT INTO courses (crn, class, instructor, anumber, status, complete ) VALUES (?,?,?,?,?,?)";
                            
                            if($stmt = mysqli_prepare($link, $sql)){
                                // Bind variables to the prepared statement as parameters
                                mysqli_stmt_bind_param($stmt, "sssssi", $param_crn,$param_class, $param_inst, $param_anumber, $param_status, $param_complete);
                                
                                // Set parameters
                                $param_crn = $crn[0];
                                $param_class = $crn[1];
                                $param_inst = $instructor;
                                $param_anumber = $anumber;
                                $param_status = "active";
                                $param_complete = 1;
                                        
                                
                                // Attempt to execute the prepared statement
                                if(mysqli_stmt_execute($stmt)){
                                    // Redirect to login page
                                    // header("location: login.php");

                                    
                                    echo "<br> Course: ".$crn[1]." ( ".$crn[0]." ) added to registry";
                                

                                } else{
                                    echo "Could not add course. Please add manually";
                                }  

                                // Close statement
                                mysqli_stmt_close($stmt);

                                
                            }
        
                        }
                    }


                    
            
            } else{
                echo "Something went wrong. Please try again later.";
            }  

        
            
        }
    


    // Close connection
    mysqli_close($link);


    }

    ?>

        <script>
            // $(".anumber, .firstname, .lastname, .email, .classification, .major ").removeClass("input-error");

            var success = "<?php echo $success; ?>";
            var anumber_err = "<?php echo $anumber_err; ?>";
            var firstname_err = "<?php echo $firstname_err; ?>";
            var lastname_err = "<?php echo $lastname_err; ?>";
            var email_err = "<?php echo $email_err; ?>";
            var crn_err = "<?php echo $crn_err; ?>";
            // var password_err = "<?php echo $password_err; ?>";
            // var confirm_password_err = "<?php echo $confirm_password_err; ?>";
            
            $(".anum_err").html(anumber_err);
            $(".fname_err").html(firstname_err);
            $(".lname_err").html(lastname_err);
            $(".email_err").html(email_err);
            $(".crn_err").html(crn_err);
            // $(".password_err").html(password_err);
            // $(".confirm_password_err").html(confirm_password_err);
        
            
        
        </script>

        <?php



}break;

    //add course
    case "validate_add_course":{

        $crn_err = $class_err = $inst_fname_err =$inst_lname_err =$anumber_err = "";

        // Validate crn
            if(empty(trim($_POST["crn"]))){
                $crn_err = "Please enter a crn";
            } else{
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
                            $crn_err = "This crn is already registered";
                        } else{
                            $crn = trim($_POST["crn"]);
                        }
                    } else{
                        echo "Oops! Could not verify CRN. Please try again later";
                    }
                }
                
                // Close statement
                mysqli_stmt_close($stmt);
            }

            
            //validate class number
            if(empty(trim($_POST["classname"]))){
                $class_err = "Please enter the Class Name";     
            }
            else{
                $class = trim($_POST["classname"]);
            }

            //validate instructor anumber
            // Validate anumber
            if(empty(trim($_POST["anumber"]))){
                $anumber_err = "Please enter an anumber";
            } else{ 
                
                $anumber =  trim($_POST["anumber"]);
              
            }

            //validate instructor first name
            if(empty(trim($_POST["ins_fname"]))){
                $inst_fname_err = "Please enter Instructor's first name";    
            }
            else{
                $ins_fname = trim($_POST["ins_fname"]);
            }
            
            //validate instructor last name
            if(empty(trim($_POST["ins_lname"]))){
                $inst_lname_err = "Please enter Instructor's last name";     
            }
            else{
                $inst_lname= trim($_POST["ins_lname"]);
            }
            
            


            // Check input errors before inserting in database
            if(empty($crn_err) && empty($class_err) && empty($inst_fname_err) && empty($inst_lname_err) && empty($anumber_err)){
                    
                    // Prepare an insert statement
                    $sql = "INSERT INTO courses (crn, class, instructor, anumber, status, complete ) VALUES (?,?,?,?,?,?)";
                    
                    if($stmt = mysqli_prepare($link, $sql)){
                        // Bind variables to the prepared statement as parameters
                        mysqli_stmt_bind_param($stmt, "sssssi", $param_crn, $param_class, $param_inst, $param_anumber, $param_status, $param_complete);
                        
                        // Set parameters
                        $param_crn= $crn;
                        $param_class = $class;
                        $param_inst = $ins_fname." ".$inst_lname;
                        $param_anumber = $anumber;
                        $param_status = "active";
                        $param_complete = 1;
                        
                        // Attempt to execute the prepared statement
                        if(mysqli_stmt_execute($stmt)){
                       
                            //Display Success in pop-up
                            echo "<script>alert('SUCCESS!!');</script>";

                            //time to update instructor records in students table if it exists
                            //update add new course to his record
                            if(anumber_exists($link, $anumber)){
                               
                                $sql = "SELECT id, firstname, lastname, crn FROM students WHERE anumber = '$anumber' and type='instructor' and status = 'active'";
                                
                                $result = mysqli_query($link,$sql);

                                if($row = mysqli_fetch_assoc($result)){

                                    $id = $row['id'];
                                    $crn_db = $row['crn'];
                                    $firstname = $row['firstname'];
                                    $lastname = $row['lastname'];

                                     //update crn string
                                     $new_crn = $crn_db.",".$crn;

                                     //update crn in record now!
                                     update_student_crn($link, $id, $new_crn, $firstname, $lastname);
                                   
                                }else{
                                    echo "Could not fetch records for $anumber. Please try again later.";
                                } 


                            }else{
                                //create new instructor with blank unavailabe fields and render "incomplete"
                                    
                                    $sql = "INSERT INTO students (type ,anumber, firstname, lastname, classification, crn, status, complete) VALUES (?,?,?,?,?,?,?,?)";
                                    
                                    if($stmt = mysqli_prepare($link, $sql)){
                                      
                                        mysqli_stmt_bind_param($stmt, "sssssssi", $param_type, $param_anumber, $param_firstname, $param_lastname, $param_classification, $param_crn, $param_status, $param_complete );
                                        
                                        // Set parameters
                                        $param_type = "instructor";
                                        $param_anumber = $anumber;
                                        $param_firstname = $ins_fname;
                                        $param_lastname  = $inst_lname;
                                        $param_classification = "instructor";
                                        $param_crn = $crn;
                                        $param_status = "active";
                                        $param_complete = 0;

                                        
                                        if(mysqli_stmt_execute($stmt)){
                                            
                                            echo "New instructor ". $param_inst ." created in database, but with incomplete records";
                                        }


                                    }
                                }

                        } else{
                            echo "Could not register course CRN:$crn. Please try again later.";
                        }  

                        // Close statement
                        mysqli_stmt_close($stmt);

                    }
                
            }
                
                // Close connection
                mysqli_close($link);
    
            ?>

            <script>
                

                var crn_err = "<?php echo $crn_err; ?>";
                var class_err = "<?php echo $class_err; ?>";
                var anumber_err = "<?php echo $anumber_err; ?>";
                var inst_fname_err = "<?php echo $inst_fname_err; ?>";
                var inst_lname_err = "<?php echo $inst_lname_err; ?>";
                
                
                $(".crn_err").html(crn_err);
                $(".classname_err").html(class_err);
                $(".anum_err").html(anumber_err);
                $(".ins_fname_err").html(inst_fname_err);
                $(".ins_lname_err").html(inst_lname_err);   
                
            
            </script>

            <?php

    }
    break;


    //student login
case "log_in_student":{

        
        // Define variables and initialize with empty values
       $username_err = $password_err = $login_msg = "";
        
    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username / anumber.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT password FROM students WHERE username = ? OR anumber = ? ";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_username);
            
            // Set parameters
            $param_username = $username;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){    

                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            // If Password is correct

                            //find out if user is student or instructor
                            $result = mysqli_query($link, "SELECT type, firstname, lastname, anumber FROM students WHERE username = '$username' or anumber = '$username'");

                            if($row = mysqli_fetch_assoc($result)){
                               
                                $type = $row['type'];
                                $firstname = $row['firstname'];
                                $lastname = $row['lastname'];
                                $anumber = $row['anumber'];

                            }
                                

                                    $_SESSION["clocker_type"] = $type;

                                   $_SESSION["clock_in_username"] = $username;

                                   $_SESSION["clocker_name"] = $type;

                                   $_SESSION["clock_in_username"] = $username;

                                   $_SESSION["clock_in_valid"] = 1;

                                   //header("Refresh:0");
                                    //  header("location: student_login.php?username=$username");
                                    // //yet to create this function to clock students/ instructors in using their details
                                    //clock_in($firstname, $lastname, $anumber, $admin_name);

                                      

                                    // //save student username in session
                                    // $_SESSION["studentname"]= $username;
                                    

                                

                                // }

                        } else{
                            // Display an error message if password is not valid
                            $password_err = "The password you entered was not valid.";
                        }
                    }
                } else{
                    // Display an error message if username doesn't exist
                    $username_err = "No account found with that username.";
                }
            } else{
                $login_msg = "Oops! Something went wrong. Please try again later.";
            }
        }
        
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
   

    
   // clock student in if details authenticated
   if(empty($username_err) && empty($password_err)){
        
    $username = $_POST["username"];
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
            // $login_msg = "Found entry:  ".mysqli_stmt_num_rows($stmt);

              mysqli_stmt_bind_result($stmt, $res_id, $res_memo);


              while(mysqli_stmt_fetch($stmt)){
                  $id = $res_id;
                  $memo = $res_memo;

              }

              //check if an instructor
              //if instructor, redirect him to dashboard where he can manually clock out
               if($type == "instructor"){
                echo '<div><a href="instructor_dashboard.php?anumber='.$anumber.'"> <button>Open Dashboard</button></a></div><br> <div><a href="#"> <button>CLOCK OUT</button></a></div>';

                // will remove later
                $login_msg = clock_out($type , $anumber, $link);
              
               }else{
                   //call clock out function if not instructor
                    $login_msg = clock_out( $type, $anumber, $link);
               }

           } else{
            // $login_msg = "None found: ".mysqli_stmt_num_rows($stmt);

              //call clock in function
              $login_msg = clock_in( $type, $anumber, $firstname, $lastname, $link);

              //open Instructor dashboard if an instructor clocks in  (will personalize it soon)
              if($type == "instructor"){
                // header("location: instructor_dashboard.php?anumber=$anumber&id=$id"); //sends id via GET for manual clock-out
                echo '<div><a href="instructor_dashboard.php?anumber='.$anumber.'"> <button>Open Dashboard</button></a></div><br>';


              }


           }
       } else{
           $login_msg = "Oops! Something went wrong. Please try again later.";
       }
   }
    
 echo $login_msg;  // // Close statement
   // mysqli_stmt_close($stmt);    
       
    
} 

?>     

<script>


var username_err = "<?php echo $username_err; ?>";
var password_err = "<?php echo $password_err; ?>";

$(".anum_err").html(username_err);
$(".password_err").html(password_err);


</script>


<?php
}
break;


case "qr_login" :{





   // extract  user records for attendance entry
if(isset($_POST['username'])){
        
         $username = $_POST["username"];
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


    

}//end of case "clock_out_instructor
break;

case "clock_out_instructor" :{

    if(isset($_POST['username'])){
        $login_msg = "";

        if(!empty(trim($_POST["username"]))){
            $anumber = $_POST["username"];

            $login_msg = clock_out("instructor", $anumber, $link);

        }else echo "No User found";

        echo $login_msg;
    }else echo "No User found";


    
?>     

<script>


    var username_err = "<?php echo $username_err; ?>";
    var password_err = "<?php echo $password_err; ?>";

    $(".anum_err").html(username_err);
    $(".password_err").html(password_err);


</script>

<?php
}//end of case "clock_out_instructor
break;



case "get_crns":{

    if(empty($_POST['searchTerm'])){ 
        $fetchData = mysqli_query($link,"select class,crn from courses");
      }else{ 
        $search = explode(",", $_POST['searchTerm']);   
        // $fetchData = mysqli_query($link,"select class,crn from courses where crn like '%".$search."%' or class like '%".$search."%' ");
        $fetchData = mysqli_query($link,"select class,crn from courses where crn = '$search[0]'  ");
      } 
      
      $data = array();
      while ($row = mysqli_fetch_array($fetchData)) { 
          
        $course = $row['class']." (".$row['crn'].")";
        $id = $row['crn'].",".$row['class'];
        $data[] = array("id"=>$id, "text"=>$course);
      
      }
      echo json_encode($data);

}
break;

case "get_inst_crns":{

    $anumber = $_POST['anumber'];
    if(empty($_POST['searchTerm'])){ 
        $fetchData = mysqli_query($link,"select class,crn from courses where anumber = '$anumber' ");
      }else{ 
        $search = explode(",", $_POST['searchTerm']);   
        // $fetchData = mysqli_query($link,"select class,crn from courses where crn like '%".$search."%' or class like '%".$search."%' ");
        $fetchData = mysqli_query($link,"select class,crn from courses where crn = '$search[0]' and anumber = '$anumber' ");
      } 
      
      $data = array();
      while ($row = mysqli_fetch_array($fetchData)) { 
          
        $course = $row['class']." (".$row['crn'].")";
        $id = $row['crn'].",".$row['class'];
        $data[] = array("id"=>$id, "text"=>$course);
      
      }
      echo json_encode($data);

}
break;


case "get_instructors_anum":{

    //if(!isset($_POST['searchTerm'])){ 
        $fetchData = mysqli_query($link,"select anumber, firstname from students where type ='instructor'");
     // }else{ 
        //$search = $_POST['searchTerm'];   
       // $fetchData = mysqli_query($link,"select anumber from students where type ='instructor' and anumber like '%".$search."%' or instructor like '%".$search."%' ");
     // } 
      
      $data = array();
      while ($row = mysqli_fetch_array($fetchData)) {    
          //$course = $row['anumber']." (".$row['anumber'].")";
        $data[] = array("id"=>$row['anumber'], "text"=>$row['anumber']);
      
      }
      echo json_encode($data);

}
break;


// case "get_instructor_name":{

//     //if(!isset($_POST['searchTerm'])){ 
//         $anumber = $_POST['inst_anumber'];
//         $fetchData = mysqli_query($link,"select anumber, firstname, lastname from students where anumber = '$anumber'");
//      // }else{ 
//         //$search = $_POST['searchTerm'];   
//        // $fetchData = mysqli_query($link,"select anumber from students where type ='instructor' and anumber like '%".$search."%' or instructor like '%".$search."%' ");
//      // } 
      
//       $data = array();
//       while ($row = mysqli_fetch_array($fetchData)) {    
//           //$course = $row['anumber']." (".$row['anumber'].")";
//         $data[] = array("firstname"=>$row['firstname'], "lastname"=>$row['lastname']);
      
//       }
//       echo json_encode($data);

// }
// break;
case "get_anumber_record":{

   
    $anumber = $_POST['inst_anumber'];
    $fetchData = mysqli_query($link,"select id, type, anumber, firstname, lastname, email, major, classification, crn from students where anumber = '$anumber'");
        
    $data = array();
    $option_str = "";
    $classname = "";
    $option = "";
    
    while ($row = mysqli_fetch_array($fetchData)) {  
    
        //crn comes in string of crns separted by commas.
        $crn_str = $row['crn'];
        //we will explode it into an array
        $crn_arr = explode(",",$crn_str);

        //foreach crn, query its classname and bulid a selected option string for select2
        foreach($crn_arr as $crn){

            //get class name from object returned from "get_crn_record" function
            // $record = get_crn_record($link, $crn);
            // $classname = $record['class'];

            $result = mysqli_query($link,"select class from courses where crn = '$crn'");

            while ($row1 = mysqli_fetch_array($result)) { 
                
               
                $classname = $row1['class'];
                
        
            }
            //build crn value str for select2 option id
            $select2_id = $crn .",". $classname;
            //build crn name str for select2 option text
            $select2_text = $classname." ( ". $crn ." )";

            //now build the options string
            $option = '<option selected="selected" value="'. $select2_id .'">'.$select2_text.'</option>';

            $option_str =$option_str.$option;

        }
    
    
        //$course = $row['anumber']." (".$row['anumber'].")";
        $data[] = array("id"=>$row['id'],"anumber"=>$row['anumber'],"type"=>$row['type'],"firstname"=>$row['firstname'], "lastname"=>$row['lastname'], "email"=>$row['email'], "crn"=>$option_str, "major"=>$row['major'], "classification"=>$row['classification']);
  
  }
  echo json_encode($data);

}
break;

case "get_instructor_record":{

   
        $anumber = $_POST['inst_anumber'];
        $fetchData = mysqli_query($link,"select id, anumber, firstname, lastname, email, crn, password from students where anumber = '$anumber'");
            
        $data = array();
        $option_str = "";
        
        while ($row = mysqli_fetch_array($fetchData)) {  
        
            //crn comes in string of crns separted by commas.
            $crn_str = $row['crn'];
            //we will explode it into an array
            $crn_arr = explode(",",$crn_str);

            //foreach crn, query its classname and bulid a selected option string for select2
            foreach($crn_arr as $crn){

                //get class name from object returned from "get_crn_record" function
                // $record = get_crn_record($link, $crn);
                // $classname = $record['class'];

                $result = mysqli_query($link,"select class from courses where crn = '$crn'");
    
                while ($row1 = mysqli_fetch_array($result)) { 
                    
                   
                    $classname = $row1['class'];
                    
            
                }
                //build crn value str for select2 option id
                $select2_id = $crn .",". $classname;
                //build crn name str for select2 option text
                $select2_text = $classname." ( ". $crn ." )";

                //now build the options string
                $option = '<option selected="selected" value="'. $select2_id .'">'.$select2_text.'</option>';

                $option_str =$option_str.$option;

            }
        
        
            //$course = $row['anumber']." (".$row['anumber'].")";
            $data[] = array("anumber"=>$row['anumber'], "id"=>$row['id'],"firstname"=>$row['firstname'], "lastname"=>$row['lastname'], "email"=>$row['email'], "crn"=>$option_str, "password"=>$row['password']);
      
      }
      echo json_encode($data);

}
break;

case "validate_get_attendance_test":{

    $type_str = "";
    $crn_str = "";

    $date_range = "";
    $start = "";
    $end = "";

    // $start = $_POST['from'];
    // $end = $_POST['to'];
    // $date_range = " and (date between '".$start."' and '".$end."') ";


    if(isset($_POST['type'])){

        $type_str = " on s.type = '". $_POST['type']."'";
    }

    if(isset($_POST['crn'])){

        $course = $_POST["crn"];

        $crn_arr = explode(",", $course);   
        $crn = $crn_arr[0];

        $crn_str = " and s.crn like '%". $crn."%'";
  
    }
    
    

    if(isset($_POST['from']) && isset($_POST['to'])){
        $start = $_POST['from'];
        $end = $_POST['to'];
        $date_range = " and (a.date between '".$start."' and '".$end."') ";
    }



            // get results from database
        // $result = mysqli_query($link,"SELECT DATE_FORMAT(date, '%d/%m/%Y' ) as date, type, anumber, firstname, lastname,time_in, time_out, memo FROM attendance ".$type_str." ".$date_range );



        $result = mysqli_query($link,"SELECT DATE_FORMAT(a.date, '%m/%d/%Y' ) as date,s.type, s.anumber, s.firstname, s.lastname, a.time_in, a.time_out, a.memo FROM attendance a INNER JOIN students s ". $type_str." and a.anumber = s.anumber ". $crn_str." ".$date_range);

        // or die(mysql_error());



        // display data in table

        echo '<table border="0" class="hover" id="table" style="width:80%">';

       echo "<thead> <tr> <th>Date</th> <th>Type</th> <th>A number</th>  <th>First Name</th> <th>Last Name</th>  <th>Time In</th> <th>Time Out</th> <th>Memo</th></tr> </thead> <tbody>";



        // loop through results of database query, displaying them in the table

        while($row = mysqli_fetch_array( $result )) {
        // fetch the contents of each row into a table
        echo "<tr>";
        echo '<td>' . $row['date'] . '</td>';
        echo '<td>' . $row['type'] . '</td>';
        echo '<td>' . $row['anumber'] . '</td>';
        echo '<td>' . $row['firstname'] . '</td>';
        echo '<td>' . $row['lastname'] . '</td>';
        echo '<td>' . $row['time_in'] . '</td>';
        echo '<td>' . $row['time_out'] . '</td>';
        echo '<td>' . $row['memo'] . '</td>';


        // echo '<td><a href="#?crn=' . $row['crn'] . '">Edit</a></td>';
        // echo '<td><a href="#?crn=' . $row['crn'] . '&confirm=0">Delete</a></td>';
         echo "</tr>";
        }



        // close table>
        echo "</tbody> </table>";


        ?>
           <script type="text/javascript" src="scripts.js"></script>
        <?php
}
break;


case "validate_get_attendance":{

    $type_str = "";

    $date_range = "";
    $start = "";
    $end = "";

    // $start = $_POST['from'];
    // $end = $_POST['to'];
    // $date_range = " and (date between '".$start."' and '".$end."') ";


    if(isset($_POST['type'])){

        $type_str = "where type = '". $_POST['type']."'";
    }

    if(isset($_POST['from']) && isset($_POST['to'])){
        $start = $_POST['from'];
        $end = $_POST['to'];
        $date_range = " and (date between '".$start."' and '".$end."') ";
    }



            // get results from database
        $result = mysqli_query($link,"SELECT DATE_FORMAT(date, '%d/%m/%Y' ) as date, type, anumber, firstname, lastname,time_in, time_out, memo FROM attendance ".$type_str." ".$date_range );

        // or die(mysql_error());



        // display data in table

        echo '<table border="0" class="hover" id="table" style="width:80%">';

       echo "<thead> <tr> <th>Date</th> <th>Type</th> <th>A number</th>  <th>First Name</th> <th>Last Name</th>  <th>Time In</th> <th>Time Out</th> <th>Memo</th></tr> </thead> <tbody>";



        // loop through results of database query, displaying them in the table

        while($row = mysqli_fetch_array( $result )) {
        // fetch the contents of each row into a table
        echo "<tr>";
        echo '<td>' . $row['date'] . '</td>';
        echo '<td>' . $row['type'] . '</td>';
        echo '<td>' . $row['anumber'] . '</td>';
        echo '<td>' . $row['firstname'] . '</td>';
        echo '<td>' . $row['lastname'] . '</td>';
        echo '<td>' . $row['time_in'] . '</td>';
        echo '<td>' . $row['time_out'] . '</td>';
        echo '<td>' . $row['memo'] . '</td>';


        // echo '<td><a href="#?crn=' . $row['crn'] . '">Edit</a></td>';
        // echo '<td><a href="#?crn=' . $row['crn'] . '&confirm=0">Delete</a></td>';
         echo "</tr>";
        }



        // close table>
        echo "</tbody> </table>";


        ?>
           <script type="text/javascript" src="scripts.js"></script>
        <?php
}
break;


case "validate_get_graph_data":{

    $type_str = "";

    $date_range = "";
    $start = "";
    $end = "";

     $anumber = $_POST['anumber'];
    // $end = $_POST['to'];
    // $date_range = " and (date between '".$start."' and '".$end."') ";


    if(isset($_POST['type'])){

        $type = $_POST['type'];
        //$type_str = "where type = '". $_POST['type']."'";
    }

    if(isset($_POST['from']) && isset($_POST['to'])){
        $start = $_POST['from'];
        $end = $_POST['to'];
        $date_range = " and (date between '".$start."' and '".$end."') ";
    }

     //determine with table to save to
     if($type==="tutor" || $type === "admin"){
        $table_name = "tutor_attendance";
    }else
        $table_name = "attendance";
  
    $result2 = mysqli_query($link,"
        SELECT date, SUM( time_out - time_in ) as total FROM ". $table_name ." WHERE anumber='$anumber' ".$date_range."
        group by date");
    // $result2 = mysqli_query($link,"
    // SELECT date, SUM( time_out - time_in ) as total FROM ". $table_name ." WHERE TIMESTAMPDIFF(DAY,date,now()) < 30 
    // and anumber='$anumber'
    // group by date");

        if(mysqli_num_rows($result2) > 0){
        while($row = mysqli_fetch_assoc($result2)){

            // get data from db
            $date[] =$row['date'];
            $total[] = round($row['total']/3600,2);

        }
        
        //display nothing on graph if no record is captured
        // if (!empty($date) || !empty($total)){
          
         $graph_result = []; 
         array_push($graph_result,$date);   
         array_push($graph_result,$total); 
         $graph_msg = "";
         echo json_encode($graph_result);
    }
    else{
            echo json_encode(["",""]);
            $graph_msg = "No Attendence Record available ";
    }

  
}
break;



case "validate_tutor_gen_graph_data":{

    $hours = []; 
    $username = [];
    $anum = [];

    if(isset($_POST['from']) && isset($_POST['to'])){
        $start = $_POST['from'];
        $end = $_POST['to'];
        $date_range = " and (date between '".$start."' and '".$end."') ";
    }

   

    
    // Selecting Database From Server.
        $query = mysqli_query($link,"select username,anumber from users where not position ='admin'", );

        // SQL query to fetch data to display in menu.
        while ($row  = mysqli_fetch_assoc($query)) {
            
            //get list of tutors in array for general graph
            array_push($username, $row['username']);
            $anumb = $row['anumber'];

            $result2 = mysqli_query($link," 
            SELECT sum(TIMESTAMPDIFF(SECOND, time_in, time_out)) as hours  FROM tutor_attendance WHERE anumber ='$anumb'  $date_range");

          
            if (mysqli_num_rows($result2) > 0) {
            
             while($row = mysqli_fetch_assoc($result2)){
        
                    // get data from db
                  
                    $total = round($row['hours']/3600,2);

                   
                    array_push($hours, $total);
                   
                    
                }
            } else {
                array_push($hours, 0);
            }
 
        }

       
        
            

            $graph_result = []; 
            array_push($graph_result, $username);   
        
            array_push($graph_result, $hours); 
            $graph_msg = "";
            
 //display nothing on graph if no record is captured
        // if (!empty($date) || !empty($total)){
          
        $a = ["jay", "emma"];
        $b = [1,4];
         
         //return $graph_result;
         echo json_encode($graph_result);
        // echo json_encode(["",""]);
         //echo json_encode([$a,$b]);
}break;
    
       
    
       

        



} 
 


}
    
    
?>