<?php 
include "../header.php";
if(isset($_GET['uid']) && !empty($_GET['uid']) && isset($_GET['exam_id']) && !empty($_GET['exam_id']) && isset($_GET['subject_id']) && !empty($_GET['subject_id'])){
$uid = $_GET['uid'];
$exam_id = $_GET['exam_id'];
$subject_id = $_GET['subject_id'];

$getassigneddata    =   mysqli_query($conn,'SELECT * FROM pe_assign_candidates WHERE invigilator_id = '.$uid.' AND exam_id = '.$exam_id.' AND subject_id = '.$subject_id.' ORDER BY id DESC'  );

//$invigilator = [];
if(mysqli_num_rows($getassigneddata) > 0) {
    $invigilator = mysqli_fetch_assoc($getassigneddata);  // Get first row since we're using GROUP BY invigilator_id
}

$exam = array();
$getexam = mysqli_query($conn,'SELECT * FROM pe_subjects');
if(mysqli_num_rows($getexam) > 0){
    while($examData   =   mysqli_fetch_assoc($getexam)){
        $exam[]       =    $examData;
    }
}


$subject = array();
$getsubject = mysqli_query($conn,'SELECT * FROM pe_question_paper WHERE id = '.$subject_id.'');
if(mysqli_num_rows($getsubject) > 0){
   $subject = mysqli_fetch_assoc($getsubject);
}

$getinvigilator = mysqli_query($conn,'SELECT * FROM pe_invigilators WHERE exam_id = '.$exam_id.' AND subject = '.$subject_id.'');
if(mysqli_num_rows($getinvigilator) > 0){
    while($invigilatorData   =   mysqli_fetch_assoc($getinvigilator)){
        $invigilatorslist[]       =    $invigilatorData;
    }
}

$current_invigilator = mysqli_query($conn,'SELECT * FROM pe_invigilators WHERE id = '.$uid.'');
if(mysqli_num_rows($current_invigilator) > 0){
    $current_invigilator_name = mysqli_fetch_assoc($current_invigilator);
}


}


if(isset($_POST['saveChanges'])){


    $new_invigilator = $_POST['new_invigilator'];
    $current_invigilator = $_POST['current_invigilator'];
    $exam_id = $_POST['exam_id'];
    $subject_id = $_POST['subject_id'];


    $query = "UPDATE pe_assign_candidates 
              SET invigilator_id = ? 
              WHERE invigilator_id = ? 
              AND exam_id = ? 
              AND subject_id = ? 
AND (status IS NULL OR status = 'in process')";

    $stmt = mysqli_prepare($conn, $query);


    mysqli_stmt_bind_param($stmt, 'iiii', $new_invigilator, $current_invigilator, $exam_id, $subject_id);

    // Execute the statement
    if (mysqli_stmt_execute($stmt)) {
       
   
        $rows_affected = mysqli_stmt_affected_rows($stmt);
        echo "Successfully updated " . $rows_affected . " records.";
        
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    
    mysqli_stmt_close($stmt);
   
    
}



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
                                <h4 class="card-title">Swapping Invigilator</h4>
                             
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
                                                    <?php  if (isset($exam) && !empty($exam)) {
                                                        foreach ($exam as $exam) { ?>
                                                            <option value="<?php echo $exam['id'] ?>" <?php echo $exam['id'] == $invigilator['exam_id'] ? 'selected' : '' ?>><?php echo ucfirst($exam['subject_name']) ?></option>
                                                    <?php }
                                                    } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-3 col-lg-3">
                                            <div class="form-group">
                                                <label for="subject_id">Select Subject</label>
                                                <select class="form-control" name="subject_id" id="subject_id" onchange="getInvigilators()" required>
                                                    <?php if (isset($subject) && !empty($subject)) { ?>
                                                        <option value="<?php echo $subject['id'] ?>"><?php echo ucfirst($subject['question_paper']) ?></option>
                                                    <?php } ?>


                                                </select>
                                            </div>
                                        </div>
                                        <!-- <div class="col-md-3 col-sm-3 col-lg-3">
                                            <div class="form-group">
                                                <label for="assign_candidates">Current Assign</label>
                                                <input type="text" class="form-control" name="current_invigilator" id="current_invigilator" value="<?php echo $current_invigilator_name['invigilator_name'] ?>" readonly>
                                               
                                            </div>
                                        </div> -->
                                        <div class="col-md-3 col-sm-3 col-lg-3">
                                        <div class="form-group">
                                            <label for="assign_candidates">Current Assign</label>
                                            <input type="text" class="form-control" value="<?php echo $current_invigilator_name['invigilator_name'] ?>" readonly>
                                            
                                            <input type="hidden" name="current_invigilator" value="<?php echo $current_invigilator_name['id'] ?>">
                                        </div>
                                    </div>
                                       
                                        <div class="col-md-3 col-sm-3 col-lg-3">
                                            <div class="form-group">
                                                <label for="assign_candidates">Assign To</label>
                                             
                                                <select class="form-control" name="new_invigilator" id="new_invigilator" required>
                                                    <option value="">Select Invigilator</option>
                                                    <?php if (isset($invigilatorslist) && !empty($invigilatorslist)) { ?>
                                                        <?php foreach ($invigilatorslist as $invigilatorslist) { ?>
                                                        <option value="<?php echo $invigilatorslist['id'] ?>" ><?php echo ucfirst($invigilatorslist['invigilator_name']) ?></option>
                                                    <?php } ?>
                                                    <?php } ?>

                                                </select>
                                             </div>
                                        </div>

                                        




                                    </div>

                                    <input type="submit" name="saveChanges" class="btn btn-primary mr-2" value="Submit" id="submit_button">
                                    <a href="<?php echo BASE_URL ?>invigilators/invigilatordashboard.php" class="btn btn-light">Cancel</a>
                                    </form>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
    <?php include "../footer.php" ?>

