<?php
if($_SERVER['HTTP_HOST'] == 'localhost'){
    $servername     =   "localhost";
    $username       =   "root";
    $password       =   "";
    $database       =   "paper_evaluation_db";
}
else{
    $servername     =   "localhost";
    $username       =   "root";
    $password       =   "";
    $database       =   "paper_evaluation_db";
}
$conn = new mysqli($servername, $username, $password,$database);
if($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
?>