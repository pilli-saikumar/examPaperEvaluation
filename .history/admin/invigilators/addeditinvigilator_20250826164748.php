<?php 
include "../header.php";


$getCandidateData    =   mysqli_query($conn,'SELECT * FROM pe_candidates');
if(mysqli_num_rows($getCandidateData) > 0){
    while($candidateData   =   mysqli_fetch_assoc($getCandidateData)){
        $candidate[]       =    $candidateData;
    }
}

// $getSubjectData    =   mysqli_query($conn,'SELECT * FROM `pe_subjects` ORDER BY id DESC');
// if(mysqli_num_rows($getSubjectData) > 0){
//     while($subjectData   =   mysqli_fetch_assoc($getSubjectData)){
//         $subject[]       =    $subjectData;
//     }
// }
$getSubjectData    =   mysqli_query($conn, 'SELECT * FROM pe_subjects ORDER BY subject_name ASC');
if (mysqli_num_rows($getSubjectData) > 0) {
    while ($subjectData   =   mysqli_fetch_assoc($getSubjectData)) {
        $exam[]       =    $subjectData;
    }
}


if(isset($_GET['uid']) && !empty($_GET['uid'])){
    $getInvigilatorData    =   mysqli_query($conn,'SELECT * FROM pe_invigilators where id='.$_GET['uid'].' ');
    if(mysqli_num_rows($getInvigilatorData) > 0){
        $invigilator       =    mysqli_fetch_assoc($getInvigilatorData);
    } 
}
// echo "<br><br><br><pre>";
// echo $invigilator['invigilator_name'];
// echo "<pre>";print_r($invigilator);die;
$error ='';
if(isset($_POST['saveChanges']) && $_POST['saveChanges'] == 'Submit'){
   //echo "<br><br><br><pre>";print_r($_POST);die;
    if(isset($_POST['invigilator_email']) && !empty($_POST['invigilator_email'])){

        $creation_date     =   date('Y-m-d h:i:s');
        $creation_ip       =   $_SERVER['REMOTE_ADDR'];
                     
        $param['invigilator_name']      =   $_POST['invigilator_name'];
        $param['invigilator_email']     =   $_POST['invigilator_email'];
        $param['invigilator_phone']     =   $_POST['invigilator_phone'];
        $param['role']                  =   $_POST['role'];
        $param['exam_id']               =   $_POST['exam_id'];
        $param['subject']               =   $_POST['subject_id'];
        $param['password']              =   md5($_POST['password']);
        
        $where = '';
        if(isset($_POST['id']) && !empty($_POST['id'])){
            $where = 'AND id !='.$_POST['id'].' ';
        }
        //echo 'SELECT * FROM pe_invigilators where (invigilator_email="'.$_POST['invigilator_email'].'" OR invigilator_phone="'.$_POST['invigilator_phone'].'") '.$where.'';die;
        $getExistInvigilatorData        =   mysqli_query($conn,'SELECT * FROM pe_invigilators where (invigilator_email="'.$_POST['invigilator_email'].'" OR invigilator_phone="'.$_POST['invigilator_phone'].'") '.$where.' ');
        //echo "<pre>";print_r($getExistInvigilatorData);die;
        if(mysqli_num_rows($getExistInvigilatorData) == 0){
            if(isset($_POST['id']) && !empty($_POST['id'])){
                if(isset($_POST['password']) && !empty($_POST['password'])){
                    $set = ",password = '".md5($_POST['password'])."' ";
                }
                $updateQuery = "UPDATE `pe_invigilators` SET `invigilator_name`='".$param['invigilator_name']."',`invigilator_email`='".$param['invigilator_email']."',
                `invigilator_phone`='".$param['invigilator_phone']."',`subject`='".$param['subject']."',`role`='".$param['role']."',`exam_id`='".$param['exam_id']."',`update_date`='".$creation_date."',`updated_by`='Admin',`updated_ip_address`='".$creation_ip."' ".$set." WHERE id=".$_POST['id']." ";
                $insertData        =   mysqli_query($conn,$updateQuery);
            }
            else{
                $insertQuery = "INSERT INTO `pe_invigilators`(`invigilator_name`, `invigilator_email`, `invigilator_phone`, `subject`, `creation_date`, `creation_ip_address`, `created_by`, `status`, `password`, `role`, `exam_id`) 
                VALUES ('".$param['invigilator_name']."','".$param['invigilator_email']."','".$param['invigilator_phone']."',
                '".$param['subject']."','".$creation_date."','".$creation_ip."','admin','A','".$param['password']."','".$param['role']."','".$param['exam_id']."')";
              // echo $insertQuery;die;
                $insertData        =   mysqli_query($conn,$insertQuery);
                //die;
            }
            
            if($insertData){
                redirect(BASE_URL.'invigilators/invigilators.php');
            }
        }
        else{
            $error = 'Email Id or phone already exists.';
        }
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
                     <h4 class="card-title">Add Evaluator</h4>
                     <p class="error"><?php echo $error;?></p>
                     <form class="forms-sample" name="currentDataForm" id="currentDataForm" action="" method="post" enctype="multipart/form-data">
                     <input type="hidden" name="id" value="<?php echo isset($_GET['uid'])?$_GET['uid']:''?>">    
                      <div class="row">
                             <div class="col-md-6 col-sm-6 col-lg-6">
                                <div class="form-group">
                                    <label for="exampleInputUsername1">Name</label>
                                    <input type="text" class="form-control" name="invigilator_name" id="invigilator_name" required placeholder="Name" value="<?php echo isset($invigilator['invigilator_name'])?$invigilator['invigilator_name']:"";?>">
                               </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-lg-6">
                                <div class="form-group">
                                    <label for="exampleInputUsername1">Email</label>
                                    <input type="email" class="form-control" name="invigilator_email" id="invigilator_email" required placeholder="Email" value="<?php echo isset($invigilator['invigilator_email'])?$invigilator['invigilator_email']:"";?>">
                               </div>
                            </div>
                        </div>
                        <div class="row">
                             <div class="col-md-6 col-sm-6 col-lg-6">
                                <div class="form-group">
                                    <label for="exampleInputUsername1">Phone Number</label>
                                    <input type="text" class="form-control" name="invigilator_phone" id="invigilator_phone" required placeholder="Phone Number" value="<?php echo isset($invigilator['invigilator_phone'])?$invigilator['invigilator_phone']:"";?>">
                               </div>
                            </div>
                            
                            <div class="col-md-6 col-sm-6 col-lg-6">
                                 <div class="form-group">
                                    <label for="exampleInputUsername1">Role</label>
                                    <select class="form-control" name="role" id="role" required>
                                        <option value="">Select Role</option>
                                        <option value="head_evaluator" <?php echo isset($invigilator['role']) && $invigilator['role'] == 'head_evaluator'?'selected':''?>>Head Evaluator</option>
                                        <option value="evaluator" <?php echo isset($invigilator['role']) && $invigilator['role'] == 'evaluator'?'selected':''?>>Evaluator</option>
                                        
                                    </select>
                               </div>
                            </div>
                        </div>
                        <div class="row">
                             <div class="col-md-6 col-sm-6 col-lg-6">
                               <!-- <div class="form-group">
                                    <label for="exampleInputUsername1">Exam</label>
                                    <select class="form-control" name="exam_id" id="exam_id" required onchange="getsubjectName()">
                                        <option value="">Choose Exam</option>
                                        <?php if(isset($subject) && !empty($subject)){foreach($subject as $subject){
                                            if(isset($_GET['uid']) && !empty($_GET['uid'])){
                                                if($subject['id'] == $invigilator['subject']){$select = "selected";}
                                            }    
                                        ?>
                                        <option <?php echo $select;?> value="<?php echo $subject['id']?>"><?php echo ucfirst($subject['subject_name'])?></option>
                                        <?php }}?>
                                    </select>
                               </div> -->
                               <div class="form-group"><label for="exam_id">Exam</label>
                                                <select class="form-control" name="exam_id" id="exam_id" onchange="getsubjectName()" required>
                                                    <option value="">Choose Exam</option>
                                                    <?php if (isset($exam) && !empty($exam)) {
                                                        foreach ($exam as $exam) { ?>
                                                            <option value="<?php echo $exam['id'] ?>" <?php echo isset($invigilator['exam_id']) && $invigilator['exam_id'] == $exam['id']?'selected':''?>><?php echo ucfirst($exam['subject_name']) ?></option>
                                                    <?php }
                                                    } ?>
                                                </select>
                                            </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-lg-6">
                              <div class="form-group">
                                    <label for="exampleInputUsername1">Choose Subject</label>
                                    
                                `
                                 <select class="form-control" name="subject_id" id="subject_name" required>
                                    <?php if(isset($invigilator['subject']) && !empty($invigilator['subject'])){
                                        foreach($subject as $subject){
                                            if($subject['id'] == $invigilator['subject']){$select = "selected";}
                                        }
                                    }else{
                                        
                                    }?>
                                    
                                        <option value=""    <?php echo isset($invigilator['subject']) && $invigilator['subject'] == ''?'selected':''?>>Select Subject</option>
                                    </select>`
                               
                                </div>
                            </div>
                        </div>
                        <div class="row">
                             <div class="col-md-6 col-sm-6 col-lg-6">
                                <div class="form-group">
                                    <label for="exampleInputUsername1">Password</label>
                                    <input type="password" class="form-control" name="password" id="password" <?php if(isset($_GET['uid']) && !empty($_GET['uid'])){echo "";} else {echo "required";};?> placeholder="Password">
                               </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-lg-6">
                                <div class="form-group">
                                    <label for="exampleInputUsername1">Confirm Password</label>
                                    <input type="password" class="form-control" name="conf_password" id="conf_password" <?php if(isset($_GET['uid']) && !empty($_GET['uid'])){echo "";} else {echo "required";};?> placeholder="Confirm Password">
                               </div>
                            </div>
                        </div>
                        
                        <input type="submit" name="saveChanges" class="btn btn-primary mr-2" value="Submit">
                        <a href="<?php echo BASE_URL?>invigilators/invigilators.php" class="btn btn-light">Cancel</a>
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
                rules: {
                    "password": {
                        minlength: 6,
                    },
                    "conf_password": {
                        equalTo : "#password",
                        minlength: 6,
                    }
                },
            });
        }
    });
    function getsubjectName(){
        var exam_name = document.getElementById('exam_id').value;
       
       if(exam_name){
           $.ajax({
               url: '<?php echo BASE_URL?>subjects/get_question_paper.php',
               type: 'POST',
               data: {exam_name: exam_name},
               success: function(response){
                   
               //  '<option value="">Select Subject</option>' + response;
                   document.getElementById('subject_name').innerHTML = '<option value="">Select Subject</option>' + response;
               }
           });
       } else {
           // Clear the dropdown and hide other fields if no exam selected
           document.getElementById('subject_name').innerHTML = '<option value="">Select Subject</option>';
         
       }
    }
</script>
 <?php include "../footer.php"?>
