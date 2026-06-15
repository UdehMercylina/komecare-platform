<?php 
  include 'includes/session.php';
  include 'includes/format.php'; 
?>
<?php 
  $today = date('Y-m-d');
  $year = date('Y');
  if(isset($_GET['year'])){
    $year = $_GET['year'];
  }

  $conn = $pdo->open();
?>
<?php include 'includes/header.php'; ?>
<body class="hold-transition skin-yellow sidebar-mini">
<div class="wrapper">

  <?php include 'includes/navbar.php'; ?>
  <?php include 'includes/menubar.php'; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dashboard
      </h1>
      <ol class="breadcrumb">
        <li><a href="dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
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
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-4 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              $ 884.00
              <p>Available Earnings</p>
            </div>
            <div class="icon">
              <i class="fa fa-money"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-4 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              30
              <p>Total Shifts Worked</p>
            </div>
            <div class="icon">
              <i class="fa fa-barcode"></i>
            </div>
            <a href="shifts" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-4 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-purple">
            <div class="inner">
              9
              <p>Openings</p>
            </div>
            <div class="icon">
              <i class="fa fa-briefcase"></i>
            </div>
            <a href="openings.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      </div>
      <!-- /.row -->

      <div class="row">
        <div class="col-xs-12">
          <div class="box">

            <div class="box-header with-border">
              <h5>Shift Summary</h5>
            </div>

            <div class="box-body">
              <div id="calendar" class="fc fc-unthemed fc-ltr"></div>
            </div>
          </div>
        </div>
      </div>

      </section>
      <!-- right col -->
    </div>
  	<?php include 'includes/footer.php'; ?>

</div>
<!-- ./wrapper -->

<!-- Chart Data -->
<?php
  $months = array();
  $sales = array();
  for( $m = 1; $m <= 12; $m++ ) {
    try{
      $stmt = $conn->prepare("SELECT *, COUNT(*) AS numrows FROM tracking WHERE MONTH(dateShipped)=:month AND YEAR(dateShipped)=:year");
      $stmt->execute(['month'=>$m, 'year'=>$year]);
      $trow = $stmt->fetch();
      $total = $trow['numrows'];

      array_push($sales, $total);
    }
    catch(PDOException $e){
      echo $e->getMessage();
    }

    $num = str_pad( $m, 2, 0, STR_PAD_LEFT );
    $month =  date('M', mktime(0, 0, 0, $m, 1));
    array_push($months, $month);
  }

  $months = json_encode($months);
  $sales = json_encode($sales);

?>
<!-- End Chart Data -->

<?php $pdo->close(); ?>
<?php include 'includes/scripts.php'; ?>
<script>
$(function(){
  var barChartCanvas = $('#barChart').get(0).getContext('2d')
  var barChart = new Chart(barChartCanvas)
  var barChartData = {
    labels  : <?php echo $months; ?>,
    datasets: [
      {
        label               : 'SALES',
        fillColor           : 'rgba(60,141,188,0.9)',
        strokeColor         : 'rgba(60,141,188,0.8)',
        pointColor          : '#3b8bba',
        pointStrokeColor    : 'rgba(60,141,188,1)',
        pointHighlightFill  : '#fff',
        pointHighlightStroke: 'rgba(60,141,188,1)',
        data                : <?php echo $sales; ?>
      }
    ]
  }
  //barChartData.datasets[1].fillColor   = '#00a65a'
  //barChartData.datasets[1].strokeColor = '#00a65a'
  //barChartData.datasets[1].pointColor  = '#00a65a'
  var barChartOptions                  = {
    //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
    scaleBeginAtZero        : true,
    //Boolean - Whether grid lines are shown across the chart
    scaleShowGridLines      : true,
    //String - Colour of the grid lines
    scaleGridLineColor      : 'rgba(0,0,0,.05)',
    //Number - Width of the grid lines
    scaleGridLineWidth      : 1,
    //Boolean - Whether to show horizontal lines (except X axis)
    scaleShowHorizontalLines: true,
    //Boolean - Whether to show vertical lines (except Y axis)
    scaleShowVerticalLines  : true,
    //Boolean - If there is a stroke on each bar
    barShowStroke           : true,
    //Number - Pixel width of the bar stroke
    barStrokeWidth          : 2,
    //Number - Spacing between each of the X value sets
    barValueSpacing         : 5,
    //Number - Spacing between data sets within X values
    barDatasetSpacing       : 1,
    //String - A legend template
    legendTemplate          : '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<datasets.length; i++){%><li><span style="background-color:<%=datasets[i].fillColor%>"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>',
    //Boolean - whether to make the chart responsive
    responsive              : true,
    maintainAspectRatio     : true
  }

  barChartOptions.datasetFill = false
  var myChart = barChart.Bar(barChartData, barChartOptions)
  document.getElementById('legend').innerHTML = myChart.generateLegend();
});
</script>
<script>
$(function(){
  $('#select_year').change(function(){
    window.location.href = 'dashboard.php?year='+$(this).val();
  });
});

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
            $stmt = $conn->prepare("SELECT * FROM shift WHERE candidate_id=:user_id AND soft_delete=0");
            $stmt->execute(['user_id'=>$staff['id']]);
            $now = date('Y-m-d h:i A');

            foreach($stmt as $row){
              if ($now < $row['shift_start_date']) {
                  $color = '#0073b7';
                  $status = 'Assigned';
              } elseif ($now >= $row['shift_due_date']) {
                  $color = '#008000';
                  $status = 'Completed';
              } else {
                  $color = '#00c0ef';
                  $status = 'Ongoing';
              }
              echo "
                {
                  title          : '".$status." - ".$row['task_title']."',
                  start          : new Date(".date('Y', strtotime($row['shift_start_date'])).", ".date('m', strtotime($row['shift_start_date']))." - 1, ".date('d', strtotime($row['shift_start_date']))."),
                  end            : new Date(".date('Y', strtotime($row['shift_due_date'])).", ".date('m', strtotime($row['shift_due_date']))." - 1, ".date('d', strtotime($row['shift_due_date']))."),
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
</body>
</html>