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
            .header-container {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 15px 30px;
                background-color: #2c3e50;
                color: white;
                box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            }
            .logo {
                font-size: 24px;
                font-weight: bold;
            }
            .logout-btn {
                background-color: #e74c3c;
                color: white;
                border: none;
                padding: 8px 15px;
                border-radius: 4px;
                cursor: pointer;
                text-decoration: none;
                display: inline-flex;
                align-items: center;
            }
            .logout-btn:hover {
                background-color: #c0392b;
                color: white;
                text-decoration: none;
            }
            .logout-btn i {
                margin-right: 5px;
            }
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




