<?php
    include 'helper.php';
	session_start();
   echo "<pre>";print_r($_POST);die;
	//get session vars required
	$studid = $_SESSION['studid'];
	$QpId = $_SESSION['QpId'];
	$correction_percent =  (int)$_POST['correction_percent']; 
	$candidateid = candidateuserid($studid);
	$factid = $_SESSION['FactId'];



	/**************************************************************************************/
	
	//create and check connection
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "paper_evaluation_db";

	$conn = new mysqli($servername, $username, $password, $dbname);

	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	
	
	
	//fetch courseid,marksids and remarksids from hidden text-fields
	$courseid 		= 	$_POST['courseid'];
	$marksids 		= 	explode('&',$_POST['marksids']);
	$remarksids 	= 	explode('&',$_POST['remarksids']);
	
	//echo "<pre>";print_r($_POST);die;
	//update marks in db
	foreach($marksids as $marksTBid){
		$marksTBid = trim($marksTBid);
		$idData = explode('_',$marksTBid);
		$qno = 	substr($idData[1],1);
		$sqno = substr($idData[2],2);
		$qid = substr($idData[3],3);
		
		//echo "UPDATE `pe_marks` SET `MarksPerQ`='{$_POST[$marksTBid]}' WHERE `StudId`='{$studid}' AND `QpId`='{$QpId}' AND `QId`='{$qid}';";die;
		// if($_POST[$marksTBid] == ''){
		// 	//do nothing
		// } else {
		// 	//update in db 
		// 	if ($conn->query("UPDATE `pe_marks` SET `MarksPerQ`='{$_POST[$marksTBid]}' WHERE `StudId`='{$studid}' AND `QpId`='{$QpId}' AND `QId`='{$qid}';") === TRUE) {
		// 		//ok
		// 		//echo "{$marksTBid}:{$_POST[$marksTBid]}";
		// 	} else {
		// 		echo "Error updating record: " . $conn->error;
		// 	}
		// }
		if($_POST[$marksTBid] !== '') {
            // Check if record exists
            $check = $conn->query("SELECT * FROM `pe_marks` WHERE `StudId`='{$studid}' AND `QpId`='{$QpId}' AND `QId`='{$qid}'");

			$evalution_endtime = date('Y-m-d H:i:s');
            
			$evalution_time = $conn->query(
				"UPDATE `useractions` 
				 SET `evalution_endtime` = '{$evalution_endtime}' 
				 WHERE `userid` = '{$factid}' AND `candidate_id` = '{$studid}'"
			);
            
			
			if($correction_percent == 100){
				$status = 'completed';
			   }else{
				   $status = 'in_process';
			   }
            if($check->num_rows > 0) {
                // Update existing record
                $sql = "UPDATE `pe_marks` SET `MarksPerQ`='{$_POST[$marksTBid]}' WHERE `StudId`='{$studid}' AND `QpId`='{$QpId}' AND `QId`='{$qid}'";
            
           
				
			} else {
                // Insert new record
                $sql = "INSERT INTO `pe_marks` (`StudId`, `QpId`,`CourseId`, `QId`, `MarksPerQ`) 
                        VALUES ('{$studid}', '{$QpId}', '{$courseid}', '{$qid}', '{$_POST[$marksTBid]}')";


            }
			date_default_timezone_set('Asia/Kolkata'); // or your preferred timezone

// Then get the current date and time
$date = date('Y-m-d H:i:s'); 
			

			$updateassignedstatus = $conn->query("UPDATE `pe_assign_candidates` 
    SET `status`='{$status}', 
        `evaluated_date`='{$date}' 
    WHERE `candidate_id`='{$candidateid}' 
    AND `invigilator_id`='{$factid}'");
         
			 if(!$updateassignedstatus){
				$success = false;
				$message .= "Error updating assigned status: " . $conn->error . "\n";
			 }
            if (!$conn->query($sql)) {
                $success = false;
                $message .= "Error updating marks: " . $conn->error . "\n";
			}
		}
		
	}
	

	// //update remarks in db
	// foreach($remarksids as $remarksTBid){
	// 	$remarksTBid = trim($remarksTBid);
	// 	$idData = explode('_',$remarksTBid);
	// 	$qno = 	substr($idData[1],1);
	// 	$sqno = substr($idData[2],2);
	// 	$qid = substr($idData[3],3);
		
	// 	//if($_POST[$remarksTBid] == ''){
	// 		//do nothing
	// 	//} else {
	// 		//update in db 
	// 		if ($conn->query("UPDATE `pe_marks` SET `Remarks`='{$_POST[$remarksTBid]}' WHERE `StudId`='{$studid}' AND `QpId`='{$QpId}' AND `QId`='{$qid}';") === TRUE) {
	// 			//ok
	// 		} else {
	// 			echo "Error updating record: " . $conn->error;
	// 		}
	// 	//}
		
	// }
	
	//update remarks in db
	foreach($remarksids as $remarksTBid){
		$remarksTBid = trim($remarksTBid);
        if(empty($remarksTBid)) continue;
        
		$idData = explode('_',$remarksTBid);
        $qno = substr($idData[1],1);
		$sqno = substr($idData[2],2);
		$qid = substr($idData[3],3);
        $remarks = trim($_POST[$remarksTBid] ?? '');

        // Check if record exists
        $check = $conn->query("SELECT * FROM `pe_marks` WHERE `StudId`='{$studid}' AND `QpId`='{$QpId}' AND `QId`='{$qid}'");
        
        if($check->num_rows > 0) {
            // Update existing record
            $sql = "UPDATE `pe_marks` SET `Remarks`=" . ($remarks === '' ? "NULL" : "'$remarks'") . " 
                    WHERE `StudId`='{$studid}' AND `QpId`='{$QpId}' AND `QId`='{$qid}'";
			} else {
            // Insert new record with empty marks
            // $sql = "INSERT INTO `pe_marks` (`StudId`, `QpId`,`CourseId`, `QId`, `QNo`, `SubQNo`, `MarksPerQ`, `Remarks`) 
            //         VALUES ('{$studid}', '{$QpId}', '{$courseid}', '{$qid}', '{$qno}', '{$sqno}', NULL, " . 
            // //         ($remarks === '' ? "NULL" : "'$remarks'") . ")";
			// $sql = "INSERT INTO `pe_marks` (`StudId`, `QpId`,`CourseId`, `QId`, `QNo`, `SubQNo`, `MarksPerQ`, `Remarks`) 
            //         VALUES ('{$studid}', '{$QpId}', '{$courseid}', '{$qid}', '{$qno}', '{$sqno}', NULL, " . 
            //         ($remarks === '' ? "NULL" : "'$remarks'") . ")";
        }
        
        if (!$conn->query($sql)) {
            $success = false;
            $message .= "Error updating remarks: " . $conn->error . "\n";
			}
	}
	
	$conn->close();
	
	//assign session vars and redirect page to HomePage of evaluator
	
	/*assign here***************************************************************************/
	
	$url = 'dashboard.php';
	if (headers_sent()){
		die('<script type="text/javascript">window.location.href="' . $url . '";</script>');
	}else{
		header('Location: dashboard.php');
		die();
	}













?>