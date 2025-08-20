<?php
	
	define('UPLOAD_DIR', 'images/');
	$img = $_POST['imgDataURL'];
	$hidid = $_POST['hidid'];
	$imgid = $_POST['imgid'];
	$cursrc = $_POST['cursrc'];
	
	
	if (preg_match('/.*(-D)+.jpg/',$cursrc)){
		unlink($cursrc);
	}
	
	$cursrc = preg_replace('/\.jpeg|\.jpg/','',$cursrc);
	$filename = $cursrc . "-D.jpeg";
	$img = str_replace('data:image/jpeg;base64,', '', $img);
	$img = str_replace(' ', '+', $img);
	$data = base64_decode($img);
	//$file = UPLOAD_DIR . uniqid($prefix) . '.jpeg';
	$file = $filename ; 
	$success = file_put_contents($file, $data);
	//print $success ? $file : 'error';
	if($success){
		echo $file;
	}
	//create and check connection
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "paper_evaluation_db";

	$conn = new mysqli($servername, $username, $password, $dbname);

	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	
	
	//update imgpath in db 
	$conn->query("UPDATE `pe_candidate_answers` SET `corrected_answer`='{$file}' WHERE `registration_id`='{$hidid}' AND `id`='{$imgid}'");
	
	$conn->close();

	
?>
