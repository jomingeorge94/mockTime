<?php 
	include 'core/session.php';
	include 'includes/head.php';

  if(isset($_REQUEST['submittest'])) {
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
    ?>
    <?php $totalquestions = count_questions_of_an_exam($_SESSION['chosen_exam_id']);?>

    <div class = "panel panel-primary student_question_area">
       <div class = "panel-heading student_question_heading">
          <h3 class = "panel-title student_question_number"> <span class="chosen_student_exam_name"> Exam Name: <strong><?php  echo $_SESSION['chosen_exam_name'];?></strong> </span> <span class="currentquestionNumber">Question Number: <strong> <?php if($_SESSION['questionNumber'] == 0){echo '1';}else {echo $_SESSION['questionNumber'] + 1;} ?></strong> </span> <span class="chosen_exam_total_numbers"> Number of Questions: <strong> <?php  echo $totalquestions[0];?> </strong></span></h3>
       </div>
       <div class = "panel-body">
          <div class= "chosen_exam_questions" style="font-family: sans-serif;">
            <?php 
              $question_num = $_SESSION['questionNumber']; 
              echo '<div class="chosen_exam_questions_class">' . $e[$question_num]['question_name'] . '</div>';


              if ($e[$question_num]['question_type'] == 'Essay') {
               
                echo '<div class="form-group essay_question_types">
                        <textarea class="form-control noresize" placeholder="Please specify your answer"></textarea>
                      </div>';
              
              }

            ?>

            
          </div>  

          
       </div>
      <form >
          <div class="next_and_previous_button">

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
    //die(var_dump($e));
    //die(var_dump($e[$question_num]['question_type'] == 'Essay'));
    include 'includes/footer.php';
?>