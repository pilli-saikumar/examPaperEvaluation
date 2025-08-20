<?php

	//fetch hidid from post
	$hidid = $_POST['hidid'];
	//$hidid = 'hid1';
	//create and check connection
	$servername = "127.0.0.1";
	$username = "root";
	$password = "";
	$dbname = "paper_evaluation_db";

	$conn = new mysqli($servername, $username, $password, $dbname);

	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	
	$str = '';
	//fetch imgsrcs 
	$result = $conn->query("SELECT * FROM `pe_candidate_answers` WHERE `registration_id`='{$hidid}'");
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$str = $str . $row['corrected_answer'] . ",";
		}
	} else {
		echo "0 results";
	}
	
	$str = substr($str,0,-1);
	
	echo $str;


?>