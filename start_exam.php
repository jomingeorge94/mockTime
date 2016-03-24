<!DOCTYPE html>
<html lang="en">
<?php 
    include 'core/session.php';
    include 'includes/head.php';

    if (user_logged_in() === true){
         include 'includes/navigationloggedinmodified.php';
?>
<body>
    <div class="container profile">
                <div class="startExamHeader">
                    <div style="font-size:26px" class="panel-heading"><span class="glyphicon glyphicon-book startExam"></span> <strong class="startExam">Start Exam</strong></div>
                </div>    
                    <hr class="startExamLine">
                        
                    <div class="startExamMainScreen">
                        <div class="startExamInsideScreen">
                          <div id="loginForm">
                            <form method="post" action="<?php echo generate_site_link("exam_authorisation"); ?>">
                                
                                <?php  $r = get_exam($_GET['id']); ?>
                                      <fieldset>
                                        <input type="hidden" value="start" name="mode">
                                        <input type="hidden" value="<?php echo intval($r[0]); ?>" name="eid">
                                        <input type="hidden" value="<?php echo safe_output($r[1]); ?>" name="ename">
                                        <input type="hidden" value="<?php echo safe_output($r[3]); ?>" name="etime">

                                        <div class="form-group col-12 center">
                                          <div class="padding10"></div>
                                          <div class="help-block startExam">Exam Subject &nbsp&nbsp: <strong><?php if($r[1]==null) {echo 'No Data';} else {echo $r[1];} ?></strong></div>
                                          <div class="help-block startExam" name="etime">Exam Duration&nbsp&nbsp: <strong><?php if($r[3]==null) {echo 'No Data';} else {echo $r[3] . " Minutes";}?></strong></div>
                                          <div class="help-block startExam">Exam Date & Time&nbsp&nbsp: <strong><?php if ($r[7]==null) {echo 'No Data';} else {echo date("D d F Y,  H:i:s", strtotime(safe_output($r[7])));} ?> </strong></div>
                                          <button class="btn btn-success startExamSubmitButton" type="submit">Enter Exam</button>
                                        </div>

                                      </fieldset>
                            </form>
                          </div>
                        </div>
                    </div>   
    </div>
<?php
    }else{
        include 'includes/navigation_modified.php'; 
        header('Location: generic.php');
            exit();
    }
    include 'includes/footer.php';
?> 
</body>
</html>