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
            <small>Exam Result </small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="admin_dashboard.php"><i class="fa fa-home"></i> Dashboard</a></li>
            <li class="active">Exam Resul</li>
          </ol>
        </section>



        <section class="content">

              <table class="table table-hover table-datatable table-striped table-bordered">

                  <thead>
                      <tr>
                          <th style="text-align: left;">Full Name</th>
                          <th style="text-align: left;">Email Address</th>
                          <th style="text-align: left;">Exam Name</th>
                          <th style="text-align: left;">Exam Date</th>
                          <th style="text-align: left;">Exam Duration</th>
                          <th style="text-align: left;">Total Questions</th>
                          <th style="text-align: left;">Time Taken</th>
                          <th style="text-align: left;">Student Score (%)</th>
                          <th style="text-align: left;">Mark Classification</th>


                          
                      </tr>
                  </thead>


                  <tbody>
                    <?php  foreach (get_student_detail() as $r) { ?>
                      
                      <tr>
                          <td style="text-align: left;"><?php echo $r['first_name'] . " " . $r['last_name'] ?></td> 

                          
                          <td style="text-align: left;"><?php echo $r['email_address'] ?></td> 

                          <td style="text-align: left;"><?php echo $r['quiz_name'] ?></td> 

                          <td style="text-align: left;"><?php echo $r['exam_start_time'] ?></td> 
                          <td style="text-align: left;"><?php echo $r['quiz_duration'] ?></td> 
                          <td style="text-align: left;"><?php echo $r['total_questions'] ?></td> 
                          <td style="text-align: left;"><?php echo $r['time_taken'] ?></td> 
                          <td style="text-align: left;"><?php echo $r['student_result'] ?></td>

                          <?php
                          

                             if(intval($r['student_result']) <35){
                                echo '<td class="label-danger" style="text-align: left;">  Failed </td>';
                             }else if(intval($r['student_result']) >= 35 && intval($r['student_result']) <40){
                                echo '<td class="label-warning" style="text-align: left;">  Pass by Compensation   </td>';
                             }else if(intval($r['student_result']) >= 40 && intval($r['student_result']) <50){
                                echo '<td class="label-info" style="text-align: left;">  Passed   </td>';
                             }else if(intval($r['student_result']) >= 50 && intval($r['student_result']) <60){
                                echo '<td class="label-primary" style="text-align: left;">  Second Lower Class   </td>';
                             }else if(intval($r['student_result']) >= 60 && intval($r['student_result']) <70){
                                echo '<td class="label-primary" style="text-align: left;">  Second Upper Class   </td>';
                             }else if(intval($r['student_result']) >= 70){
                                echo '<td class="label-success" style="text-align: left;">  First Class   </td>';
                             }
                           
                          ?> 
                          
                          
                      </tr>
                    <?php } ?>

                  </tbody>
              </table>   

          <?php if (get_all_categories() == null) {
            echo '<h3>No records found in the database.</h3>';
          } ?>


        </section>



      </div><!-- /.content-wrapper -->
  

      <?php include '/includes/footer.php'; ?> 

  <?php include '/includes/admin_dashboard_scripts.php'; ?>
  


  </body>
</html>