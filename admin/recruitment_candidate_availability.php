<?php 
  include 'includes/session.php';

  if (!in_array($admin["admin_role"], ["global", "recruitment", "compliance"])) {
    $_SESSION['error'] = "You do not have the permission to view that resource!";

    $act_time = date('Y-m-d h:i A');
    $id = $admin["id"];

    $activity = $conn->prepare("INSERT INTO activity (user_id, message, category, date_sent) VALUES (:user_id, :message, :category, :date_sent)");
    $activity->execute(['user_id'=>$id, 'message'=>'Attempted to view unauthorized resource (applicant&#39;s profile)', 'category'=>'Security', 'date_sent'=>$act_time]);

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
        Candidates Availability
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Candidates Availability</li>
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
                  <th>Name</th>
                  <th>Status</th>
                  <th>Tools</th>
                </thead>
                <tbody>
                  <?php
                    $conn = $pdo->open();

                    try{
                      $stmt = $conn->prepare("SELECT * FROM users WHERE type=:type AND application_status=1 AND soft_delete=0");
                      $stmt->execute(['type'=>0]);
                      foreach($stmt as $row){
                        echo "
                          <tr>
                            <td>".$row['email']."</td>
                            <td>".$row['full_name']."</td>
                            <td>".$row['availability_status']."</td>
                            <td>
                              <a href='candidate_availability.php?wid=".$row["id"]."' class='btn btn-primary btn-sm btn-flat'><i class='fa fa-calendar'></i> Availability</a>
                              <button class='btn btn-info btn-sm edit btn-flat' data-id='".$row['id']."'><i class='fa fa-edit'></i> Toggle Edit</button>
                              <button class='btn btn-danger btn-sm delete btn-flat' data-id='".$row['id']."'><i class='fa fa-trash'></i> Clear Availability</button>
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
    <?php include 'includes/availability_modal.php'; ?>

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
    url: 'users_row.php',
    data: {id:id},
    dataType: 'json',
    success: function(response){
      $('.userid').val(response.id);
      $('.fullname').html(response.full_name);
      $('#edit_email').val(response.email);
      $('#edit_password').val(response.password);
      $('#edit_firstname').val(response.firstname);
      $('#edit_lastname').val(response.lastname);
      $('#edit_gender').val(response.gender).html(response.gender);
      $('#edit_avail_status').val(response.availability_status).html(response.availability_status);
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
