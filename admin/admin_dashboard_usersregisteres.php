<!DOCTYPE html>
<html>

  <?php include '../core/session.php'; ?>
  <?php admin_protect (); ?>
  <?php

    if(($user_data['admin_password_check']) == 1){
    } else {
      header('Location: /mocktime/admin');
    }

  ?>
  
  <?php include '/includes/admin_dashboard_usersregisteres_header.php'; ?>
  <?php include '/includes/admin_dashboard_header.php'; ?>

<body class="hold-transition skin-blue sidebar-mini">
  <div class="wrapper">

    <?php include '/includes/admin_header_profile.php';?>
      <!-- Left side column. contains the logo and sidebar -->
    <?php include '/includes/admin_side_navigation.php';?>

    <div class="content-wrapper">
      <section class="content-header">
        <h1>
          Dashboard
          <small>Registered Users</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="admin_dashboard.php"><i class="fa fa-home"></i> Home</a></li>
          <li><a href="admin_dashboard.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
          <li class="active">Registered Users</li>
        </ol>
      </section>

        <?php
        
          $counter = 0;

          if (isset($_POST['freezechecked'])) {
            foreach ($_POST['freezechecked'] as $freeze){
              if($freeze == "On")
                set_freeze_user_account($_POST['id'][$counter]);
              else
                unset_freeze_user_account($_POST['id'][$counter]); 

              $counter++;
            }
          }

        ?>

        <section class="content">

          <form method="post" action="">

              <table class="table table-hover table-datatable table-striped table-bordered">
                  <thead>
                      <tr>
                          <th style="text-align: left;">Full Name</th>
                          <th style="text-align: left;">Email Address</th>
                          <th style="text-align: left;">Date Joined</th>
                          <th style="text-align: left;">Freeze Account</th>
                          <th style="text-align: left;">Delete Account</th>
                      </tr>
                  </thead>


                  <tbody>
                    <?php foreach (get_all_users() as $r) { ?>
                      
                      <tr>
                          <td style="text-align: left;"><?php echo $r['first_name'] ?> <?php echo $r['last_name'] ?></td> 
                          <td style="text-align: left;"><?php echo $r['email_address'] ?></td>
                          <td style="text-align: left;"><?php echo date("jS F Y, h:i:s A", strtotime(safe_output($r['date_created']))); ?> </td>
                          <td style="text-align: left;">

                              <?php 
                                if ($r['freeze_account'] == 0) { 
                                    echo '<div class="example">
                                     <input id="freezechecked" type="hidden" value="Off" name="freezechecked[]">
                                    <input type="checkbox" id="toggle-event" class="freeze" name="freezerchecked[]" value="Off" unchecked data-toggle="toggle">
                                    <input type="hidden" value="'. $r['user_id'] .'" name="id[]">
                                  </div>';
                                } 
                                else {
                                    echo '<div class="example">
                                    <input id="freezechecked" type="hidden" value="On" name="freezechecked[]">
                                    <input type="checkbox" id="toggle-event" class="freeze" name="freezerchecked[]" value="On" checked data-toggle="toggle">
                                    <input type="hidden" value="'. $r['user_id'] .'" name="id[]">

                                  </div>';
                                }
                              ?>
                          </td>

                          <td style="text-align: left;">

                              <?php
                                 echo '<button type="button" class="btn btn-danger  delete delete-account"><i class="fa fa-trash-o fa-lg"></i> Delete</a></button> 
                                        <input type="hidden" value="'. $r['user_id'] .'"  name="delete[]">';
                              ?>
                          </td>
                      </tr>
                    <?php } ?>

                  </tbody>
              </table>   
              <input type="submit" class="btn btn-success update-button" name="formSubmit" id="formSubmit" value="Update" />

          </form>   

        </section><!-- /.content -->
    </div><!-- /.content-wrapper -->
  

  <?php include '/includes/footer.php'; ?> 

  <script src="dist/js/bootstrap-toggle.js"></script>

  <script>

  //checkbox toggle on and off
  $(document).ready(function(){
     $(document).on('click.bs.toggle', 'div[data-toggle^=toggle]', function(e) {
      var $checkbox = $(this).find('input[type=checkbox]').parent().parent();

      if($checkbox[0].childNodes[1].value == "On")
        $checkbox[0].childNodes[1].value = "Off";
      else
        $checkbox[0].childNodes[1].value = "On";
    })
  });

  //delete button
  var id;
  $('button.delete-account').click(function(e) {
    id = $(this).parent()[0].childNodes[3].value;
      swal({
    title: "Are you sure?",
    text: " You will not be able to undo this action !",
    type: "warning",
    showCancelButton: true,
    confirmButtonColor: "#DD6B55",
    confirmButtonText: "Yes, delete it!",
    closeOnConfirm: false,
    html: false
  }, function(){
    $.post( "deleteuser.php", { deletefunction: id}, function( data ) {
      alert(id);
    location.reload();
  });
  });
    });

  </script>

  <?php include '/includes/admin_dashboard_scripts.php'; ?>

</body>
</html>

