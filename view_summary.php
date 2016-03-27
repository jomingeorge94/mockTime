<!DOCTYPE html>
<html lang="en">
<?php 
    include 'core/session.php';
    include 'includes/head.php';

    if (user_logged_in() === true){
         include 'includes/navigationloggedinmodified.php';
//die(var_dump($_SESSION));

?>

<body>
    <div class="container profile">
                <div class="startExamHeader">
                    <div style="font-size:26px" class="panel-heading"><span class="fa fa-list-alt startExam"></span> <strong class="startExam">Exam Summary</strong></div>
                </div>    
                    <hr class="startExamLine">
                        
                    <table class="table table-hover table-datatable table-striped table-bordered">

                  <thead class="student_exam_summary_thread">
                      <tr>
                          <th style="text-align: center;">Exam Name</th>
                          <th style="text-align: center;">Category</th>
                          <th style="text-align: center;">Exam Duration</th>
                          <th style="text-align: center;">Date and Time</th>
                          <th style="text-align: center;">Time Spend</th>
                          <th style="text-align: center;">Percentage</th>
                          <th style="text-align: center;">Actions</th>

                      </tr>
                  </thead>


                  <tbody>

                    <?php foreach (get_student_summary() as $r ) { ?>

                     
                      <tr>
                          <td style="text-align: left;"><?php echo $r['quiz_name'] ?></td> 

                          <td style="text-align: left;"><?php echo $r['category_name'] ?></td> 


                          <td style="text-align: left;"><?php echo $r['quiz_duration'] ?> Minutes</td> 
                          
                          <td style="text-align: left;"><?php echo date("D d F Y,  H:i:s", strtotime($r['exam_start_time'])); ?></td> 

                          <td style="text-align: left;">
                          	<?php

                          			$start_date = $r['exam_start_time'];
                          			$end_date = $r['exam_end_time'];

                          			$start_time = strtotime($start_date);
									$end_time = strtotime($end_date);
									$difference = $end_time - $start_time;

									echo sprintf("%02d%s%02d%s%02d", floor($difference/3600), ':', ($difference/60)%60, ':', $difference%60); 
	
                          	?> 
                          </td> 

                          <td style="text-align: left;"><?php  ?></td> 

                          <td style="text-align: center;">
                          	<a href="#" class="btn btn-success"><i class="fa fa-file-pdf-o"></i> Save as PDF</a>
                          	<a href="#" class="btn btn-danger"><i class="fa fa-print"></i> Print</a>
                          	<a href="#" class="btn btn-primary"><i class="fa fa-eye"></i> View</a>
                          </td> 
                          

                          
                      </tr>
                    <?php } ?>

                  </tbody>
              </table>
    </div>
<?php
    }else{ 
        header('Location: index.php');
        exit();
    }
    include 'includes/footer.php';
?> 
</body>
</html>