<?php
  include 'includes/session.php'; 
  include "../account/connect.php";

  $task_id = $_GET['task_id'];

  $conn = $pdo->open();

  $stmt = $conn->prepare("SELECT *, task.pm_id AS task_pmid, project_manager.pm_id AS manager_pmid FROM task LEFT JOIN project_manager ON task.pm_id=project_manager.pm_id LEFT JOIN users ON task.user_id=users.id WHERE task.task_id=:id");
  $stmt->execute(['id'=>$task_id]);
  $row = $stmt->fetch();
?>
<?php include 'includes/header.php'; ?>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <?php include 'includes/navbar.php'; ?>
  <?php include 'includes/menubar.php'; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <section class="content">
      <?php
        if(isset($_SESSION['error'])){
          echo "
            <div class='alert alert-danger alert-dismissible'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <h4><i class='icon fa fa-warning'></i> Error!</h4>
              ".$_SESSION['error']."
            </div>
          ";
          unset($_SESSION['error']);
        }
        if(isset($_SESSION['success'])){
          echo "
            <div class='alert alert-success alert-dismissible'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <h4><i class='icon fa fa-check'></i> Success!</h4>
              ".$_SESSION['success']."
            </div>
          ";
          unset($_SESSION['success']);
        }
      ?>
      <div class="row">
         <div class="marbtm50 wdt-100">

            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 project-desc">
              <ul class="profile_info list_none mb-4 pt-2 border-bottom">
                 <li>
                     <span class="title"> Task Title:</span>
                     <p><?php echo $row["task_title"] ?></p>
                 </li>
                 <li>
                     <span class="title"> Assignee:</span>
                     <p> <?php echo $row["full_name"]; ?> </p>
                 </li>
                 <li>
                     <span class="title"> Project Manager:</span>
                     <p> <?php echo $row["pm_name"]; ?> </p>
                 </li>
                 <li>
                     <span class="title"> Task Delegate Date/Time: </span>
                     <p> <?php echo $row["task_delegate_date"]; ?> </p>
                 </li>
              </ul>
            </div>

            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 project-desc">
              <ul class="profile_info list_none mb-4 pt-2 border-bottom">
                 <li>
                     <span class="title"> Task Submit Date/Time: </span>
                     <p> <?php echo $row["task_submit_date"]; ?> </p>
                 </li>
                 <li>
                     <span class="title"> Task Completion Date:</span>
                     <p><?php echo $row["task_completion_date"] ?></p>
                 </li>
                 <li>
                     <span class="title"> Task Status:</span>
                     <p> <?php echo $row["task_status"]; ?> </p>
                 </li>
                 <li>
                     <span class="title"> Last Updated:</span>
                     <p> <?php echo $row["last_updated"]; ?> </p>
                 </li>                
              </ul>
            </div>

            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 project-desc">
              <ul class="profile_info list_none mb-4 pt-2 border-bottom">
                 <li>
                     <span class="title"> Task Summary: </span>
                     <p> <?php echo $row["task_description_summary"]; ?> </p>
                 </li>
              </ul>
            </div>

            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 project-desc">
              <ul class="profile_info list_none mb-4 pt-2 border-bottom">
                 <li>
                     <span class="title"> Task Description: </span>
                     <p> <?php echo $row["task_description"]; ?> </p>
                 </li>
              </ul>
            </div>
         </div>
         <div class="col-md-12 marbtm50 wdt-100">

            <section class="content-header">
              <h1>
                Files Attached To Task
              </h1>
            </section>
            
            <div class="box-body">
              <table id="example1" class="table table-bordered">
                <thead>
                  <th>File Name</th>
                  <th>Tools</th>
                </thead>
                <tbody>
                  <?php
                    $conn = $pdo->open();

                    try{
                      $stmt = $conn->prepare("SELECT * FROM task_files WHERE task_id=:task_id");
                      $stmt->execute(['task_id'=>$task_id]);
                      foreach($stmt as $file){
                        echo "
                          <tr>
                            <td>".$file['task_file_name']."</td>
                            <td>
                              <a href='../images/".$file['task_file']."' class='btn btn-primary btn-sm btn-flat'><i class='fa fa-eye'></i> View</a>
                              <a href='task_file_delete.php?id=".$file['task_file_id']."' class='btn btn-danger btn-sm btn-flat'><i class='fa fa-trash'></i> Delete</a>
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
              </table>
            </div>
         </div>

         <div class="col-md-12 marbtm50 wdt-100">

            <section class="content-header">
              <h1>
                Files Submitted By User
              </h1>
            </section>
            
            <div class="box-body">
              <table id="example1" class="table table-bordered">
                <thead>
                  <th>File Name</th>
                  <th>Tools</th>
                </thead>
                <tbody>
                  <?php
                    $conn = $pdo->open();

                    try{
                      $stmt = $conn->prepare("SELECT * FROM task_submit_files WHERE task_id=:task_id");
                      $stmt->execute(['task_id'=>$task_id]);
                      foreach($stmt as $file_submitted){
                        echo "
                          <tr>
                            <td>".$file_submitted['task_submit_file_name']."</td>
                            <td>
                              <a href='../images/".$file_submitted['task_submit_file']."' class='btn btn-primary btn-sm btn-flat'><i class='fa fa-eye'></i> View</a>
                              <a href='task_submit_file_delete.php?id=".$file_submitted['task_submit_file_id']."' class='btn btn-danger btn-sm btn-flat'><i class='fa fa-trash'></i> Delete</a>
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
              </table>
            </div>
         </div>
      </div>

    </section>
     
  </div>
  	<?php include 'includes/footer.php'; ?>

</div>
<!-- ./wrapper -->

<?php include 'includes/scripts.php'; ?>
</body>
</html>
