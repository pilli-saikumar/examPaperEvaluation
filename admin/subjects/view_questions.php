<?php
include "../header.php";
$getSubjectData    =   mysqli_query($conn, 'SELECT * FROM `pe_subjects` ORDER BY id DESC');
if (mysqli_num_rows($getSubjectData) > 0) {
    while ($subjectData   =   mysqli_fetch_assoc($getSubjectData)) {
        $subject[]       =    $subjectData;
    }
}
if(isset($_POST['viewQuestions']) && $_POST['viewQuestions'] == 'View Questions'){
    $exam_id         =   $_POST['exam_name'];
    $course_id        =   $_POST['question_paper'];
    $getquestiondata = mysqli_query($conn, "SELECT * FROM `pe_qpapers` WHERE `QpId` = '$exam_id' AND `CourseId` = '$course_id'");
    $question = [];
    if (mysqli_num_rows($getquestiondata) > 0) {
        while ($questionData   =   mysqli_fetch_assoc($getquestiondata)) {
            $question[]       =    $questionData;
        }
    }
    
}
?>
<div class="container-scroller">
    <div class="container-fluid page-body-wrapper">
        <?php include_once "../sidebar.php"; ?>
        <!-- partial -->
        <div class="main-panel">
            <div class="content-wrapper">
                <div class="row">
                    <div class="col-md-12 colspan=3 grid-margin stretch-card ">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">View Questions</h4>

                                <form class="forms-sample" name="currentDataForm" id="currentDataForm" action="" method="post" enctype="multipart/form-data">
                                    <?php if (!empty($success)): ?>
                                        <div id="success-message" style="color: green; font-weight: bold;">
                                            <?= $success ?>
                                        </div>
                                    <?php endif; ?>

                                    <?php if (!empty($error)): ?>
                                        <div id="error-message" style="color: red; font-weight: bold;">
                                            <?= $error ?>
                                        </div>
                                    <?php endif; ?>
                                    <input type="hidden" name="id" value="<?php echo isset($_GET['uid']) ? $_GET['uid'] : '' ?>">
                                    <div class="row">
                                        <div class="col-md-6 col-sm-6 col-lg-6">
                                            <div class="form-group">
                                                <label for="exampleInputUsername1">Exam Name</label>
                                                <select class="form-control" name="exam_name" id="exam_name" required onchange="getQuestionPaper()">
                                                    <option value="">Select Exam Name</option>
                                                    <?php if (isset($subject) && !empty($subject)) {
                                                        foreach ($subject as $subject) { ?>
                                                            <option value="<?php  echo $subject['id'] ?>"><?php echo ucfirst($subject['subject_name']) ?></option>
                                                    <?php }
                                                    } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-lg-6">
                                            <div class="form-group">
                                                <label for="question_paper">Question Paper</label>
                                                <select class="form-control" name="question_paper" id="question_paper" required onchange="showUploadField()">
                                                    <option value="">Select Question Paper</option>
                                                </select>
                                            </div>
                                        </div>


                                    </div>
                                    <div class="row ml-2">
                                        <input type="submit" name="viewQuestions" class="btn btn-primary mr-2" value="View Questions">
                                    </div>


                                    <!-- <a href="<?php echo BASE_URL ?>subjects/index.php" class="btn btn-light">Cancel</a> -->
                                </form>

                            </div>
                        </div>
                    </div>
                </div>

           
         
                <?php
    $isFormSubmitted = isset($_POST['viewQuestions']);
    ?>
         
             
         
                <div class="row mt-2">
                    <div class="col-12">
                        <div class="table-responsive">
                        <table class="table table-bordered table-hover table-striped" id="questionsTable">
                            <thead class="thead-dark">
                            <tr>
                                <th>QNo</th>
                                <th>SubQNo</th>
                                <th>QStmt</th>
                                <th>MaxMarks</th>
                                <th>Setter</th>
                                
                                <th>Min Answer</th>
                                <th>Total Marks</th>
                            </tr>
                            </thead>
                            <tbody>
                                <?php if ($isFormSubmitted && isset($question) && !empty($question)): ?>
                            <?php foreach ($question as $q): ?>
                                <tr>
                                <td><?= htmlspecialchars($q['QNo']) ?></td>
                                <td><?= htmlspecialchars($q['SubQNo']) ?></td>
                            
                                <td title="<?= htmlspecialchars($q['QStmt']) ?>">
                                    <?= htmlspecialchars(mb_strimwidth($q['QStmt'], 0, 50, "...")) ?>
                                </td>
                                <td><?= htmlspecialchars($q['MaxMarks']) ?></td>
                                <td><?= htmlspecialchars($q['Setter']) ?></td>
                                <td><?= htmlspecialchars($q['min_ans']) ?></td>
                                <td><?= htmlspecialchars($q['total_marks']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="7" class="text-center">No questions found.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                        </div>
                    </div>
                    </div>
                    
                    
           

        </div>
    </div>
</div>
<script>
 
 $(document).ready(function() {
    $('#questionsTable').DataTable({
        dom: 'Bfrtip', // B = Buttons
        buttons: [
        
            {
                extend: 'csv',
                text: 'CSV'
            },
            {
                extend: 'excel',
                text: 'Excel'
            },
           
        ]
    });
})
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(function() {
            const successBox = document.getElementById('success-message');
            const errorBox = document.getElementById('error-message');

            if (successBox) successBox.style.display = 'none';
            if (errorBox) errorBox.style.display = 'none';
        }, 5000); // 5000 milliseconds = 5 seconds
    });

    function getQuestionPaper() {
        var exam_name = document.getElementById('exam_name').value;

        if (exam_name) {
            $.ajax({
                url: '<?php echo BASE_URL ?>subjects/get_question_paper.php',
                type: 'POST',
                data: {
                    exam_name: exam_name
                },
                success: function(response) {
                    document.getElementById('question_paper').innerHTML = response;
                }
            });
        } else {
            // Clear the dropdown and hide other fields if no exam selected
            document.getElementById('question_paper').innerHTML = '<option value="">Select Question Paper</option>';
            document.getElementById('upload_field_row').style.display = 'none';
            document.getElementById('submit_button_row').style.display = 'none';
        }
    }

    function showUploadField() {
        var question_paper = document.getElementById('question_paper').value;
        if (question_paper) {
            document.getElementById('upload_field_row').style.display = 'block';
            document.getElementById('submit_button_row').style.display = 'block';
        } else {
            document.getElementById('upload_field_row').style.display = 'none';
            document.getElementById('submit_button_row').style.display = 'none';
        }
    }
</script>
<?php include "../footer.php"?>