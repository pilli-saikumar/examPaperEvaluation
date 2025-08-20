<?php
include "../header.php";

$getSubjectData    =   mysqli_query($conn,'SELECT * FROM `pe_subjects` ORDER BY id DESC');

if(mysqli_num_rows($getSubjectData) > 0){
    while($subjectData   =   mysqli_fetch_assoc($getSubjectData)){
        $subject[]       =    $subjectData;
    }
}

$success = '';
$error = '';
if(isset($_POST['saveChanges']) && $_POST['saveChanges'] == 'Submit'){

                     
      $exam_name         =   $_POST['exam_name'];
      $question_papers         =   $_POST['question_paper'];

       foreach($question_papers as $question_paper){
     
          $question_paper_slug         =   strtolower(str_replace(' ','-',$question_paper));
      $uploadQuery = "INSERT INTO `pe_question_paper`(`exam_id`,`question_paper`,`question_paper_slug`,`status`) 
      VALUES ('".$exam_name."','".$question_paper."','".$question_paper_slug."','A')";
      
      $insertData        =   mysqli_query($conn,$uploadQuery);
      if($insertData){
        $success = 'Data inserted successfully.';
       // redirect(BASE_URL.'subjects/manage_course.php');
      }
      else{
        $error = 'Failed to insert data.';
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
            <div class="col-md-12 colspan=3 grid-margin stretch-card ">
               <div class="card">
                  <div class="card-body">
                     <h4 class="card-title">Add Subject</h4>
                    
                     <form class="forms-sample" name="currentDataForm" id="currentDataForm" action="" method="post" enctype="multipart/form-data">
                     <?php if (!empty($success)): ?>
    <div id="success-message" style="color: green; font-weight: bold;">
        <?= $success ?>
    </div>
<?php endif; ?>

<?php if (!empty($error)): ?>
    <div id="error-message" style="color: red; font-weight: bold;">
        <?= $error ?>
    </div>
<?php endif; ?>
                     <input type="hidden" name="id" value="<?php echo isset($_GET['uid'])?$_GET['uid']:''?>">   
                     <div class="row">
                             <div class="col-md-6 col-sm-6 col-lg-6">
                                <div class="form-group">
                                    <label for="exampleInputUsername1">Exam Name</label>
                                    <select class="form-control" name="exam_name" id="exam_name" required>
                                        <option value="">Select Exam Name</option>
                                    <?php if(isset($subject) && !empty($subject)){foreach($subject as $subject){?>
                                        <option value="<?php echo $subject['id']?>"><?php echo ucfirst($subject['subject_name'])?></option>
                                        <?php }}?>
                                    </select>
                               </div>
                            </div>
                        </div>
                       <div class="row">
                             <div class="col-md-6 col-sm-6 col-lg-6">
                                <div class="form-group">
                                    <label for="exampleInputUsername1">Subject Name</label>
                                    <input type="text" class="form-control" name="question_paper[]" id="question_paper" required placeholder="Question Paper Name" value="<?php echo isset($subject['question_paper'])?$subject['question_paper']:"";?>" >
                               </div>
                            </div>
                        </div>

                        <div class="row">
                        <button type="button" class="btn btn-primary mr-2" onclick="addSubject()">add +</button>
                        <input type="submit" name="saveChanges" class="btn btn-primary mr-2" value="Submit">
                    </div>

                       
                        <!-- <a href="<?php echo BASE_URL?>subjects/index.php" class="btn btn-light">Cancel</a> -->
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
    // Wait for the page to load
    document.addEventListener('DOMContentLoaded', function () {
        setTimeout(function () {
            const successBox = document.getElementById('success-message');
            const errorBox = document.getElementById('error-message');

            if (successBox) successBox.style.display = 'none';
            if (errorBox) errorBox.style.display = 'none';
        }, 5000); // 5000 milliseconds = 5 seconds
    });
    function addSubject(){
        // Find the container where we want to add the new field
        const addButton = document.querySelector('button[onclick="addSubject()"]');
        const buttonRow = addButton.closest('.row');
        
        // Create the new field HTML
        const newFieldHTML = `
        <div class="row subject-field">
            <div class="col-md-6 col-sm-6 col-lg-6">
                <div class="form-group">
                    <label for="exampleInputUsername1">Subject Name</label>
                    <input type="text" class="form-control" name="question_paper[]" required placeholder="Question Paper Name">
                </div>
            </div>
            <div class="col-md-2 col-sm-2 col-lg-2">
                <div class="form-group">
                    <label>&nbsp;</label><br>
                    <button type="button" class="btn btn-danger" onclick="removeSubject(this)">Remove</button>
                </div>
            </div>
        </div>`;
        
        // Insert the new field before the button row
        buttonRow.insertAdjacentHTML('beforebegin', newFieldHTML);
    }
    
    function removeSubject(button) {
        // Find the parent row and remove it
        const row = button.closest('.subject-field');
        if (row) {
            row.remove();
        }
    }
    </script>
<?php include "../footer.php"?>