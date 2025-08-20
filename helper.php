<?php
include 'config.php';
function authenticateUser($pageType=''){
    // if($pageType == 'login'){
    //     if(isset($_SESSION['id']) && empty($_SESSION['id'])){
    //         return true;
    //     }
    //     else{
    //         redirect('dashboard.php');
    //     }
    // }
    // elseif($pageType == 'dashboard'){
    //     if(isset($_SESSION['id']) && !empty($_SESSION['id'])){
    //         return true;
    //     }
    //     else{
    //         redirect('index.php');
    //     }
    // }
    return true;
}

function redirect($url=''){
    header('location:'.$url);
}

function candidateuserid($registration_id){
	global $conn;
	$result = $conn->query("SELECT * FROM `pe_candidates` WHERE `registration_id`='{$registration_id}'");
	if ($result->num_rows > 0) {
		if($row = $result->fetch_assoc()){
			return $row['id'];
		}
	}
}
?>