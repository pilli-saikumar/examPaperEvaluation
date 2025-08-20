<?php 
include "../config.php";
include "../constants.php";
include "../helper.php";

if(isset($_GET['uid']) && !empty($_GET['uid'])){
    mysqli_query($conn,'DELETE FROM pe_invigilators WHERE id='.$_GET['uid'].' ');
    echo "<script>alert('Deleted data successfully.');window.location.href='../invigilators/invigilators.php'</script>";
    //redirect(BASE_URL.'uploadanswers/candidate_answers.php');
}
?>
