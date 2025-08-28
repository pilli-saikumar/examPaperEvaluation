<?php 
include "../header.php";


$getSubjectData    =   mysqli_query($conn,'SELECT * FROM `pe_subjects` ORDER BY id DESC');
if(mysqli_num_rows($getSubjectData) > 0){
    while($subjectData   =   mysqli_fetch_assoc($getSubjectData)){
        $subject[]       =    $subjectData;
    }
}

$error = '';
if (isset($_POST['saveChanges']) && $_POST['saveChanges'] == 'Submit') {
  if (isset($_POST['subject_id']) && !empty($_POST['subject_id'])) {
      $subject_id = $_POST['subject_id'];
      $candidate_details = $_FILES['candidate_details'];

      if (isset($candidate_details) && $candidate_details['error'] == 0) {
          $filename = $candidate_details['tmp_name'];
          $handle = fopen($filename, 'r');
          $header = fgetcsv($handle);

          $conn = new mysqli('localhost', 'root', '', 'paper_evaluation_db');
          if ($conn->connect_error) {
              die("Connection failed: " . $conn->connect_error);
          }

          $inserted = 0;
          while (($row = fgetcsv($handle, 1000, ',')) !== FALSE) {
              $registration_id = $conn->real_escape_string($row[0]);
              $candidate_name = $conn->real_escape_string($row[1]);
              $candidate_father_name = $conn->real_escape_string($row[2]);

              $raw_dob = trim($row[3]); 
              $dob_parts = explode('-', $raw_dob);
              
              if (count($dob_parts) === 3) {
             
                  $candidate_dob = $dob_parts[2] . '-' . $dob_parts[1] . '-' . $dob_parts[0];
              } else {
                  $candidate_dob = '0000-00-00';
              }
              

           //   $candidate_dob = $conn->real_escape_string($row[3]);
              $candidate_gender = $conn->real_escape_string($row[4]);
              $candidate_email = $conn->real_escape_string($row[5]);
              $candidate_phone = $conn->real_escape_string($row[6]);
              $subject_id_csv = !empty($row[7]) ? $row[7] : $subject_id;
              $status = $conn->real_escape_string($row[8]);

              $sql = "INSERT INTO pe_candidates 
                      (registration_id, candidate_name, candidate_father_name, candidate_dob, candidate_gender, candidate_email, candidate_phone, subject_id, status)
                      VALUES 
                      ('$registration_id', '$candidate_name', '$candidate_father_name', '$candidate_dob', '$candidate_gender', '$candidate_email', '$candidate_phone', '$subject_id_csv', '$status')";

              if ($conn->query($sql) === TRUE) {
                  $inserted++;
              } else {
                  $error .= "❌ Error: " . $conn->error . "<br>";
              }
          }

          fclose($handle);
          $conn->close();

          if ($inserted > 0) {
              $success = "✅ $inserted candidate(s) inserted successfully.";
          }
      } else {
          $error = '❌ Please upload a valid CSV file.';
      }

  } else {
      $error = '❌ Please select subject.';
  }
}
?>
  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper">
      <?php include_once "../sidebar.php";?>
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
        <a href= "<?php echo BASE_URL;?>candidates/candidate.csv" class="btn btn-primary btn-sm btn-icon-text float-right" target="_blank">Sample CSV file</a>
        <div class="row">
          
            <div class="col-md-12 colspan=3 grid-margin stretch-card">
               <div class="card">
                  <div class="card-body">
                     <h4 class="card-title">Upload Candidate Data</h4>
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
                     <div class="row">
                             <div class="col-md-6 col-sm-6 col-lg-6">
                                <div class="form-group">
                                    <label for="exampleInputUsername1">Choose Exam</label>
                                    <select class="form-control" name="exam_id" id="exam_id" required onchange="getQuestionPaper()">
                                        <option value="">Choose Exam</option>
                                        <?php if(isset($subject) && !empty($subject)){foreach($subject as $subject){?>
                                        <option value="<?php echo $subject['id']?>"><?php echo ucfirst($subject['subject_name'])?></option>
                                        <?php }}?>
                                    </select>
                               </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-lg-6">
                                <div class="form-group">
                                    <label for="exampleInputUsername1">Choose Subject</label>
                                
                                 <select class="form-control" name="question_paper" id="subject_name" required>
                                        <option value="">Select Subject</option>
                                    </select>
                                    </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-lg-6">
                                <div class="form-group">
                                    <label for="exampleInputUsername1">Upload Candidate Data</label>
                                  <input type="file" class="form-control" name="candidate_details" id="candidate_details" required placeholder="Upload Candidate Details" accept=".csv">
                                 <span id="candidate_details_error" class="error text-danger">*Upload csv file</span>
                                </div>
                            </div>
                        </div>
                        
                        <input type="submit" name="saveChanges" class="btn btn-primary mr-2" value="Submit">
                        <a href="<?php echo BASE_URL?>candidates/candidates.php" class="btn btn-light">Cancel</a>
                                          
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
    function getQuestionPaper(){
        var exam_name = document.getElementById('exam_id').value;
       
        if(exam_name){
            $.ajax({
                url: '<?php echo BASE_URL?>subjects/get_question_paper.php',
                type: 'POST',
                data: {exam_name: exam_name},
                success: function(response){
                    
                   $()
                    document.getElementById('subject_name').innerHTML = response;
                }
            });
        } else {
            // Clear the dropdown and hide other fields if no exam selected
            document.getElementById('subject_name').innerHTML = '<option value="">Select Subject</option>';
          
        }
    }
</script>
 <?php include "../footer.php"?>
