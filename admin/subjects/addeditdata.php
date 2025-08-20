<?php 
include "../header.php";


if(isset($_GET['uid']) && !empty($_GET['uid'])){
    $getSubjectData    =   mysqli_query($conn,'SELECT * FROM pe_subjects where id='.$_GET['uid'].' ');
    if(mysqli_num_rows($getSubjectData) > 0){
        $subject       =    mysqli_fetch_assoc($getSubjectData);
    } 
}
// echo "<br><br><br><pre>";
// echo $subject['subject_name'];
//echo "<pre>";print_r($subject);die;
$error ='';
if(isset($_POST['saveChanges']) && $_POST['saveChanges'] == 'Submit'){
  // echo "<br><br><br><pre>";print_r($_POST);die;
    if(isset($_POST['subject_name']) && !empty($_POST['subject_name'])){
        $creation_date     =   date('Y-m-d h:i:s');
        $creation_ip       =   $_SERVER['REMOTE_ADDR'];
                     
        $param['subject_name']          =   $_POST['subject_name'];
        $param['subject_slug']          =   strtolower(str_replace(' ','-',$param['subject_name']));
        
        $where = '';
        if(isset($_POST['id']) && !empty($_POST['id'])){
            $where = 'AND id !='.$_POST['id'].' ';
        }
        //echo 'SELECT * FROM pe_subjects where (subject_name="'.$_POST['subject_name'].'" OR invigilator_phone="'.$_POST['invigilator_phone'].'") '.$where.'';die;
        $getExistInvigilatorData        =   mysqli_query($conn,'SELECT * FROM pe_subjects where (subject_slug="'.$param['subject_slug'].'") '.$where.' ');
        //echo "<pre>";print_r($getExistInvigilatorData);die;
        if(mysqli_num_rows($getExistInvigilatorData) == 0){
            if(isset($_POST['id']) && !empty($_POST['id'])){
                echo $updateQuery = "UPDATE `pe_subjects` SET `subject_name`='".$param['subject_name']."',`subject_slug`='".$param['subject_slug']."',
                `update_date`='".$creation_date."',`updated_by`='Admin',`update_ip`='".$creation_ip."' WHERE id=".$_POST['id']." ";
                $insertData        =   mysqli_query($conn,$updateQuery);
            }
            else{
                $insertQuery = "INSERT INTO `pe_subjects`(`subject_name`, `subject_slug`, `creation_date`, `creation_ip`, `created_by`, `status`) 
                VALUES ('".$param['subject_name']."','".$param['subject_slug']."','".$creation_date."','".$creation_ip."','admin','A')";
                $insertData        =   mysqli_query($conn,$insertQuery);
                //die;
            }
            
            if($insertData){
                redirect(BASE_URL.'subjects/index.php');
            }
        }
        else{
            $error = 'Subject already exists.';
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
                     <h4 class="card-title">Add Exam Name</h4>
                     <p class="error"><?php echo $error;?></p>
                     <form class="forms-sample" name="currentDataForm" id="currentDataForm" action="" method="post" enctype="multipart/form-data">
                     <input type="hidden" name="id" value="<?php echo isset($_GET['uid'])?$_GET['uid']:''?>">    
                     <div class="row">
                             <div class="col-md-6 col-sm-6 col-lg-6">
                                <div class="form-group">
                                    <label for="exampleInputUsername1">Exam Name</label>
                                    <input type="text" class="form-control" name="subject_name" id="subject_name" required placeholder="Exam Name" value="<?php echo isset($subject['subject_name'])?$subject['subject_name']:"";?>">
                               </div>
                            </div>
                        </div>
                        
                        <input type="submit" name="saveChanges" class="btn btn-primary mr-2" value="Submit">
                        <a href="<?php echo BASE_URL?>subjects/index.php" class="btn btn-light">Cancel</a>
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
</script>
 <?php include "../footer.php"?>
