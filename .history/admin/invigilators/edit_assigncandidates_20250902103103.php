<?php 
include "../header.php";

$uid = $_POST['uid'];
$exam_id = $_POST['exam_id'];
$subject_id = $_POST['subject_id'];

$getInvigilatorData    =   mysqli_query($conn,'SELECT * FROM pe_assign_candidates WHERE invigilator_id = '.$uid.' AND exam_id = '.$exam_id.' AND subject_id = '.$subject_id.'' );

if(mysqli_num_rows($getInvigilatorData) > 0){
    while($invigilatorData   =   mysqli_fetch_assoc($getInvigilatorData)){
        $invigilator[]       =    $invigilatorData;
    }
}

Warning:  Undefined variable $invigilator in C:\xampp\htdocs\examPaperEvaluation\admin\invigilators\edit_assigncandidates.php on line 16

?>
<div class="container-scroller">
    <div class="container-fluid page-body-wrapper">
        <?php include_once "../sidebar.php"; ?>
        <!-- partial -->
        <div class="main-panel">
            <div class="content-wrapper">
                <div class="row">
                    <div class="col-md-12 colspan=3 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Assign Candidates</h4>


                                <form class="forms-sample" name="currentDataForm" id="currentDataForm" action="" method="post" enctype="multipart/form-data">
                                    <input type="hidden" name="id" value="<?php echo isset($_GET['uid']) ? $_GET['uid'] : '' ?>">
                                    <?php if (isset($_SESSION['success']) && $_SESSION['success'] != '') {
                                        echo '<div class="alert alert-success">' . $_SESSION['success'] . '</div>';
                                        unset($_SESSION['success']);
                                    }
                                    if (isset($_SESSION['error']) && $_SESSION['error'] != '') {
                                        echo '<div class="alert alert-danger">' . $_SESSION['error'] . '</div>';
                                        unset($_SESSION['error']);
                                    }
                                    ?>

                                    <div class="row">

                                        <div class="col-md-3 col-sm-3 col-lg-3">
                                            <div class="form-group"><label for="exam_id">Exam</label>
                                                <select class="form-control" name="exam_id" id="exam_id" onchange="getsubjectName()" required>
                                                    <option value="">Choose Exam</option>
                                                    <?php if (isset($exam) && !empty($exam)) {
                                                        foreach ($exam as $exam) { ?>
                                                            <option value="<?php echo $exam['id'] ?>"><?php echo ucfirst($exam['subject_name']) ?></option>
                                                    <?php }
                                                    } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-3 col-lg-3">
                                            <div class="form-group">
                                                <label for="subject_id">Select Subject</label>
                                                <select class="form-control" name="subject_id" id="subject_id" onchange="getInvigilators()" required>
                                                    <option value="">Select Subject</option>


                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-3 col-lg-3">
                                            <div class="form-group">
                                                <label for="assign_candidates">Assign candidates</label>
                                                <select class="form-control" name="assign_candidates" id="assign_candidates" required>
                                                    <option value="">Select Assign candidates</option>
                                                    <option value="auto">Auto Assign</option>
                                                    <option value="individual">Individual Assign</option>

                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-12 col-sm-6 col-lg-6" id="invigilator" style="display: none;"></div>



                                        <!-- 
                                        <div class="col-md-3 col-sm-3 col-lg-3" style="display: none;" id="invigilator">
                                            <div class="form-group">
                                                <label for="invigilator_id">Invigilator</label>
                                                <select name="invigilator_id[]" class="form-select form-control" id="invigilator_id" multiple="multiple">



                                                </select>
                                            </div>


                                        </div> -->

                                        <!-- <div class="col-md-3 col-sm-3 col-lg-3" style="display: none;" id="candidate_assign_count">
                            <div class="form-group">
                                <label for="candidate_assign_count">Candidate Assign Count</label>
                           <input type="number" class="form-control" name="candidate_assign_count" id="candidate_assign_count" required>
                        </div>
                       
                        
                         </div> -->

                                    </div>

                                    <input type="submit" name="saveChanges" class="btn btn-primary mr-2" value="Submit" id="submit_button">
                                    <a href="<?php echo BASE_URL ?>invigilators/invigilators.php" class="btn btn-light">Cancel</a>
                                </form>
                                <div class="row">
                                    
                                    <div class="col-md-4" >
                                        <div id="candidateCount" class="p-3"></div>
                                    </div>
                                    <div class="col-md-4" id="msg" style="color: red;" style="display: none;">
                                        
                                    </div>
                                    <div class="col-md-4" id="totalAssignedCount">
                                      
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
    <?php include "../footer.php" ?>

