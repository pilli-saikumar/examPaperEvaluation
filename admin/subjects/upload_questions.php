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
if(isset($_POST['uploadQuestions']) && $_POST['uploadQuestions'] == 'Upload Questions'){
 
          
    $exam_id         =   $_POST['exam_name'];
    $question_paper         =   $_POST['question_paper'];
  
    
   if(isset($_FILES['question_file']) && $_FILES['question_file']['error'] == 0){
    $question_file_name    =   $_FILES['question_file']['name'];
   
      $file_extension    =   pathinfo($question_file_name, PATHINFO_EXTENSION);
       if($file_extension !== 'csv' && $file_extension !== 'xlsx'){
        $error = 'Invalid file format. Please upload a CSV or XLSX file.';
        die;
       }
      
    //  $conn = new mysqli("localhost", "root", "", "paper_evaluation_db");
      
      if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
      }
      
      if(($handle = fopen($_FILES['question_file']['tmp_name'], 'r')) !== FALSE) {
        $header = fgetcsv($handle);
        $datarow = array();
        while(($data = fgetcsv($handle)) !== FALSE){
            $row  = array_combine($header, $data);
          
            $datarow[] = $row;
            
           }
        
       fclose($handle);
       $totals = [];
       $insertedQno = [];
       foreach ($datarow as $row) {
           $qno = trim($row['QNo']);
           $maxMarks = (int)$row['MaxMarks'];
           $totals[$qno] = ($totals[$qno] ?? 0) + $maxMarks;
       }
       // Insert rows
       $question_id = 1;
       foreach ($datarow as $row) {
        $qno = trim($row['QNo']);
         $Q_id   =   $question_id++;
        $subqno = $conn->real_escape_string(trim($row['SubQNo']));
        $qstmt = $conn->real_escape_string(trim($row['QStmt']));
        $maxMarks = (int)$row['MaxMarks'];
        $Setter = 'Admin';
        $CourseId = $question_paper;
        $min_ans = 0;
       // first time we see this QNo, set total_marks
    if (!isset($insertedQno[$qno])) {
        $totalMarks = $totals[$qno];
        $insertedQno[$qno] = true;
    } else {
        $totalMarks = 0; // or NULL
    }

        $sql = "INSERT INTO pe_qpapers (QpId,QId, QNo, SubQNo, QStmt, MaxMarks,Setter,CourseId,min_ans,total_marks) 
                VALUES ('$exam_id', '$Q_id', '$qno', '$subqno', '$qstmt', '$maxMarks', '$Setter', '$CourseId', '$min_ans', '$totalMarks')";

        if (!$conn->query($sql)) {
            $error = "Insert error: " . $conn->error . "<br>";
        }
    }

    $success = "Upload completed successfully.";
    }
       
   }else{
    $error = 'Failed to upload file.';
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
                     <h4 class="card-title">Upload Questions</h4>
                     <a href="questionpaper.csv" class="btn btn-primary btn-sm float-right mr-4 mb-2" target="_blank">Download Sample CSV</a>    
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
                                    <select class="form-control" name="exam_name" id="exam_name" required onchange="getQuestionPaper()">
                                        <option value="">Select Exam Name</option>
                                    <?php if(isset($subject) && !empty($subject)){foreach($subject as $subject){?>
                                        <option value="<?php echo $subject['id']?>"><?php echo ucfirst($subject['subject_name'])?></option>
                                        <?php }}?>
                                    </select>
                               </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-lg-6">
                                <div class="form-group">
                                    <label for="question_paper">Question Paper</label>
                                    <select class="form-control" name="question_paper" id="question_paper" required onchange="showUploadField()">
                                        <option value="">Select Question Paper</option>
                                    </select>
                               </div>
                            </div>
                        </div>
                        
                        <!-- Upload Field Container -->
                        <div class="row" id="upload_field_row" style="display:none;">
                            <div class="col-md-6 col-sm-6 col-lg-6">
                                <div class="form-group">
                                    <label for="question_file">Upload Questions File</label>
                                    <input type="file" class="form-control" name="question_file" id="question_file" accept=".excel,.csv">
                                    <small class="form-text text-muted">Accepted formats: Excel, CSV</small>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row" id="submit_button_row" style="display:none;">
                            <div class="col-md-12">
                                <input type="submit" name="uploadQuestions" class="btn btn-primary mr-2" value="Upload Questions">
                            </div>
                        </div>
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
     document.addEventListener('DOMContentLoaded', function () {
        setTimeout(function () {
            const successBox = document.getElementById('success-message');
            const errorBox = document.getElementById('error-message');

            if (successBox) successBox.style.display = 'none';
            if (errorBox) errorBox.style.display = 'none';
        }, 5000); // 5000 milliseconds = 5 seconds
    });
    function getQuestionPaper(){
        var exam_name = document.getElementById('exam_name').value;
       
        if(exam_name){
            $.ajax({
                url: '<?php echo BASE_URL?>subjects/get_question_paper.php',
                type: 'POST',
                data: {exam_name: exam_name},
                success: function(response){
                    document.getElementById('question_paper').innerHTML = response;
                }
            });
        } else {
            // Clear the dropdown and hide other fields if no exam selected
            document.getElementById('question_paper').innerHTML = '<option value="">Select Question Paper</option>';
            document.getElementById('upload_field_row').style.display = 'none';
            document.getElementById('submit_button_row').style.display = 'none';
        }
    }
    
    function showUploadField(){
        var question_paper = document.getElementById('question_paper').value;
        if(question_paper){
            document.getElementById('upload_field_row').style.display = 'block';
            document.getElementById('submit_button_row').style.display = 'block';
        } else {
            document.getElementById('upload_field_row').style.display = 'none';
            document.getElementById('submit_button_row').style.display = 'none';
        }
    }
    </script>
    <?php include "../footer.php"?>