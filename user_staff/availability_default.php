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
        Availability
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Availability</li>
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
              <a href="#addnew" data-toggle="modal" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-plus"></i> Register Availability</a>
            </div>

            <div class="box-body">
              <table id="example1" class="table table-bordered">
                <thead>
                  <th>Start Date</th>
                  <th>End Date</th>
                  <th>Time of Day</th>
                  <th>Tools</th>
                </thead>
                <tbody>
                  <?php
                    $conn = $pdo->open();

                    try{
                      $stmt = $conn->prepare("SELECT * FROM availability WHERE user_id=:user_id AND soft_delete=0");
                      $stmt->execute(['user_id'=>$staff['id']]);
                      foreach($stmt as $row){
                        echo "
                          <tr>
                            <td>".date('M d, Y', strtotime($row['start_date']))."</td>
                            <td>".date('M d, Y', strtotime($row['end_date']))."</td>
                            <td>".$row['time_of_day']."</td>
                            <td>
                              <button class='btn btn-info btn-sm edit btn-flat' data-id='".$row['id']."'><i class='fa fa-edit'></i> Edit</button>
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

});

function getRow(id){
  $.ajax({
    type: 'POST',
    url: 'availability_row.php',
    data: {id:id},
    dataType: 'json',
    success: function(response){
      $('.availid').val(response.id);
      $('#edit_start_date').val(response.start_date);
      $('#edit_end_date').val(response.end_date);
      $('#edit_time_of_day').val(response.time_of_day).html(response.time_of_day);
    }
  });
}

  document.addEventListener('DOMContentLoaded', function() {
        var startDateInput = document.getElementById('start_date');
        var endDateInput = document.getElementById('end_date');
        var errorContainer = document.getElementById('error_container');
        var submitButton = document.getElementById('submit_button');

        startDateInput.addEventListener('input', checkDateDifference);
        endDateInput.addEventListener('input', checkDateDifference);

        function checkDateDifference() {
            var startDate = new Date(startDateInput.value);
            var endDate = new Date(endDateInput.value);
            var differenceInDays = Math.abs((endDate - startDate) / (1000 * 60 * 60 * 24));

            if (differenceInDays < 7) {
                errorContainer.textContent = 'Error: Mimimum duration for availability should be at least 7 days.';
                submitButton.disabled = true; // Disable the submit button
            } else {
                errorContainer.textContent = '';
                submitButton.disabled = false; // Enable the submit button
            }
        }
    });
</script>
</body>
</html>
