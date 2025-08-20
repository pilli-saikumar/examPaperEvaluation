<?php 
include "../config.php";
include "../constants.php";
include "../helper.php";

$getCandidateData    =   mysqli_query($conn,'SELECT * FROM `pe_candidates`');
if(mysqli_num_rows($getCandidateData) > 0){
    while($candidateData   =   mysqli_fetch_assoc($getCandidateData)){
        $getQuestionData    =   mysqli_query($conn,'SELECT * FROM `pe_qpapers` where QPId=1');
        if(mysqli_num_rows($getQuestionData) > 0){
            while($questions   =   mysqli_fetch_assoc($getQuestionData)){
                $sql = "INSERT INTO `pe_marks`(`StudId`, `HidId`, `QpId`, `CourseId`, `QId`, `MarksPerQ`) VALUES 
                ('".$candidateData['registration_id']."','".$candidateData['id']."','1','1','".$questions['QId']."','-1')";
                $insertData        =   mysqli_query($conn,$sql);
            }
        }
    }
    redirect(BASE_URL.'candidates/index.php');
}


?>
