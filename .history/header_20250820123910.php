<?php
    session_start();
    include "config.php";
    include "constants.php";
    include "helper.php";
?>
<!DOCTYPE html>
<html>
    <head>
        <title>EXAM PAPER EVALUATION</title>
        <link rel="stylesheet" href="<?php echo BASE_URL;?>assets/css/style.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js" defer></script>
        <link rel="stylesheet" href="<?php echo BASE_URL;?>assets/css/vertical-layout-light/style.css">
    <link rel="stylesheet" href="<?php echo BASE_URL;?>vendors/css/style.css">
    <!-- endinject -->
    <link rel="shortcut icon" href="<?php echo BASE_URL;?>assets/images/faces/profile.jfif" />
    </head>
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




