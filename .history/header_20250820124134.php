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
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Bootstrap JS if using Bootstrap's alert functionality -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
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




