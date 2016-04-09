<?php 
	include 'core/session.php';
	include 'includes/head.php';
 
  if(isset($_REQUEST['submittest'])) {
    if(isset($_POST['raw_questionid'])){
            $student_result2 = retrieve_student_result($_SESSION['user_id'], $_SESSION['chosen_exam_id'], $_POST['raw_questionid']);

              if(!is_null($student_result2)) {
                
                update_student_result ($_SESSION['user_id'], $_SESSION['chosen_exam_id'], intval($_POST['raw_questionid']), $_POST['answer']);


              } else {

                        insert_student_result ($_SESSION['user_id'], $_SESSION['chosen_exam_id'], intval($_POST['raw_questionid']), $_POST['answer'], '0');
              }} 


    $date_clicked = new DateTime();
    $date_clicked->setTimeZone(new DateTimeZone('Europe/London'));
    $clickedtime =  $date_clicked->format('Y-m-d H:i:s');

    $choosen_exam_time = $_SESSION['chosen_exam_start_time'];
    $choosen_exam_time->setTimeZone(new DateTimeZone('Europe/London'));
    $chosen_start_time_forExam =  $choosen_exam_time->format('Y-m-d H:i:s');
    $chosen_exam_summary_id = get_student_summary_id($chosen_start_time_forExam);

    update_student_summary($chosen_exam_summary_id[0], $clickedtime);
    header('Location: view_summary.php');
    exit();
  }

  if(isset($_REQUEST['nextquestion'])) {

    
    
    if((int)$_SESSION['questionNumber']<count_questions_of_an_exam($_SESSION['chosen_exam_id'])) {
      $_SESSION['questionNumber']=$_SESSION['questionNumber']+1;
    }


  }

  if(isset($_REQUEST['previousquestion'])) {
     
    if((int)$_SESSION['questionNumber']>=1){
      $_SESSION['questionNumber']=$_SESSION['questionNumber']-1;
    }

  }

	if (user_logged_in() === true){
    include 'includes/navigationloggedinmodified.php';
  } else {
   	include 'includes/navigation_modified.php'; 
    header('Location: generic.php');
    exit();
  }

  header("Cache-Control: no-cache, must-revalidate");
