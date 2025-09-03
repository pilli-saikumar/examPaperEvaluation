<?php 
include "../header.php";


$getCandidateData    =   mysqli_query($conn,'SELECT c.candidate_name,c.candidate_email,c.id,c.candidate_phone  from pe_assign_candidates as ca JOIN pe_candidates as c ON c.id=ca.candidate_id where ca.invigilator_id ='.$_GET['uid'].' AND ca.subject_id ='..' AND ca.exam_id ='.$_GET['eid'].' group by c.id');
if(mysqli_num_rows($getCandidateData) > 0){
    while($candidateData   =   mysqli_fetch_assoc($getCandidateData)){
        $candidate[]       =    $candidateData;
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
                  <h4 class="card-title">Assigned Candidate data </h4>
                  
                  <div class="table-responsive">
                    <table class="table">
                      <thead>
                        <tr>
                          <th>S.NO</th>
                          <th>Candidate Name</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php if(isset($candidate) && !empty($candidate)){ $i=1;foreach($candidate as $candidate){?>
                        <tr>
                          <td><?php echo $i;?></td>
                          <td><?php echo ucfirst($candidate['candidate_name'])?></td>
                          <!-- <td>
                          <div class="btn-group">
                          <button style="height:31px;" class="btn btn-danger btn-sm dropdown-toggle" type="button" id="dropdownMenuSizeButton3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">Action </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuSplitButton3">
                              <a class="dropdown-item" href="<?php echo BASE_URL;?>invigilators/deletecandidate.php?uid=<?php echo $candidate['id']?>&iid=<?php echo $_GET['uid']?>">Delete</a>
                              </div>
                          </div>
                          </td> -->
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
