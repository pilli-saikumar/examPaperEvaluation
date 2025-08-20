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
    }
}

function calculatedescMarks($regId,$conn){
  $desMarks = mysqli_query($conn,"SELECT sum(MarksPerQ) as marks FROM `pe_marks` where StudId=".$regId." AND MarksPerQ > 0");
  if(mysqli_num_rows($desMarks) > 0){
      $descriptiveMarks = mysqli_fetch_assoc($desMarks);
      return $descriptiveMarks['marks']?$descriptiveMarks['marks']:0;
  }
}
?>
<div class="container">
	<div id="projectFacts" class="sectionClass">
	    <div class="fullWidth eight columns">
	        <div class="projectFactsWrap ">
	            <div class="item" data-number="" style="visibility: visible;">
	                <p id="number1" class="number">3</p>
	                <span></span>
	                <p>Uploaded</p>
	            </div>
	            <div class="item" data-number="" style="visibility: visible;">
	                <p id="number2" class="number">3</p>
	                <span></span>
	                <p>Evaluated</p>
	            </div>
	            <div class="item" data-number="" style="visibility: visible;">
	                <p id="number3" class="number">0</p>
	                <span></span>
	                <p>Remaining</p>
	            </div>
	            
	        </div>
	    </div>
	</div>
</div>
<div class="container">
    <table class="table table-bordered">
        <thead>
          <tr class="bg-primary">
            <th>S.NO</th>
            <th>Registration Id</th>
            <th>Status</th>
            <th>Evaluated Date</th>
            <th>Total Marks</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
        <?php if($candidate){$i=1;foreach($candidate as $candi){?>
          <tr>
            <td><?php echo $i?></td>
            <td><?php echo base64_encode($candi['registration_id'])?></td>
            <td>In process</td>
            <td>2022-04-12</td>
            <td><?php echo calculatedescMarks($candi['registration_id'],$conn);?>/30</td>
            <td><a class="btn btn-primary btn-sm evaluatePaper" href="<?php echo BASE_URL.'evaluate.php?hidid='.$candi['registration_id']?>">Evaluate</a></td>
          </tr>
          <?php $i++;}}?>
          
        </tbody>
      </table>
</div>