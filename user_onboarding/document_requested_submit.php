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

    $did = $_GET['did'];

    $sql1 = "SELECT *, documents.id AS fileid FROM documents LEFT JOIN documents_list ON documents.file_id = documents_list.id WHERE documents.id=".$did;
    $result1 = $conne->query($sql1);
    $row1 = $result1->fetch_assoc();

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
                                <h4 class="card-title"><?= $row1["document_name"] ?> Document</h4>
                                <p class="text-muted mb-0">Please enter the required document details and submit.
                                </p>
                            </div><!--end card-header-->
                            <form method="POST" action="document_submit.php" enctype="multipart/form-data">
                                <div class="card-body">
                                    <input type="hidden" value="<?= $did ?>" name="id">
                                    <input type="hidden" value="<?= $row1["document_name"] ?>" name="doc_name">
                                    <div class="form-group row">
                                        <label class="col-xl-3 col-lg-3 text-right mb-lg-0 align-self-center">Date Issued</label>
                                        <div class="col-lg-9 col-xl-8">
                                            <input class="form-control" type="date" name="date_issued" placeholder="DD-MM-YYYY">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-xl-3 col-lg-3 text-right mb-lg-0 align-self-center">Date Expiring</label>
                                        <div class="col-lg-9 col-xl-8">
                                            <input class="form-control" type="date" name="date_expiring" placeholder="DD-MM-YYYY">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-xl-3 col-lg-3 text-right mb-lg-0 align-self-center">Document</label>
                                        <div class="col-lg-9 col-xl-8">
                                            <div class="input-group">
                                                <div class="input-group-prepend"><span class="input-group-text"><i class="las la-file-upload"></i></span></div>
                                                
                                                <div class="custom-file">
                                                    <input type="file" name="file_name" class="custom-file-input" id="customFile">
                                                    <label class="custom-file-label" for="customFile">Choose file</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-lg-9 col-xl-8 offset-lg-3">
                                            <button type="submit" name="submit_file" class="btn btn-primary">Submit</button>
                                        </div>
                                    </div>                                                    
                                </div>   
                            </form>
                        </div><!--end card-->
                    </div><!--end col-->
                </div>

            </div><!-- container -->

            <?php include('inc/footer.php'); ?><!--end footer-->
        </div>
        <!-- end page content -->
    </div>
    <!-- end page-wrapper -->

    
    <?php include('inc/scripts.php'); ?>

      
      
  </body>



</html>