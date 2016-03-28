<?php 
	include 'core/session.php';
	include 'includes/head.php';

	if (user_logged_in() === true){
         include 'includes/navigationloggedinmodified.php';
    } else {
     	include 'includes/navigation_modified.php'; 
        header('Location: generic.php');
        exit();
    }

  //die(var_dump(get_questions_from_exam($_SESSION['chosen_exam_id'])));
    

?>

<script src="http://localhost/mockTime/assets/js/countdown.js"></script>

<script>
  function time_over() {
    document.getElementById("form1").submit();
  }

  function submitExams() {
    
    if (confirm('Are you sure')) {
      
      document.getElementById("form1").submit();

    }

  }
</script>

<div class="col-6 col-offset-4"  id="foo">

</div>


        <form class="form-horizontal" method="post" id="form1" name="form1" action="<?php echo generate_site_link("view_summary"); ?>">
          <input type="hidden" value="end" name="mode">
          <input type="hidden" value="<?php echo intval($_SESSION["user_id"]); ?>" name="eid">
          <input type="hidden" value="<?php echo ($_SESSION["exam_start_time"]); ?>" name="st_exams_time">
          <input type="hidden" value="<?php echo ($_SESSION["chosen_exam_time"]); ?>" name="etime">
          <input type="hidden" value="<?php echo ($_SESSION["chosen_exam_category"]); ?>" name="ecategory">
          <input type="hidden" value="<?php echo ($_SESSION["chosen_exam_category_id"]); ?>" name="ecategoryid">


          <div class = "panel panel-primary student_question_area">
             <div class = "panel-heading">
                <h3 class = "panel-title student_question_number">Panel title</h3>
             </div>
             <div class = "panel-body">
                This is a Basic panel
             </div>
          </div>


          <button class="btn btn-success loginbutton" type="submit" style="margin-top:100px;" name="submittest" onclick="submitExams();">Submit Test</button>
        </form>

<script type="application/javascript">

  var myCountdown4 = new Countdown({

  time: '<?php echo intval((intval($_SESSION["chosen_exam_time"]) * 60) - $_SESSION["last_exam_time"]); ?>',
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

</script>  

<?php 

 

    include 'includes/footer.php';

?>