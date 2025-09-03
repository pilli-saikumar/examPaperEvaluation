<?php 
include "../header.php";

$query = "SELECT in.id as invigilator_id, in.invigilator_name, in.invigilator_email,  in.exam_id, in.subject_id, FROM `pe_assign_candidates` WHERE `invigilator_id` = "

$result = mysqli_query($conn, $query);
if(mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
        $invigilator[] = $row;
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
                          <td></td>
                          <td><?php echo $invigilator['assigned_candidates_count']?></td>
                          <td><?php echo $invigilator['status']?></td>
                          <td>
                         
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
