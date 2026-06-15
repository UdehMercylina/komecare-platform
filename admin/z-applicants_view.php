<?php
  include 'includes/session.php'; 
  include "../account/connect.php";

  $id = $_GET['aid'];

  $sql0 = "SELECT * FROM applicants WHERE id=".$id;
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
      <div class="row">
         <div class="marbtm50 wdt-100">

            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 project-desc">
              <ul class="profile_info list_none mb-4 pt-2 border-bottom">
                 <li>
                     <span class="title"><i class="fa fa-user"></i> First Name:</span>
                     <p><?php echo $row0["firstname"] ?></p>
                 </li>
                 <li>
                     <span class="title"><i class="fa fa-user-circle-o"></i> Last Name:</span>
                     <p> <?php echo $row0["lastname"]; ?> </p>
                 </li>
                 <li>
                     <span class="title"><i class="fa fa-envelope"></i> Email:</span>
                     <p> <?php echo $row0["email"]; ?> </p>
                 </li>
                 <li>
                     <span class="title"><i class="fa fa-phone"></i> Phone Number:</span>
                     <p> <?php echo $row0["phone_number"]; ?> </p>
                 </li>
              </ul>
            </div>

            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 project-desc">
              <ul class="profile_info list_none mb-4 pt-2 border-bottom">
                 <li>
                     <span class="title"><i class="fa fa-globe"></i> Nationality: </span>
                     <p> <?php echo $row0["country"]; ?> </p>
                 </li>
                 <li>
                     <span class="title"><i class="fa fa-home"></i> Address:</span>
                     <p> <?php echo $row0["address"]; ?> </p>
                 </li>
                 <li>
                     <span class="title"><i class="fa fa-building"></i> Post Applied:</span>
                     <p> <?php echo $row0["career"]; ?> </p>
                 </li>
                 <li>
                     <span class="title"><i class="fa fa-venus-mars"></i> Gender:</span>
                     <p> <?php echo $row0["gender"]; ?> </p>
                 </li>
                 <li>
                     <span class="title"><i class="fa fa-calendar"></i> Date/Time Applied: </span>
                     <p> <?php echo $row0["created_on"]; ?> </p>
                 </li>
              </ul>
            </div>
         </div>

         <!---<div class="col-md-12 marbtm50 wdt-100">

            <section class="content-header">
              <h1>
                Files Uploaded
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
                      $stmt = $conn->prepare("SELECT * FROM applicant_files WHERE applicant_email=:applicant_email");
                      $stmt->execute(['applicant_email'=>$row0["email"]]);
                      foreach($stmt as $file){
                        echo "
                          <tr>
                            <td>".$file['file_title']."</td>
                            <td>
                              <a href='uploads/".$file['file_name']."' class='btn btn-primary btn-sm btn-flat'><i class='fa fa-eye'></i> View</a>
                              <a href='applicants_file_delete.php?id=".$file['id']."' class='btn btn-danger btn-sm btn-flat'><i class='fa fa-trash'></i> Delete</a>
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
         </div>--->

      </div>

    </section>
     
  </div>
  	<?php include 'includes/footer.php'; ?>

</div>
<!-- ./wrapper -->

<?php include 'includes/scripts.php'; ?>
</body>
</html>
