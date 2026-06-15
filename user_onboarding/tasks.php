<?php
    include('../inc/config.php');
    include('../admin/includes/format.php');

    include '../admin/session.php';

    $page_name = 'Tasks';
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

    $sql1 = "SELECT *, COUNT(*) AS num_of_tasks FROM task WHERE user_id = ".$id." ORDER BY task_id DESC LIMIT 1";
    $result1 = $conne->query($sql1);
    $row1 = $result1->fetch_assoc();
    $no_of_tasks = $row1['num_of_tasks'];

    if($no_of_tasks == 0){
        $_SESSION['error'] = 'You have no task yet';
        header('location: dashboard.php');
    }

    $sql2 = "SELECT *, COUNT(*) AS num_of_pending_tasks FROM task WHERE user_id = ".$id." && task_status = 'pending' ORDER BY task_id DESC LIMIT 1";
    $result2 = $conne->query($sql2);
    $row2 = $result2->fetch_assoc();
    $no_of_pending_tasks = $row2['num_of_pending_tasks'];

    $time = strtotime($row1["task_delegate_date"]);
    $sanitized_time = date("Y-m-d, g:i A", $time);

    $sql6 = $conn->query("SELECT * FROM task WHERE user_id=$id ORDER BY 1 ASC");
    if ($sql6->rowCount()) {
       $row6 = $sql6->fetchAll(PDO::FETCH_OBJ);
    }

    $task_completed = $task_pending = $task_reassigned = $task_overdue = $percent_completed = $percent_pending = $percent_reassigned = $percent_overdue = 0;

    if (!empty($row6)) {
    
        $sql7 = $conn->prepare("SELECT *, COUNT(*) AS numrows FROM task WHERE user_id = $id && task_status = 'completed' ");
        $sql7->execute();
        $row7 = $sql7->fetch();

        $task_completed = $row7['numrows'];

        $percent_completed = number_format($task_completed*100/$no_of_tasks, 0);

        $sql8 = $conn->prepare("SELECT *, COUNT(*) AS numrows FROM task WHERE user_id = $id && task_status = 'pending' ");
        $sql8->execute();
        $row8 = $sql8->fetch();

        $task_pending = $row8['numrows'];

        $percent_pending = number_format($task_pending*100/$no_of_tasks, 0);

        $sql9 = $conn->prepare("SELECT *, COUNT(*) AS numrows FROM task WHERE user_id = $id && task_status = 'reassigned' ");
        $sql9->execute();
        $row9 = $sql9->fetch();

        $task_reassigned = $row9['numrows'];

        $percent_reassigned = number_format($task_reassigned*100/$no_of_tasks, 0);

        $sql10 = $conn->prepare("SELECT *, COUNT(*) AS numrows FROM task WHERE user_id = $id && task_status = 'pending' && task_submit_date  <= '$today' ");
        $sql10->execute();
        $row10 = $sql10->fetch();

        $task_overdue = $row10['numrows'];

        $percent_overdue = number_format($task_overdue*100/$no_of_tasks, 0);
        
    }

    $sql11 = "SELECT * FROM task WHERE user_id = ".$id." ORDER BY task_id DESC LIMIT 1";
    $result11 = $conne->query($sql11);
    $row11 = $result11->fetch_assoc();

    $last_updated = strtotime($row11['last_updated']);
    $present_time = strtotime($today);
    $delegate_date = strtotime($row11['task_delegate_date']);
    $submit_date = strtotime($row11['task_submit_date']);

    $last_updated =  $present_time -$last_updated;

    if ($last_updated < 60 ) {
        $last_updated = $last_updated.' sec';
    }elseif ($last_updated < 3600 ) {
        $last_updated = number_format($last_updated/60, 0);
        $last_updated = $last_updated.' min';
    }elseif ($last_updated < 86400 ) {
        $last_updated = number_format($last_updated/3600, 0);
        $last_updated = $last_updated.' hour';
    }elseif ($last_updated < 604800 ) {
        $last_updated = number_format($last_updated/86400, 0);
        $last_updated = $last_updated.' day';
    }elseif ($last_updated < 2419200 ) {
        $last_updated = number_format($last_updated/604800, 0);
        $last_updated = $last_updated.' week';
    }elseif ($last_updated < 29030400 ) {
        $last_updated = number_format($last_updated/2419200, 0);
        $last_updated = $last_updated.' month';
    }elseif ($last_updated > 29030400 ) {
        $last_updated = number_format($last_updated/29030400, 0);
        $last_updated = $last_updated.' year';
    }

    if ($row11['task_status'] == 'completed') {
        $progressbar = 100;
    }elseif (($row11['task_status'] == 'pending') && ($row11['task_submit_date']  < $today)) {
        $progressbar = 90;
    }else{
        $progressbar = number_format(($present_time - $delegate_date) * 100/ ($submit_date - $delegate_date), 0);
    }

    $taskQuery = $conn->query("SELECT * FROM task WHERE user_id=$id order by 1 desc ");
    if ($taskQuery->rowCount()) {
       $tasks = $taskQuery->fetchAll(PDO::FETCH_OBJ);
    }

    /*
    $sql2 = "SELECT * FROM task WHERE user_id = $id ORDER BY trans_id DESC LIMIT 1,1";
    $result2 = $conne->query($sql2);
    $row2 = $result2->fetch_assoc();

    if (empty($row2)) {
        $loss_gain = "";
        $percent_loss_gain = "";
    }elseif ($row1["balance"] > $row2["balance"]) {
        $loss_gain = "Increase";
        $percent_loss_gain = ($row1["balance"] - $row2["balance"]) * 100 / $row2["balance"];
    }elseif ($row2["balance"] > $row1["balance"]) {
        $loss_gain = "Decrease";
        $percent_loss_gain = ($row2["balance"] - $row1["balance"]) * 100 / $row2["balance"];
    }else{
        $loss_gain = "";
        $percent_loss_gain = "";
    }

    $sql3 = "SELECT * FROM transaction WHERE user_id = $id ORDER BY trans_id DESC LIMIT 5";

    $sql4 = "SELECT *, COUNT(*) AS numrows FROM investment WHERE user_id = $id && status = 'in progress' ORDER BY invest_id DESC";
    $result4 = $conne->query($sql4);
    $row4 = $result4->fetch_assoc();

    $no_of_inv = $row4['numrows'];

    $planQuery = $conn->query("SELECT * FROM investment LEFT JOIN investment_plans ON investment_plans.id = investment.invest_plan_id WHERE user_id = $id && status = 'in progress' ORDER BY invest_id DESC");
    if ($planQuery->rowCount()) {
       $row5 = $planQuery->fetchAll(PDO::FETCH_OBJ);
    }

    $sql6 = "SELECT *, COUNT(*) AS numrows FROM investment WHERE user_id = $id && status = 'completed' ORDER BY invest_id DESC";
    $result6 = $conne->query($sql6);
    $row6 = $result6->fetch_assoc();
    $no_of_inv_comp = $row6['numrows'];


    $stmt = $conn->prepare("SELECT * FROM investment WHERE user_id = $id && status = 'completed' ");
    $stmt->execute();

    $total = 0;
    foreach($stmt as $srow){
      $amount = $srow['returns'];
      $total += $amount;
    }

    $allplanQuery = $conn->query("SELECT * FROM investment_plans ORDER BY id ASC");
    if ($allplanQuery->rowCount()) {
       $stmt1 = $allplanQuery->fetchAll(PDO::FETCH_OBJ);
    }

    $total_plan1 = $total_plan2 = $total_plan3 = $percent_plan1 = $percent_plan2 = $percent_plan3 = 0;
    
    $stmt3 = $conn->prepare("SELECT * FROM investment WHERE user_id = $id && status = 'completed' && invest_plan_id = 1 ");
    $stmt3->execute();

    foreach($stmt3 as $prow){
        $amount_plan1 = $prow['returns'];
        $total_plan1 += $amount_plan1;

        $percent_plan1 = number_format($total_plan1*100/$total, 0);
    }

    $stmt3 = $conn->prepare("SELECT * FROM investment WHERE user_id = $id && status = 'completed' && invest_plan_id = 2 ");
    $stmt3->execute();

    foreach($stmt3 as $prow){
        
        $amount_plan2 = $prow['returns'];
        $total_plan2 += $amount_plan2;

        $percent_plan2 = number_format($total_plan2*100/$total, 0);

    } 

    $stmt3 = $conn->prepare("SELECT * FROM investment WHERE user_id = $id && status = 'completed' && invest_plan_id = 3 ");
    $stmt3->execute();

    foreach($stmt3 as $prow){

        $amount_plan3 = $prow['returns'];
        $total_plan3 += $amount_plan3;

        $percent_plan3 = number_format($total_plan3*100/$total, 0);
    }
    */

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
                                    <h4 class="page-title">Tasks</h4>
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
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-body">  
                                    <div class="apexchart-wrapper">
                                        <div id="task_status" class="apex-charts"></div>
                                    </div>
                                </div><!--end card-body-->
                            </div><!--end card-->
                        </div><!--end col--> 
                        
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-body">  
                                    <div class="media mb-5">
                                        <img src="assets/images/widgets/project3.jpg" alt="" class="thumb-lg rounded-circle">                                      
                                        <div class="media-body align-self-center text-truncate ml-3">
                                            <p class="text-muted mb-0 font-11 text-uppercase">Latest Task</p>
                                            <h4 class="mt-0 mb-0 font-weight-semibold text-dark font-16"><?= $row11['task_title'] ?></h4>                                            
                                        </div><!--end media-body-->
                                    </div>
                                    
                                    <div class="d-flex justify-content-between">
                                        <small class="font-weight-semibold font-13 align-self-center">Last updated: <?= $last_updated; ?><?= ($last_updated < 2 ? '':'s') ?> ago</small>
                                    </div>
                                    <div class="mt-2">
                                        <div class="progress mt-3" style="height:5px;">
                                            <div class="progress-bar bg-secondary" role="progressbar" style="width: <?= $progressbar; ?>%;" aria-valuenow="<?= $progressbar; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                    <div class="row mt-4">
                                        <div class="col-4 text-center align-items-center">
                                            <h5 class="mb-0 font-weight-semibold font-20"><?= $no_of_tasks; ?></h5>
                                            <p class="font-12 mb-1 text-muted">Assigned</p>                                                                              
                                        </div>
                                        <div class="col-4 text-center align-items-center">
                                            <h5 class="mb-0 font-weight-semibold font-20"><?= $task_pending; ?></h5>
                                            <p class="font-12 mb-1 text-muted">Pending</p>
                                        </div>
                                        <div class="col-4 text-center align-items-center">
                                            <h5 class="mb-0 font-weight-semibold font-20"><?= $task_completed; ?></h5>
                                            <p class="font-12 mb-1 text-muted">Completed</p>
                                        </div>
                                    </div>
                                    <div class="mt-4 d-flex justify-content-between">
                                        <p class="mb-0 font-weight-semibold">Start Date : <span class="text-muted  font-weight-normal ml-2"><?= date('D M j Y', $delegate_date) ?></span> </p>
                                        <p class="mb-0 text-danger font-weight-semibold">Deadline : <span class="text-muted font-weight-normal ml-2"><?= date('D M j Y', $submit_date) ?></span> </p>
                                    </div>
                                </div><!--end card-body-->                                
                            </div><!--end card-->
                        </div><!--end col--> 
                    </div><!--end row-->
                    
                    <div class="row">
                        <?php
                        foreach ($tasks as $task) : 
                            $time = date('h:i:s A', strtotime($task->task_delegate_date));
                            $date = date('M j', strtotime($task->task_delegate_date));
                            $status = $task->task_status;                            
                            $task_percentage = number_format(($present_time - strtotime($task->task_delegate_date)) * 100/ (strtotime($task->task_submit_date) - strtotime($task->task_delegate_date)), 0);
                            $progressbar_bg = 'secondary';
                            $progressbar_bg_bg = '';
                            if (($status != 'completed') && (strtotime($task->task_submit_date) < time())) {
                                $task_status_icon = '<i class="fas fa-circle text-danger"></i>';
                                $task_status_badge = '<span class="badge badge-danger mr-2">overdue</span>';
                                if ($status == 'reassigned') {
                                    $task_status_badge = '<span class="badge badge-danger mr-2">reassigned</span>';
                                }
                                $task_percentage = 0;
                                $progressbar_bg = 'danger';
                                $progressbar_bg_bg = 'bg-danger';
                            }elseif ($status == 'completed') {
                                $task_status_icon = '<i class="fas fa-check text-success"></i>';
                                $task_status_badge = '<span class="badge badge-success mr-2">'.$task->task_status.'</span>';
                                $task_percentage = 100;
                                $progressbar_bg = 'success';
                            }elseif ($status == 'pending') {
                                $task_status_icon = '<i class="fas fa-circle text-secondary"></i>';
                                $task_status_badge = '<span class="badge badge-warning mr-2">'.$task->task_status.'</span>';
                            }
                            ?>
                            
                            <div class="col-lg-6">
                                <a href="task.php?id=<?= $task->task_id; ?>&title=<?= $task->task_title;; ?>">
                                    <div class="card">
                                        <div class="card-body">                                    
                                            <div class="task-box">
                                                <div class="task-priority-icon"><?= $task_status_icon; ?></div>
                                                <p class="text-muted float-right">
                                                    <?= $task_status_badge; ?>
                                                    <span class="text-muted"><?= $time; ?></span>
                                                    <span class="mx-1">·</span> 
                                                    <span><i class="far fa-fw fa-clock"></i> <?= $date; ?></span>
                                                </p>
                                                <h5 class="mt-0"><?= $task->task_title; ?></h5>
                                                <p class="text-muted mb-1"><?= substrwords($task->task_description_summary, 200); ?>
                                                </p>
                                                <p class="text-muted text-right mb-1"><?= $task_percentage; ?>% Complete</p>
                                                <div class="progress <?= $progressbar_bg_bg; ?> mb-4" style="height: 4px;">
                                                    <div class="progress-bar bg-<?= $progressbar_bg; ?>" role="progressbar" style="width: <?= $task_percentage; ?>%;" aria-valuenow="<?= $task_percentage; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                                <div class="mt-4 d-flex justify-content-between">
                                                    <p class="mb-0 font-weight-semibold">Start Date : <span class="text-muted  font-weight-normal ml-2"><?= date('D M j Y', $delegate_date) ?></span> </p>
                                                    <p class="mb-0 text-danger font-weight-semibold">Deadline : <span class="text-muted font-weight-normal ml-2"><?= date('D M j Y', $submit_date) ?></span> </p>
                                                </div>
                                            </div><!--end task-box-->
                                        </div><!--end card-body-->
                                    </div><!--end card-->
                                </a>
                            </div><!--end col-->

                        <?php
                        endforeach; ?>

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