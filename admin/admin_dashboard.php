<!DOCTYPE html>
<html>

<?php include '../core/session.php'; ?>

<?php admin_protect (); ?>

<?php
if(($user_data['admin_password_check']) == 1){
  /*header('Location: /mocktime/admin/admin_dashboard.php');
  exit();*/
} else {
  header('Location: /mocktime/admin');
}

?>


 <?php include '/includes/admin_dashboard_header.php'; ?> 


  <body class="hold-transition skin-green sidebar-mini">
    <div class="wrapper">

      <?php include '/includes/admin_header_profile.php';?>
      <!-- Left side column. contains the logo and sidebar -->
      <?php include '/includes/admin_side_navigation.php';?>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Dashboard
            <small>Control panel</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-home"></i> Home</a></li>
            <li class="active">Dashboard</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <!-- Small boxes (Stat box) -->
          <div class="row admin_dashboard">
            
            
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-purple">
                <div class="inner">
                  <h3><?php echo user_count ();?></h3>
                  <p>Registered Users </p>
                </div>
                <div class="icon">
                  <i class="ion ion-person-add"></i>
                </div>
                <a href="admin_dashboard_usersregisteres.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->

            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-blue">
                <div class="inner">
                  <h3><?php echo getLoggedInUsers();?></h3>
                  <p>Currently logged in Users</p>
                </div>
                <div class="icon">
                  <i class="ion-aperture"></i>
                </div>
                <a href="admin_dashboard_usersregisteres.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
              
            </div><!-- ./col -->

            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-red">
                <div class="inner">
                  <h3><?php echo quiz_count();?></h3>
                  <p>Currently active Exams</p>
                </div>
                <div class="icon">
                  <i class="ion ion-pie-graph"></i>
                </div>
                <a href="../admin/admin_manage_exam.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
              </div>

            </div><!-- ./col -->
             <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-orange">
                <div class="inner">
                  <h3><?php echo category_count();?></h3>
                  <p>Currently available Categories</p>
                </div>
                <div class="icon">
                  <i class="ion-aperture"></i>
                </div>
                <a href="../admin/admin_manage_category.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
              
            </div><!-- ./col -->

          </div><!-- /.row -->


          <div class="box box-danger">
            <div class="box-header with-border">
              <h3 class="box-title">Marking Boundaries</h3>
              <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
              </div>
            </div>
            <div class="box-body">
                <canvas id="pieChart" style="height:250px"></canvas>
            </div><!-- /.box-body -->
          </div><!-- /.box -->

          
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
  

      <?php include '/includes/footer.php'; ?> 

  <?php include '/includes/admin_dashboard_scripts.php'; ?>
    

<!-- jQuery 2.1.4 -->
    <script src="plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <!-- ChartJS 1.0.1 -->
    <script src="plugins/chartjs/Chart.min.js"></script>
    <!-- FastClick -->
    <script src="plugins/fastclick/fastclick.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/app.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="dist/js/demo.js"></script>
    <!-- page script -->


    <script>
      $(function () {

        //-------------
        //- PIE CHART -
        //-------------
        // Get context with jQuery - using jQuery's .get() method.
        var pieChartCanvas = $("#pieChart").get(0).getContext("2d");
        var pieChart = new Chart(pieChartCanvas);
        var PieData = [
          {
            value: 35,
            color: "#E5AE05",
            highlight: "#f56954",
            label: "Pass by Compensation"
          },
          {
            value: 40,
            color: "#92E5AC",
            highlight: "#00a65a",
            label: "Pass"
          },
          {
            value: 50,
            color: "#8DDEE5",
            highlight: "#24403F",
            label: "Second Lower Class"
          },
          {
            value: 60,
            color: "#132240",
            highlight: "#00c0ef",
            label: "Second Upper Class"
          },
          {
            value: 70,
            color: "#00400C",
            highlight: "#00a65a",
            label: "First Class"
          }
        ];
        var pieOptions = {
          //Boolean - Whether we should show a stroke on each segment
          segmentShowStroke: true,
          //String - The colour of each segment stroke
          segmentStrokeColor: "#fff",
          //Number - The width of each segment stroke
          segmentStrokeWidth: 2,
          //Number - The percentage of the chart that we cut out of the middle
          percentageInnerCutout: 50, // This is 0 for Pie charts
          //Number - Amount of animation steps
          animationSteps: 100,
          //String - Animation easing effect
          animationEasing: "easeOutBounce",
          //Boolean - Whether we animate the rotation of the Doughnut
          animateRotate: true,
          //Boolean - Whether we animate scaling the Doughnut from the centre
          animateScale: false,
          //Boolean - whether to make the chart responsive to window resizing
          responsive: true,
          // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
          maintainAspectRatio: true,
          //String - A legend template
          legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<segments.length; i++){%><li><span style=\"background-color:<%=segments[i].fillColor%>\"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>"
        };
        //Create pie or douhnut chart
        // You can switch between pie and douhnut using the method below.
        pieChart.Doughnut(PieData, pieOptions);


        barChartOptions.datasetFill = false;
        barChart.Bar(barChartData, barChartOptions);
      });
    </script>


  </body>
</html>