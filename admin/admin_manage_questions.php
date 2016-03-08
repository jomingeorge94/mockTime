<!DOCTYPE html>
<html>

  <?php include '../core/session.php'; ?>
  <?php admin_protect (); ?>
  <?php

    if(($user_data['admin_password_check']) == 1){
    } else {
      header('Location: /mocktime/admin');
    }


    if($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_POST['q']) && !isset($_POST['a'])){
      delete_all_questions($_GET['id']);
    }

    if(isset($_POST['q']) && isset($_POST['a'])){
      $ansid = array();
      clear_questions($_GET['id']);

      $ctr = 0;
      $diff = 1;
      $ctrtype = 0;

        $ctr3 = 0;

      foreach($_POST['q'] as $q){
        $id = add_question($_GET['id'], $q, $_POST['type'][$ctrtype]);
        $diff = $_POST['in'][$ctr];
        $ctr2 = $ctr;
        
        $ctr4 = 1;

        while($_POST['in'][$ctr2] == $diff || $ctr2 > count($_POST['in'])){
          
          $isTrue = 1;


          if($_POST['type'][$ctrtype] == 'Multiple_Choice'){

            if($_POST['selector'][$ctr3] == $ctr4){
              $isTrue = 1;
            }else{
              $isTrue = 0;
            }
          }

          if($_POST['type'][$ctrtype] == 'True_False'){
            $isTrue = $_POST['a'][$ctr2];
          }

          add_answer($id, $_POST['a'][$ctr2], $isTrue);
          $ctr2++;
          $ctr4++;
          $ctr++;
        }

        if($_POST['type'][$ctrtype] == 'Multiple_Choice')
          $ctr3++; 

        $ctrtype++;
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

<?php
  $ct = 0;
  foreach(get_questions_from_exam($_GET['id']) as $quest){
    echo '<div class="wrapperdiv"><br /> <br />';

      if($quest['question_type'] == "Essay"){
        echo '<div class="form-group"> 
                <label class="col-2 control-label" for="exam_name"><span class="required"><i class="fa fa-star-o"></i></span>Question Name: </label> 
                <div class="col-6"> 
                  <input type="text" placeholder="Subject Name" id="quiz_name" autocomplete="off" name="q[]" class="form-control" value="' . $quest['question_name'] .'"> 
                </div> 
              </div>';

        echo '<br /><label class="col-2 control-label" for="exam_name"><span class="required"><i class="fa fa-star-o"></i></span>Essay Answer: </label> <br /> 
            <textarea rows="20" cols="250" name="a[]">' . get_answers_from_exam($quest['question_id'])[0]['answer_name'] . '</textarea><input name="in[]" type="hidden" value="' . ++$ct . '" /><input type="hidden" name="type[]" value="Essay" />';
              echo '<button id="deletebtn" class="btn btn-danger delete-category" type="button""> <span class="glyphicon glyphicon-plus-sign"></span> Delete Question</button></div>';

      }

      if($quest['question_type'] == "Multiple_Choice"){
        echo '<div class="form-group"> 
                <label class="col-2 control-label" for="exam_name"><span class="required"><i class="fa fa-star-o"></i></span>Question Name: </label> 
                <div class="col-6"> 
                  <input type="text" placeholder="Subject Name" id="quiz_name" autocomplete="off" name="q[]" class="form-control" value="'. $quest['question_name'] . '"> 
                </div> 
              </div>';

        echo '<br /><label class="col-2 control-label" for="exam_name"><span class="required"><i class="fa fa-star-o"></i></span>Multi-Choice Answers: </label> <br /> ';
            $index = 0;
         foreach (get_answers_from_exam($quest['question_id']) as $ans){
          echo '<input style="width:60%" class="form-control" value="' . $ans['answer_name'] . '" placeholder="Subject Name" type="text" name="a[]">';
          if($index==0)
            echo '<input name="in[]" type="hidden" value="' . ++$ct .  '" /> ';
          else
            echo '<input name="in[]" type="hidden" value="' . $ct .  '" /> ';
            $index++;
            echo '<br />';
         }
          echo '<input type="hidden" name="type[]" value="Multiple_Choice" />';
           echo '<div class="form-group" style="width:60%">
                        <label class="col-2 control-label" for="ans"><span class="required">*</span>Answer: </label>
                        <div class="col-2">
                          <select class="form-control" name="selector[]" id="selector" >';
                            $count = count(get_answers_from_exam($quest['question_id']));
                            $j = 0;
                            foreach(get_answers_from_exam($quest['question_id']) as $ans){
                              if($ans['is_true'] == 1){
                                                             echo '<option selected value="' . ($j + 1) . '">Question: '. ($j + 1) . '</option>';

                              }else{
                                                             echo '<option value="' . ($j + 1) . '">Question: '. ($j + 1) . '</option>';

                              }
                              $j++;
                            }
                            
                         echo ' </select>
                        </div>
                      </div>';
      echo '<button id="deletebtn" class="btn btn-danger delete-category" type="button""> <span class="glyphicon glyphicon-plus-sign"></span> Delete Question</button>';
    echo '</div>';
      }

      if($quest['question_type'] == "True_False"){
         echo '<div class="form-group"> 
                <label class="col-2 control-label" for="exam_name"><span class="required"><i class="fa fa-star-o"></i></span>Question Name: </label> 
                <div class="col-6"> 
                  <input type="text" placeholder="Subject Name" id="quiz_name" autocomplete="off" name="q[]" class="form-control" value="'. $quest['question_name'] . '"> 
                </div> 
              </div>';

        echo '<div class="form-group col-md-12"> 
                <div class="form-group col-md-12"> 
                    <label for="tf" class="control-label"><b>True or False</b></label/>  
                    <br /> 
                    <div class="btn-group inline" data-toggle="buttons"> 
                            ';
                    if(get_answers_from_exam($quest['question_id'])[0]['answer_name'] == 1){ $checked = '<label class="btn chk btn-default active" style="margin-right:10px"><input class="" type="radio" checked id="category" name="faux" value="1" /> True </label>';}
                    else $checked = '<label class="btn chk btn-default" style="margin-right:10px"><input class="" type="radio" id="category" name="faux" value="1" /> True </label>';

                    if(get_answers_from_exam($quest['question_id'])[0]['answer_name'] == 0){ $checkedf = '<label class="btn chk btn-default active" style="margin-right:10px"><input type="radio" checked id="category" name="faux" value="0" /> False </label>';}
                    else $checkedf = '<label class="btn chk btn-default" style="margin-right:10px"><input class="" type="radio" id="category" name="faux" value="0" /> False </label>';


                      echo $checked . $checkedf .' 
                    <input name="a[]" value="' . get_answer($quest['question_id'])[0] . '" type="hidden"><input name="in[]" type="hidden" value="' . ++$ct . '" /><input type="hidden" name="type[]" value="True_False" /></div> 
                </div> 
            </div>';
                  echo '<button id="deletebtn" class="btn btn-danger delete-category" type="button""> <span class="glyphicon glyphicon-plus-sign"></span> Delete Question</button>';
        echo '</div>';
      }

      if($quest['question_type'] == "Acronym_Answer"){
        echo '<div class="form-group"> 
                <label class="col-2 control-label" for="exam_name"><span class="required"><i class="fa fa-star-o"></i></span>Question Name: </label> 
                <div class="col-6"> 
                  <input type="text" placeholder="Subject Name" id="quiz_name" autocomplete="off" name="q[]" class="form-control" value="' . $quest['question_name'] . '"> 
                </div> 
              </div>';
              echo '<br /><label class="col-2 control-label" for="exam_name"><span class="required"><i class="fa fa-star-o"></i></span>Acronym Answer: </label> <br /> 
<input type="text" value="' . get_answer($quest['question_id'])[0] . '" name="a[]"><input name="in[]" type="hidden" value="' . ++$ct . '" /><input type="hidden" name="type[]" value="Acronym_Answer" />';
      echo '<br /><br /><button id="deletebtn" class="btn btn-danger delete-category" type="button""> <span class="glyphicon glyphicon-plus-sign"></span> Delete Question</button>';

        echo '</div>';
      }
     
  }
?>

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

  var sele = '<div class="form-group" style="width:60%"> \
                        <label class="col-2 control-label" for="ans"><span class="required">*</span>Answer: </label> \
                        <div class="col-2"> \
                          <select class="form-control" name="selector[]" id="selector" > \
                           ';


  $('#addQ').click(function (e){
    var quiz = $( "#quiz_category" ).val();

    if(quiz == "Essay")
      doEssay();

    if(quiz == "Multiple_Choice")
      doMulti();

    if(quiz == "True_False")
      doTF();

    if(quiz == "Acronym_Answer")
      doAcro();

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
  }, function(){
    i.parent().remove();
    swal("Deleted!", "Your question has been deleted.", "success");
  });
  });

  $('body').on('click', '.chk', function() {
    var update = $(this).children().eq(0).val();
    $(this).parent().children().eq(2).val(update);
  });

  $('body').on('click', '.add-multi', function() {
    $(this).before('<input type="text" style="width:60%" class="form-control"  placeholder="Subject Name" name="a[]"> <input name="in[]" type="hidden" value="' + counter + '" /> <br />');
    var x = $(this).next().next().next().children().eq(1).children().eq(0).children().length;
    x++;
    $(this).next().next().next().children().eq(1).children().eq(0).append('<option value="' + x + '"> Question: ' + x + '</option>');
    console.log($(this));
  });

  var counter = <?php echo $ct; ?>;

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
    
  var options = '<option value="1">Question: 1</option><option value="2">Question: 2</option>';

    $("#endtrailer").before("<div class='wrapperdiv'><br /> <br /> " + q + textfields  + '<br />' + addButton + '<br /><br />'+ sele + options + '</select></div></div><br /><br />' + deleteBtn + "</div>");
  }

  function doTF(){
    var q = '<div class="form-group"> \
                <label class="col-2 control-label" for="exam_name"><span class="required"><i class="fa fa-star-o"></i></span>Question Name: </label> \
                <div class="col-6"> \
                  <input type="text" placeholder="Subject Name" id="quiz_name" autocomplete="off" name="q[]" class="form-control" value=""> \
                </div> \
              </div>';

    var radios = '<div class="form-group col-md-12"> \
                <div class="form-group col-md-12"> \
                    <label for="tf" class="control-label"><b>True or False</b></label/>  \
                    <br /> \
                    <div class="btn-group inline" data-toggle="buttons"> \
                            <label class=" chk btn btn-default" style="margin-right:10px"><input type="radio" id="category" name="faux" value="1" /> True </label> \
                            <label class="btn chk btn-default"><input type="radio" id="category" name="faux" value="0" /> False </label> ' +  
                   ' <input name="a[]" type="hidden" value="0"> <input name="in[]" type="hidden" value="' + ++counter + '" /><input type="hidden" name="type[]" value="True_False" /></div> \
                </div> \
            </div>';
    $("#endtrailer").before("<div class='wrapperdiv'><br /> <br /> " + q + radios + '<br /><br />' +  deleteBtn + "</div>");
  }

  function doAcro(){
    var q = '<div class="form-group"> \
                <label class="col-2 control-label" for="exam_name"><span class="required"><i class="fa fa-star-o"></i></span>Question Name: </label> \
                <div class="col-6"> \
                  <input type="text" placeholder="Subject Name" id="quiz_name" autocomplete="off" name="q[]" class="form-control" value=""> \
                </div> \
              </div>';
    var textfield = '<br /><label class="col-2 control-label" for="exam_name"><span class="required"><i class="fa fa-star-o"></i></span>Acronym Answer: </label> <br /> \
<input type="text" name="a[]"><input name="in[]" type="hidden" value="' + ++counter + '" /><input type="hidden" name="type[]" value="Acronym_Answer" />';
    $("#endtrailer").before("<div class='wrapperdiv'><br /> <br /> " + q + textfield + '<br /><br/> ' + deleteBtn + "</div>");
  }



  </script>

  <?php include '/includes/admin_dashboard_scripts.php'; ?>

</body>
</html>