<?php
// function authenticateUser($pageType=''){
//     if($pageType == 'login'){
//         if(isset($_SESSION['id']) && empty($_SESSION['id'])){
//             return true;
//         }
//         else{
//             redirect('dashboard.php');
//         }
//     }
//     elseif($pageType == 'dashboard'){
//         if(isset($_SESSION['id']) && !empty($_SESSION['id'])){
//             return true;
//         }
//         else{
//             redirect('index.php');
//         }
//     }
// }

function redirect($url=''){
    header('location:'.$url);
}

function getSubjectName($subjectId){
    global $conn;
    $getSubjectData    =   mysqli_query($conn,'SELECT * FROM `pe_question_paper` where id='.$subjectId.' ');
    if(mysqli_num_rows($getSubjectData) > 0){
        $subject       =    mysqli_fetch_assoc($getSubjectData);
    } 
    return $subject['subject_name'] ?? '';
}
?>