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

?>






<script src="http://localhost/mockTime/assets/js/countdown.js"></script>


<script>

  var st = '<?php echo intval($_SESSION["last_exam_time"]); ?>';
  function last_exam_time() {
    $.ajax({
      type: "GET",
      url: "<?php echo generate_site_link("ajax/inc_last_exam_time"); ?>",
      data: "lext=" + window.st,
      cache: false,
      success: function(html) {
        //console.log("New Value : "+html)
        window.st = html;
      }
    });
  }

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


        <form class="form-horizontal" method="post" id="form1" name="form1" action="<?php echo generate_site_link("ee"); ?>">
          <input type="hidden" value="end" name="mode">
          <input type="hidden" value="<?php echo intval($_SESSION["user_id"]); ?>" name="eid">
          <input type="hidden" value="<?php echo ($_SESSION["exam_start_time"]); ?>" name="st_exams_time">
          <input type="hidden" value="<?php echo ($_SESSION["chosen_exam_time"]); ?>" name="etime">
          
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