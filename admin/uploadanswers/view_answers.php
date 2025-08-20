<?php 
include "../header.php";

$candidateId         =   $_GET['cid'];
$paperId             =   $_GET['qid'];
$getCandidateData    =   mysqli_query($conn,'SELECT ca.id,c.candidate_name,q.question_paper,ca.uploaded_answer FROM `pe_candidate_answers` as ca JOIN pe_candidates as c ON c.registration_id=ca.registration_id JOIN pe_question_paper as q ON q.id = ca.question_paper_id WHERE ca.registration_id='.$candidateId.' AND ca.question_paper_id='.$paperId.' ORDER BY ca.id DESC');
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
                  <h4 class="card-title">Candidate answer data <a href="<?php echo BASE_URL;?>uploadanswers/candidate_answers.php"  style="float:right" type="button" class="btn btn-sm btn-info btn-icon-text">Back</a></h4>
                  
                  <div class="table-responsive">
                    <table class="table">
                      <thead>
                        <tr>
                          <th width="5px">S.NO</th>
                          <th width="85px">Answer</th>
                          <th width="10px">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php if(isset($candidate) && !empty($candidate)){ $i=1;foreach($candidate as $candidate){?>
                        <tr>
                          <td><?php echo $i;?></td>
                          <td><img style="width:100px;height:100px;border-radius:0;" src="<?php echo "http://localhost/examPaperEvaluation/".$candidate['uploaded_answer']?>"></td>
                          <td>
                          <button type="button" class="btn btn-danger btn-rounded btn-icon">
                          <a style="color:#fff" href="<?php echo BASE_URL;?>uploadanswers/delete.php?id=<?php echo $candidate['id']?>"><i class="ti-trash"></i></a></button>
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