?>

  <script src="/mockTime/assets/js/countdown.js"></script>

  <script>
    function time_over() {
      document.getElementById("form1").submit();

      window.location.replace("http://localhost/mockTime/view_summary.php");
    }
  </script>

  <div class="col-6 col-offset-4"  id="foo">

  </div>

  <form class="form-horizontal" method="post" id="form1" name="form1" action="exam.php">
    <input type="hidden" value="end" name="mode">
    <input type="hidden" value="<?php echo intval($_SESSION["user_id"]); ?>" name="eid">
    <input type="hidden" value="<?php echo ($_SESSION["exam_start_time"]); ?>" name="st_exams_time">
    <input type="hidden" value="<?php echo ($_SESSION["chosen_exam_time"]); ?>" name="etime">
    <input type="hidden" value="<?php echo ($_SESSION["chosen_exam_category"]); ?>" name="ecategory">
    <input type="hidden" value="<?php echo ($_SESSION["chosen_exam_category_id"]); ?>" name="ecategoryid">

    <?php
      $e = get_questions_from_exam($_SESSION['chosen_exam_id']); 

      
      $question_and_answers = get_questions_from_exam_and_answers($_SESSION['chosen_exam_id']); //all the questions and asnwers that belongs to an exam

      //current exam question 
      $question_num = $_SESSION['questionNumber']; 

      //student result is getting stored into the database
      $student_result = retrieve_student_result($_SESSION['user_id'], $_SESSION['chosen_exam_id'], $e[$question_num]['question_id']);
      $student_result2 = retrieve_student_result($_SESSION['user_id'], $_SESSION['chosen_exam_id'], $_POST['raw_questionid']);

      $totalquestions = count_questions_of_an_exam($_SESSION['chosen_exam_id']);

      insert_total_questions_into_quiz ($totalquestions[0], $_SESSION['chosen_exam_id'], $_SESSION['chosen_exam_time'], $_SESSION['chosen_exam_category']);

    ?>
    



    <div class = "panel panel-primary student_question_area">
       <div class = "panel-heading student_question_heading">
          <h3 class = "panel-title student_question_number"> <span class="chosen_student_exam_name"> Exam Name: <strong><?php  echo $_SESSION['chosen_exam_name'];?></strong> </span> <span class="currentquestionNumber">Question Number: <strong> <?php if($_SESSION['questionNumber'] == 0){echo '1';}else {echo $_SESSION['questionNumber'] + 1;} ?></strong> </span> <span class="chosen_exam_total_numbers"> Number of Questions: <strong> <?php  echo $totalquestions[0];?> </strong></span></h3>
       </div>
       <div class = "panel-body">
          <div class= "chosen_exam_questions" style="font-family: sans-serif;">
            <?php 
              
              echo '<div class="chosen_exam_questions_class">' . $e[$question_num]['question_name'] . '</div>';

              if(isset($_POST['raw_questionid'])){
              if(!is_null($student_result2)) {
                
                update_student_result ($_SESSION['user_id'], $_SESSION['chosen_exam_id'], intval($_POST['raw_questionid']), $_POST['answer']);


              } else {

                        insert_student_result ($_SESSION['user_id'], $_SESSION['chosen_exam_id'], intval($_POST['raw_questionid']), $_POST['answer'], '0');
              }} 






              if ($e[$question_num]['question_type'] == 'Essay') {



                echo '<div class="form-group">
                        <textarea class="form-control noresize" name="answer" placeholder="Please specify your answer"> '. $student_result .  ' </textarea>
                      </div>';
              
              }
              echo '<hr>';
              if ($e[$question_num]['question_type'] == 'True_False') {
               if($student_result == 1)
                echo '<div class="form-group trueorfalse">
                        <label class="btn chk btn-default active essay_question_types_trueorfalse" style="margin-right:10px"><input class="" type="radio" id="category" name="answer" value="1" checked /> True </label>
                        <label class="btn chk btn-default active essay_question_types_trueorfalse" style="margin-right:10px"><input type="radio" id="category" name="answer" value="0" /> False </label>
                      </div>';
                else
                  echo '<div class="form-group trueorfalse">
                        <label class="btn chk btn-default active essay_question_types_trueorfalse" style="margin-right:10px"><input class="" type="radio" id="category" name="answer" value="1" /> True </label>
                        <label class="btn chk btn-default active essay_question_types_trueorfalse" style="margin-right:10px"><input type="radio" id="category" name="answer" value="0" checked /> False </label>
                      </div>';
              
              }

              echo '<hr>';
              if ($e[$question_num]['question_type'] == 'Multiple_Choice') {

                $questionNumber = $question_and_answers[$question_num]['question_id']; //get the question id by passing in the exam id and the current question
                $questions_and_answer_from_question = get_all_answers_belongToOne_question($questionNumber); //pass in the question id so collect all the details of the specified question and it's answers
                $count  = count_answers_belongToOne_question($questionNumber)[0]['count(*)']; //counting all the answers for a question
                echo '<select class="form-control multiplechose_questionTypes" name="answer" id="multiple_choice_student_chosen">';
                if(is_null($student_result))
                      echo  '<option class="multiplechoiceguessess" value=""disabled selected>Select the answer</option>';
                    else
                      echo '<option class="multiplechoiceguessess" value="'. $student_result . '"selected>' . $student_result . '</option>';
                      for($i = 0; $i < $count; $i++) {
                          
                          echo '<option class="multiplechoiceguessess">'; echo $questions_and_answer_from_question[$i]['answer_name']; '</option>';

              
                      }
                echo'</select>';
                echo '<p class="linebreak">&nbsp;</p>';

              }

              if ($e[$question_num]['question_type'] == 'Fill_Blank') {
               
                echo '<div class="form-group fillblankquestiontype">
                        <input type="text" class="fill_in_blank_answer_box" value=" ' . $student_result .'" name="answer" placeholder="Type your answer here" >
                      </div>';
              
              }

              if ($e[$question_num]['question_type'] == 'Acronym_Answer') {
               
                echo '<div class="form-group fillblankquestiontype">
                        <input type="text" class="acronym_answer_box" name="answer" value="' . $student_result .'" placeholder="Type your answer here" >
                      </div>';
              
              }

                    
            ?>

            
          </div>  

          
       </div>
      <form >


          <div class="next_and_previous_button">
                <input type="hidden" value="<?php echo ($e[$question_num]['question_id']); ?>" name="raw_questionid">  

            <button class="btn btn-info nextpreviousbutton" id="previous" name="previousquestion" type="submit" <?php
            if ($_SESSION['questionNumber'] < 1) {
                echo 'disabled';
            } else {
                ?> <?php } ?> ><span class="glyphicon glyphicon-backward"></span> PREVIOUS</button>


            <button class="btn btn-info nextpreviousbutton" id="next" name="nextquestion" type="submit" <?php if ($_SESSION['questionNumber'] < (int)$totalquestions[0] - 1) { ?> <?php
            } else {
                echo 'disabled';
            }
                ?>>NEXT <span class="glyphicon glyphicon-forward"></span></button>
          </div>


    </form>
    <button class="btn btn-large btn-block btn-primary submitbutton" type="submit" style="margin-top:100px;" name="submittest">Submit Test</button>
    </div>
  </form>

  <script type="application/javascript">
      var storage = 0;
      if(!localStorage["<?php echo $_SESSION['chosen_exam_id']; ?>"]){
        storage = <?php echo intval((intval($_SESSION["chosen_exam_time"]) * 60) - $_SESSION["last_exam_time"]); ?>
      } else {
        storage = localStorage["<?php echo $_SESSION['chosen_exam_id']; ?>"]; 
      }
      var myCountdown4 = new Countdown({
      time: storage,
      width:300,
      rangeHi  : "hour",     
      hideLine  : true,  
      height:60, 
      target        : "foo",     
      padding : 1.0, 
      onComplete : time_over,
      numbers   : {
      font  : "Trebuchet MS",
      color : "#FFFFFF",
      bkgd  : "#365D8B",
      fontSize : 200,
      shadow    : {
      x : 0,            
      y : 3,            
      s : 4,            
      c : "#000000",    
      a : 0.4
      }
      },

      labels : {
      textScale : 0.8,
      offset : 5
      } 
      });

      $("#next").click(function (){
        console.log(myCountdown4._timeRunnerNow);//
        localStorage["<?php echo $_SESSION['chosen_exam_id']; ?>"] =  parseInt(myCountdown4._timeRunnerNow.second) + parseInt(myCountdown4._timeRunnerNow.minute * 60) + parseInt(myCountdown4._timeRunnerNow.hour * 3600);
      });

      $("#previous").click(function (){
        console.log(myCountdown4._timeRunnerNow);//
        localStorage["<?php echo $_SESSION['chosen_exam_id']; ?>"] =  parseInt(myCountdown4._timeRunnerNow.second) + parseInt(myCountdown4._timeRunnerNow.minute * 60) + parseInt(myCountdown4._timeRunnerNow.hour * 3600);
      });
  </script> 

<?php 

    include 'includes/footer.php';
?>