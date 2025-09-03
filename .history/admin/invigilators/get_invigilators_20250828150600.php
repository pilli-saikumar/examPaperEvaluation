

<?php
include "../config.php";

if(isset($_POST['exam_id']) && $_POST['exam_id'] != ''){
    $exam_id = intval($_POST['exam_id']);
    $subject_id = intval($_POST['subject_id']);
 
    
    
    // Get invigilators
   // $getInvigilatorData = mysqli_query($conn, 'SELECT * FROM `pe_invigilators` WHERE subject ='.$exam_id.' ORDER BY id DESC');
    $getInvigilatorData = mysqli_query($conn, 'SELECT * FROM `pe_invigilators` WHERE subject ='.$exam_id.' AND exam_id ='.$exam_id.' ORDER BY id DESC');
    $output = '';
   // $output .= "<option value=''>Select Invigilator</option>";
    
    // if(mysqli_num_rows($getInvigilatorData) > 0) {
    //     while($invigilator = mysqli_fetch_assoc($getInvigilatorData)) {
    //         $output .= "<option value='".$invigilator['id']."'>".ucfirst($invigilator['invigilator_name'])."</option>";
    //     }
    // }

    // if($getInvigilatorData){
    //     while($invigilator = mysqli_fetch_assoc($getInvigilatorData)) {
    //         $output .= "<option value='".$invigilator['id']."'>".ucfirst($invigilator['invigilator_name'])."</option>";
    //     }
    // }
    // if($getInvigilatorData){
    //     while($invigilator = mysqli_fetch_assoc($getInvigilatorData)) {
    //        $output .= "<div class='form-check'>";
    //        $output .= "<input class='form-check-input' type='checkbox' name='invigilator_id[]' value='".$invigilator['id']."'>";
    //        $output .= "<label class='form-check-label' for='flexCheckDefault'>".ucfirst($invigilator['invigilator_name'])."</label>";
    //        $output .= "</div>";
    //     }
    // }
     $output = '';
if ($getInvigilatorData) {
    $output .= "<div class='card shadow-sm p-3'>";
    $output .= "<div class='form-check mb-2 border-bottom pb-2 ml-2'>";
    $output .= "<input class='form-check-input ml-2' type='checkbox' id='selectAllInvigilators'>";
    $output .= "<label class='form-check-label fw-bold ms-2' for='selectAllInvigilators'>Select All Invigilators</label>";
    $output .= "</div>";

    $output .= "<div class='invigilator-list' style='max-height: 200px; overflow-y: auto;'>";
    while ($invigilator = mysqli_fetch_assoc($getInvigilatorData)) {
        $output .= "<div class='form-check mb-2 '>";
        $output .= "<input class='form-check-input invigilator-checkbox ml-2' type='checkbox' name='invigilator_id[]' value='".$invigilator['id']."' id='invigilator_".$invigilator['id']."'>";
        $output .= "<label class='form-check-label ms-2 ml-4 fw-bold' for='invigilator_".$invigilator['id']."'>".ucfirst($invigilator['invigilator_name'])."</label>";
        $output .= "</div>";
    }
    $output .= "</div></div>";
}
// if ($getInvigilatorData) {
//     $output .= "<div class='card shadow-sm p-3'>";

//     // Select All checkbox
//     $output .= "<div class='form-check mb-3 border-bottom pb-2 ml-2'>";
//     $output .= "<input class='form-check-input text-center ml-2' type='checkbox' id='selectAllInvigilators'>";
//     $output .= "<label class='form-check-label fw-bold ms-2' for='selectAllInvigilators'>Select All Invigilators</label>";
//     $output .= "</div>";

//     // Grid layout container
//     $output .= "<div class='invigilator-list' style='max-height: 200px; overflow-y: auto;'>";
//     $output .= "<div class='row'>";

//     $count = 0;
//     while ($invigilator = mysqli_fetch_assoc($getInvigilatorData)) {
//         $output .= "<div class='col-md-4 mb-2'>";  // 3 columns per row
//         $output .= "<div class='form-check ml-2'>";
//         $output .= "<input class='form-check-input ml-2 invigilator-checkbox' type='checkbox' name='invigilator_id[]' value='".$invigilator['id']."' id='invigilator_".$invigilator['id']."'>";
//         $output .= "<label class='form-check-label ms-2' for='invigilator_".$invigilator['id']."'>".ucfirst($invigilator['invigilator_name'])."</label>";
//         $output .= "</div>";
//         $output .= "</div>";

//         $count++;
//         if ($count % 3 == 0) {
//             $output .= "</div><div class='row'>"; // start new row after 3 items
//         }
//     }

//     $output .= "</div>"; // close last row
//     $output .= "</div>"; // close invigilator-list
//     $output .= "</div>"; // close card
// }
    // Add a special marker to separate invigilators and count
    $output .= "||COUNT||";
    
    // Get candidate count
    $count = 0;
    $countResult = mysqli_query($conn, 'SELECT COUNT(*) as total FROM `pe_candidates` WHERE subject_id='.$subject_id .' AND exam_id='.$exam_id);
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