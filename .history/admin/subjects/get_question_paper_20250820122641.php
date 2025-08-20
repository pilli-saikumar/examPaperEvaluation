<?php
include ""

$exam_name = $_POST['exam_name'];

$getQuestionPaperData = mysqli_query($conn,'SELECT * FROM `pe_question_paper` WHERE `exam_id` = '.$exam_name.' ORDER BY id DESC');

echo '<option value="">Select Question Paper</option>';

if(mysqli_num_rows($getQuestionPaperData) > 0){
    while($questionPaperData = mysqli_fetch_assoc($getQuestionPaperData)){
        echo '<option value="'.$questionPaperData['id'].'">'.$questionPaperData['question_paper'].'</option>';
    }
}else{
    echo '<div>No question papers found</div>';
}
?>