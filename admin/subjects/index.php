<?php 
include "../header.php";
//

$getSubjectData    =   mysqli_query($conn,'SELECT * FROM `pe_subjects` ORDER BY id DESC');
if(mysqli_num_rows($getSubjectData) > 0){
    while($subjectData   =   mysqli_fetch_assoc($getSubjectData)){
        $subject[]       =    $subjectData;
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
                  <h4 class="card-title">Exam data  <a href="<?php echo BASE_URL;?>subjects/addeditdata.php"  style="float:right" type="button" class="btn btn-sm btn-info btn-icon-text"><i class="ti-upload btn-icon-prepend"></i>Add Exam Name</a></h4>
                  
                  <div class="table-responsive">
                    <table class="table">
                      <thead>
                        <tr>
                          <th>S.NO</th>
                          <th>Exam Name</th>
                          <th>Status</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php if(isset($subject) && !empty($subject)){ $i=1;foreach($subject as $subject){?>
                        <tr>
                          <td><?php echo $i;?></td>
                          <td><?php echo ucfirst($subject['subject_name'])?></td>
                          <td><label class="badge badge-success"><?php echo $subject['status'] == 'A'?'Active':'Inactive'?></label></td>
                          <td>
                          <div class="btn-group">
                          <button style="height:31px;" class="btn btn-danger btn-sm dropdown-toggle" type="button" id="dropdownMenuSizeButton3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">Action </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuSplitButton3">
                              <a class="dropdown-item" href="<?php echo BASE_URL;?>subjects/addeditdata.php?uid=<?php echo $subject['id']?>">Edit Subject</a>
                              <div class="dropdown-divider"></div>
                              <a class="dropdown-item" href="<?php echo BASE_URL;?>subjects/delete.php?uid=<?php echo $subject['id']?>">Delete</a>
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
