<nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
          <li class="nav-item">
            <a class="nav-link" href="<?php echo BASE_URL.'dashboard.php';?>">
              <i class="icon-grid menu-icon"></i>
              <span class="menu-title">Dashboard</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#myerror2" aria-expanded="false" aria-controls="myerror">
              <i class="icon-head  menu-icon"></i>
              <span class="menu-title">Evaluator Dashboard </span>
               <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="myerror2">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="<?php echo BASE_URL;?>i/index.php">Evaluator Dashboard </a></li>
              </ul>
              
            </div>
            
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#myerror3" aria-expanded="false" aria-controls="myerror">
              <i class="icon-head  menu-icon"></i>
              <span class="menu-title">Manage Master Data </span>
               <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="myerror">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="<?php echo BASE_URL;?>subjects/index.php">Manage Exam </a></li>
              </ul>
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="<?php echo BASE_URL;?>subjects/manage_course.php"> Add Subject </a></li>
              </ul>
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="<?php echo BASE_URL;?>subjects/upload_questions.php"> Upload Questions </a></li>
              </ul>
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="<?php echo BASE_URL;?>subjects/view_questions.php"> View Questions </a></li>
              </ul>
              
              
            </div>
            
          </li>
         
          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#error" aria-expanded="false" aria-controls="error">
              <i class="icon-upload menu-icon"></i>
              <span class="menu-title">Manage Uploads</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="error">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="<?php echo BASE_URL;?>uploadanswers/candidate_answers.php">Candidate Answers </a></li>
              </ul>
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="<?php echo BASE_URL;?>candidates/add_candidate_details.php">Candidate Details </a></li>
              </ul>
            </div>
            
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#error1" aria-expanded="false" aria-controls="error1">
              <i class="icon-head  menu-icon"></i>
              <span class="menu-title">Manage Users </span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="error1">
            <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="<?php echo BASE_URL;?>invigilators/invigilatordashboard.php">Evaluator Dashboard </a></li>
              </ul>
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="<?php echo BASE_URL;?>invigilators/invigilators.php">Evaluator </a></li>
              </ul>
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="<?php echo BASE_URL;?>candidates/index.php">Candidate </a></li>
              </ul>
              
            </div>
            
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#myerror" aria-expanded="false" aria-controls="myerror">
              <i class="icon-head  menu-icon"></i>
              <span class="menu-title">Manage Exam Data </span>
               <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="myerror">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="<?php echo BASE_URL;?>subjects/index.php">Manage Exam </a></li>
              </ul>
              
            </div>
            
          </li>
          
        </ul>
      </nav>