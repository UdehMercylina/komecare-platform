<?php
    include('../inc/config.php');
    include('../admin/includes/format.php');

    include '../admin/session.php';

    $page_name = 'Profile';
    $page_parent = '';
    $page_title = 'Welcome to the Official Website of '.$settings->siteTitle;
    $page_description = 'We are a service provider of home care and staffing services. Kome Care is committed to providing quality and cost effective medical staffing solutions; in terms of enhancing the quality of life in professional manner for all our service users.';

    include('inc/head.php');

    $id = $_SESSION['onboardee'];

    if(!isset($_SESSION['onboardee'])){
        header('location: ../');
    }

    $sql0 = "SELECT * FROM users WHERE id=".$id;
    $result0 = $conne->query($sql0);
    $row0 = $result0->fetch_assoc();

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
                                    <h4 class="page-title">Profile</h4>
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
                        <?php
                            if (empty($row0['dob'])) {
                                echo '  
                                        <div class="alert custom-alert custom-alert-primary icon-custom-alert alert-secondary-shadow fade show" role="alert">                                            
                                            <i class="mdi mdi-alert-outline alert-icon text-primary align-self-center font-30 mr-3"></i>
                                            <div class="alert-text my-1">
                                                <span><a href="profile-edit" class="btn mb-1 btn-primary">Click Here</a> to Complete Your Profile Setup</span>
                                            </div>                                        
                                            <div class="alert-close">
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true"><i class="mdi mdi-close font-16"></i></span>
                                                </button>
                                            </div>
                                        </div>
                                    ';
                            }else{echo '';}

                        ?>
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
                                <div class="dastone-profile">
                                    <div class="row">
                                        <div class="col-lg-6 align-self-center mb-3 mb-lg-0">
                                            <div class="dastone-profile-main">
                                                <div class="dastone-profile-main-pic">
                                                    <img src="../admin/images/<?php echo $row0["photo"]; ?>" alt="" height="110" class="rounded-circle">
                                                    <span class="dastone-profile_main-pic-change">
                                                        <i class="fas fa-camera"></i>
                                                    </span>
                                                </div>                                                    
                                                <div class="dastone-profile_user-detail">
                                                    <h5 class="dastone-user-name"><b> Fullname :</b> <?php echo $row0["full_name"] ?></h5>                                                        
                                                    <p class="mb-0 dastone-user-name-post"><b> Username :</b> <?php echo $row0["uname"]; ?></p>                          
                                                </div>
                                            </div>                                                
                                        </div><!--end col-->
                                        
                                        <div class="col-lg-6 ml-auto align-self-center">
                                            <ul class="list-unstyled personal-detail mb-0">
                                                <li class=""><i class="las la-phone mr-2 text-secondary font-22 align-middle"></i> <b> phone </b> : <?php if (empty($row0["phone_no"])) {
                                                    echo 'xxx-xxx-xxx-xxxx';
                                                }else{ echo $row0["phone_no"]; } ?></li>
                                                <li class="mt-2"><i class="las la-envelope text-secondary font-22 align-middle mr-2"></i> <b> Email </b> : <?php echo $row0["email"]; ?></li>
                                                <li class="mt-2"><i class="las la-globe text-secondary font-22 align-middle mr-2"></i> <b> Full Address </b> : 
                                                    <?php if (empty($row0["address"])) {
                                                    echo 'xxxxxxxxxxxxx';
                                                }else{ echo $row0["address"].', '.$row0["town_city"].', '.$row0["postcode"].' '.$row0["country"]; } ?>
                                                </li>                                                   
                                            </ul>
                                           
                                        </div><!--end col-->
                                    </div><!--end row-->
                                </div><!--end f_profile-->                                                                                
                            </div><!--end card-body-->          
                        </div> <!--end card-->    
                    </div><!--end col-->
                </div><!--end row-->

                <div class="row">
                    <div class="col-12">
                        <div class="card">                              
                            <div class="card-body">
                                <div class="dastone-profile">
                                    <div class="row">
                                        
                                        <div class="col-lg-4 ml-auto align-self-center">
                                            <ul class="list-unstyled personal-detail mb-0">
                                                <li class=""><i class="las la-genderless mr-2 text-secondary font-22 align-middle"></i> <b> Gender </b> : <?php if (empty($row0["gender"])) {
                                                    echo 'xx-xxxx';
                                                }else{ echo $row0["gender"]; } ?></li>               
                                            </ul>
                                           
                                        </div><!--end col-->
                                        
                                        <div class="col-lg-4 ml-auto align-self-center">
                                            <ul class="list-unstyled personal-detail mb-0">
                                                <li class="mt-2"><i class="las la-calendar text-secondary font-22 align-middle mr-2"></i> <b> Date Of Birth </b> : <?php if (empty($row0["dob"])) {
                                                    echo 'DD-MM-YYYY';
                                                }else{ echo $row0["dob"]; } ?></li>                 
                                            </ul>
                                           
                                        </div><!--end col-->
                                        
                                        <div class="col-lg-4 ml-auto align-self-center">
                                            <ul class="list-unstyled personal-detail mb-0">
                                                <li class="mt-2"><i class="las la-calendar-check text-secondary font-22 align-middle mr-2"></i> <b> Date Joined </b> : 
                                                    <?php echo $row0["created_on"]; ?>
                                                </li>                                                   
                                            </ul>
                                           
                                        </div><!--end col-->
                                    </div><!--end row-->
                                </div><!--end f_profile-->                                                                                
                            </div><!--end card-body-->          
                        </div> <!--end card-->    
                    </div><!--end col-->
                </div><!--end row-->

                <div class="row">
                    <div class="col-12">
                        <div class="card">                              
                            <div class="card-body">
                                <div class="dastone-profile">
                                    <div class="row">
                                        
                                        <div class="col-lg-4 ml-auto align-self-center">
                                            <ul class="list-unstyled personal-detail mb-0">
                                                <li class=""><i class="las la-id-badge mr-2 text-secondary font-22 align-middle"></i> <b> Profile Code </b> : <?php if (empty($row0["profile_code"])) {
                                                    echo 'Not Given Yet';
                                                }else{ echo $row0["profile_code"]; } ?></li>               
                                            </ul>
                                           
                                        </div><!--end col-->
                                        
                                        <div class="col-lg-4 ml-auto align-self-center">
                                            <ul class="list-unstyled personal-detail mb-0">
                                                <li class="mt-2"><i class="las la-briefcase text-secondary font-22 align-middle mr-2"></i> <b> Role/Skill </b> : <?php if (empty($row0["career_path"])) {
                                                    echo 'N/A';
                                                }else{ echo $row0["career_path"]; } ?></li>                 
                                            </ul>
                                           
                                        </div><!--end col-->
                                        
                                        <div class="col-lg-4 ml-auto align-self-center">
                                            <ul class="list-unstyled personal-detail mb-0">
                                                <li class="mt-2"><i class="dripicons-enter text-secondary font-22 align-middle mr-2"></i> <b> Last Sign-In </b> : <?php if (empty($row0["date_view"])) {
                                                    echo 'xxxxxxxx';
                                                }else{ echo $row0["date_view"]; } ?>
                                                </li>                                                   
                                            </ul>
                                           
                                        </div><!--end col-->
                                    </div><!--end row-->
                                </div><!--end f_profile-->                                                                                
                            </div><!--end card-body-->          
                        </div> <!--end card-->    
                    </div><!--end col-->
                </div><!--end row-->

                <?php if ($row0["status"] == 0) { ?>

                <div class="row">
                    <div class="col-12">
                        <div class="card mt-20">
                            <div class="card-header">
                                <h4 class="card-title">Identity Verification</h4>
                                <p class="text-danger mb-0">Your account has not been activated as your identity has not been verified. Submit supporting documents for identity verification as requested by the HR Department. You can select more than one document to submit at once.
                                </p>
                            </div><!--end card-header-->
                            <div class="card-body">
                                <form class="form-inline" method="post" action="profile-verification-action.php" enctype="multipart/form-data">
                                    <input type="hidden" name="user_id" value="<?= $id; ?>">
                                    <div class="form-group">
                                        <label class="sr-only" for="fileName">File Name</label>
                                        <input type="text" name="file_name" class="form-control" id="fileName" placeholder="Enter File Name" required>
                                    </div>
                                    <div class="form-group ml-1">
                                        <div class="custom-file">
                                            <input type="file" name="identity_file[]" class="custom-file-input" id="customFile" multiple required>
                                            <label class="custom-file-label" for="customFile">Choose file</label>
                                        </div>
                                    </div>
                                    <button type="submit" name="submit_file" class="btn btn-primary ml-2">Verify Identity</button>
                                </form>

                                
                            </div><!--end card-body-->
                        </div><!--end card-->
                    </div><!--end col-->
                </div><!--end row-->

                <?php } ?>

                <!--<div class="row">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="card">                                                        
                                    <div class="card-body  report-card">
                                        <div class="row d-flex justify-content-center">
                                            <div class="col">
                                                <p class="text-dark mb-1 font-weight-semibold">Wallet Balance</p>
                                                <h3 class="my-2 font-24 font-weight-bold">&#36; <?php echo number_format_short($row1["balance"], 2); ?></h3>
                                                
                                            </div>
                                            <div class="col-auto align-self-center">
                                                <div class="report-main-icon bg-light-alt">
                                                    <i data-feather="briefcase" class="align-self-center text-muted icon-md"></i>  
                                                </div>
                                            </div>
                                        </div>
                                    </div>      
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="card">                                                        
                                    <div class="card-body  report-card">
                                        <div class="row d-flex justify-content-center">
                                            <div class="col">
                                                <p class="text-dark mb-1 font-weight-semibold">Referral Code: <?php echo $row0["uname"]; ?></p>
                                                <h3 class="my-2 font-24 font-weight-bold"> <?php echo number_format_short($no_of_referrals, 0); ?> Referral(s)</h3>
                                            </div>
                                            <div class="col-auto align-self-center">
                                                <div class="report-main-icon bg-light-alt">
                                                    <i data-feather="git-merge" class="align-self-center text-muted icon-md"></i>  
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>-->


            </div><!-- container -->

            <?php include('inc/footer.php'); ?><!--end footer-->
        </div>
        <!-- end page content -->
    </div>
    <!-- end page-wrapper -->

    
    <?php include('inc/scripts.php'); ?>

      
      
</body>

</html>