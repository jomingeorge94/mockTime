<!DOCTYPE html>
<html lang="en">
<?php 
    include 'core/session.php';
    include 'includes/head.php';


    if (user_logged_in() === true){
         include 'includes/navigationloggedinmodified.php';

    //retrieving the data based on the id's that has been passed into this page
    $retrieving_data = retrieve_exam_user_detail_basedon_student_summaryid($_GET['student_sum_id'],$_GET['quiz_id']);
   
    $user_detail = getuserdetail ($retrieving_data[0]['user_id']);

   

    $question_and_answers = get_questions_from_exam($retrieving_data[0]['quiz_id']); //all the questions and asnwers that belongs to an exam

    $total_questions_for_exam = $retrieving_data[0]['total_questions'];
    
  //die(var_dump($question_and_answers[0]));

    
?>

<body>
    <div class="container profile">
                <div class="startExamHeader">
                    <div style="font-size:26px" class="panel-heading"><span class="fa fa-list-alt startExam"></span> <strong class="startExam">Summary</strong></div>
                </div>    
                    <hr class="startExamLine">

                    
                  
                <table class="table table-bordered table-condensed table-datatable table-hover user_exam_summary">
                
                  <tbody>
                    <tr>
                        <td style="text-align: left;" width="50%"></td>
                        <td style="text-align: left;" width="50%"><strong><?php echo $user_detail[3] . ' ' . $user_detail[4]?></strong></td>
                    </tr>

                    <tr>
                        <td style="text-align: left;" width="50%">Exam Name:</td>
                        <td style="text-align: left;" width="50%"><?php echo $retrieving_data[0]['quiz_name']; ?></td>
                    </tr>

                    <tr>
                        <td style="text-align: left;">Exam Duration:</td>
                        <td style="text-align: left;"><?php echo $retrieving_data[0]['quiz_duration']; ?> Minutes</td>
                    </tr>

                    <tr>
                        <td style="text-align: left;">Total Questions:</td>
                        <td style="text-align: left;"><?php echo $retrieving_data[0]['total_questions']; ?></td>
                    </tr>

                    <tr>
                        <td style="text-align: left;">Time Spent:</td>
                        <td style="text-align: left;"><?php echo $retrieving_data[0]['time_taken']; ?></td>
                    </tr>

                    <tr>
                        <td style="text-align: left;">Score%:</td>
                        <td style="text-align: left;">
                          <?php 

                            if ($retrieving_data[0]['student_result'] == "Pending") {
                                echo '<span class="label label-pill label-danger marking">Pending</span>';
                            } else {
                                echo $retrieving_data[0]['student_result'];
                            } 
                          ?>
                        </td>
                    </tr>

                    <tr>
                        <td style="text-align: left;">Marking Status:</td>
                        <td style="text-align: left;">
                          <?php 

                            if ($retrieving_data[0]['exam_result_status'] == 0) {
                                echo '<span class="label label-pill label-warning marking">TBC</span>';
                            } else if($retrieving_data[0]['exam_result_status'] == 1) {
                                echo '<span class="label label-pill label-info marking">Marked</span>';
                            } else {
                                echo 'No Data';
                            } 
                          ?>
                        </td>
                    </tr>

                  </tbody>

                </table>

                <div >
                  <h2 class="review_user_answers_heading">Review your exam</h2>








            <?php 
            //die(var_dump($question_and_answers));

            for ($i=1; $i<=$total_questions_for_exam; $i++) {

             echo '   <table class="table table-bordered table-condensed table-datatable table-hover">
                        <tbody>

                            <tr>
                                <td style="text-align: left;" width="100%"><strong>Question '. $i .'</strong></td>
                            </tr>
                            <tr>
                                <td style="text-align: left;" width="100%">
                                    In International Test Cricket which player has most runs in an innings</td>
                            </tr>
                    
                    
                            <tr>
                                <td style="text-align: left;" width="100%" class="warning">
                                    <em>Question Not attempted</em><br>
                                    <strong>Correct Answer is</strong><br>Brian Lara </td>
                            </tr>

                            <tr>
                                <td style="height: 5px;" width="100%">&nbsp;</td>
                            </tr>
                    
                            <tr>
                            <td style="height: 5px;" width="100%">&nbsp;</td>
                            </tr>

                        </tbody>
                        </table>';
              
            }


            ?>























































                  

                </div>    
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