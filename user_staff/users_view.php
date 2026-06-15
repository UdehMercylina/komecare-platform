<?php
  include 'includes/session.php'; 
  include "../account/connect.php";

  $id = $_GET['wid'];

  $sql0 = "SELECT * FROM users WHERE id=".$id;
  $result0 = $conne->query($sql0);
  $row0 = $result0->fetch_assoc();
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
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
               <span class="portfolio-img-column image_hover">
               <img src="images/<?php echo $row0["photo"]; ?>" class="img-responsive zoom_img_effect" alt="worker-image">
               </span>
            </div>


            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 project-desc">
              <ul class="profile_info list_none mb-4 pt-2 border-bottom">
                 <li>
                     <span class="title"><i class="fa fa-user"></i> Name:</span>
                     <p><?php echo $row0["full_name"] ?></p>
                 </li>
                 <li>
                     <span class="title"><i class="fa fa-user-circle-o"></i> Username:</span>
                     <p> <?php echo $row0["uname"]; ?> </p>
                 </li>
                 <li>
                     <span class="title"><i class="fa fa-envelope"></i> Email:</span>
                     <p> <?php echo $row0["email"]; ?> </p>
                 </li>
                 <li>
                     <span class="title"><i class="fa fa-phone"></i> Phone Number: </span>
                     <p> <?php echo $row0["phone_no"]; ?> </p>
                 </li>
                 <li>
                     <span class="title"><i class="fa fa-globe"></i> Nationality: </span>
                     <p> <?php echo $row0["nationality"]; ?> </p>
                 </li>
                 <li>
                     <span class="title"><i class="fa fa-id-badge"></i> Profile Code:</span>
                     <p><?php echo $row0["profile_code"] ?></p>
                 </li>
                 <li>
                     <span class="title"><i class="fa fa-address-card"></i> Postal Code:</span>
                     <p> <?php echo $row0["postal_code"]; ?> </p>
                 </li>
                 <li>
                     <span class="title"><i class="fa fa-building"></i> Career Path:</span>
                     <p> <?php echo $row0["career_path"]; ?> </p>
                 </li>
                 <li>
                     <span class="title"><i class="fa fa-check-square"></i> Application Status: </span>
                     <p> <?php echo $row0["application_status"]; ?> </p>
                 </li>
              </ul>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 project-desc">
              <ul class="profile_info list_none mb-4 pt-2 border-bottom">
                 <li>
                     <span class="title"><i class="fa fa-ticket"></i> Visa Status:</span>
                     <p><?php echo $row0["visa_status"] ?></p>
                 </li>
                 <li>
                     <span class="title"><i class="fa fa-location-arrow"></i> Office Address:</span>
                     <p> <?php echo $row0["office_addr"]; ?> </p>
                 </li>
                 <li>
                     <span class="title"><i class="fa fa-money"></i> Salary:</span>
                     <p> <?php echo $row0["salary"]; ?> </p>
                 </li>
                 <li>
                     <span class="title"><i class="fa fa-calendar"></i> Start Date: </span>
                     <p> <?php echo $row0["start_date"]; ?> </p>
                 </li>
                 <li>
                     <span class="title"><i class="fa fa-book"></i> Passport ID:</span>
                     <p><?php echo $row0["passport_id"] ?></p>
                 </li>
                 <li>
                     <span class="title"><i class="fa fa-plane"></i> Flight Ticket Status:</span>
                     <p> <?php echo $row0["flight_ticket"]; ?> </p>
                 </li>
                 <li>
                     <span class="title"><i class="fa fa-map-marker"></i> Perm LC Status:</span>
                     <p> <?php echo $row0["perm_lc"]; ?> </p>
                 </li>
                 <li>
                     <span class="title"><i class="fa fa-globe"></i> Green Card Status: </span>
                     <p> <?php echo $row0["green_card"]; ?> </p>
                 </li>
                 <li>
                     <span class="title"><i class="fa fa-comment"></i> Company Message: </span>
                     <p> <?php echo $row0["company_message"]; ?> </p>
                 </li>
              </ul>
            </div>
         </div>
         <div class="col-md-12 marbtm50 wdt-100">

            <section class="content-header">
              <h1>
                All Files
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
                      $stmt = $conn->prepare("SELECT * FROM worker_files WHERE worker_id=:worker_id");
                      $stmt->execute(['worker_id'=>$id]);
                      foreach($stmt as $file){
                        echo "
                          <tr>
                            <td>".$file['file_title']."</td>
                            <td>
                              <a href='uploads/".$file['file_name']."' class='btn btn-primary btn-sm btn-flat'><i class='fa fa-eye'></i> View</a>
                              <a href='users_file_delete.php?id=".$file['id']."' class='btn btn-danger btn-sm btn-flat'><i class='fa fa-trash'></i> Delete</a>
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
                Worker Identity Verification File
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
                      $stmt = $conn->prepare("SELECT * FROM identity_verification_file WHERE user_id=:worker_id");
                      $stmt->execute(['worker_id'=>$id]);
                      foreach($stmt as $identity_file){
                        echo "
                          <tr>
                            <td>".$identity_file['id_verification_file_name']."</td>
                            <td>
                              <a href='../images/".$identity_file['id_verification_file']."' class='btn btn-primary btn-sm btn-flat'><i class='fa fa-eye'></i> View</a>
                              <a href='identity_verification_file_delete.php?id=".$identity_file['id_verification_file_id']."' class='btn btn-danger btn-sm btn-flat'><i class='fa fa-trash'></i> Delete</a>
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
