
<?php 
date_default_timezone_set('Asia/Kolkata');
include "header.php";

?>
<style>
   .container {
   display: grid;
   grid-template-rows: minmax(min-content, 100vh);
   }
</style>
<?php
    if(isset($_POST['saveChanges']) && $_POST['saveChanges'] == 'Login'){

        $username   =   $_POST['username'];
        $password   =   md5($_POST['password']);
        $getData    =   mysqli_query($conn,'SELECT * FROM pe_invigilators WHERE invigilator_email="'.$username.'" AND password="'.$password.'" ');
    
        if(mysqli_num_rows($getData) > 0){
            $getAdminData   =   mysqli_fetch_assoc($getData);
               
            if(!empty($getAdminData)){
                $_SESSION['logged_in']          =   true;
                $_SESSION['FactId']             =   $getAdminData['id'];
                $_SESSION['invigilator_name']   =   $getAdminData['invigilator_name'];
                $_SESSION['invigilator_email']  =   $getAdminData['invigilator_email'];
       // Insert login log
                $user_id = $getAdminData['id'];
                $role = 'invigilator'; // Assuming the role is invigilator for this login
                $login_time = date('Y-m-d H:i:s');
                $ip_address = $_SERVER['REMOTE_ADDR'];
                
                $log_query = "INSERT INTO `user_logs` (user_id, role, login, ip_address) 
                                VALUES ('$user_id', '$role', '$login_time', '$ip_address')";
                mysqli_query($conn, $log_query);
                
       
                redirect('dashboard.php');
            }
        }   
    }
?>
<div class="container">
   <main class="signup-container">
      <h1 class="heading-primary">Log ins<span class="span-blue">.</span></h1>
      <p class="text-mute">Enter your credentials to access your account.</p>
      <form class="signup-form" name="loginForm" id="loginForm"  action="" method="post" autocomplete="off">
         <label class="inp">
         <input autocomplete="off" type="text" name="username" id="username" class="input-text" placeholder="&nbsp;" required>
         <span class="label">Email</span>
         <span class="input-icon"><i class="fa-solid fa-envelope"></i></span>
         </label>
         <label class="inp">
         <input autocomplete="off" type="password" name="password" id="password" class="input-text" placeholder="&nbsp;" required>
         <span class="label">Password</span>
         <span class="input-icon input-icon-password" data-password><i class="fa-solid fa-eye"></i></span>
         </label>
         <input type="submit" class="btn btn-login btn-primary" value="Login" name="saveChanges">
      </form>
   </main>
   <div class="welcome-container">
      <h1 class="heading-secondary">Exam Paper <span class="lg">Evaluation</span></h1>
   </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
<script>
    $('#loginForm').validate({
    });
</script>
<?php include "footer.php";?>