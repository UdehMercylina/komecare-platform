<?php
  include 'includes/session.php';

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
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?= $row0["full_name"] ?>
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

            <div class="box-body">
              <div id="calendar" class="fc fc-unthemed fc-ltr"></div>
            </div>
          </div>
        </div>
      </div>
    </section>
     
  </div>
    <?php include 'includes/footer.php'; ?>

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
      $('#edit_selected_date').val(response.selected_date);
      $('#edit_time_of_day').val(response.time_of_day).html(response.time_of_day);
    }
  });
}

/* initialize the calendar */
$(function () {
  //Date for the calendar events (dummy data)
  var date = new Date()
  var d    = date.getDate(),
      m    = date.getMonth(),
      y    = date.getFullYear()
  $('#calendar').fullCalendar({
    header    : {
      left  : 'prev,next',
      center: 'title',
      right : ''
    },
    buttonText: {
      month: 'month',
      week : 'week',
      day  : 'day'
    },
     events    : [
        <?php
          $conn = $pdo->open();

          try{
            $stmt = $conn->prepare("SELECT * FROM availability WHERE user_id=:user_id AND soft_delete=0");
            $stmt->execute(['user_id'=>$id]);
            foreach($stmt as $row){
              if ($row['time_of_day'] == "Day") {
                $color = '#00c0ef';
              }elseif ($row['time_of_day'] == "Night") {
                $color = '#000000';
              }elseif ($row['time_of_day'] == "Day and Night") {
                $color = '#6c7b8b';
              }else {
                $color = '#f56954';
              }
              echo "
                {
                  title          : '".$row['time_of_day']."',
                  start          : new Date(".date('Y', strtotime($row['selected_date'])).", ".date('m', strtotime($row['selected_date']))." - 1, ".date('d', strtotime($row['selected_date']))."),
                  backgroundColor: '".$color."',
                  borderColor    : '".$color."'
                },
              ";
            }
          }
          catch(PDOException $e){
            echo $e->getMessage();
          }

          $pdo->close();
        ?>
        // {
        //   title          : 'All Day Event',
        //   start          : new Date(y, m, 1),
        //   backgroundColor: '#f56954', //red '#f39c12', //yellow '#0073b7', //Blue '#00c0ef', //Black '#000000', linear-gradient(to right, #00c0ef 50%, #000000 50%); //Info (aqua)
        //   borderColor    : '#f56954' //red
        // },
        // {
        //   title          : 'Long Event',
        //   start          : new Date(y, m, d - 5),
        //   end            : new Date(y, m, d - 2),
        //   backgroundColor: '#f39c12', //yellow
        //   borderColor    : '#f39c12' //yellow
        // }
      ],
    clickable  : true,
    //selectable: true,
    //editable  : true,
  })

  $(document).on('click', '.fc-day', function(e){
    e.preventDefault();
    var dateStr = $(this).data('date');
        // Log the date to the console or use it as needed
        console.log('Clicked date:', dateStr);
    openAvailabilityModal(dateStr);
  });

  function openAvailabilityModal(dateStr) {
      // Show the availability modal
      $('#availabilityModal').modal('show');
      var dateFull = moment(dateStr).format('dddd, Do [of] MMMM YYYY');
      
      // Set the selected date in the modal
      $('#selectedDate').val(dateStr);
      $('#selectedDateFull').html(dateFull);
  }

  /* ADDING EVENTS */
  var currColor = '#3c8dbc' //Red by default
  //Color chooser button
  var colorChooser = $('#color-chooser-btn')
  $('#color-chooser > li > a').click(function (e) {
    e.preventDefault()
    //Save color
    currColor = $(this).css('color')
    //Add color effect to button
    $('#add-new-event').css({ 'background-color': currColor, 'border-color': currColor })
  })
  $('#add-new-event').click(function (e) {
    e.preventDefault()
    //Get value and make sure it is not null
    var val = $('#new-event').val()
    if (val.length == 0) {
      return
    }

    //Create events
    var event = $('<div />')
    event.css({
      'background-color': currColor,
      'border-color'    : currColor,
      'color'           : '#fff'
    }).addClass('external-event')
    event.html(val)
    $('#external-events').prepend(event)

    //Add draggable funtionality
    init_events(event)

    //Remove event from text input
    $('#new-event').val('')
  })
})

</script>

<!-- <script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            selectable: true,
            dateClick: function(info) {
                openAvailabilityModal(info.dateStr);
            }
        });
        calendar.render();

        function openAvailabilityModal(date) {
            // Show the availability modal
            $('#availabilityModal').modal('show');
            
            // Set the selected date in the modal
            $('#selectedDate').val(date);
        }

        // Handle submission of availability form
        $('#availabilityForm').submit(function(e) {
            e.preventDefault();
            var selectedDate = $('#selectedDate').val();
            var availability = $('#availability').val();
            
            // Log selected date and availability
            console.log('Selected date:', selectedDate);
            console.log('Selected availability:', availability);
            
            // Close the modal
            $('#availabilityModal').modal('hide');
            
            // You can add your code here to handle the availability data (e.g., send it to a server)
        });
    });
</script> -->

</body>
</html>