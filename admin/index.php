<!DOCTYPE html>
<html>

<?php include '../core/session.php'; ?>

<?php admin_protect (); ?>

<?php
if($user_data['admin_password_check']){
  header('Location: /mocktime/admin/admin_dashboard.php');
  exit();}

?>

  <?php include '/includes/admin_main_header.php'; ?> 

  <body class="hold-transition skin-blue sidebar-mini">
      <!-- Main Header -->
      <?php include '/includes/admin_navigation_screen.php'; ?> 

      <!-- Left side column. contains the logo and sidebar -->
      <?php include '/includes/admin_left_screen.php'; ?> 

      <!-- Content Wrapper. Contains page content -->
      <?php include '/includes/admin_content_screen.php'; ?> 

      <!-- Main Footer -->
      <?php include '/includes/footer.php'; ?> 


    <!-- REQUIRED JS SCRIPTS -->
    <?php include '/includes/admin_main_javascripts.php'; ?> 

  </body>
</html>
