
<?php 

        $fname="";
        $lname="";
        $email="";
        $email2="";
        $password="";
        $password2="";
        $date="";
        $error_array=array();

    if(isset($_POST['register_button'])){
        $fname=strip_tags($_POST['reg_fname']);
        $fname=str_replace(' ', '',$fname);
        $fname=ucfirst(strtolower($fname));
        $_SESSION['reg_fname'] = $fname;

        $lname=strip_tags($_POST['reg_lname']);
        $lname=str_replace(' ', '',$lname);
        $lname=ucfirst(strtolower($lname));
        $_SESSION['reg_lname'] = $lname;
        
        $email=strip_tags($_POST['reg_email']);
        $email=str_replace(' ', '',$email);
        $email=ucfirst(strtolower($email));
        $_SESSION['reg_email'] = $email;
        
        $email2=strip_tags($_POST['reg_email2']);
        $email2=str_replace(' ', '',$email2);
        $email2=ucfirst(strtolower($email2));
        $_SESSION['reg_email2'] = $email2;
        
        $password=strip_tags($_POST['reg_password']);
      
       
        $password2=strip_tags($_POST['reg_password2']);
       

        $date = date("Y-m-d");

    if($email==$email2){
        if(filter_var($email, FILTER_VALIDATE_EMAIL)){
            
            $email=filter_var($email, FILTER_VALIDATE_EMAIL);

            $e_check= mysqli_query($con, "SELECT email FROM users WHERE email='$email'");

           $num_rows = mysqli_num_rows($e_check); 

           if($num_rows > 0){
               array_push($error_array, "Email already in use<br>");
           }
            }else{
                array_push($error_array, "Invalid email Format<br>");
        }
             }else{
                array_push($error_array, "Emails do not match<br>");
    }

    if(strlen($fname) > 23 || strlen($fname) < 2){
        array_push($error_array, "Your first name must be between 2 and 25 characters<br>");
    }
    if(strlen($lname) > 23 || strlen($lname) < 2){
        array_push($error_array, "Your last name must be between 2 and 25 characters<br>");
    }
    if($password != $password2){
        array_push($error_array, "Your passwords do not match<br>");
    } else {
    if(preg_match('/[^A-Za-z0-9]/', $password)){
        array_push($error_array, "Your password can only contain english characters or numbers<br>");
    }

    }

    if(strlen($password) > 30 || strlen($password) < 5) {
        array_push($error_array,  "Your password must be between 5 and 30 characters<br>");
    }
    if(empty($error_array)) {
        $password = md5($password);

        $username = strtolower($fname."_".$lname);
        $check_username_query = mysqli_query($con, "SELECT username FROM users WHERE username='$username'");

        $i = 0;
        while(mysqli_num_rows($check_username_query) != 0){
            $i++;
            $username=$username."_".$i;
            $check_username_query=mysqli_query($con, "SELECT username FROM users WHERE username='$username'");
        }
        $random=rand(1,2);

        if($random==1)
             $profile_pic="assets/images/profile_pics/defaults/head_deep_blue.png";
        else if ($random==2)
             $profile_pic="assets/images/profile_pics/defaults/head_emarald.png";

             $query=mysqli_query($con, "INSERT INTO users VALUES ('','$fname', '$lname', '$username', '$email', '$password', '$date', '$profile_pic', '0', '0', 'no', ',')");

             array_push($error_array, "<span style='color: #14c800;'>You're all set! Go ahead and Login!</span<br>");

             $_SESSION['reg_fname']= "";
             $_SESSION['reg_lname']= "";
             $_SESSION['reg_email']= "";
             $_SESSION['reg_email2']= "";
    }
}
?>