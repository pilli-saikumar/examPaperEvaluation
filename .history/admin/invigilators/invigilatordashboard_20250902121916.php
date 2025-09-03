<?php 
include "../header.php";

$getexam = mysqli_query($conn,'SELECT * FROM pe_subjects');
if(mysqli_num_rows($getexam) > 0){
    while($examData   =   mysqli_fetch_assoc($getexam)){
        $exam[]       =    $examData;
    }
}

//$result = mysqli_query($conn, "SELECT  * FROM `pe_assign_candidates`   group by invigilator_id ORDER BY id DESC");
// $result = mysqli_query($conn, "SELECT ac.*, i.invigilator_name, i.invigilator_email, i.invigilator_phone ,e.subject_name,s.question_paper
// FROM pe_assign_candidates ac
// JOIN pe_invigilators i ON i.id = ac.invigilator_id
// JOIN pe_subjects e ON e.id = ac.exam_id
// JOIN pe_question_paper s ON s.id = ac.subject_id
// GROUP BY ac.invigilator_id
// ORDER BY ac.id DESC");

          
if(mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
        $invigilator[] = $row;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if(isset($_POST['exam_id']) && !empty($_POST['exam_id'])){
    $exam_id = $_POST['exam_id'];
    $result = mysqli_query($conn, "SELECT ac.*, i.invigilator_name, i.invigilator_email, i.invigilator_phone ,e.subject_name,s.question_paper
FROM pe_assign_candidates ac
JOIN pe_invigilators i ON i.id = ac.invigilator_id
JOIN pe_subjects e ON e.id = ac.
JOIN pe_question_paper s ON s.id = ac.subject_id
GROUP BY ac.invigilator_id
ORDER BY ac.id DESC");
  
  }


}


// $invigilatorassigndata = mysqli_query($conn,'SELECT* FROM `pe_assign_candidates`  ORDER BY id DESC');
// //$getInvgilatorData    =   mysqli_query($conn,'SELECT s.subject_name,i.* FROM `pe_invigilators` as i JOIN pe_subjects as s ON s.id=i.exam_id ORDER BY id DESC');
// if(mysqli_num_rows($getInvgilatorData) > 0){
//     while($invigilatorData   =   mysqli_fetch_assoc($getInvgilatorData)){
//         $invigilator[]       =    $invigilatorData;
//     }
// }
?>
  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper">
      <?php include_once "../sidebar.php";?>
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
        <form action="" method="post" id="examForm">
    <label for="exam_id">Choose Exam</label>
    <select name="exam_id" id="exam_id" class="form-control" onchange="this.form.submit()">
        <option value="">Select Exam</option>
        <?php if(isset($exam) && !empty($exam)){ foreach($exam as $exam){?>
        <option value="<?php echo $exam['id']?>"><?php echo $exam['subject_name']?></option>
        <?php } }?>
    </select>
</form>
          <div class="row">
          <div class="col-lg-12 grid-margin stretch-card">
            
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Evaluator data </h4>
                  
                  <div class="table-responsive">
                    <table class="table">
                      <thead>
                        <tr>
                          <th>S.NO</th>
                          <th>Evaluator Name</th>
                          <!-- <th>Email</th>
                         -->
                          <th>Exam</th>
                          <th>Subject</th>
                          <th>Assigned Candidates</th>
                          <th>Status</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php if(isset($invigilator) && !empty($invigilator)){ $i=1;foreach($invigilator as $invigilator){?>
                        <tr>
                          <td><?php echo $i;?></td>
                          <td><?php echo ucfirst($invigilator['invigilator_name'])?></td>
                          <!-- <td><?php echo ucfirst($invigilator['invigilator_email'])?></td> -->
                        
                          <td><?php echo ucfirst($invigilator['subject_name'])?></td>
                          <td><?php echo ucfirst($invigilator['question_paper'])?></td>
                          <td><?php echo $invigilator['assign_count']?></td>
                          <td><?php echo $invigilator['status']?></td>
                          <td>
            <form action="<?php echo BASE_URL;?>invigilators/edit_assigncandidates.php" method="post" style="display: inline;">
                <input type="hidden" name="uid" value="<?php echo $invigilator['invigilator_id']?>">
                <input type="hidden" name="exam_id" value="<?php echo $invigilator['exam_id']?>">
                <input type="hidden" name="subject_id" value="<?php echo $invigilator['subject_id']?>">
                <button type="submit" class="btn btn-primary btn-sm">Edit</button>
            </form>
        </td>

                        </tr>
                        <?php $i++;}
                         
                        } else{echo "<tr><td colspan=7>No Data Available</td></tr>";}?>
                        
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
         
        </div>
        
      </div>
    </div>
  </div>
 <?php include "../footer.php"?>
