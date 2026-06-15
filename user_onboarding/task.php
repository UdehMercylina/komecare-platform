<?php
    include('../inc/config.php');
    include('../admin/includes/format.php');

    include '../admin/session.php';

    $t_id = $_REQUEST['id'];

    $page_name = 'Task';
    $page_parent = '';
    $page_title = 'Welcome to the Official Website of '.$settings->siteTitle;
    $page_description = 'We are a service provider of home care and staffing services. Kome Care is committed to providing quality and cost effective medical staffing solutions; in terms of enhancing the quality of life in professional manner for all our service users.';

    include('inc/head.php');

    $id = $_SESSION['onboardee'];

    if(!isset($_SESSION['onboardee'])){
        header('location: ../');
    }

    $sqlId = "SELECT * FROM users WHERE id=".$id;
    $resultId = $conne->query($sqlId);
    $rowId = $resultId->fetch_assoc();

    if($rowId["status"] == 0){
        header('location: profile.php');
    }

    $stmtQuery = $conn->query("SELECT * FROM task WHERE task_id = $t_id LIMIT 1");
    if ($stmtQuery->rowCount()) {
       $task = $stmtQuery->fetchAll(PDO::FETCH_OBJ);
    }

    $taskFileQuery = $conn->query("SELECT * FROM task_files WHERE task_id=$t_id order by 1 desc ");
    if ($taskFileQuery->rowCount()) {
       $task_file = $taskFileQuery->fetchAll(PDO::FETCH_OBJ);
    }

