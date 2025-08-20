<?php
session_start();
$_SESSION['logged_in']  =   false;
$_SESSION['id']         =   '';
$_SESSION['FactId']     =   '';
$_SESSION['invigilator_name']   =   '';
$_SESSION['invigilator_email']      =   '';

// Insert logout log
$user_id = $_SESSION['FactId'];
$role = 'invigilator'; // Assuming the role is invigilator for this logout
$logout_time = date('Y-m-d H:i:s');
if(!empty($user_id)){
   $log_query = "UPDATE `user_logs` SET logout = '$logout_time' WHERE user_id = '$user_id' AND role = '$role' ";
   mysqli_query($conn, $log_query);
   
}



header('location:index.php');
?>