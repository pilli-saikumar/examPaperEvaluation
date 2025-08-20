<?php 
include "../header.php";


$getSubjectData    =   mysqli_query($conn,'SELECT * FROM pe_subjects ORDER BY subject_name ASC');
if(mysqli_num_rows($getSubjectData) > 0){
    while($subjectData   =   mysqli_fetch_assoc($getSubjectData)){
        $exam[]       =    $subjectData;
    }
}


$success = '';
$error = '';
if(isset($_POST['saveChanges']) && $_POST['saveChanges'] == 'Submit'){



    $exam_id = $_POST['exam_id'];
   $subject_id = $_POST['subject_id'];
    $assign_candidates = $_POST['assign_candidates'];
    
   //First, delete any existing assignments for this subject
    mysqli_query($conn, "DELETE ac FROM pe_assign_candidates ac 
                        JOIN pe_candidates c ON ac.candidate_id = c.id 
                        WHERE c.subject_id = $subject_id");

    if($assign_candidates == 'individual') {
        // Individual assignment logic
        $candidate_assign_count = intval($_POST['candidate_assign_count']);
        $invigilator_ids = $_POST['invigilator_id'];
           $invigilator  = [];
        foreach($invigilator_ids as $invigilator_id){
            $getinvigilatorData    =   mysqli_query($conn,'SELECT id FROM pe_invigilators WHERE id = '.$invigilator_id.'');
            if(mysqli_num_rows($getinvigilatorData) > 0){
                while($invigilatorData   =   mysqli_fetch_assoc($getinvigilatorData)){
                    $invigilator[]       =    $invigilatorData['id'];
        }
    }
        }
    
        $candidates = [];
        $getCandidates = mysqli_query($conn, "SELECT id FROM pe_candidates 
                                            WHERE subject_id = $exam_id
                                            ORDER BY id");
        
        while($cand = mysqli_fetch_assoc($getCandidates)) {
            $candidates[] = $cand['id'];
        }
     
        $totalCandidates = count($candidates);
        $totalInvigilators = count($invigilator);
        
        if($totalInvigilators > 0) {
            // Calculate base candidates per invigilator and remaining candidates
            $baseCandidates = floor($totalCandidates / $totalInvigilators);
            $remainingCandidates = $totalCandidates % $totalInvigilators;
            
            $assigned = 0;
            
            // Assign candidates to each invigilator
            foreach($invigilator as $index => $invigilatorId) {
                // Calculate how many candidates this invigilator gets
                $toAssign = $baseCandidates;
                
                // Distribute remaining candidates one by one
                if($index < $remainingCandidates) {
                    $toAssign++;
                }
                
                // Assign candidates
                for($i = 0; $i < $toAssign; $i++) {
                    if(isset($candidates[$assigned])) {
                        $insertQuery = "INSERT INTO `pe_assign_candidates`(`candidate_id`, `invigilator_id`, `subject_id`) 
                                      VALUES ('".$candidates[$assigned]."', '$invigilatorId', '$subject_id')";
                        mysqli_query($conn, $insertQuery);
                        $assigned++;
                    }
                }
            }
        }

       //  $getinvigilatorData    =   mysqli_query($conn,'SELECT * FROM pe_invigilators WHERE id IN ('.$invigilator_ids.')');
           
        
        // Get candidates for this subject
        // $candidates = [];
        // $getCandidates = mysqli_query($conn, "SELECT id FROM pe_candidates 
        //                                     WHERE subject_id = $subject_id 
        //                                     ORDER BY id 
        //                                     LIMIT $candidate_assign_count");
        
        // // Assign selected number of candidates to the selected invigilator

        // while($candidate = mysqli_fetch_assoc($getCandidates)) {
        //     $insertQuery = "INSERT INTO `pe_assign_candidates`(`candidate_id`, `invigilator_id`, `subject_id`) 
        //                   VALUES ('".$candidate['id']."', '$invigilator_id', '$subject_id')";
        //     mysqli_query($conn, $insertQuery);
        // }
        
    } else {
        // Auto assignment logic
        // Get all invigilators for this subject
        $invigilators = [];
        $getInvigilators = mysqli_query($conn, "SELECT id FROM pe_invigilators 
                                              WHERE subject = $subject_id 
                                              ORDER BY id");
        
        while($inv = mysqli_fetch_assoc($getInvigilators)) {
            $invigilators[] = $inv['id'];
        }
        
        // Get all candidates for this subject
        $candidates = [];
        $getCandidates = mysqli_query($conn, "SELECT id FROM pe_candidates 
                                            WHERE subject_id = $exam_id 
                                            ORDER BY id");
        
        while($cand = mysqli_fetch_assoc($getCandidates)) {
            $candidates[] = $cand['id'];
        }
        
        $totalCandidates = count($candidates);
        $totalInvigilators = count($invigilators);
        
        if($totalInvigilators > 0) {
            // Calculate base candidates per invigilator and remaining candidates
            $baseCandidates = floor($totalCandidates / $totalInvigilators);
            $remainingCandidates = $totalCandidates % $totalInvigilators;
            
            
            $assigned = 0;
            
            // Assign candidates to each invigilator
            foreach($invigilators as $index => $invigilatorId) {
                // Calculate how many candidates this invigilator gets
                $toAssign = $baseCandidates;
                
                // Distribute remaining candidates one by one
                if($index < $remainingCandidates) {
                    $toAssign++;
                }
                
                // Assign candidates
                for($i = 0; $i < $toAssign; $i++) {
                    if(isset($candidates[$assigned])) {
                        $insertQuery = "INSERT INTO `pe_assign_candidates`(`candidate_id`, `invigilator_id`, `subject_id`) 
                                      VALUES ('".$candidates[$assigned]."', '$invigilatorId', '$subject_id')";
                        mysqli_query($conn, $insertQuery);
                        $assigned++;
                    }
                }
            }
        }
    }
    
    // Redirect after successful assignment
    $_SESSION['success'] = "Candidates assigned successfully!";
    redirect(BASE_URL.'invigilators/assigncandidates.php');
}

?>
  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper">
      <?php include_once "../sidebar.php";?>
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 colspan=3 grid-margin stretch-card">
               <div class="card">
                  <div class="card-body">
                     <h4 class="card-title">Assign Candidates</h4>
              
                   
                     <form class="forms-sample" name="currentDataForm" id="currentDataForm" action="" method="post" enctype="multipart/form-data">
                     <input type="hidden" name="id" value="<?php echo isset($_GET['uid'])?$_GET['uid']:''?>">    
                   <?php   if(isset($_SESSION['success']) && $_SESSION['success'] != ''){
                        echo '<div class="alert alert-success">'.$_SESSION['success'].'</div>';
                        unset($_SESSION['success']);
                    }
                    if(isset($_SESSION['error']) && $_SESSION['error'] != ''){
                        echo '<div class="alert alert-danger">'.$_SESSION['error'].'</div>';
                        unset($_SESSION['error']);
                    }
                    ?>
                 
                     <div class="row">
                         
                        <div class="col-md-3 col-sm-3 col-lg-3">
                            <div class="form-group"><label for="exam_id">Exam</label>
                            <select class="form-control" name="exam_id" id="exam_id"  onchange="getsubjectName()" required>
                                <option value="">Choose Exam</option>
                                <?php if(isset($exam) && !empty($exam)){foreach($exam as $exam){?>
                                <option value="<?php echo $exam['id']?>"><?php echo ucfirst($exam['subject_name'])?></option>
                                <?php }}?>
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
                        <div class="col-md-3 col-sm-3 col-lg-3" >
                            <div class="form-group">
                                <label for="assign_candidates">Assign candidates</label>
                            <select class="form-control" name="assign_candidates" id="assign_candidates" required> 
                                <option value="">Select Assign candidates</option>
                                <option value="auto">Auto Assign</option>
                                <option value="individual">Individual Assign</option>
                               
                            </select>
                        </div>
                        </div>
     
   
                      
                          <div class="col-md-3 col-sm-3 col-lg-3" style="display: none;" id="invigilator">
                            <div class="form-group">
                                <label for="invigilator_id">Invigilator</label>
                                <select name="invigilator_id[]"  class="form-select form-control"  id="invigilator_id"  multiple="multiple">
                     
                               
                               
                            </select>
                            </div>
                       
                        
                         </div>

                         <!-- <div class="col-md-3 col-sm-3 col-lg-3" style="display: none;" id="candidate_assign_count">
                            <div class="form-group">
                                <label for="candidate_assign_count">Candidate Assign Count</label>
                           <input type="number" class="form-control" name="candidate_assign_count" id="candidate_assign_count" required>
                        </div>
                       
                        
                         </div> -->
                       
                    </div>
                       
                        <input type="submit" name="saveChanges" class="btn btn-primary mr-2" value="Submit">
                        <a href="<?php echo BASE_URL?>invigilators/invigilators.php" class="btn btn-light">Cancel</a>
                     </form>
                     <div class="row">
                    <div class="col-md-4">
                        <div id="candidateCount" class="p-3"></div>
                    </div>
                    <div class="col-md-4" id="assignedCandidates">
                        <div id="assignedCandidates" class="p-3" ></div>
                    </div>
                    <div class="col-md-4" id="remainingCandidates">
                        <div id="remainingCandidates" class="p-3"></div>
                    </div>
                    
                  </div>
               </div>
            </div>
         </div>
         
        </div>
        
      </div>
    </div>
  </div>
  
  <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.js"></script>


  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script> -->


  <script>

    $(document).ready(function(){

        function initMultiselect() {
            $('#invigilator_id').multiselect({
                buttonWidth: '100%',
                includeSelectAllOption: true,
             
                enableFiltering: false,
                maxHeight: 300,
                numberDisplayed: 2
            });
        }
        initMultiselect();
	           // Form Validation
        if($("#currentDataForm").length) { 
            $("#currentDataForm").validate({
                rules: {
                    "password": {
                        minlength: 6,
                    },
                    "conf_password": {
                        equalTo : "#password",
                        minlength: 6,
                    }
                },
            });
        }
    });

    $(document).on('change', '#assign_candidates', function() {
       
        var assign_candidates = $(this).val();
 
    
        
        if (assign_candidates == 'individual') {
            $('#invigilator').show().prop('required', true);
            // $('#candidate_assign_count').show().prop('required', false);
         
        } else {
            $('#invigilator').hide().prop('required', false);
            // $('#candidate_assign_count').hide().prop('required', true);
            
        }
    });
    // function getInvigilators(){
    //     var subject_id = document.getElementById('subject_id').value;
        


    //     if (subject_id) {
    //         $.ajax({
    //             url: '<?php echo BASE_URL?>invigilators/get_invigilators.php',
    //             type: 'POST',
    //             data: {
    //                 subject_id: subject_id
    //             },
    //             success: function(response) {
    //                 console.log(response);
                    
    //                 document.getElementById('invigilator_id').innerHTML = response;
    //                 document.getElementById('candidateCount').innerHTML = response;
    //             }
    //         });
    //     } else {
    //         // Clear the dropdown and hide other fields if no exam selected
    //         document.getElementById('invigilator_id').innerHTML = '<option value="">Select Invigilator</option>';
    //         document.getElementById('candidateCount').innerHTML = '0';
    //     }
    // }
    function getsubjectName(){
     
        var exam_name = document.getElementById('exam_id').value;
       
        if(exam_name){
            $.ajax({
                url: '<?php echo BASE_URL?>subjects/get_question_paper.php',
                type: 'POST',
                data: {exam_name: exam_name},
                success: function(response){
                    document.getElementById('subject_id').innerHTML = response;
                }
            });
        } else {
            // Clear the dropdown and hide other fields if no exam selected
            document.getElementById('subject_id').innerHTML = '<option value="">Select Subject</option>';
            document.getElementById('upload_field_row').style.display = 'none';
            document.getElementById('submit_button_row').style.display = 'none';
        }
    }
//     function getInvigilators() {
//     var exam_id = document.getElementById('exam_id').value;
//     var subject_id = document.getElementById('subject_id').value;

    
//     if (exam_id) {
//         $.ajax({
//             url: '<?php echo BASE_URL?>invigilators/get_invigilators.php',
//             type: 'POST',
//             data: {     exam_id: exam_id, subject_id: subject_id },
//             success: function(response) {
//                  console.log("Raw Response:", response);
                
//                 // Split the response at the marker
//                 var parts = response.split("||COUNT||");
                
//                 if (parts.length === 2) {
    
//                  document.getElementById('invigilator_id').innerHTML = parts[0];



//                     // Second part is the count
//                     document.getElementById('candidateCount').innerHTML = "Total Candidates: " + parts[1];
//                 } else {
//                     // Fallback in case the response format is unexpected
//                     document.getElementById('invigilator_id').innerHTML = '<option value="">Select Invigilator</option>';
//                     document.getElementById('candidateCount').innerHTML = 'Total Candidates: 0';
//                     document.getElementById('multiple_invigilator').innerHTML = '<option value="">Select Invigilators</option>';
//                 }
//             },
//             error: function(xhr, status, error) {
//                 console.error("Error:", error);
//                 document.getElementById('invigilator_id').innerHTML = '<option value="">Select Invigilator</option>';
//                 document.getElementById('candidateCount').innerHTML = 'Total Candidates: 0';
//             }
//         });
//     } else {
//         // Clear fields if no subject is selected
//         document.getElementById('invigilator_id').innerHTML = '<option value="">Select Invigilator</option>';
//         document.getElementById('candidateCount').innerHTML = 'Total Candidates: 0';
//     }
// }

// $(document).on('change', '#invigilator_id', function() {
//     var invigilator_id = $(this).val();
//     if (invigilator_id) {
//         $.ajax({
//             url: '<?php echo BASE_URL?>invigilators/get_invigilators.php',
//             type: 'POST',
//             data: { invigilator_id: invigilator_id },
//             success: function(response) {
                
//                     document.getElementById('assignedCandidates').innerHTML = "Assigned Candidates: " + response;
    
              
              
//             },
//             error: function(xhr, status, error) {
//                 console.error("Error:", error);
//                 document.getElementById('invigilator_id').innerHTML = '<option value="">Select Invigilator</option>';
//                 document.getElementById('candidateCount').innerHTML = 'Total Candidates: 0';
//             }
//         });
        
//     }
    
   
// });

function getInvigilators() {
        var subject_id = $('#subject_id').val();
        var exam_id = $('#exam_id').val();
        
        if (subject_id && exam_id) {
            // Show loading state
            var $select = $('#invigilator_id');
            $select.html('<option value="">Loading invigilators...</option>');
            
            // Make AJAX request
            $.ajax({
                url: 'get_invigilators.php',
                type: 'POST',
                data: { 
                    subject_id: subject_id, 
                    exam_id: exam_id 
                },
                dataType: 'html',
                success: function(response) {
                    var parts = response.split('||COUNT||');
                    
                   // var partscandidate = response.split('||COUNTCANDIDATE||');
               
                    
                    if (parts.length === 2) {
                        // Destroy existing multiselect
                        if ($.fn.multiselect) {
                            $select.multiselect('destroy');
                        }
                        
                        // Update options
                        $select.html(parts[0]);
                        
                        // Reinitialize multiselect
                        $select.multiselect({
                            buttonWidth: '100%',
                            includeSelectAllOption: true,
                            enableFiltering: true,
                            maxHeight: 300,
                            numberDisplayed: 2
                        });
                        
                        // Update candidate count
                        
                 }
                 $('#candidateCount').html("Total Candidates: " + parts[1]);
                },
                error: function() {
                    $select.html('<option value="">Error loading invigilators</option>');
                    $('#candidateCount').html('Total Candidates: 0');
                }
            });
        } else {
            $('#invigilator_id').html('<option value="">Please select subject and exam first</option>');
            $('#candidateCount').html('Total Candidates: 0');
        }
    }
</script>
 <?php include "../footer.php"?>
