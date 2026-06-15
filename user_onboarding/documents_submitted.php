<?php
    include('../inc/config.php');
    include('../admin/includes/format.php');

    include '../admin/session.php';

    $page_name = 'Documents';
    $page_parent = '';
    $page_title = 'Welcome to the Official Website of '.$settings->siteTitle;
    $page_description = 'We are a service provider of home care and staffing services. Kome Care is committed to providing quality and cost effective medical staffing solutions; in terms of enhancing the quality of life in professional manner for all our service users.';

    include('inc/head.php');

    $id = $_SESSION['onboardee'];

    if(!isset($_SESSION['onboardee'])){
        header('location: ../');
    }

    $today = date('Y-m-d');    
?>

     <body>
    <!-- Left Sidenav -->
    <?php include('inc/sidebar.php'); ?>
    

    <div class="page-wrapper">
        <!-- Top Bar Start -->
    <!-- end left-sidenav-->
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
                                    <h4 class="page-title">Onboarding</h4>
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
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Documents Submitted</h4>
                                <p class="text-muted mb-0">Review and add documents.
                                </p>
                            </div><!--end card-header-->
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered mb-0 table-centered">
                                        <thead>
                                        <tr>
                                            <th>File Name</th>
                                            <th>Validity</th>
                                            <th>Status</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                          <?php
                                            $conn = $pdo->open();

                                            try{
                                              $stmt = $conn->prepare("SELECT *, documents.id AS fileid FROM documents LEFT JOIN documents_list ON documents.file_id = documents_list.id WHERE user_id=:user_id AND documents.soft_delete=0 AND file_status <> :file_status");
                                              $stmt->execute(['user_id'=>$id, 'file_status'=>'requested']);
                                              foreach($stmt as $file){
                                                echo "
                                                  <tr>
                                                    <td>".$file['document_name']."</td>
                                                    <td>".$file['date_issued']." - ".$file['date_expiring']."</td>
                                                    <td>".$file['file_status']."</td>
                                                    <td class='text-right'>
                                                      <a href='../admin/uploads/".$file['file_name']."' class='btn btn-primary btn-sm btn-flat'><i class='fa fa-eye'></i> View</a> 
                                                    </td>
                                                  </tr>
                                                ";
                                              }
                                            }
                                            catch(PDOException $e){
                                              echo $e->getMessage();
                                            }

                                            $pdo->close();
                                          ?>
                                        </tbody>
                                    </table><!--end /table-->
                                </div><!--end /tableresponsive-->
                            </div><!--end card-body-->
                        </div>
                    </div>

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