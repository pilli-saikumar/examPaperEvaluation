<?php

include "header.php";
include "mainheader.php";

?>

<?php
$getCandidateData    =   mysqli_query($conn,'SELECT c.*,ac.* FROM `pe_candidates` as c JOIN pe_assign_candidates as ac ON ac.candidate_id = c.id WHERE ac.invigilator_id ='.$_SESSION['FactId'].' ');


$candidate = array();
$uploadedCount = 0;
$evaluatedCount = 0;
if(mysqli_num_rows($getCandidateData) > 0){
    while($candidateData   =   mysqli_fetch_assoc($getCandidateData)){
       
        $candidate[]       =    $candidateData;
        $uploadedCount     =    count($candidate);
        if($candidateData['status'] == 'completed'){
            $evaluatedCount++;
        }
    
      
       
        
    }
}

function calculatedescMarks($regId,$conn){
  $desMarks = mysqli_query($conn,"SELECT sum(MarksPerQ) as marks FROM `pe_marks` where StudId=".$regId." AND MarksPerQ > 0");
  if(mysqli_num_rows($desMarks) > 0){
      $descriptiveMarks = mysqli_fetch_assoc($desMarks);
      return $descriptiveMarks['marks']?$descriptiveMarks['marks']:0;
  }
}

function calculateTotalMarks($subjectId,$conn){
  $totalMarks = mysqli_query($conn,"SELECT sum(MaxMarks) as totalMarks FROM `pe_qpapers` where CourseId=".$subjectId." AND MaxMarks > 0");
  if(mysqli_num_rows($totalMarks) > 0){
      $totalMarks = mysqli_fetch_assoc($totalMarks);
      return $totalMarks['totalMarks']?$totalMarks['totalMarks']:0;
  }
}

function getsubjectName($subjectId,$conn){
    $subjectName = mysqli_query($conn,"SELECT question_paper FROM `pe_question_paper` where id=".$subjectId);
    if(mysqli_num_rows($subjectName) > 0){
        $subjectName = mysqli_fetch_assoc($subjectName);
        return $subjectName['question_paper']?$subjectName['question_paper']:'N/A';
    }
}
?>
<div class="container">
	<div id="projectFacts" class="sectionClass">
	    <div class="fullWidth eight columns">
	        <div class="projectFactsWrap ">
	            <div class="item" data-number="" style="visibility: visible;">
	                <p id="number1" class="number"><?php echo $uploadedCount?></p>
	                <span></span>
	                <p>Uploaded</p>
	            </div>
	            <div class="item" data-number="" style="visibility: visible;">
	                <p id="number2" class="number"><?php echo $evaluatedCount?></p>
	                <span></span>
	                <p>Evaluated</p>
	            </div>
	            <div class="item" data-number="" style="visibility: visible;">
	                <p id="number3" class="number"><?php echo $uploadedCount-$evaluatedCount?></p>
	                <span></span>
	                <p>Remaining</p>
	            </div>
	            
	        </div>
	    </div>
	</div>
</div>

<?php if(isset($_SESSION['msg'])):?>
<div class="alert alert-danger "  role="alert">
    <?php echo $_SESSION['msg'];?>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<?php unset($_SESSION['msg']);?>
<?php endif;?>

<div class="container">
    <table class="table table-bordered">
        <thead>
          <tr class="bg-primary">
            <th>S.NO</th>
            <th>Registration Id</th>
            <th>Subject</th>
            <th>Status</th>
            <th>Evaluated Date</th>
            <th>Total Marks</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
        <?php if($candidate){$i=1;foreach($candidate as $candi){?>
          <tr>
            <td><?php echo $candi['registration_id']?></td>
            <td><?php echo base64_encode( $candi['registration_id'].$candi['subject_id'])?></td>
            <td><?php echo getsubjectName($candi['subject_id'],$conn)?></td>
            <td><?php
                if(isset($candi['status']) && $candi['status'] == 'completed'){
                   $status = 'Completed';
                }elseif(isset($candi['status']) && $candi['status'] == 'in_process'){
                    $status = 'In Process';
                }else{
                    $status = '';
                }
            ?>
            <?php echo $status ?></td>
            <td><?php echo $candi['evaluated_date']?></td>
            <td><?php echo calculatedescMarks($candi['registration_id'],$conn);?>/ <?php echo calculateTotalMarks($candi['subject_id'],$conn);?></td>
            <td><a class="btn btn-primary btn-sm evaluatePaper" href="<?php echo BASE_URL.'evaluate.php?hidid='.$candi['registration_id']?>">Evaluate</a></td>
          </tr>
          <?php $i++;}}?>
          
        </tbody>
      </table>
</div>
