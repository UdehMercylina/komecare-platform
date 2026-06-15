<?php 
  include 'includes/session.php';
  include 'includes/header.php';
?>
<body class="hold-transition skin-yellow sidebar-mini">
<div class="wrapper">

  <?php include 'includes/navbar.php'; ?>
  <?php include 'includes/menubar.php'; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Completed Shifts
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Completed Shifts</li>
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
                  <th>Date Assigned</th>
                  <th>Date Due</th>
                  <th>Date Completed</th>
                  <th>Assigned By</th>
                  <th>Provider Info</th>
                  <th>Location</th>
                  <th>Tools</th>
                </thead>
                <tbody>
                  <tr>
                    <td>11 Feb 2024</td>
                    <td>11 Mar 2024</td>
                    <td>12 Mar 2024</td>
                    <td>Onabayi Elewa</td>
                    <td>Peak Ltd</td>
                    <td>Manchester</td>
                    <td>
                      <button class='btn btn-success btn-sm msg btn-flat'><i class='fa fa-money'></i> Request Payment</button>
                    </td>
                  </tr>
                  <tr>
                    <td>11 Feb 2024</td>
                    <td>11 Mar 2024</td>
                    <td>12 Mar 2024</td>
                    <td>Onabayi Elewa</td>
                    <td>Peak Ltd</td>
                    <td>Manchester</td>
                    <td>
                      Payment Requested
                    </td>
                  </tr>
                  <tr>
                    <td>11 Feb 2024</td>
                    <td>11 Mar 2024</td>
                    <td>12 Mar 2024</td>
                    <td>Onabayi Elewa</td>
                    <td>Peak Ltd</td>
                    <td>Manchester</td>
                    <td>
                      Payment Completed
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </section>
     
  </div>
  	<?php include 'includes/footer.php'; ?>
    <?php include 'includes/users_modal.php'; ?>

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
