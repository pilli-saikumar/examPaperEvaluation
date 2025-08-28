<?php 
include "../header.php";

$getCandidateData    =   mysqli_query($conn,'SELECT * FROM pe_candidates');
if(mysqli_num_rows($getCandidateData) > 0){
    while($candidateData   =   mysqli_fetch_assoc($getCandidateData)){
        $candidate[]       =    $candidateData;
    }
}

// $getQuestionPprData    =   mysqli_query($conn,'SELECT * FROM pe_question_paper');
// if(mysqli_num_rows($getQuestionPprData) > 0){
//     while($questionPaperData   =   mysqli_fetch_assoc($getQuestionPprData)){
//         $questionPaper[]       =    $questionPaperData;
//     }
// }
$exam = array();
$getexam = mysqli_query($conn,'SELECT * FROM pe_subjects');
if(mysqli_num_rows($getexam) > 0){
    while($examData   =   mysqli_fetch_assoc($getexam)){
        $exam[]       =    $examData;
    }
}

if(isset($_POST['saveChanges']) && $_POST['saveChanges'] == 'Submit'){
    echo "<br><br><br><pre>";//print_r($_POST);
    //echo "<pre>";print_r($_FILES);die;
    $targetDir = "../assets/uploads/"; 
    $allowTypes = array('jpg','png','jpeg','gif'); 
    $fileNames = array_filter($_FILES['uploadanswers']['name']); 
    if(!empty($fileNames)){ 
        $i=1;foreach($_FILES['uploadanswers']['name'] as $key=>$val){ 
            $fileName = basename($_FILES['uploadanswers']['name'][$key]); 
            $fileType = pathinfo($fileName, PATHINFO_EXTENSION);
            $newFileName    =   $_POST['candidate'].'_'.$_POST['question_id'].'_'.$i.'_'.uniqid().'.'.$fileType;
            $targetFilePath = $targetDir . $newFileName; 
            $newPath        =   "admin/assets/uploads/". $newFileName;
            //echo $targetFilePath;die; 
            if(in_array($fileType, $allowTypes)){ 
                // Upload file to server 
                if(move_uploaded_file($_FILES["uploadanswers"]["tmp_name"][$key], $targetFilePath)){ 
                     $creation_date     =   date('Y-m-d h:i:s');
                     $creation_ip       =   $_SERVER['REMOTE_ADDR'];
                     $uploadQuery       =   "INSERT INTO `pe_candidate_answers`
                                    (`registration_id`, `question_paper_id`, `uploaded_answer`,`corrected_answer`, `creation_date`, `creation_ip_address`, `created_by`,`status`) VALUES 
                                    (".$_POST['candidate'].",".$_POST['question_id'].",'".$newPath."','".$newPath."','".$creation_date."','".$creation_ip."','admin','A')";

                     $insertData        =   mysqli_query($conn,$uploadQuery);
                     //die;
                     if($insertData){
                         redirect(BASE_URL.'uploadanswers/candidate_answers.php');
                     }
                     
                }
                else{
                    //echo "wrong";die;
                }
            }else{ 
                $errorUploadType .= $_FILES['uploadanswers']['name'][$key].' | '; 
            } 
        $i++;} 
    }
}
?>
  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper">
      <?php include_once "../sidebar.php";?>
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 colspan=3 grid-margin stretch-card">
               <div class="card">
                  <div class="card-body">
                     <h4 class="card-title">Upload Answers</h4>
                     
                     <form class="forms-sample" name="currentDataForm" id="currentDataForm" action="" method="post" enctype="multipart/form-data">
                         <div class="row">
                             <!-- <div class="col-md-6 col-sm-6 col-lg-6">
                                <div class="form-group">
                                    <label for="exampleInputUsername1">Choose Candidate</label>
                                    <select class="form-control" name="candidate" id="candidate" required>
                                        <option value="">Choose Candidate</option>
                                        <?php if(isset($candidate) && !empty($candidate)){foreach($candidate as $candidate){?>
                                        <option value="<?php echo $candidate['registration_id']?>"><?php echo ucfirst($candidate['registration_id'])?></option>
                                        <?php }}?>
                                    </select>
                                </div>
                            </div> -->
                            <div class="col-md-6 col-sm-6 col-lg-6">
                                <div class="form-group">
                                    <label for="exampleInputUsername1">Choose Exam</label>
                                    <select class="form-control" name="question_id" id="question_id" required onchange="getQuestionPaper(this.value)">
                                        <option value="">Choose Exam</option>
                                        <?php if(isset($exam) && !empty($exam)){foreach($exam as $questionPaper){?>
                                        <option value="<?php echo $questionPaper['id']?>"><?php echo ucfirst($questionPaper['subject_name'])?></option>
                                        <?php }}?>
                                    </select>
                                </div>
                            </div>
                            <!-- <div class="col-md-6 col-sm-6 col-lg-6">
                                <div class="form-group">
                                    <label for="exampleInputUsername1">Choose Question Paper</label>
                                    <select class="form-control" name="question_id" id="question_id" required>
                                        <option value="">Choose Question Paper</option>
                                        <?php if(isset($questionPaper) && !empty($questionPaper)){foreach($questionPaper as $questionPaper){?>
                                        <option value="<?php echo $questionPaper['id']?>"><?php echo ucfirst($questionPaper['question_paper'])?></option>
                                        <?php }}?>
                                    </select>
                                </div>
                            </div> -->
                            <div class="col-md-6 col-sm-6 col-lg-6">
                                <div class="form-group">
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Upload Answers</label>
                                        <input name="uploadanswers[]" type="file" class="form-control" id="uploadanswers" multiple accept="image/*" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <input type="submit" name="saveChanges" class="btn btn-primary mr-2" value="Submit">
                        <a href="<?php echo BASE_URL?>uploadanswers/candidate_answers.php" class="btn btn-light">Cancel</a>
                     </form>
                  </div>
               </div>
            </div>
         </div>
         
        </div>
        
      </div>
    </div>
  </div>

  <script>
    $(document).ready(function(){
	// Form Validation
        if($("#currentDataForm").length) { 
            $("#currentDataForm").validate({
                
            });
        }
    });

    function getQuestionPaper(exam_id){
        
    }
</script>
 <?php include "../footer.php"?>
