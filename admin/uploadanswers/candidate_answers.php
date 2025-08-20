<?php 
include "../header.php";


$getCandidateData    =   mysqli_query($conn,'SELECT ca.creation_date,ca.question_paper_id,ca.registration_id,c.candidate_name,q.question_paper,ca.status,count(*) as count FROM `pe_candidate_answers` as ca JOIN pe_candidates as c ON c.registration_id=ca.registration_id JOIN pe_question_paper as q ON q.id = ca.question_paper_id GROUP BY c.registration_id,q.id;');
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
                  <h4 class="card-title">Candidate answer data <a href="<?php echo BASE_URL;?>uploadanswers/uploadanswer.php"  style="float:right" type="button" class="btn btn-sm btn-info btn-icon-text"><i class="ti-upload btn-icon-prepend"></i>Upload</a></h4>
                  
                  <div class="table-responsive">
                    <table class="table">
                      <thead>
                        <tr>
                          <th>S.NO</th>
                          <th>Candidate Name</th>
                          <th>Question Paper</th>
                          <th>Total sheets</th>
                          <th>Created</th>
                          <th>Status</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php if(isset($candidate) && !empty($candidate)){ $i=1;foreach($candidate as $candidate){?>
                        <tr>
                          <td><?php echo $i;?></td>
                          <td><?php echo ucfirst($candidate['candidate_name'])?></td>
                          <td><?php echo ucfirst($candidate['question_paper'])?></td>
                          <td><?php echo ucfirst($candidate['count'])?></td>
                          <td><?php echo ucfirst($candidate['creation_date'])?></td>
                          <td><label class="badge badge-success"><?php echo $candidate['status'] == 'A'?'Active':'Inactive'?></label></td>
                          <td>
                          <div class="btn-group">
                          <button style="height:31px;" class="btn btn-danger btn-sm dropdown-toggle" type="button" id="dropdownMenuSizeButton3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">Action </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuSplitButton3">
                              <a class="dropdown-item" href="<?php echo BASE_URL;?>uploadanswers/view_answers.php?cid=<?php echo $candidate['registration_id']?>&qid=<?php echo $candidate['question_paper_id']?>">View Uploaded Answers</a>
                              <div class="dropdown-divider"></div>
                              <a class="dropdown-item" href="<?php echo BASE_URL;?>uploadanswers/delete.php?cid=<?php echo $candidate['registration_id']?>&qid=<?php echo $candidate['question_paper_id']?>">Delete</a>
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
