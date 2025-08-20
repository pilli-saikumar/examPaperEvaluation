<?php
    session_start();
    include "config.php";
    include "constants.php";
    include "helper.php";
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
    <link rel="shortcut icon" href="<?php echo BASE_URL;?>assets/images/faces/profile.jfif" />
    
  
<!-- DataTables CSS -->
<!-- Bootstrap CSS (use same version as your layout) -->

!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Bootstrap Multiselect CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.15/css/bootstrap-multiselect.css" rel="stylesheet">
<!-- <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet"> -->

<!-- Bootstrap Multiselect CSS -->
<!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-multiselect@1.1.0/dist/css/bootstrap-multiselect.css">

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.15/css/bootstrap-multiselect.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.15/js/bootstrap-multiselect.min.js"></script> -->

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  Bootstrap CSS & JS
  <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script> -->

  <!-- Bootstrap Multiselect CSS & JS -->
  <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.15/css/bootstrap-multiselect.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.15/js/bootstrap-multiselect.min.js"></script> -->

        <style>
           .invigilator-list {
    border: 1px solid #ccc;
    height: 150px; /* Set a fixed height */
    overflow-y: scroll; /* Add a scrollbar */
    padding: 5px;
    background-color: #fff;
    border-radius: 4px;
}
.invigilator-list label {
    display: block; /* Each checkbox on a new line */
    margin-bottom: 5px;
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



