<?php include 'includes/session.php'; ?>
<?php include 'includes/header.php'; ?>

<?php if (!in_array($admin["admin_role"], ["global", "onboarding", "compliance"])) {
  $_SESSION['error'] = "You do not have the permission to view that resource!";

  $act_time = date('Y-m-d h:i A');
  $id = $admin["id"];

  $activity = $conn->prepare("INSERT INTO activity (user_id, message, category, date_sent) VALUES (:user_id, :message, :category, :date_sent)");
  $activity->execute(['user_id'=>$id, 'message'=>'Attempted to view unauthorized resource (onboarding page)', 'category'=>'Security', 'date_sent'=>$act_time]);

  header('location: home');
} ?>

<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <?php include 'includes/navbar.php'; ?>
  <?php include 'includes/menubar.php'; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Applicants
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Applicants</li>
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
            <div class="box-body">
              <table id="example1" class="table table-bordered">
                <thead>
                  <th>S/N</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>City/Town</th>
                  <th>Date Applied</th>
                  <th>Tools</th>
                </thead>
                <tbody>
                  <?php
                    $conn = $pdo->open();

                    try{
                      $stmt = $conn->prepare("SELECT * FROM users WHERE type=0 AND application_status=0 AND soft_delete=0");
                      $stmt->execute();
                      $index = 1;
                      foreach($stmt as $row){
                        echo "
                          <tr>
                            <td>".$index."</td>
                            <td>".$row['firstname']." ".$row['lastname']."</td>
                            <td>".$row['email']."</td>
                            <td>".$row['town_city']."</td>
                            <td>".date('M d, Y', strtotime($row['created_on']))."</td>
                            <td>
                              <a href='applicants_view.php?aid=".$row["id"]."' class='btn btn-primary btn-sm btn-flat'><i class='fa fa-eye'></i> View</a>
                              <button class='btn btn-success btn-sm upload btn-flat' data-id='".$row['id']."'><i class='fa fa-user'></i> Approve</button>
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
      </div>
    </section>
     
  </div>
  	<?php include 'includes/footer.php'; ?>
    <?php include 'includes/applicants_modal.php'; ?>

</div>
<!-- ./wrapper -->

<?php include 'includes/scripts.php'; ?>
<script>
$(function(){

  $(document).on('click', '.reject', function(e){
    e.preventDefault();
    $('#reject').modal('show');
    var id = $(this).data('id');
    getUserRow(id);
  });

  $(document).on('click', '.upload', function(e){
    e.preventDefault();
    $('#upload').modal('show');
    var id = $(this).data('id');
    getUserRow(id);
  });

});

function getUserRow(id){
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
