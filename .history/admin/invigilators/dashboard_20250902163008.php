<?php 
include "../header.php";
$getinvigilatorData    =   mysqli_query($conn,'SELECT * FROM pe_invigilators');
if(mysqli_num_rows($getinvigilatorData) > 0){
    while($invigilatorData   =   mysqli_fetch_assoc($getinvigilatorData)){
        $invigilator[]       =    $invigilatorData;
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
                    <div class="col-md-12 colspan=3 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Evaluation Dashboard</h4>
                                <p class="error"><?php echo $error ??   '';?></p>
                                <p class="success"><?php echo $success ?? '';?></p>
                                <form class="forms-sample" name="currentDataForm" id="currentDataForm" action="" method="post" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label for="invigilator_id">Select Invigilator</label>
                                        <select class="form-control" name="invigilator_id" id="invigilator_id">
                                            <option value="">Select Invigilator</option>
                                            <?php foreach($invigilator as $invigilator){ ?>
                                            <option value="<?php echo $invigilator['id'];?>"><?php echo $invigilator['invigilator_name'];?></option>
                                            <?php } ?>
                                        </select>
                                    </div>  
                                </form>


                              
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
    <?php include "../footer.php" ?>
