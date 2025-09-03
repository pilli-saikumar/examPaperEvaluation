<?php
include "../config.php";

$subject_id = $_POST['subject_name'];

$getcandidateData = mysqli_query($conn,'SELECT * FROM `pe_candidates` WHERE `subject_id` = '.$subject_id.' ORDER BY id DESC');

// echo '<option value="">Select Question Paper</option>';

if(mysqli_num_rows($getcandidateData) > 0){
    while($candidateData = mysqli_fetch_assoc($getcandidateData)){
        echo '<option value="'.$candidateData['id'].'">'.$candidateData['registration_id'].'</option>';
    }
}else{
    echo '<div>No candidates found</div>';
}
