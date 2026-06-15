<?php 
  include 'includes/session.php';

  if (!in_array($admin["admin_role"], ["global", "recruitment"])) {
    $_SESSION['error'] = "You do not have the permission to view that resource!";

    $act_time = date('Y-m-d h:i A');
    $id = $admin["id"];

    $activity = $conn->prepare("INSERT INTO activity (user_id, message, category, date_sent) VALUES (:user_id, :message, :category, :date_sent)");
    $activity->execute(['user_id'=>$id, 'message'=>'Attempted to view unauthorized resource (stakeholder&#39;s profile)', 'category'=>'Security', 'date_sent'=>$act_time]);

    header('location: home');
    exit;
  }

?>
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
        Stakeholders
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Stakeholders</li>
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

              <a href="#msg_all" data-toggle="modal" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-envelope"></i> Send General Message</a>
            </div>
            <div class="box-body">
              <table id="example1" class="table table-bordered">
                <thead>
                  <th>Email</th>
                  <th>Contact Name</th>
                  <th>Client Name</th>
                  <th>Location</th>
                  <th>Date Registered</th>
                  <th>Tools</th>
                </thead>
                <tbody>
                  <?php
                    $conn = $pdo->open();

                    try{
                      $stmt = $conn->prepare("SELECT * FROM users WHERE type=:type AND soft_delete=1");
                      $stmt->execute(['type'=>1]);
                      foreach($stmt as $row){
                        echo "
                          <tr>
                            <td>".$row['email']."</td>
                            <td>".$row['full_name']."</td>
                            <td>".$row['business_name']."</td>
                            <td>".$row['town_city']."</td>
                            <td>".date('M d, Y', strtotime($row['created_on']))."</td>
                            <td>
                              <button class='btn btn-primary btn-sm msg btn-flat' data-id='".$row['id']."'><i class='fa fa-envelope'></i> DM</button>
                              <a href='users_view.php?wid=".$row["id"]."' class='btn btn-primary btn-sm btn-flat'><i class='fa fa-eye'></i> F-Prof</a>
                              <button class='btn btn-info btn-sm edit btn-flat' data-id='".$row['id']."'><i class='fa fa-edit'></i> Edit</button>
                              <button class='btn btn-success btn-sm restore btn-flat' data-id='".$row['id']."'><i class='fa fa-undo'></i> Restore</button>
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
    <?php include 'includes/stakeholders_modal.php'; ?>

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

  $(document).on('click', '.restore', function(e){
    e.preventDefault();
    $('#restore').modal('show');
    var id = $(this).data('id');
    getRow(id);
  });

  $(document).on('click', '.msg', function(e){
    e.preventDefault();
    $('#msg').modal('show');
    var id = $(this).data('id');
    getRow(id);
  });

  $(document).on('click', '.status', function(e){
    e.preventDefault();
    var id = $(this).data('id');
    getRow(id);
  });

});

function getRow(id){
  $.ajax({
    type: 'POST',
    url: 'stakeholders_row.php',
    data: {id:id},
    dataType: 'json',
    success: function(response){
      $('.userid').val(response.id);
      $('.fullname').html(response.full_name);
      $('.business_name').html(response.business_name);
      $('#edit_email').val(response.email);
      $('#edit_password').val(response.password);
      $('#edit_firstname').val(response.firstname);
      $('#edit_lastname').val(response.lastname);
      $('#edit_gender').val(response.gender).html(response.gender);
      $('#edit_dob').val(response.dob);
      $('#edit_uname').val(response.uname);
      $('#edit_profile_code').val(response.profile_code);
      $('#edit_phone_no').val(response.phone_no);
      $('#edit_address').val(response.address);
      $('#edit_town_city').val(response.town_city);
      $('#edit_postcode').val(response.postcode);
      $('#edit_country').val(response.country);
      $('#edit_career_path').val(response.career_path);
    }
  });
}
</script>
</body>
</html>
