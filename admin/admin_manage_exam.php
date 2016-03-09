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
          Manage
          <small>Exam Listing</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="admin_dashboard.php"><i class="fa fa-home"></i> Home</a></li>
          <li><a href="admin_dashboard.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
          <li class="active">Exam Listing</li>
        </ol>
      </section>

        <?php
        
          $counterboy = 0;

          if (isset($_POST['freezechecked'])) {
            foreach ($_POST['freezechecked'] as $freeze){
              if($freeze == "On")
                set_exam_active($_POST['id'][$counterboy]);
              else
                unset_exam_active($_POST['id'][$counterboy]); 

              $counterboy++;
            }
          }


        ?>

        <section class="content">

          <form method="post" action="">




              <table class="table table-hover table-datatable table-striped table-bordered">

                  <thead>
                      <tr>
                          <th style="text-align: left;">Exam Name</th>
                          <th style="text-align: left;">Category</th>
                          <th style="text-align: left;">Exam Duration</th>
                          <th style="text-align: left;">Status</th>
                          <th style="text-align: left;">Action</th>
                      </tr>
                  </thead>


                  <tbody>
                    <?php foreach (get_all_exam() as $r) { ?>
                     
                      <tr>
                          <td style="text-align: left;"><?php echo $r['quiz_name'] ?></td> 

                          <td style="text-align: left;"><?php echo $r['category_name'] ?></td> 


                          <td style="text-align: left;"><?php echo $r['quiz_duration'].' minutes' ?></td> 
                          
                          <td style="text-align: left;">

                              <?php 
                                if ($r['quiz_status'] == 0) { 
                                    echo '<div class="example">
                                     <input id="freezechecked" type="hidden" value="Off" name="freezechecked[]">
                                    <input type="checkbox" id="toggle-event" class="freeze" name="freezerchecked[]" value="Off" unchecked data-toggle="toggle">
                                    <input type="hidden" value="'. $r['quiz_id'] .'" name="id[]">
                                  </div>';
                                } 
                                else {
                                    echo '<div class="example">
                                    <input id="freezechecked" type="hidden" value="On" name="freezechecked[]">
                                    <input type="checkbox" id="toggle-event" class="freeze" name="freezerchecked[]" value="On" checked data-toggle="toggle">
                                    <input type="hidden" value="'. $r['quiz_id'] .'" name="id[]">

                                  </div>';
                                }
                              ?>
                          </td>

                          <td style="text-align: left;">

                              <a href="<?php echo generate_admin_link("admin_manage_questions", "id=" . ($r["quiz_id"]) . "&" . get_all_get_params(array("id"))); ?>">
                                <button class="btn btn-sm btn-primary" type="button"><span class="glyphicon glyphicon-cog"></span> Modify Questions</button>
                             </a>
                             &nbsp
                            <a href="<?php echo generate_admin_link("admin_manage_edit_exam", "id=" . ($r["quiz_id"]) . "&" . get_all_get_params(array("id"))); ?>">
                              <button class="btn btn-sm btn-warning" type="button"><span class="glyphicon glyphicon-edit"></span> Edit</button>
                            </a>
                            &nbsp
                            
                            <?php 
                              echo '<button type="button" class="btn btn-sm btn-danger glyphicon glyphicon-trash delete delete-exam"> Delete</a></button> 
                                        <input type="hidden" value="'. $r['quiz_id'] .'"  name="delete[]">'; 
                            ?>

                          </td>
                      </tr>
                    <?php } ?>

                  </tbody>
              </table>
              <a style="color: white" href="<?php echo generate_admin_link("admin_manage_add_exam"); ?>">   
              <button type="button" class="btn btn-success  add-exam"> <i class="fa fa-plus-circle"></i> Add Exam</a></button>
            </a>
              <input type="submit" class="btn btn-success update-button" name="formSubmit" id="formSubmit" value="Update" />


          </form> 

          <?php if (get_all_exam() == null) {
            echo '<h3>No records found in the database.</h3>';
          } ?>


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
  $('button.delete-exam').click(function(e) {
    id = $(this).parent()[0].childNodes[7].value;
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

    $.post( "delete_exam.php", { deleteexamfunction: id}, function( data ) {
 alert(id);
    location.reload();
  });
  });
    });

  </script>

  <?php include '/includes/admin_dashboard_scripts.php'; ?>

</body>
</html>