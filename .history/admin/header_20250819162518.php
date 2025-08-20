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



