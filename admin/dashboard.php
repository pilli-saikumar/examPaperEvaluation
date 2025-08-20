<?php 
include "header.php"  ;

function countData($table,$conn){
  $count = mysqli_query($conn,"SELECT count(*) as count FROM $table");
  if(mysqli_num_rows($count) > 0){
      $total = mysqli_fetch_assoc($count);
      return $total['count']?$total['count']:0;
  }
}

function evaluatedCount($conn) {
  $result = mysqli_query($conn, "SELECT COUNT(DISTINCT StudId) as count FROM pe_marks");
  if ($result && $row = mysqli_fetch_assoc($result)) {
      return (int)$row['count'];
  }
  return 0;
}
?>
  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper">
      <?php include_once "sidebar.php";?>
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-md-12 grid-margin">
              <div class="row">
                <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                  <h3 class="font-weight-bold">Welcome Admin</h3>
                </div>
                
              </div>
            </div>
          </div>
          <div class="row">
            
            <div class="col-md-12 grid-margin transparent">
              <div class="row">
                <div class="col-md-3 mb-4 stretch-card transparent">
                  <div class="card card-tale">
                    <div class="card-body">
                      <p class="mb-4">Total Question Papers</p>
                      <p class="fs-30 mb-2"><?php echo countData('pe_question_paper',$conn);?></p>
                    </div>
                  </div>
                </div>
                <div class="col-md-3 mb-4 stretch-card transparent">
                  <div class="card card-dark-blue">
                    <div class="card-body">
                      <p class="mb-4">Total Sheets Uploaded</p>
                      <p class="fs-30 mb-2"><?php echo countData('pe_candidate_answers',$conn);?></p>
                    </div>
                  </div>
                </div>
                <div class="col-md-3 mb-4 stretch-card transparent">
                  <div class="card card-light-blue">
                    <div class="card-body">
                      <p class="mb-4">Total Candidates</p>
                      <p class="fs-30 mb-2"><?php echo countData('pe_candidates',$conn);?></p>
                    </div>
                  </div>
                </div>
                <div class="col-md-3 mb-4 stretch-card transparent">
                  <div class="card card-light-danger">
                    <div class="card-body">
                      <p class="mb-4">Papers Evaluated</p>
                      <p class="fs-30 mb-2"><?php echo evaluatedCount($conn);?></p>
                    </div>
                  </div>
                </div>
              </div>
          </div>
        
        </div>
        
      </div>
    </div>
  </div>

 <?php include "footer.php"?>
