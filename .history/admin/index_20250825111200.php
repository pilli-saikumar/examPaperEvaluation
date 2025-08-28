<?php 
session_start();
include "config.php";
include "constants.php";
include "helper.php";
// include "header.php";

authenticateUser('login');
?>
<!DOCTYPE html>
<html>
    <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Skydash Admin</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="<?php echo BASE_URL;?>vendors/feather/feather.css">
    <link rel="stylesheet" href="<?php echo BASE_URL;?>vendors/ti-icons/css/themify-icons.css">
    <link rel="stylesheet" href="<?php echo BASE_URL;?>vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="<?php echo BASE_URL;?>vendors/datatables.net-bs4/dataTables.bootstrap4.css">
    <link rel="stylesheet" href="<?php echo BASE_URL;?>vendors/ti-icons/css/themify-icons.css">
    <link rel="stylesheet" type="text/css" href="<?php echo BASE_URL;?>assets/js/select.dataTables.min.css">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="<?php echo BASE_URL;?>assets/css/vertical-layout-light/style.css">
    <link rel="stylesheet" href="<?php echo BASE_URL;?>vendors/css/style.css">
    <!-- endinject -->
      <!-- Multiselect plugin CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.15/css/bootstrap-multiselect.css">
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> -->
   
    <link rel="shortcut icon" href="<?php echo BASE_URL;?>assets/images/faces/profile.jfif" />
    
<style>
   .page-body-wrapper{
   background: #f5f7ff;
   }
   .main-panel {
   width: 100% !important;
   }
</style>
<?php
    if(isset($_POST['saveChanges']) && $_POST['saveChanges'] == 'Submit'){
        $username   =   $_POST['username'];
        $password   =   $_POST['password'];
        $getData    =   mysqli_query($conn,'SELECT * FROM pe_admin WHERE username="'.$username.'" AND password="'.$password.'" ');
        //echo "<pre>";print_r($getData);die;
        if(mysqli_num_rows($getData) > 0){
            $getAdminData   =   mysqli_fetch_assoc($getData);
            if(!empty($getAdminData)){
                $_SESSION['logged_in']  =   true;
                $_SESSION['id']         =   $getAdminData['id'];
                $_SESSION['username']   =   $getAdminData['username'];
                $_SESSION['email']      =   $getAdminData['email'];
                $_SESSION['admin_type'] =   $getAdminData['admin_type'];
                if(!empty($getAdminData['admin_type']) && $getAdminData['admin_type'] == 'Super Admin'){
                 $insertAdminLog = mysqli_query($conn, "INSERT INTO `user_logs`(`user_id`, `role`,`login`, `ip_address`) VALUES ('".$getAdminData['id']."', '".$getAdminData['admin_type']."', '".date('Y-m-d H:i:s')."',  '".$_SERVER['REMOTE_ADDR']."')");
                 
                }
                
                redirect('dashboard.php');
            }
        }
    }
?>

<div class="container page-body-wrapper">
   <div class="main-panel">
      <div class="content-wrapper">
         <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6 colspan=3 grid-margin stretch-card">
               <div class="card">
                  <div class="card-body">
                     <h4 class="card-title">Login</h4>
                     <p class="card-description">
                        Enter your credentials to access your account.
                     </p>
                     <form class="forms-sample" name="loginForm" action="" method="post">
                        <div class="form-group">
                           <label for="exampleInputUsername1">Username</label>
                           <input name="username" type="text" class="form-control" id="exampleInputUsername1" placeholder="Username">
                        </div>
                        <div class="form-group">
                           <label for="exampleInputPassword1">Password</label>
                           <input name="password" type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                        </div>
                        <input type="submit" name="saveChanges" class="btn btn-primary mr-2" value="Submit">
                     </form>
                  </div>
               </div>
            </div>
            <div class="col-md-3"></div>
         </div>
      </div>
   </div>
</div>
<!-- page-body-wrapper ends -->
</div>
<!-- container-scroller -->
<!-- plugins:js -->
<?php include "footer.php";?>
