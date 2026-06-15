<?php
    include('../inc/config.php');
    include('../admin/includes/format.php');

    include '../admin/session.php';

    $page_name = 'Dashboard';
    $page_parent = '';
    $page_title = 'Welcome to the Official Website of '.$settings->siteTitle;
    $page_description = 'We are a service provider of home care and staffing services. Kome Care is committed to providing quality and cost effective medical staffing solutions; in terms of enhancing the quality of life in professional manner for all our service users.';

    include('inc/head.php');

    $id = $_SESSION['onboardee'];

    if(!isset($_SESSION['onboardee'])){
        header('location: ../');
    }

    $today = date('Y-m-d');
    $today_in_secs = strtotime($today);
    $year = date('Y');
    if(isset($_GET['year'])){
        $year = $_GET['year'];
    }

    $sqlId = "SELECT * FROM users WHERE id=".$id;
    $resultId = $conne->query($sqlId);
    $rowId = $resultId->fetch_assoc();

    if($rowId["status"] == 0){
        header('location: profile.php');
    }

    $sql1 = "SELECT *, COUNT(*) AS num_of_tasks FROM documents WHERE user_id = ".$id." && soft_delete=0 ORDER BY date_requested DESC LIMIT 1";
    $result1 = $conne->query($sql1);
    $row1 = $result1->fetch_assoc();
    $no_of_tasks = $row1['num_of_tasks'];

    $sql2 = "SELECT *, COUNT(*) AS num_of_pending_tasks FROM documents WHERE user_id = ".$id." && soft_delete=0 && file_status = 'requested' ORDER BY date_requested DESC LIMIT 1";
    $result2 = $conne->query($sql2);
    $row2 = $result2->fetch_assoc();
    $no_of_pending_tasks = $row2['num_of_pending_tasks'];

    $sql3 = $conn->prepare("SELECT *, COUNT(*) AS num_of_msg FROM direct_message WHERE user_id=$id");
    $sql3->execute();
    $row3 = $sql3->fetch();
    $no_of_msgs = $row3['num_of_msg'];

    $sql4 = $conn->prepare("SELECT *, COUNT(*) AS num_of_unread_msg FROM direct_message WHERE user_id=$id && status=0");
    $sql4->execute();
    $row4 = $sql4->fetch();
    $no_of_unread_msg = $row4['num_of_unread_msg'];

    $sql5 = $conn->prepare("SELECT *, COUNT(*) AS num_of_read_msg FROM direct_message WHERE user_id=$id && status=1");
    $sql5->execute();
    $row5 = $sql5->fetch();
    $no_of_read_msg = $row5['num_of_read_msg'];

    $sql6 = $conn->query("SELECT * FROM documents WHERE user_id=$id && soft_delete=0 ORDER BY id ASC");
    if ($sql6->rowCount()) {
       $row6 = $sql6->fetchAll(PDO::FETCH_OBJ);
    }

    $document_requested = $document_approved = $document_submitted = $percent_requested = $percent_approved = $percent_submitted = 0;

    if (!empty($row6)) {
    
        $sql7 = $conn->prepare("SELECT *, COUNT(*) AS numrows FROM documents WHERE user_id = $id && soft_delete=0 && file_status = 'requested' ");
        $sql7->execute();
        $row7 = $sql7->fetch();

        $document_requested = $row7['numrows'];

        $percent_requested = number_format($document_requested*100/$no_of_tasks, 0);

        $sql8 = $conn->prepare("SELECT *, COUNT(*) AS numrows FROM documents WHERE user_id = $id && soft_delete=0 && file_status = 'approved' ");
        $sql8->execute();
        $row8 = $sql8->fetch();

        $document_approved = $row8['numrows'];

        $percent_approved = number_format($document_approved*100/$no_of_tasks, 0);

        $sql9 = $conn->prepare("SELECT *, COUNT(*) AS numrows FROM documents WHERE user_id = $id && soft_delete=0 && file_status = 'submitted' ");
        $sql9->execute();
        $row9 = $sql9->fetch();

        $document_submitted = $row9['numrows'];

        $percent_submitted = number_format($document_submitted*100/$no_of_tasks, 0);
        
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
                                        <h4 class="page-title">Onboarding</h4>
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="profile"><?= $row0["full_name"] ?></a></li>
                                            <li class="breadcrumb-item active">Dashboard</li>
                                        </ol>

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
                                    <div class="col-auto align-self-center">
                                        <a href="#" class="btn btn-sm btn-outline-primary" id="Dash_Date">
                                            <span class="day-name" id="Day_Name">Today:</span>&nbsp;
                                            <span class="" id="Select_date">Jan 01</span>
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
                        <div class="col-lg-9">
                            <div class="row justify-content-center"> 
                                <div class="col-md-6 col-lg-4">
                                    <div class="card report-card">
                                        <div class="card-body">
                                            <div class="row d-flex justify-content-center">                                                
                                                <div class="col">
                                                    <p class="text-dark mb-0 font-weight-semibold">Last Session</p>
                                                    <h3 class="m-0"><?= date('h:i:s A', strtotime($row0['date_view'])) ?></h3>
                                                    <h5 class="mb-0 text-truncate text-muted"><?= date('D M j Y', strtotime($row0['date_view'])) ?></h5>
                                                </div>
                                                <div class="col-auto align-self-center">
                                                    <div class="report-main-icon bg-light-alt">
                                                        <i data-feather="clock" class="align-self-center text-blue icon-sm"></i>  
                                                    </div>
                                                </div> 
                                            </div>
                                        </div><!--end card-body--> 
                                    </div><!--end card--> 
                                </div> <!--end col-->
                                <div class="col-md-6 col-lg-4">
                                    <div class="card report-card">
                                        <div class="card-body">
                                            <div class="row d-flex justify-content-center">

                                                <?php

                                                    if ($no_of_tasks > 0) { ?>                                                
                                                <div class="col">
                                                    <p class="text-dark mb-0 font-weight-semibold">Documents</p>
                                                    

                                                        <h3 class="m-0"><?= $no_of_tasks; ?> Total</h3>
                                                        <h5 class="mb-0 text-truncate text-muted"> 
                                                            <?= $no_of_pending_tasks; ?> Pending
                                                        </h5>

                                                        </div>
                                                        <div class="col-auto align-self-center">
                                                            <div class="report-main-icon bg-light-alt">
                                                                <i data-feather="activity" class="align-self-center text-blue icon-sm"></i>
                                                            </div>
                                                        </div>
                                                        
                                                    <?php }else{
                                                        echo '

                                                        <div class="col">
                                                            <p class="text-dark mb-0 font-weight-semibold">Documents</p>

                                                            <h5 class="mb-0 text-danger">
                                                            <i class="mdi mdi-alert-outline alert-icon text-danger align-self-center font-30 mr-3"></i>
                                                                No document requested yet!
                                                            </h5>

                                                        </div>
                                                        ';
                                                    }

                                                    ?>
                                                    
                                                 
                                            </div>
                                        </div><!--end card-body--> 
                                    </div><!--end card--> 
                                </div> <!--end col-->
                                <div class="col-md-6 col-lg-4">
                                    <div class="card report-card">
                                        <div class="card-body">
                                            <div class="row d-flex justify-content-center">
                                                <?php

                                                    if ($no_of_msgs > 0) { ?>                                                
                                                    <div class="col">
                                                        <p class="text-dark mb-0 font-weight-semibold">New Messages</p>
                                                        

                                                        <h3 class="m-0"><?= $no_of_unread_msg; ?></h3>
                                                        <h5 class="mb-0 text-truncate text-muted"> 
                                                            <?= $no_of_msgs; ?> total messages
                                                        </h5>

                                                    </div>
                                                    <div class="col-auto align-self-center">
                                                        <div class="report-main-icon bg-light-alt">
                                                            <i data-feather="inbox" class="align-self-center text-blue icon-sm"></i>  
                                                        </div>
                                                    </div>
                                                        
                                                    <?php }else{
                                                        echo '

                                                        <div class="col">
                                                            <p class="text-dark mb-0 font-weight-semibold">Messages</p>

                                                            <h5 class="mb-0 text-danger">
                                                            <i class="mdi mdi-message-bulleted-off alert-icon text-danger align-self-center font-30 mr-3"></i>

                                                                Your inbox is empty
                                                            </h5>

                                                        </div>
                                                        ';
                                                    }

                                                ?>
                                            </div>
                                        </div><!--end card-body--> 
                                    </div><!--end card--> 
                                </div> <!--end col-->                              
                            </div><!--end row-->
                            <div class="card">
                                <div class="card-header">
                                    <div class="row align-items-center">
                                        <div class="col">                      
                                            <h4 class="card-title">Documents Overview</h4>                      
                                        </div><!--end col-->
                                        <div class="col-auto"> 
                                            <div class="dropdown">
                                                <a href="#" class="btn btn-sm btn-outline-light dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                   Requested/ Submitted/ Approved
                                                </a>
                                            </div>               
                                        </div><!--end col-->
                                    </div>  <!--end row-->                                  
                                </div><!--end card-header-->
                                <div class="card-body">
                                    <div class="">
                                        <div id="ana_dash_1" class="apex-charts"></div>
                                    </div> 
                                </div><!--end card-body--> 
                            </div><!--end card--> 
                        </div><!--end col-->
                        <div class="col-lg-3">
                            <div class="card">
                                <div class="card-header">
                                    <div class="row align-items-center">
                                        <div class="col">                      
                                            <h4 class="card-title">Documents</h4>                      
                                        </div><!--end col-->
                                        <div class="col-auto"> 
                                            <div class="dropdown">
                                                <a href="#" style="cursor: context-menu; width: 120%;" class="btn btn-sm btn-outline-light">
                                                   All Documents
                                                </a>
                                            </div>         
                                        </div><!--end col-->
                                    </div>  <!--end row-->                                  
                                </div><!--end card-header-->
                                <div class="card-body">
                                    <div class="text-center">
                                        <div id="ana_device" class="apex-charts"></div>
                                    </div>  
                                    <div class="table-responsive mt-2">
                                        <table class="table border-dashed mb-0">
                                            <thead>
                                            <tr>
                                                <th>Status</th>
                                                <th class="text-right">Amount</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Requested</td>
                                                    <td class="text-right"><?= $document_requested; ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Submitted</td>
                                                    <td class="text-right"><?= $document_submitted; ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Approved</td>
                                                    <td class="text-right"><?= $document_approved; ?>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table><!--end /table-->
                                    </div><!--end /div-->                                 
                                </div><!--end card-body--> 
                            </div><!--end card--> 
                        </div> <!--end col--> 
                    </div><!--end row-->

                    <div class="row">
                        <div class="col-lg-4">
                            <div class="card">
                                <div class="card-header">
                                    <div class="row align-items-center">
                                        <div class="col">                      
                                            <h4 class="card-title">What's New</h4>                      
                                        </div><!--end col-->
                                    </div>  <!--end row-->                                  
                                </div><!--end card-header-->                   
                                <div class="card-body">
                                    <ul class="list-group custom-list-group mb-n3">
                                    <?php
                                        $stmtnews = $conn->prepare("SELECT COUNT(*) AS numrows FROM news ORDER BY id desc limit 7");
                                        $stmtnews->execute();
                                        $drownews = $stmtnews->fetch();
                                        $no_of_news = $drownews['numrows'];

                                        $newsQuery = $conn->query("SELECT * FROM news ORDER BY id desc limit 7");
                                        if ($newsQuery->rowCount()) {
                                           $newsrow = $newsQuery->fetchAll(PDO::FETCH_OBJ);
                                        }
                                        if($no_of_news > 0){

                                            foreach ($newsrow as $new) : ?>

                                            <li class="list-group-item latest-news-item align-items-center d-flex justify-content-between pt-0">
                                                <div class="media">
                                                    <img src="../admin/images/<?= $new->photo; ?>" height="30" class="mr-3 align-self-center rounded" alt="...">
                                                    <div class="media-body align-self-center"> 
                                                        <h6 class="m-0"><?= substrwords($new->short_title, 30); ?></h6>                                                                                     
                                                    </div><!--end media body-->
                                                </div>
                                                <div class="align-self-center">
                                                    <a target="_blank" href="../news-detail.php?id=<?= $new->id; ?>&title=<?= $new->slug; ?>" class="btn btn-sm btn-soft-primary">Read <i class="las la-external-link-alt font-15"></i></a>  
                                                </div>                                            
                                            </li>

                                    <?php
                                      endforeach; }else{ ?>

                                        <div class="activity-info">
                                            <h5>
                                                No News Yet
                                            </h5>
                                        </div>

                                    <?php  }
                                    ?>
                                    </ul>                                
                                </div><!--end card-body--> 
                            </div><!--end card--> 
                        </div> <!--end col--> 
                        <div class="col-lg-4"> 
                            <div class="card">
                                <div class="card-header">
                                    <div class="row align-items-center">
                                        <div class="col">                      
                                            <h4 class="card-title">Documents Overview</h4>                      
                                        </div><!--end col-->                                        
                                    </div>  <!--end row-->                                  
                                </div><!--end card-header-->  
                                <div class="card-body">
                                    <div class="analytic-dash-activity" data-simplebar>
                                        <div class="activity">

                                            <?php
                                                $tskQuery = $conn->query("SELECT * FROM documents LEFT JOIN documents_list ON documents.file_id = documents_list.id WHERE user_id=$id AND documents.soft_delete=0 order by 1 desc Limit 6");
                                                if ($tskQuery->rowCount()) {
                                                   $tskRow = $tskQuery->fetchAll(PDO::FETCH_OBJ);
                                                }
                                                if($no_of_tasks > 0){

                                                    foreach ($tskRow as $tsk) : ?>

                                                    <div class="activity-info">
                                                        <div class="activity-info-text">
                                                            <div class="d-flex justify-content-between align-items-center">
                                                                <p class="text-muted mb-0 font-13 w-75"><?= date('M j Y', strtotime($tsk->date_requested)) ?> <span> 
                                                                    <?= $tsk->document_name; ?></span>
                                                                </p>
                                                                <small class="text-muted"><?= $tsk->file_status; ?></small>
                                                            </div>    
                                                        </div>
                                                    </div>
                                            <?php
                                              endforeach; }else{ ?>

                                                <div class="activity-info">
                                                    <h5>
                                                        No Document Requested or Submitted Yet
                                                    </h5>
                                                </div>

                                            <?php  }
                                            ?>
                                        </div><!--end activity-->
                                    </div><!--end analytics-dash-activity-->
                                </div><!--end card-body--> 
                            </div><!--end card--> 
                        </div><!--end col-->
                        
                        <div class="col-lg-4">
                            <div class="card">   
                                <div class="card-header">
                                    <div class="row align-items-center">
                                        <div class="col">                      
                                            <h4 class="card-title">Activity</h4>                      
                                        </div><!--end col-->
                                    </div>  <!--end row-->                                  
                                </div><!--end card-header-->                                              
                                <div class="card-body"> 
                                    <div class="analytic-dash-activity" data-simplebar>
                                        <div class="activity">

                                            <?php
                                                $stmtact = $conn->prepare("SELECT COUNT(*) AS numrows FROM activity WHERE user_id=$id");
                                                $stmtact->execute();
                                                $drowact = $stmtact->fetch();
                                                $no_of_act = $drowact['numrows'];

                                                $actQuery = $conn->query("SELECT * FROM activity WHERE user_id=$id order by 1 desc Limit 6");
                                                if ($actQuery->rowCount()) {
                                                   $actrow = $actQuery->fetchAll(PDO::FETCH_OBJ);
                                                }
                                                if($no_of_act > 0){

                                                    foreach ($actrow as $act) : ?>

                                                    <div class="activity-info">
                                                        <div class="icon-info-activity">
                                                            <i class="mdi mdi-clock-outline bg-soft-primary"></i>
                                                        </div>
                                                        <div class="activity-info-text">
                                                            <div class="d-flex justify-content-between align-items-center">
                                                                <p class="text-muted mb-0 font-13 w-75"><span><?= $act->category; ?></span> 
                                                                    <?= $act->message; ?>
                                                                </p>
                                                                <small class="text-muted"><?= $act->date_sent; ?></small>
                                                            </div>    
                                                        </div>
                                                    </div>


                                            <?php
                                              endforeach; }else{ ?>

                                                <div class="activity-info">
                                                    <h5>
                                                        No Activity Yet
                                                    </h5>
                                                </div>

                                            <?php  }
                                            ?>

                                            

                                        </div><!--end activity-->
                                    </div><!--end analytics-dash-activity-->
                                </div>  <!--end card-body-->                                     
                            </div><!--end card--> 
                        </div><!--end col--> 
                       
                    </div><!--end row-->
                    

                </div><!-- container -->

                <?php include('inc/footer.php'); ?><!--end footer-->
            </div>
            <!-- end page content -->
        </div>
        <!-- end page-wrapper -->

        <!-- Chart Data -->
        <?php

            $task_close = array();
            $task_open = array();
            for( $m = 1; $m <= 12; $m++ ) {
                try{
                    $stmt = $conn->prepare("SELECT *, COUNT(*) AS numrows FROM documents WHERE user_id = $id AND soft_delete=0 AND MONTH(date_requested)=:month AND YEAR(date_requested)=:year");
                    $stmt->execute(['month'=>$m, 'year'=>$year]);
                    $total = $total2 = 0;                    
                    foreach($stmt as $srow){
                        $total = $srow['numrows'];
                    }
                    array_push($task_close, $total);

                    array_push($task_open, $total2);
                }
                catch(PDOException $e){
                    echo $e->getMessage();
                }

            }

            $task_close = json_encode($task_close);
            $task_open = json_encode($task_open);

        ?>

        


        <?php include('inc/scripts.php'); ?>

        
        
    </body>

</html>