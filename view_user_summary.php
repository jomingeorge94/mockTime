<!DOCTYPE html>
<html lang="en">



<?php 
    include 'core/session.php';
    include 'includes/head.php';

    updateLastSeenUser($_SESSION['user_id']);

    //retrieving the data based on the id's that has been passed into this page
    $retrieving_data = retrieve_exam_user_detail_basedon_student_summaryid($_GET['student_sum_id'],$_GET['quiz_id']);

    //die(var_dump($retrieving_data));
    //mark
    $mark = "10";
    
    if(isset($_REQUEST['submit_review'])) {

        die(var_dump($_POST));

        //after submit database column will get updated from TBC to Marked. 
        update_student_result_for_each_question($_POST['student_summary_id']);

        //if the check box is submitted then do this
        if (isset($_REQUEST['correct_answer_or_not'])) {
           
            for ($j=0; $j<count($_POST['correct_answer_or_not']); $j++) {
                

                update_student_mark_for_each_question ($_POST['student_summary_id'], $_POST['user_id'], $_POST['exam_id'], $_POST['correct_answer_or_not'][$j], $mark);

            } 
        }
            
            $student_exam_score = get_sum_of_student_marks ($_POST['user_id'], $_POST['exam_id'], $_POST['student_summary_id']); 

            update_student_final_result ($_POST['student_summary_id'], $student_exam_score[0]['SUM(student_result_status)']);
            
            header('Location:view_summary.php');
            exit();
        
    }

    if (user_logged_in() === true){
         include 'includes/navigationloggedinmodified.php';

    
   
    $user_detail = getuserdetail ($retrieving_data[0]['user_id']);

   

    $question_and_answers = get_questions_from_exam($retrieving_data[0]['quiz_id']); //all the questions and asnwers that belongs to an exam

    



    $quandans = get_questions_from_exam_and_answers($retrieving_data[0]['quiz_id']);

    $total_questions_for_exam = $retrieving_data[0]['total_questions'];
    

    
    

    
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
                        <td style="text-align: left;">Maximum Mark:</td>
                        <td style="text-align: left;"><?php echo $retrieving_data[0]['total_questions'] * 10; ?></td>
                    </tr>


                    

                    <tr>
                        <td style="text-align: left;">Gained Mark:</td>
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
                        <td style="text-align: left;">Score %:</td>
                        <td style="text-align: left;"><?php echo ($retrieving_data[0]['student_result']/10) / ($retrieving_data[0]['total_questions']) * 100?>%</td>
                    </tr>

                    <tr>
                        <td style="text-align: left;">Time Spent:</td>
                        <td style="text-align: left;"><?php echo $retrieving_data[0]['time_taken']; ?></td>
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
            //die(var_dump($_GET));
            for ($i=0; $i<$total_questions_for_exam; $i++) {
            //var_dump($student_answer_per_question === '' || '')
            $question_id= $question_and_answers[$i]['question_id'];
            $numberofanswersperquestion = count_answers_belongToOne_questionNew($question_id);
            $score = retrieve_student_result_status ($_GET['student_sum_id'], $retrieving_data[0]['user_id'], $retrieving_data[0]['exam_id'], $question_id);
            $student_answer_per_question = htmlspecialchars(retrieve_student_result ($_SESSION['user_id'], $_GET['quiz_id'], $question_id, $_GET['student_sum_id']));
            $correct_answer = $numberofanswersperquestion[0]['answer_name'];

            
           
             echo ' <form method="post" id="review_form" name="review_form" action="view_user_summary.php">   
                <table class="table table-bordered table-condensed table-datatable table-hover review_marks">
                    <tbody>

                        <tr>
                            <td style="text-align: left;" width="100%"><strong>Question '. ($i+1) .'</strong></td> 
                        </tr>
                        <tr>
                            <td style="text-align: left;" width="100%">' . $question_and_answers[$i]['question_name'] .'</td>
                        </tr>';

                        if($student_answer_per_question == '') 
                          echo  '<tr>
                                    <td style="text-align: left;" width="100%" class="warning"><em>Question Not attempted</em><br><strong>Correct Answer is </strong><br>' . $numberofanswersperquestion[0]['answer_name'] . '</td>
                                </tr>';
                        
                        else if ($student_answer_per_question == $correct_answer)
                            
                         echo  '<tr>
                                    <td style="text-align: left;" width="100%" class="success"><strong>Your answer is correct.</strong><br>' . $student_answer_per_question .'</td>
                                </tr>';

                        else 
                            echo    '<tr>
                                        <td style="text-align: left;" width="100%" class="danger">
                                            <table style="width: 100%">
                                                <tbody>
                                                    <tr>
                                                        <th style="width: 50%"><strong>Your Answer</strong></th>
                                                        <th style="width: 50%"><strong>Correct Answer</strong></th>
                                                    </tr>
                                                    <tr>
                                                        <td style="width: 50%">' . $student_answer_per_question . '</td>
                                                        <td style="width: 50%">' . $correct_answer .'</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>';
                        
                        echo 

                        '<tr>
                            <td style="height: 5px;" width="100%">&nbsp;</td>
                        </tr>
                
                        <tr>
                        <td style="height: 5px;" width="100%">&nbsp;</td>
                        </tr>

                    </tbody>
                </table>';


            if($score[0]['student_result_status'] != 0) {
                echo '<div class="[ form-group ] correct_answer">
                    <input type="checkbox" checked name="correct_answer_or_not[]" value="'.$question_id.'"  id="' . $question_id . '" autocomplete="off" />
                    <div class="[ btn-group ]">
                        <label for="' . $question_id . '" class="[ btn btn-primary ]">
                            <span class="[ glyphicon glyphicon-ok ]"></span>
                            <span> </span>
                        </label>
                        <label for="' . $question_id . '" class="[ btn btn-default active ]">
                            Correct Answer
                        </label>
                    </div>
                </div>';
            } else {
                echo '<div class="[ form-group ] correct_answer">
                    <input type="checkbox" unchecked name="correct_answer_or_not[]" value="'.$question_id.'"  id="' . $question_id . '" autocomplete="off" />
                    <div class="[ btn-group ]">
                        <label for="' . $question_id . '" class="[ btn btn-primary ]">
                            <span class="[ glyphicon glyphicon-ok ]"></span>
                            <span> </span>
                        </label>
                        <label for="' . $question_id . '" class="[ btn btn-default active ]">
                            Correct Answer
                        </label>
                    </div>
                </div>';
            }


              
            }

            echo    '<div class="rate_review"><div class="col-md-4"></div>
                        <div class="col-md-4">
                            <div class="panel panel-default">
                                <ul class="list-group list-group-flush text-center">
                                    <li class="list-group-item">
                                        <div class="skillLineDefault">
                                            <div class="skill pull-left text-center">Rate the Exam</div>
                                            <div onclick="getValue()" class="rating" id="rate1"></div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>';

            echo '<input type="hidden" name="myRate1" id="myRate1"/><input  type="hidden" value="' .$retrieving_data[0]['student_summary_id']. '" name="student_summary_id"><input type="hidden" value="' .$retrieving_data[0]['exam_id']. '" name="exam_id"> <input type="hidden" value="' .$retrieving_data[0]['user_id']. '" name="user_id"><input type="hidden" value="' .$retrieving_data[0]['exam_id']. '" name="exam_id"><button class="btn btn-large btn-block btn-primary submitbutton" type="submit" style="margin-top:100px;" name="submit_review">Submit Review</button></form>';


            echo $variable = "<script>document.write(a)</script>";

            

            ?>


                </div>    
    </div>


    


<style>
    
    .rate_review {
        padding-top: 50px;
        padding-bottom: 50px;
        position: static;
    }
    .rating {
        margin-left: 30px;
    }

    div.skill {
        background: #5cb85c;
        border-radius: 3px;
        color: white;
        
        padding: 3px 4px;
        margin-top: -10px;
        
    }

    .skillLine {
        display: inline-block;
        width: 100%;
        min-height: 90px;
        padding: 3px 4px;
    }

    skillLineDefault {
        padding: 3px 4px;

    }
</style>

<!-- you need to include the shieldui css and js assets in order for the charts to work -->
<link rel="stylesheet" type="text/css" href="http://www.shieldui.com/shared/components/latest/css/light/all.min.css" />
<script type="text/javascript" src="http://www.shieldui.com/shared/components/latest/js/shieldui-all.min.js"></script>

<script type="text/javascript">
    initializeRatings();

    function initializeRatings() {
        $('#rate1').shieldRating({
            max: 5,
            step: 1,
            value: 0,
            markPreset: false
        });
        
    }


    function getValue() {
        //var a = $('#rate1').swidget().value();
        //alert(a);
        document.getElementById("myRate1").value = $('#rate1').swidget().value();
    }
</script>

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