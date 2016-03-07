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

    <header class="main-header">
        <!-- Logo -->
      <a href="index.php" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b>mT</b></span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><b>mockTime</b></span>
      </a>
        <!-- Header Navbar: style can be found in header.less -->
      <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
          <span class="sr-only">Toggle navigation</span>
        </a>
        <div class="navbar-custom-menu">
          <ul class="nav navbar-nav">

            <!-- User Account: style can be found in dropdown.less -->
            <li class="dropdown user user-menu">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <?php echo '<img src="../', $user_data['profile_picture'], '" alt="', $user_data['first_name'], '\'s Profile Picture" class="user-image" /> '; ?>
                <span class="hidden-xs"><?php echo $user_data['first_name'];?>&nbsp;<?php echo $user_data['last_name'];?></span>
              </a>
              <ul class="dropdown-menu">
                <!-- User image -->
                <li class="user-header">
                  <?php echo '<img src="../', $user_data['profile_picture'], '" alt="', $user_data['first_name'], '\'s Profile Picture" class="img-circle" /> '; ?>                     
                  <p>
                    <?php echo $user_data['first_name'];?>&nbsp;<?php echo $user_data['last_name'];?>
                    <small>Member since Nov. 2012</small>
                  </p>
                </li>
                <!-- Menu Footer-->
                <li class="user-footer">
                  <div class="pull-left">
                    <a href="#" class="btn btn-default btn-flat">Profile</a>
                  </div>
                  <div class="pull-right">
                    <a href="admin_logout.php" class="btn btn-default btn-flat">Sign out</a>
                  </div>
                </li>
              </ul>
            </li>
          </ul>
        </div>
      </nav>
    </header>
      <!-- Left side column. contains the logo and sidebar -->
    <?php include '/includes/admin_side_navigation.php';?>

    <div class="content-wrapper">
      <section class="content-header">
        <h1>
          Manage
          <small>Edit Exam</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="admin_dashboard.php"><i class="fa fa-home"></i> Home</a></li>
          <li><a href="admin_dashboard.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
          <li><a href="admin_manage_exam.php"><i class="fa fa-dashboard"></i> Exam Listing</a></li>
          <li class="active">Edit Exam</li>
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




               
              <input type="submit" class="btn btn-success update-button" name="formSubmit" id="formSubmit" value="Submit" />


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
    $.post( "delete_exam.php", { deleteexamfunction: id}, function( data ) {
      alert(id);
    location.reload();
  });
  });
    });


  /*//edit button
  var id;
  var userInput;

  $('button.edit-category').click(function(e) {
    id = $(this).parent()[0].childNodes[3].value;
      swal({   title: "Modify category name",   
        text: "Change the category name :",   
        type: "input",   
        showCancelButton: true,   
        closeOnConfirm: false,   
        animation: "slide-from-top",   
        inputPlaceholder: "Category name"
      }, 
        function(inputValue){   
          if (inputValue === false) return false;      
          if (inputValue === "") {     
            swal.showInputError("You need to write something!");     
            return false   }      
            swal("Successfully Changed!", "Category name : " + inputValue, "success"); 
            userInput = inputValue;

            $.post( "edit_category_name.php", { editcategory: id, edituservalue: userInput}, function( data ) {
              setTimeout(function () { location.reload(1); }, 1000);
            });

          }
      );
  });
*/


//add category button
  var id;
  var userInput;

  $('button.add-category').click(function(e) {
    id = $(this).parent()[0].childNodes[3].value;
      swal({   title: "Add category",   
        text: "Category name : ",   
        type: "input",    
        showCancelButton: true,   
        closeOnConfirm: false,   
        animation: "slide-from-top",   
        inputPlaceholder: "Category name"
      }, 
        function(inputValue){   
          if (inputValue === false) return false;      
          if (inputValue === "") {     
            swal.showInputError("You need to write something!");     
            return false   }      
            swal("Successfully Added!", "Category name : " + inputValue, "success"); 
            userInput = inputValue;

            $.post( "add_category.php", { editcategory: id, edituservalue: userInput}, function( data ) {
              setTimeout(function () { location.reload(1); }, 1000);
            });

          }
      );
  });





  </script>

  <?php include '/includes/admin_dashboard_scripts.php'; ?>

</body>
</html>