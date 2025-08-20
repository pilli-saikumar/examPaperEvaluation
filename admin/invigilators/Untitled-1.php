<?php
include "../header.php";

if(isset($_POST['subject_id']) && $_POST['subject_id'] != ''){
    $subject_id = $_POST['subject_id'];
    
    $response = [
        'invigilators' => '',
        'candidate_count' => 0
    ];
    
    $getInvigilatorData    =   mysqli_query($conn,'SELECT * FROM `pe_invigilators` WHERE subject='.$subject_id.' ORDER BY id DESC');
    if(mysqli_num_rows($getInvigilatorData) > 0){
        while($invigilatorData   =   mysqli_fetch_assoc($getInvigilatorData)){
            $invigilator[]       =    $invigilatorData;
        }
    }
    echo "<option value=''>Select Invigilator</option>";
    if(isset($invigilator) && !empty($invigilator)){foreach($invigilator as $invigilator){?>
    <option value="<?php echo $invigilator['id']?>"><?php echo ucfirst($invigilator['invigilator_name'])?></option>
    <?php }}?>
<?php
     $assignCandidate = [];
    $getAssignCandidateData    =   mysqli_query($conn,'SELECT * FROM `pe_assign_candidates` WHERE subject='.$subject_id.' ORDER BY id DESC');
    if(mysqli_num_rows($getAssignCandidateData) > 0){
        while($assignCandidateData   =   mysqli_fetch_assoc($getAssignCandidateData)){
            $assignCandidate[]       =    $assignCandidateData;
        }
    }

?>

<?php }?>         