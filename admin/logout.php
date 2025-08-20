<?php
session_start();
include_once "config.php";
if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true){
  $userlogout = mysqli_query($conn, "UPDATE `user_logs` SET `logout` = '".date('Y-m-d H:i:s')."' WHERE user_id = '".$_SESSION['id']."'");
}
$_SESSION['logged_in']  =   false;
$_SESSION['id']         =   '';
$_SESSION['username']   =   '';
$_SESSION['email']      =   '';
$_SESSION['admin_type'] =   '';




header('location:index.php');
?>