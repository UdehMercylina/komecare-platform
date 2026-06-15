<?php include 'includes/session.php'; ?>
<?php include 'includes/header.php'; ?>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <?php include 'includes/navbar.php'; ?>
  <?php include 'includes/menubar.php'; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Tracking
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Tracking</li>
      </ol>
    </section>

    <!-- Main content -->
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
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header with-border">
              <a href="#addnew" data-toggle="modal" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-plus"></i> New</a>

            </div>
            <div class="box-body">
              <table id="example1" class="table table-bordered">
                <thead>
                  <th>Tracking ID</th>
                  <th>Sender</th>
                  <th>Receiver</th>
                  <th>Date Shipped</th>
                  <th>Tools</th>
                </thead>
                <tbody>
                  <?php
                    $conn = $pdo->open();

                    try{
                      $stmt = $conn->prepare("SELECT * FROM tracking ORDER BY id DESC");
                      $stmt->execute();
                      foreach($stmt as $row){

                        echo "
                          <tr>
                            <td>".$row['trackingId']."</td>
                            <td>".$row['sender']."</td>
                            <td>".$row['receiver']."</td>
                            <td>".date('M d, Y', strtotime($row['dateShipped']))."</td>
                            <td>
                              <button class='btn btn-primary btn-sm update btn-flat' data-id='".$row['id']."'><i class='fa fa-plane'></i> UPDATE</button>
                              <button class='btn btn-info btn-sm edit btn-flat' data-id='".$row['id']."'><i class='fa fa-edit'></i> Edit</button>
                              <a href='tracking_history.php?tid=".$row["id"]."' class='btn btn-primary btn-sm btn-flat'><i class='fa fa-history'></i> History</a>
                              <button class='btn btn-danger btn-sm delete btn-flat' data-id='".$row['id']."'><i class='fa fa-trash'></i> Delete</button>
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
      </div>
    </section>
     
  </div>
  	<?php include 'includes/footer.php'; ?>
    <?php include 'includes/tracking_modal.php'; ?>

</div>
<!-- ./wrapper -->

<?php include 'includes/scripts.php'; ?>
<script>
$(function(){

  $(document).on('click', '.edit', function(e){
    e.preventDefault();
    $('#edit').modal('show');
    var id = $(this).data('id');
    getRow(id);
  });

  $(document).on('click', '.delete', function(e){
    e.preventDefault();
    $('#delete').modal('show');
    var id = $(this).data('id');
    getRow(id);
  });

  $(document).on('click', '.update', function(e){
    e.preventDefault();
    $('#update').modal('show');
    var id = $(this).data('id');
    getRow(id);
  });

});

function getRow(id){
  $.ajax({
    type: 'POST',
    url: 'tracking_row.php',
    data: {id:id},
    dataType: 'json',
    success: function(response){
      $('.trackingid').val(response.id);
      $('#edit_trackingId').val(response.trackingId);
      $('#update_trackingId').val(response.trackingId);
      $('#edit_shipmentId').val(response.shipmentId);
      $('#edit_dateShipped').val(response.dateShipped);
      $('#edit_expDelDate').val(response.expDelDate);
      $('#edit_origin').val(response.origin);
      $('#edit_destination').val(response.destination);
      $('#edit_sender').val(response.sender);
      $('#edit_senderAdd').val(response.senderAdd);
      $('#edit_receiver').val(response.receiver);
      $('#edit_receiverAdd').val(response.receiverAdd);
      $('#edit_terms').val(response.terms);
      $('#edit_reference').val(response.reference);
      $('#edit_orderNum').val(response.orderNum);
      $('#edit_invoiceNum').val(response.invoiceNum);
      $('#edit_quantity').val(response.quantity);
      $('#edit_service').val(response.service);
      $('#edit_weight').val(response.weight);
      $('#edit_dimensions').val(response.dimensions);
      $('.trackingId').html(response.trackingId);
      CKEDITOR.instances["editor2"].setData(response.package);
    }
  });
}
</script>
</body>
</html>
