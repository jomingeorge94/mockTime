<!DOCTYPE html>
<html>

  <?php include '../core/session.php'; ?>
  <?php admin_protect (); ?>
  <?php

    if(($user_data['admin_password_check']) == 1){
    } else {
      header('Location: /mocktime/admin');
    }

    if(isset($_POST['q']) && isset($_POST['a']) && isset($_POST['in']) && isset($_POST['type'])){
      $ansid = array();


      $ctr = 0;
      $diff = 1;

      foreach($_POST['q'] as $q){
        $id = add_question($_GET['id'], $q, $_POST['type'][$ctr]);
        $diff = $_POST['in'][$ctr];
        $ctr2 = $ctr;
        while($_POST['in'][$ctr2] == $diff || $ctr2 > count($_POST['in'])){
          add_answer($id, $_POST['a'][$ctr2], 1);
          $ctr2++;
        }


        
        $ctr = $ctr2;
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
          <small>Edit Questions</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="admin_dashboard.php"><i class="fa fa-home"></i> Home</a></li>
          <li><a href="admin_dashboard.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
          <li><a href="admin_manage_exam.php"><i class="fa fa-dashboard"></i> Exam Listing</a></li>
          <li class="active">Edit Exam</li>
        </ol>
      </section>

      

        <section class="content">


            <?php  $r = get_exam($_GET['id']); ?>

          


              <div class="form-group">
                <label class="col-2 control-label" for="exam_name"><span class="required"><i class="fa fa-star-o"></i></span>Exam Name: </label>
                <div class="col-6">
                  <input type="text" placeholder="Subject Name" id="quiz_name" autocomplete="off" name="quiz_name" class="form-control" readonly value="<?php echo $r[1] ?>">
                </div>
              </div>
              <div class="form-group">

                  <label class="col-2 control-label" for="category"><span class="required">*</span>Exam Category: </label>
               
                    <select class="form-control" name="quiz_category" readonly id="category">
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
                  <input type="text" placeholder="Subject Name" id="quiz_name" autocomplete="off" readonly name="quiz_duration" class="form-control" value="<?php echo $r[3] ?>">
                </div>
              </div>
<br />
          <form method="post" action="">

<div class="row">
<div class="col-12 text-center">
  <div class="col-5 text-center">

                   <select style="width:25%; display:inline" class="form-control" name="quiz_category"  id="quiz_category">
                      <option value="nil" selected>Select a Question Type</option>
                      <?php
                      foreach (get_available_categories() as $cat) {
                        echo '<option value="' . $cat . '">' . $cat . '</option>';
                      } ?>
                  </select>


                  <button style="display:inline" class="btn btn-primary" type="button" id="addQ">
                    <span class="glyphicon glyphicon-plus-sign"></span> Add new Question</button>
                </div></div>
</div>

<hr />          <section id="endtrailer"> </section>
<br /> <br />
              <input type="submit" class="btn btn-success update-button" name="formSubmit" id="formSubmit" value="Submit" />
      
               
          </form> 

          

        </section><!-- /.content -->
    </div><!-- /.content-wrapper -->
  

  <?php include '/includes/footer.php'; ?> 

  <script src="dist/js/bootstrap-toggle.js"></script>

  <script>

  var deleteBtn = '<button id="deletebtn" class="btn btn-danger delete-category" type="button""> \
                    <span class="glyphicon glyphicon-plus-sign"></span> Delete Question</button>';

                     var addButton = '<button id="" class="btn btn-primary add-multi" type="button""> \
                    <span class="glyphicon glyphicon-plus-sign"></span> Add Multi-Choice</button>';


  $('#addQ').click(function (e){
    var quiz = $( "#quiz_category" ).val();

    if(quiz == "Essay")
      doEssay();

    if(quiz == "Multiple_Choice")
      doMulti();

  });

  //delete button
  var i;
  $('body').on('click', '.delete-category', function() {
    i = $(this);
      swal({
    title: "Are you sure?",
    text: " You will not be able to undo this action !",
    type: "warning",
    showCancelButton: true,
    confirmButtonColor: "#DD6B55",
    confirmButtonText: "Yes, delete it!",
    closeOnConfirm: false,
    html: false
  }, function(e){
    i.parent().remove();
    swal("Deleted!", "Your question has been deleted.", "success");
  });
  });

  $('body').on('click', '.add-multi', function() {
    $(this).before('<input type="text" style="width:60%" class="form-control"  placeholder="Subject Name" name="a[]"> <input name="in[]" type="hidden" value="' + counter + '" /> <br />');
  });

  var counter = 0;

  function doEssay(){
    var q = '<div class="form-group"> \
                <label class="col-2 control-label" for="exam_name"><span class="required"><i class="fa fa-star-o"></i></span>Question Name: </label> \
                <div class="col-6"> \
                  <input type="text" placeholder="Subject Name" id="quiz_name" autocomplete="off" name="q[]" class="form-control" value=""> \
                </div> \
              </div>';
    var textarea = '<br /><label class="col-2 control-label" for="exam_name"><span class="required"><i class="fa fa-star-o"></i></span>Essay Answer: </label> <br /> \
<textarea rows="20" cols="250" name="a[]"></textarea><input name="in[]" type="hidden" value="' + ++counter + '" /><input type="hidden" name="type[]" value="Essay" />';
    $("#endtrailer").before("<div class='wrapperdiv'><br /> <br /> " + q +textarea + deleteBtn + "</div>");
  }

  function doMulti(){
    var q = '<div class="form-group"> \
                <label class="col-2 control-label" for="exam_name"><span class="required"><i class="fa fa-star-o"></i></span>Question Name: </label> \
                <div class="col-6"> \
                  <input type="text" placeholder="Subject Name" id="quiz_name" autocomplete="off" name="q[]" class="form-control" value=""> \
                </div> \
              </div>';
    var textfields = '<br /><label class="col-2 control-label" for="exam_name"><span class="required"><i class="fa fa-star-o"></i></span>Multi-Choice Answers: </label> <br /> \
<input type="text" style="width:60%" class="form-control"  placeholder="Subject Name" name="a[]"> <br /> <input style="width:60%" class="form-control" placeholder="Subject Name" type="text" name="a[]"> <input name="in[]" type="hidden" value="' + ++counter + '" /><input name="in[]" type="hidden" value="' + counter + '" /><input type="hidden" name="type[]" value="Multiple_Choice" />';
    $("#endtrailer").before("<div class='wrapperdiv'><br /> <br /> " + q +textfields + '<br />' + addButton + '<br /><br />' + deleteBtn + "</div>");
  }



  </script>

  <?php include '/includes/admin_dashboard_scripts.php'; ?>

</body>
</html>