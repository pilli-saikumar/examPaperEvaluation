<?php
    session_start();
    include "config.php";
    include "constants.php";
    include "helper.php";
    if(!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true){
        redirect('.php');
    }

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
        select[multiple] {
            min-height: 150px;
        }
        .invigilator-list {
            border: 1px solid #ccc;
            height: 150px;
            overflow-y: auto;
            padding: 10px;
            margin-top: 5px;
            border-radius: 4px;
        }
    </style>
    </head>
    <body>
    <div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
        <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
        <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
            <h4>Exam Paper Evaluation</h4>
        </div>
        <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
            
            
            <ul class="navbar-nav navbar-nav-right">
            
            <li class="nav-item nav-profile dropdown">
                <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
                <img src="<?php echo BASE_URL;?>assets/images/faces/profile.jfif" alt="profile"/>
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
                
                <a class="dropdown-item" href="<?php echo BASE_URL;?>logout.php">
                    <i class="ti-power-off text-primary"></i>
                    Logout
                </a>
                </div>
            </li>
            
            </ul>
            
        </div>
        </nav>
