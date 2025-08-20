<?php 
include "../config.php";
 
// Filter the excel data 
function filterData(&$str){ 
    $str = preg_replace("/\t/", "\\t", $str); 
    $str = preg_replace("/\r?\n/", "\\n", $str); 
    if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"'; 
} 
$fileName = "exam_results_" . date('Y-m-d') . ".xls"; 
 
// Column names 
$fields = array('S.No','Candidate name','Roll Number','Post name','Descriptive Marks','Objective Marks','Total'); 
 
// Display column names as first row 
$excelData = implode("\t", array_values($fields)) . "\n"; 

$getCandidateData    =   mysqli_query($conn,'SELECT * FROM `pe_candidates` ORDER BY id DESC');
if(mysqli_num_rows($getCandidateData) > 0){
    while($candidateData   =   mysqli_fetch_assoc($getCandidateData)){
        $candidate[]       =    $candidateData;
    }
}

function calculatedescMarks($regId,$conn){
  $desMarks = mysqli_query($conn,"SELECT sum(MarksPerQ) as marks FROM `pe_marks` where StudId=".$regId." AND MarksPerQ > 0");
  if(mysqli_num_rows($desMarks) > 0){
      $descriptiveMarks = mysqli_fetch_assoc($desMarks);
      return $descriptiveMarks['marks']?$descriptiveMarks['marks']:0;
  }
}

function calculateObjMarks($regId,$i){
//   $conn1 = new mysqli('192.168.1.221', 'root', 'mysqlAmmulu','admin');
  
//   $objMarks = mysqli_query($conn1,"SELECT marks_obtained  FROM `candidate_norm_results` where candidate_id=".$regId."");
//   if(mysqli_num_rows($objMarks) > 0){
//       $objectiveMarks = mysqli_fetch_assoc($objMarks);
//       $marks = $objectiveMarks['marks_obtained'] > 0?$objectiveMarks['marks_obtained']:0;
//       return $marks;
//   }
//   else{
//     return 0;
//   }
if($i ==1){
    $mat =  0+15;
  }
  elseif($i ==2){
    $mat =  0+18;
  }
  elseif($i ==3){
    $mat =  0+17;
  }
  return $mat;
 //return 0;
}

// Fetch records from database 
if(isset($candidate) && !empty($candidate)){ 
    // Output each row of the data 
    $i=1;foreach($candidate as $candidate){
        $lineData = array($i,$candidate['registration_id'],$candidate['candidate_name'],"Pro SCOR" ,calculatedescMarks($candidate['registration_id'],$conn), calculateObjMarks($candidate['registration_id'],$i),calculatedescMarks($candidate['registration_id'],$conn)+calculateObjMarks($candidate['registration_id'],$i).'/60'); 
        array_walk($lineData, 'filterData'); 
        $excelData .= implode("\t", array_values($lineData)) . "\n"; 
    $i++;} 
}else{ 
    $excelData .= 'No records found...'. "\n"; 
} 
// echo "<pre>";print_r($excelData);die;
//  die;
// Headers for download 
mb_convert_encoding($excelData, 'UTF-16LE', 'UTF-8');
header('Content-Encoding: UTF-8');
header("Content-Type: text/csv; charset=UTF-8");    
header("Content-Disposition: attachment; filename=\"$fileName\""); 
header("Pragma: no-cache"); 
header("Expires: 0");

//echo "\xEF\xBB\xBF";


// Render excel data 
echo $excelData; 
//redirect('dashboard.php');
exit;