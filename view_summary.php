<!DOCTYPE html>
<html lang="en">
<?php 
    include 'core/session.php';
    include 'includes/head.php';


    if (user_logged_in() === true){
          updateLastSeenUser($_SESSION['user_id']);
          
         include 'includes/navigationloggedinmodified.php';


?>

<body>
    <div class="container profile">
                <div class="startExamHeader">
                    <div style="font-size:26px" class="panel-heading"><span class="fa fa-list-alt startExam"></span> <strong class="startExam">Exam Summary</strong></div>
                  </br>
                </div>    
                    <hr class="startExamLine">
                        
                    <table class="table table-hover table-datatable table-striped table-bordered">

                  <thead class="student_exam_summary_thread">
                      <tr>
                          <th style="text-align: center;">Exam Name</th>
                          <th style="text-align: center;">Category</th>
                          <th style="text-align: center;">Exam Duration</th>
                          <th style="text-align: center;">Date and Time</th>
                          <th style="text-align: center;">Time Spent</th>
                          <th style="text-align: center;">Maximum Mark</th>
                          <th style="text-align: center;">Status</th>
                          <th style="text-align: center;">Actions</th>

                      </tr>
                  </thead>

                  <tbody>

                    <?php foreach (get_student_summary($_SESSION['user_id']) as $r ) { ?>

                     
                      <tr>
                          <td style="text-align: center;"><?php echo $r['quiz_name'] ?></td> 

                          <td style="text-align: center;"><?php echo $r['category_name'] ?></td> 


                          <td style="text-align: center;"><?php echo $r['quiz_duration'] ?> Minutes</td> 
                          
                          <td style="text-align: center;"><?php echo date("D d F Y,  H:i:s", strtotime($r['exam_start_time'])); ?></td> 

                          <td style="text-align: center;">
                          	<?php

                          			$start_date = $r['exam_start_time'];
                          			$end_date = $r['exam_end_time'];

                          			$start_time = strtotime($start_date);
              									$end_time = strtotime($end_date);
              									$difference = $end_time - $start_time;

              									echo sprintf("%02d%s%02d%s%02d", floor($difference/3600), ':', ($difference/60)%60, ':', $difference%60); 

                                insert_time_taken_for_exam(sprintf("%02d%s%02d%s%02d", floor($difference/3600), ':', ($difference/60)%60, ':', $difference%60), $r["student_summary_id"]);
	
                          	?> 
                          </td>


                          

                          <td style="text-align: center;">
                            <?php 
                                echo $r['total_questions'] * 10;
                            ?>
                          </td>  

                            

                          <td style="text-align: center;">
                            <?php 
                            
                            if ($r['exam_result_status'] == 0) {
                              echo '<span class="label label-pill label-warning marking">TBC</span>';
                            } else if($r['exam_result_status'] == 1) {
                              echo '<span class="label label-pill label-info marking">Marked</span>';
                            } else {
                              echo 'No Data';
                            }

                            ?>
                          </td> 

                          <td style="text-align: center;">
                          	<a href="<?php echo generate_admin_link("exam_results_pdf", "quiz_id=" . ($r["quiz_id"]) . "&" .  "student_sum_id=" . ($r["student_summary_id"]) . "&" . get_all_get_params(array("id"))); ?>" class="btn btn-danger"><i class="fa fa-file-pdf-o"></i> Save as PDF</a>
                            
                          	
                          	<a href="<?php echo generate_admin_link("view_user_summary", "quiz_id=" . ($r["quiz_id"]) . "&" .  "student_sum_id=" . ($r["student_summary_id"]) . "&" . get_all_get_params(array("id"))); ?>" class="btn btn-primary"><i class="fa fa-eye"></i> View</a>
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

        die(var_dump($_SESSION));
    }
    include 'includes/footer.php';
?> 
</body>
</html>