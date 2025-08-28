

<?php
include "../config.php";

if(isset($_POST['exam_id']) && $_POST['exam_id'] != ''){
    $exam_id = intval($_POST['exam_id']);
    $subject_id = intval($_POST['subject_id']);
    
    
    // Get invigilators
    $getInvigilatorData = mysqli_query($conn, 'SELECT * FROM `pe_invigilators` WHERE subject ='.$exam_id.' ORDER BY id DESC');
    $output = '';
   // $output .= "<option value=''>Select Invigilator</option>";
    
    // if(mysqli_num_rows($getInvigilatorData) > 0) {
    //     while($invigilator = mysqli_fetch_assoc($getInvigilatorData)) {
    //         $output .= "<option value='".$invigilator['id']."'>".ucfirst($invigilator['invigilator_name'])."</option>";
    //     }
    // }

    if($getInvigilatorData){
        while($invigilator = mysqli_fetch_assoc($getInvigilatorData)) {
           
        }
    }
    
    // Add a special marker to separate invigilators and count
    $output .= "||COUNT||";
    
    // Get candidate count
    $count = 0;
    $countResult = mysqli_query($conn, 'SELECT COUNT(*) as total FROM `pe_candidates` WHERE subject_id='.$exam_id);
    if($countResult) {
        $row = mysqli_fetch_assoc($countResult);
        $count = $row['total'];
    }
    $output .= $count;

// $output .= "||COUNTCANDIDATE||";
//     $countcandidate = 0;
//     $countcandidateResult = mysqli_query($conn, 'SELECT DISTINCT COUNT(registration_id) as total FROM `pe_candidate_answers` WHERE question_paper_id='.$exam_id);
//     if($countcandidateResult) {
//         $row = mysqli_fetch_assoc($countcandidateResult);
//         $countcandidate = $row['total'];
//     }
//     $output .= $countcandidate;



    // $availableInvigilators = mysqli_query($conn, 'SELECT * FROM `pe_assign_candidates` WHERE subject_id='.$subject_id.' ORDER BY id DESC');
    // $availableInvigilatorsCount = mysqli_num_rows($availableInvigilators);
    //  $availableInvigilatorsCount - $count;

    


    
    echo $output;
    exit;
}


// if(isset($_POST['invigilator_id']) && $_POST['invigilator_id'] != ''){
//     $invigilator_id = intval($_POST['invigilator_id']);
    
//     // Get invigilators
//     $getInvigilatorData = mysqli_query($conn, 'SELECT COUNT(candidate_id) as total FROM `pe_assign_candidates` WHERE invigilator_id='.$invigilator_id.' ORDER BY id DESC');
//      if($getInvigilatorData){
//         $row = mysqli_fetch_assoc($getInvigilatorData);
//         $count = $row['total'];
//     }



//     echo $count;
//     exit;
// }

?>