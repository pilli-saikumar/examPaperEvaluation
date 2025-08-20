<?php 
include "../config.php";
include "../constants.php";
include "../helper.php";

if(isset($_GET['uid']) && !empty($_GET['uid']) && isset($_GET['iid']) && !empty($_GET['iid'])){
    //echo 'DELETE FROM pe_assign_candidates WHERE candidate_id='.$_GET['uid'].' AND invigilator_id='.$_GET['iid'].' ';die;
    mysqli_query($conn,'DELETE FROM pe_assign_candidates WHERE candidate_id='.$_GET['uid'].' AND invigilator_id='.$_GET['iid'].' ');
    echo "<script>alert('Deleted data successfully.');window.location.href='../invigilators/invigilators.php'</script>";
    //redirect(BASE_URL.'uploadanswers/candidate_answers.php');
}
?>
