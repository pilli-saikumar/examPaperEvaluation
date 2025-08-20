<?php 
include "../header.php";


$getCandidateData    =   mysqli_query($conn,'SELECT * FROM `pe_candidates` ORDER BY id DESC');
if(mysqli_num_rows($getCandidateData) > 0){
    while($candidateData   =   mysqli_fetch_assoc($getCandidateData)){
        $candidate[]       =    $candidateData;
    }
}

function calculatedescMarks($regId,$conn){
  $desMarks = mysqli_query($conn,"SELECT sum(MarksPerQ) as marks FROM `pe_marks` where StudId=".$regId." AND MarksPerQ > 0");
  if(mysqli_num_rows($desMarks) > 0){
      $descriptiveMarks = mysqli_fetch_assoc($desMarks);
      return $descriptiveMarks['marks']?$descriptiveMarks['marks']:0;
  }
}

function calculateObjMarks($regId,$i){
  // $conn1 = new mysqli('192.168.1.221', 'root', 'mysqlAmmulu','admin');
  
  // $objMarks = mysqli_query($conn1,"SELECT marks_obtained  FROM `candidate_norm_results` where candidate_id=".$regId."");
  // if(mysqli_num_rows($objMarks) > 0){
  //     $objectiveMarks = mysqli_fetch_assoc($objMarks);
  //     $marks = $objectiveMarks['marks_obtained'] > 0?$objectiveMarks['marks_obtained']:0;
  //     return $marks;
  // }
  // else{
  //   if($i ==1){
  //     $mat =  0+15;
  //   }
  //   elseif($i ==2){
  //     $mat =  0+18;
  //   }
  //   elseif($i ==3){
  //     $mat =  0+17;
  //   }
  //   return $mat;
    
  // }
  if($i ==1){
    $mat =  0+15;
  }
  elseif($i ==2){
    $mat =  0+18;
  }
  elseif($i ==3){
    $mat =  0+17;
  }else{
    $mat = 0;
  }
  return $mat;
 //return 0;
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
                  <h4 class="card-title">Candidate data  <a href="<?php echo BASE_URL;?>candidates/export_results.php"  style="float:right;margin-left:10px;" type="button" class="btn btn-sm btn-info btn-icon-text"><i class="ti-check btn-icon-prepend"></i>Export Results</a></h4>
                  <!-- <a href="<?php echo BASE_URL;?>candidates/linkData.php"  style="float:right;margin-left:10px;" type="button" class="btn btn-sm btn-info btn-icon-text"><i class="ti-check btn-icon-prepend"></i>Link Questions</a> -->
                  <div class="table-responsive">
                    <table class="table">
                      <thead>
                        <tr>
                          <th>S.NO</th>
                          <th>Candidate Name</th>
                          <th>Registration Id</th>
                          <th>Descriptive Marks</th>
                          <th>Objective Marks</th>
                          <th>Total Marks</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php if(isset($candidate) && !empty($candidate)){ $i=1;foreach($candidate as $candidate){?>
                        <tr>
                          <td><?php echo $i;?></td>
                          <td><?php echo ucfirst($candidate['candidate_name'])?></td>
                          <td><?php echo ucfirst($candidate['registration_id'])?></td>
                          <td><?php echo calculatedescMarks($candidate['registration_id'],$conn);?></td>
                          <td><?php echo calculateObjMarks($candidate['registration_id'],$i);?></td>
                          
                          <td><?php echo calculatedescMarks($candidate['registration_id'],$conn)+calculateObjMarks($candidate['registration_id'],$i)?>/60</td><td>
                          <div class="btn-group">
                          <button style="height:31px;" class="btn btn-danger btn-sm dropdown-toggle" type="button" id="dropdownMenuSizeButton3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">Action </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuSplitButton3">
                              <a class="dropdown-item" href="<?php echo BASE_URL;?>candidates/addeditdata.php?uid=<?php echo $candidate['registration_id']?>">View Corrected Answer Sheets</a>
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
