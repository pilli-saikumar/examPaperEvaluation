<?php
session_start();
$_SESSION['logged_in']  =   false;
$_SESSION['id']         =   '';
$_SESSION['FactId']     =   '';
$_SESSION['invigilator_name']   =   '';
$_SESSION['invigilator_email']      =   '';
header('location:index.php');
?>