<?php 
include "../config.php";
include "../constants.php";
include "../helper.php";
if(isset($_GET['id']) && !empty($_GET['id'])){
    //echo "<script>confirm('Are you sure?');</script>";
    $getCandidateData    =   mysqli_query($conn,'SELECT uploaded_answer FROM pe_candidate_answers WHERE id='.$_GET['id'].'');
    if(mysqli_num_rows($getCandidateData) > 0){
        while($candidateData   =   mysqli_fetch_assoc($getCandidateData)){
            unlink($candidateData['uploaded_answer']);
            mysqli_query($conn,'DELETE FROM pe_candidate_answers WHERE id='.$_GET['id'].'');
        }
    }
    
    echo "<script>alert('Deleted data successfully.');window.location.href='../uploadanswers/candidate_answers.php'</script>";
    //redirect(BASE_URL.'uploadanswers/candidate_answers.php');
}
if(isset($_GET['cid']) && !empty($_GET['qid']) && isset($_GET['qid']) && !empty($_GET['qid'])){
    //echo "<script>confirm('Are you sure?');</script>";
    $getCandidateData    =   mysqli_query($conn,'SELECT uploaded_answer FROM pe_candidate_answers WHERE registration_id='.$_GET['cid'].' AND question_paper_id='.$_GET['qid'].'');
    if(mysqli_num_rows($getCandidateData) > 0){
        while($candidateData   =   mysqli_fetch_assoc($getCandidateData)){
            unlink($candidateData['uploaded_answer']);
            mysqli_query($conn,'DELETE FROM pe_candidate_answers WHERE registration_id='.$_GET['cid'].' AND question_paper_id='.$_GET['qid'].' ');
        }
    }
    echo "<script>alert('Deleted data successfully.');window.location.href='../uploadanswers/candidate_answers.php'</script>";
    //redirect(BASE_URL.'uploadanswers/candidate_answers.php');
}
?>
