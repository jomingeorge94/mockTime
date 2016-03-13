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

  <?php
    if(isset($_POST['quiz_name']) && isset($_POST['quiz_category']) && isset($_POST['quiz_duration']) && isset($_POST['freezerchecked'])){
      $freeze = 0;
      if($_POST['freezerchecked'] == 'On'){
        $freeze = 1;
        
      }
      else{
        $freeze = 0;
      }

      if(!update_exam($_GET['id'], $_POST['quiz_name'], $_POST['quiz_category'], $_POST['quiz_duration'], $freeze)){
        // echo "error";
      }else{
        header('Location: /mocktime/admin/admin_manage_exam.php');
      }
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
          <small>Edit Exam</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="admin_dashboard.php"><i class="fa fa-home"></i> Home</a></li>
          <li><a href="admin_dashboard.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
          <li><a href="admin_manage_exam.php"><i class="fa fa-dashboard"></i> Exam Listing</a></li>
          <li class="active">Edit Exam</li>
        </ol>
      </section>

        <section class="content">

          <form method="post" action="">

            <?php  $r = get_exam($_GET['id']); ?>

          


              <div class="form-group">
                <label class="col-2 control-label" for="exam_name"><span class="required"><i class="fa fa-star-o"></i></span>Exam Name: </label>
                <div class="col-6">
                  <input type="text" placeholder="Subject Name" id="quiz_name" autocomplete="off" name="quiz_name" class="form-control" value="<?php echo $r[1] ?>">
                </div>
              </div>
              <div class="form-group">

                  <label class="col-2 control-label" for="category"><span class="required">*</span>Exam Category: </label>
               
                    <select class="form-control" name="quiz_category" id="category">
                      <option value="">select</option>
                      <?php
                      foreach (get_all_categories() as $cat) {
                        $s = ( $r[2] == $cat["category_id"] ) ? 'selected="selected"' : "";
                        echo '<option value="' . $cat["category_id"] . '" ' . $s . ' >' . $cat["category_name"] . '</option>';
                      }
                      ?>
                    </select>
            </div>

               <div class="form-group">
                <label class="col-2 control-label" for="exam_name"><span class="required"><i class="fa fa-star-o"></i></span>Exam Duration: </label>
                <div class="col-6">
                  <input type="text" placeholder="Subject Name" id="quiz_name" autocomplete="off" name="quiz_duration" class="form-control" value="<?php echo $r[3] ?>">
                </div>
              </div>

              <div class="example">
                <?php 
                                if ($r[4] == 0) { 
                                    echo '                <label class="col-2 control-label" for="exam_name"><span class="required"><i class="fa fa-star-o"></i></span>Exam Status: </label><br />
<div class="example">
                                     <input id="ss" type="hidden" value="Off" name="freezerchecked">
                                    <input type="checkbox" id="toggle-event" class="freeze" name="sss" value="Off" unchecked data-toggle="toggle">
                                  </div>';
                                } 
                                else {
                                    echo '               <label class="col-2 control-label" for="exam_name"><span class="required"><i class="fa fa-star-o"></i></span>Exam Status: </label>
<br /><div class="example"> 
                                    <input id="ss" type="hidden" value="On" name="freezerchecked">
                                    <input type="checkbox" id="toggle-event" class="freeze" name="sss" value="On" checked data-toggle="toggle">

                                  </div>';
                                }
                              ?>

               <br /> <br />
              <input type="submit" class="btn btn-success update-button" name="formSubmit" id="formSubmit" value="Submit" />
      
               
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
      console.log($checkbox);
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