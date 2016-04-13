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
            <small>Exam Statistics </small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="admin_dashboard.php"><i class="fa fa-home"></i> Dashboard</a></li>
            <li class="active">Exam Statistics</li>
          </ol>
        </section>

          <!-- Main content -->
        <section class="content">
          <!-- Small boxes (Stat box) -->
          <div class="row admin_dashboard">
            <?php foreach (get_all_exam() as $q) {

            
            echo ' <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-purple">
                <div class="inner">
                  <h1> ' . $q["quiz_name"] . ' </h3>
                  
                </div>
                <div class="icon">
                  <i class="ion ion-person-add"></i>
                </div>
                <a href="admin_exam_statics.php?id=' . $q["quiz_id"] . ' " class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col --> ';
                    }
                     ?>
          </div>

        </section>






      </div><!-- /.content-wrapper -->
  

      <?php include '/includes/footer.php'; ?> 

  <?php include '/includes/admin_dashboard_scripts.php'; ?>
  


  </body>
</html>