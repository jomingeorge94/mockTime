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
            View
            <small>Individual Exam Statistic </small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="admin_dashboard.php"><i class="fa fa-home"></i> Dashboard</a></li>
            <li class="active">Exam Statistics</li>
          </ol>
        </section>

          <!-- Main content -->
        <section class="content">
        
           <!-- DONUT CHART -->
              <div class="box box-danger">
                <div class="box-header with-border">
                  <h3 class="box-title">Max Users Chart</h3>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                  </div>
                </div>
                <div class="box-body">
                    <canvas id="pieChart" style="height:250px"></canvas>
                </div><!-- /.box-body -->
              </div><!-- /.box -->

               <!-- DONUT CHART -->
              <div class="box box-danger">
                <div class="box-header with-border">
                  <h3 class="box-title">Avg Users Chart</h3>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                  </div>
                </div>
                <div class="box-body">
                    <canvas id="pieChart2" style="height:250px"></canvas>
                </div><!-- /.box-body -->
              </div><!-- /.box -->

        </section>



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
        /* ChartJS
         * -------
         * Here we will create a few charts using ChartJS
         */

        //--------------
        //- AREA CHART -
        //--------------

  

        //-------------
        //- PIE CHART -
        //-------------
        // Get context with jQuery - using jQuery's .get() method.
        var pieChartCanvas = $("#pieChart").get(0).getContext("2d");
        var pieChart = new Chart(pieChartCanvas);
        var PieData = [
          <?php 
            foreach(get_mark_breakdown_max($_GET['id']) as $k => $e){
              echo '{
                  value: ' . $e . ',';
                    if($k == "Fail")
                     echo 'color: "red", highlight: "red" ,';
                   else if($k == "Pass by Compensation")
                      echo 'color: "yellow", highlight: "yellow" ,';
                    else if($k == "Pass")
                      echo 'color: "blue", highlight: "blue" ,';
                    else if($k == "Second Lower Class")
                      echo 'color: "purple", highlight: "purple" ,';
                    else if($k == "Second Upper Class")
                      echo 'color: "pink", highlight: "pink" ,';
                    else if($k == "First")
                      echo 'color: "green", highlight: "green" ,';
                    else if($k == "Pending")
                      echo 'color: "grey", highlight: "grey" ,';

                      echo 'label: "' . $k . '",

              },';
            }
          ?>
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






         var pieChartCanvas = $("#pieChart2").get(0).getContext("2d");
        var pieChart2 = new Chart(pieChartCanvas);
        var PieData = [
          <?php 
            foreach(get_mark_breakdown_avg($_GET['id']) as $k => $e){
              echo '{
                  value: ' . $e . ',';
                    if($k == "Fail")
                     echo 'color: "red", highlight: "red" ,';
                   else if($k == "Pass by Compensation")
                      echo 'color: "yellow", highlight: "yellow" ,';
                    else if($k == "Pass")
                      echo 'color: "blue", highlight: "blue" ,';
                    else if($k == "Second Lower Class")
                      echo 'color: "purple", highlight: "purple" ,';
                    else if($k == "Second Upper Class")
                      echo 'color: "pink", highlight: "pink" ,';
                    else if($k == "First")
                      echo 'color: "green", highlight: "green" ,';
                    else if($k == "Pending")
                      echo 'color: "grey", highlight: "grey" ,';

                      echo 'label: "' . $k . '",

              },';
            }
          ?>
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
        pieChart2.Doughnut(PieData, pieOptions);

    
      });
    </script>

  </body>
</html>