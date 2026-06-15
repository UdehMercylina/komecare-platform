<?php
  include 'includes/session.php';

  if (!in_array($admin["admin_role"], ["global", "onboarding", "compliance"])) {
    $_SESSION['error'] = "You do not have the permission to view that resource!";

    $act_time = date('Y-m-d h:i A');
    $id = $admin["id"];

    $activity = $conn->prepare("INSERT INTO activity (user_id, message, category, date_sent) VALUES (:user_id, :message, :category, :date_sent)");
    $activity->execute(['user_id'=>$id, 'message'=>'Attempted to view unauthorized resource (applicant&#39;s profile)', 'category'=>'Security', 'date_sent'=>$act_time]);

    header('location: home');
    exit;
  }

  $id = $_GET['aid'];

  $sql0 = "SELECT * FROM users WHERE id=".$id;
  $result0 = $conne->query($sql0);
  $row0 = $result0->fetch_assoc();

  $pass_btn_txt = "Update Password";
  if (!isset($row0["password"])) {
    $pass_btn_txt = "Set Password";
  }
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
        <div class="col-md-6">
          <div class="box box-solid">
            <div class="box-header with-border">
              <h3 class="box-title"><?php echo $row0["full_name"] ?>'s Profile</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <dl class="dl-horizontal">
                <dt>Name:</dt>
                <dd><?php echo $row0["full_name"] ?></dd>
                <dt>Username:</dt>
                <dd><?php echo $row0["uname"]; ?></dd>
                <dt>Gender:</dt>
                <dd><?php echo $row0["gender"]; ?></dd>
                <dt>Date of Birth:</dt>
                <dd><?php echo $row0["dob"]; ?></dd>
                <dt>Occupation:</dt>
                <dd><?php echo $row0["career_path"]; ?></dd>
                <dt>Registration Date:</dt>
                <dd><?php echo $row0["created_on"]; ?></dd>
              </dl>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>

        <div class="col-md-6">
          <div class="box box-solid">
            <div class="box-header with-border">
              <h3 class="box-title"><?php echo $row0["full_name"] ?>'s Contact Details</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <dl class="dl-horizontal">
                <dt>Email:</dt>
                <dd><?php echo $row0["email"]; ?></dd>
                <dt>Phone Number:</dt>
                <dd><?php echo $row0["phone_no"]; ?></dd>
                <dt>Registration Date:</dt>
                <dd><?php echo $row0["created_on"]; ?></dd>
                <dt>Address:</dt>
                <dd><?php echo $row0["address"]; ?></dd>
                <dt>Town/City:</dt>
                <dd><?php echo $row0["town_city"]; ?></dd>
                <dt>Postcode:</dt>
                <dd><?php echo $row0["postcode"]; ?></dd>
              </dl>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>

        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Documents</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered">
                <thead>
                  <th>File Name</th>
                  <th>Validity</th>
                  <th>Status</th>
                  <th>Tools</th>
                </thead>
                <tbody>
                  <?php
                    $conn = $pdo->open();

                    try{
                      $stmt = $conn->prepare("SELECT *, documents.id AS fileid FROM documents LEFT JOIN documents_list ON documents.file_id = documents_list.id WHERE user_id=:user_id AND documents.soft_delete=0");
                      $stmt->execute(['user_id'=>$id]);
                      foreach($stmt as $file){
                        echo "
                          <tr>
                            <td>".$file['document_name']."</td>
                            <td>".$file['date_issued']." - ".$file['date_expiring']."</td>
                            <td>".$file['file_status']."</td>
                            <td>
                              <a href='uploads/".$file['file_name']."' class='btn btn-primary btn-sm btn-flat'><i class='fa fa-eye'></i> View</a>
                              <a href='#' class='btn btn-primary status btn-sm btn-flat' data-id='".$file['fileid']."'><i class='fa fa-external-link'></i> Set Status</a>
                              <a href='#' class='btn btn-danger delete btn-sm btn-flat' data-id='".$file['fileid']."'><i class='fa fa-trash'></i> Delete</a>
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
          <!-- /.box -->
        </div>

        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-body pad table-responsive">
              <p>Important Actions</p>
              <table class="table table-bordered text-center">
                <tbody>
                  <tr>
                    <td>
                      <button class="btn btn-block password btn-default" data-id="<?php echo $row0["id"]; ?>"><i class="fa fa-lock"></i> <?php echo $pass_btn_txt; ?></button>
                    </td>
                    <td>
                      <button class="btn btn-block request btn-info" data-id="<?php echo $row0["id"]; ?>"><i class="fa fa-book"></i> Request Document</button>
                    </td>
                    <td>
                      <button class="btn btn-block upload btn-success" data-id="<?php echo $row0["id"]; ?>"><i class="fa fa-user"></i> Approve and Upload Profile</button>
                    </td>
                    <!-- <td>
                      <button class="btn btn-block reject btn-danger" data-id="<?php echo $row0["id"]; ?>"><i class="fa fa-close"></i> Reject Application</button>
                    </td> -->
                  </tr>
                </tbody>
              </table>
            </div>
            <!-- /.box -->
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

  $(document).on('click', '.status', function(e){
    e.preventDefault();
    $('#file_status').modal('show');
    var id = $(this).data('id');
    getDocRow(id);
  });

  $(document).on('click', '.delete', function(e){
    e.preventDefault();
    $('#file_delete').modal('show');
    var id = $(this).data('id');
    getDocRow(id);
  });

  $(document).on('click', '.password', function(e){
    e.preventDefault();
    $('#password_set').modal('show');
    var id = $(this).data('id');
    getUserRow(id);
  });

  $(document).on('click', '.request', function(e){
    e.preventDefault();
    $('#request_doc').modal('show');
    var id = $(this).data('id');
    getUserRow(id);
    getDocumentList();
  });

  $(document).on('click', '.upload', function(e){
    e.preventDefault();
    $('#upload').modal('show');
    var id = $(this).data('id');
    getUserRow(id);
  });

  $(document).on('click', '.reject', function(e){
    e.preventDefault();
    $('#reject').modal('show');
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

function getDocumentList(){
  $.ajax({
    type: 'POST',
    url: 'document_list_fetch.php',
    dataType: 'json',
    success:function(response){
      $('#document_list').append(response);
    }
  });
}

function getDocRow(id){
  $.ajax({
    type: 'POST',
    url: 'files_row.php',
    data: {id:id},
    dataType: 'json',
    success: function(response){
      $('.fileid').val(response.fileid);
      $('.filetitle').html(response.document_name);
      $('#edit_file_title').val(response.document_name);
      $('#edit_date_expiring').val(response.date_expiring);
      $('#edit_date_issued').val(response.date_issued);
      $('#edit_file_status').val(response.file_status).html(response.file_status);
    }
  });
}
</script>

<script>
    document.getElementById('status').addEventListener('change', function() {
        var status = this.value;
        var textareaContainer = document.getElementById('textareaContainer');

        // Check if the selected value is "requested"
        if (status === 'requested') {
            // Create a new textarea element
            var textarea = document.createElement('textarea');
            textarea.setAttribute('class', 'form-control');
            textarea.setAttribute('id', 'reason');
            textarea.setAttribute('name', 'reason');
            textarea.setAttribute('placeholder', 'Reason for request...');
            
            // Append the textarea to the textareaContainer
            textareaContainer.innerHTML = ''; // Clear previous content
            textareaContainer.appendChild(textarea);
        } else {
            // Clear textareaContainer if the selected value is not "requested"
            textareaContainer.innerHTML = '';
        }
    });
</script>

</body>
</html>