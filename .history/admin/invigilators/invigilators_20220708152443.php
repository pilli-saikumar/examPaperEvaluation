<?php 
include "../header.php";


$getInvgilatorData    =   mysqli_query($conn,'SELECT s.subject_name,i.* FROM `pe_invigilators` as i JOIN pe_subjects as s ON s.id=i.subject ORDER BY id DESC');
if(mysqli_num_rows($getInvgilatorData) > 0){
    while($invigilatorData   =   mysqli_fetch_assoc($getInvgilatorData)){
        $invigilator[]       =    $invigilatorData;
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
          <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Evaluator data <a href="<?php echo BASE_URL;?>invigilators/assigncandidates.php"  style="float:right;margin-left:10px;" type="button" class="btn btn-sm btn-info btn-icon-text"><i class="ti-check btn-icon-prepend"></i>Assign Candidates</a> <a href="<?php echo BASE_URL;?>invigilators/addeditinvigilator.php"  style="float:right" type="button" class="btn btn-sm btn-info btn-icon-text"><i class="ti-upload btn-icon-prepend"></i>Add Evaluator</a></h4>
                  
                  <div class="table-responsive">
                    <table class="table">
                      <thead>
                        <tr>
                          <th>S.NO</th>
                          <th>Evaluator Name</th>
                          <th>Email</th>
                          <th>Phone</th>
                          <th>Exam</th>
                          <th>Status</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php if(isset($invigilator) && !empty($invigilator)){ $i=1;foreach($invigilator as $invigilator){?>
                        <tr>
                          <td><?php echo $i;?></td>
                          <td><?php echo ucfirst($invigilator['invigilator_name'])?></td>
                          <td><?php echo ucfirst($invigilator['invigilator_email'])?></td>
                          <td><?php echo ucfirst($invigilator['invigilator_phone'])?></td>
                          <td><?php echo ucfirst($invigilator['subject_name'])?></td>
                          <td><label class="badge badge-success"><?php echo $invigilator['status'] == 'A'?'Active':'Inactive'?></label></td>
                          <td>
                          <div class="btn-group">
                          <button style="height:31px;" class="btn btn-danger btn-sm dropdown-toggle" type="button" id="dropdownMenuSizeButton3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">Action </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuSplitButton3">
                              <a class="dropdown-item" href="<?php echo BASE_URL;?>invigilators/addeditinvigilator.php?uid=<?php echo $invigilator['id']?>">Edit Evaluator</a>
                              <div class="dropdown-divider"></div>
                              <a class="dropdown-item" href="<?php echo BASE_URL;?>invigilators/delete.php?uid=<?php echo $invigilator['id']?>">Delete</a>
                              <!-- <div class="dropdown-divider"></div>
                              <a class="dropdown-item" href="<?php echo BASE_URL;?>invigilators/assigncandidates.php?uid=<?php echo $invigilator['id']?>">Assign Candidates</a> -->
                              <div class="dropdown-divider"></div>
                              <a class="dropdown-item" href="<?php echo BASE_URL;?>invigilators/viewassignedcandidates.php?uid=<?php echo $invigilator['id']?>">View Assigned Candidates</a>
                            </div>
                          </div>
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