?>

     <body>
    <!-- Left Sidenav -->
    <?php include('inc/sidebar.php'); ?>
    <!-- end left-sidenav-->
    

    <div class="page-wrapper">
        <!-- Top Bar Start -->
        <?php include('inc/header.php'); ?>
        <!-- Top Bar End -->

        <!-- Page Content-->
        <div class="page-content">
            <div class="container-fluid">
                <!-- Page-Title -->
                <div class="row">
                    <div class="col-sm-12">
                        <div class="page-title-box">
                            <div class="row">
                                <div class="col">
                                    <h4 class="page-title">Task</h4>
                                </div><!--end col-->
                                <div class="col-auto align-self-center">
                                    <a href="#" class="btn btn-sm btn-outline-primary" id="Dash_Date">
                                        <span class="day-name" id="Day_Name">Today:</span>&nbsp;
                                        <span class="" id="Select_date">Jan 11</span>
                                        <i data-feather="calendar" class="align-self-center icon-xs ml-1"></i>
                                    </a>
                                </div><!--end col-->  
                            </div><!--end row-->                                                              
                        </div><!--end page-title-box-->
                    </div><!--end col-->
                </div><!--end row-->
                <!-- end page title end breadcrumb -->

                <?php
                    if(isset($_SESSION['error'])){
                      echo "
                        <div class='alert alert-danger border-0' role='alert'>
                            <i class='la la-skull-crossbones alert-icon text-danger align-self-center font-30 mr-3'></i>
                            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                <span aria-hidden='true'><i class='mdi mdi-close align-middle font-16'></i></span>
                            </button>
                            <strong>Oh snap!</strong> ".$_SESSION['error']."
                        </div>
                      ";
                      unset($_SESSION['error']);
                    }
                    if(isset($_SESSION['success'])){
                      echo "
                        <div class='alert alert-success border-0' role='alert'>
                            <i class='mdi mdi-check-all alert-icon'></i>
                            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                <span aria-hidden='true'><i class='mdi mdi-close align-middle font-16'></i></span>
                            </button>
                            <strong>Well done!</strong> ".$_SESSION['success']."
                        </div>
                      ";
                      unset($_SESSION['success']);
                    }
                ?>

                <div class="row">
                    <div class="col-12">
                        <div class="card">                              
                            <div class="card-body">
                                <div class="card-body">
                                    <?php
                                        foreach ($task as $tsk) : ?>

                                        <div class="media mb-4">
                                            <img class="d-flex mr-3 rounded-circle thumb-md" src="../admin/dist/img/favicon.png" alt="Generic placeholder image">
                                            <div class="media-body align-self-center">
                                                <h5 class="font-14 m-0"><?= $settings->siteTitle ?> Admin</h5>
                                                <small class="text-muted"><?= $settings->email ?></small>
                                            </div>
                                        </div>

                                        <h4 class="mt-0 font-15"><?= $tsk->task_title; ?></h4>

                                        <?= $tsk->task_description; ?>


                                    <?php
                                       endforeach; ?>

                                    
                                </div>
                            </div><!--end card-body-->          
                        </div> <!--end card-->

                        <?php if (!empty($task_file)) { ?>
                            
                        <div class="">                                    
                            <div class="tab-content" id="files-tabContent">
                                
                                <div class="tab-pane fade show active" id="files-projects">
                                    <h4 class="card-title mt-0 mb-3">Task Files</h4>                                         
                                    <div class="file-box-content">

                                        <?php
                                            foreach ($task_file as $tsk_file) : 
                                                $upload_date = date('M j Y', strtotime($tsk_file->task_file_upload_date));

                                                $file_ext = pathinfo($tsk_file->task_file, PATHINFO_EXTENSION);
                                                $file_icon = 'la-file text-secondary';
                                                if (($file_ext == 'doc') || ($file_ext == 'docx') ) {
                                                    $file_icon = 'la-file-word text-primary';
                                                }elseif (($file_ext == 'zip') || ($file_ext == 'rar') ) {
                                                    $file_icon = 'la-file-archive text-warning';
                                                }elseif ($file_ext == 'pdf' ) {
                                                    $file_icon = 'la-file-pdf text-danger';
                                                }elseif (($file_ext == 'jpg') || ($file_ext == 'jpeg') || ($file_ext == 'png')) {
                                                    $file_icon = 'la-file-image text-info';
                                                }elseif ($file_ext == 'csv' ) {
                                                    $file_icon = 'la-file-excel text-success';
                                                }elseif ($file_ext == 'txt' ) {
                                                    $file_icon = 'la-file-alt text-dark';
                                                }
                                                ?>

                                            <div class="file-box">
                                                <a target="_blank" href="../admin/uploads/<?= $tsk_file->task_file; ?>" class="download-icon-link">
                                                    <i class="dripicons-download file-download-icon"></i>
                                                </a>
                                                <div class="text-center">
                                                    <i class="lar <?= $file_icon; ?>"></i>
                                                    <h6 class="text-truncate"><?= $tsk_file->task_file_name; ?></h6>
                                                    <small class="text-muted"><?= $upload_date; ?> / <?= $tsk_file->task_file_size; ?></small>
                                                </div>
                                            </div>

                                           
                                        <?php
                                           endforeach; ?>

                                    </div>
                                </div><!--end tab-pane-->

                            </div>  <!--end tab-content-->                                                                              
                        </div><!--end card-body-->
                            
                        <?php  }  ?>

                        <div class="card mt-20">
                            <div class="card-header">
                                <h4 class="card-title">Submit Task</h4>
                                <p class="text-muted mb-0">The task can be submitted in any file format. You can select more than one file to submit at once.
                                </p>
                            </div><!--end card-header-->
                            <div class="card-body">
                                <form class="form-inline" method="post" action="task-submit-action.php" enctype="multipart/form-data">
                                    <input type="hidden" name="task_id" value="<?= $t_id; ?>">
                                    <div class="form-group">
                                        <label class="sr-only" for="fileName">File Name</label>
                                        <input type="text" name="file_name" class="form-control" id="fileName" placeholder="Enter File Name" required>
                                    </div>
                                    <div class="form-group ml-1">
                                        <div class="custom-file">
                                            <input type="file" name="task_file[]" class="custom-file-input" id="customFile" multiple required>
                                            <label class="custom-file-label" for="customFile">Choose file</label>
                                        </div>
                                    </div>
                                    <button type="submit" name="submit_file" class="btn btn-primary ml-2">Submit Task</button>
                                </form>

                                
                            </div><!--end card-body-->
                        </div><!--end card-->
                    </div><!--end col-->
                </div><!--end row-->


            </div><!-- container -->

            <?php include('inc/footer.php'); ?><!--end footer-->
        </div>
        <!-- end page content -->
    </div>
    <!-- end page-wrapper -->

    
    <?php include('inc/scripts.php'); ?>

      
      
  </body>

</html>