<?php 
include "../header.php";
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
                                <p class="error"><?php echo $error;?></p>
                                <p class="success"><?php echo $success;?></p>
                                <


                              
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
    <?php include "../footer.php" ?>
