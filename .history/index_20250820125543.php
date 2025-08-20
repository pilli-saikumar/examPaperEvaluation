<?php 
include "co"
?>
<!DOCTYPE html>
<html>
    <head>
        <title>EXAM PAPER EVALUATION</title>
        <link rel="stylesheet" href="<?php echo BASE_URL;?>assets/css/style.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Bootstrap JS if using Bootstrap's alert functionality -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<style>
   .container {
   display: grid;
   grid-template-rows: minmax(min-content, 100vh);
   }
</style>
<?php
    if(isset($_POST['saveChanges']) && $_POST['saveChanges'] == 'Login'){
        //echo "<pre>";print_r($_POST);die;
        $username   =   $_POST['username'];
        $password   =   md5($_POST['password']);
        $getData    =   mysqli_query($conn,'SELECT * FROM pe_invigilators WHERE invigilator_email="'.$username.'" AND password="'.$password.'" ');
       // echo "<pre>";print_r($getData);die;
        if(mysqli_num_rows($getData) > 0){
            $getAdminData   =   mysqli_fetch_assoc($getData);
            if(!empty($getAdminData)){
                $_SESSION['logged_in']          =   true;
                $_SESSION['FactId']             =   $getAdminData['id'];
                $_SESSION['invigilator_name']   =   $getAdminData['invigilator_name'];
                $_SESSION['invigilator_email']  =   $getAdminData['invigilator_email'];
                redirect('dashboard.php');
            }
        }
    }
?>
<div class="container">
   <main class="signup-container">
      <h1 class="heading-primary">Log in<span class="span-blue">.</span></h1>
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