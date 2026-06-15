<?php
  include 'includes/session.php'; 
  include "../account/connect.php";

  $id = $_GET['tid'];

  $sql0 = "SELECT * FROM tracking WHERE id=".$id;
  $result0 = $conne->query($sql0);
  $row0 = $result0->fetch_assoc();

  $trackingId = $row0['trackingId'];
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
         <div class="col-md-12 marbtm50 wdt-100">

            <section class="content-header">
              <h1>
                Package <?= $row0['trackingId'] ?> Transport History
              </h1>
            </section>
            
            <div class="box-body">
              <table id="example1" class="table table-bordered">
                <thead>
                  <th>S/N</th>
                  <th>Location</th>
                  <th>Date/Time</th>
                  <th>Status</th>
                </thead>
                <tbody>
                  <?php
                    $conn = $pdo->open();

                    try{
                      $stmt = $conn->prepare("SELECT * FROM update_tracking WHERE trackingId=:trackingId ORDER BY 1 DESC");
                      $stmt->execute(['trackingId'=>$trackingId]);
                      $index = 1;
                      foreach($stmt as $history){
                        echo "
                          <tr>
                            <td>".$index."</td>
                            <td>".$history['location']."</td>
                            <td>".$history['dateAndTime']."</td>
                            <td>".$history['status']."</td>
                            <td>
                              <a href='tracking_history_delete.php?id=".$history['id']."' class='btn btn-danger btn-sm btn-flat'><i class='fa fa-trash'></i> Delete</a>
                            </td>
                          </tr>
                        ";
                      $index++;}
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
