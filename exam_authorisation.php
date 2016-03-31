<?php 
	include 'core/session.php';

    if (isset($_POST['mode']) && $_POST['mode'] == 'start') {

        $examid = $_POST['eid']; //getting the exam id 
        $examname = $_POST['ename']; //getting the exam name after form get posted
        $examduration = $_POST['etime']; //getting the exam duration after form posted
        $examcategory = $_POST['ecategory']; //getting the exam category after form posted
        $examcategoryid = $_POST['ecategoryid']; //getting the exam category id after form posted

        $currentUserPage = $_SERVER["HTTP_REFERER"]; //gettin the page where user was send the form from

            if (intval($examid) == 0) {
                $_SESSION["errorMessage"] = "Please select an available exam";
                redirect($currentUserPage); //redirecting the user back to the exam starting page with an error on the screen
                exit();
            } else if (intval($_SESSION["user_id"]) == 0) {
                $_SESSION["errorMessage"] = "You need to be logged into take an exam";
                redirect(generate_site_link("login")); //redirecting the user back to login page
                exit();
            } else {
                $_SESSION["chosen_exam_id"] = $examid;
                $_SESSION["chosen_exam_name"] = $examname;
                $_SESSION["chosen_exam_time"] = $examduration;
                $_SESSION["chosen_exam_category"] = $examcategory;
                $_SESSION["chosen_exam_category_id"] = $examcategoryid;

                $_SESSION["chosen_exam_start_time"] = new DateTime();
                $schedule_date =  $_SESSION["chosen_exam_start_time"]; 
                $schedule_date->setTimeZone(new DateTimeZone('Europe/London'));
                $triggerOn =  $schedule_date->format('Y-m-d H:i:s');

                $_SESSION['questionNumber'] = 0;

                $finished_time = new DateTime();
                $value = $examduration;
                $finished_time->modify((int) $value.' minute');
                $finished_time->setTimeZone(new DateTimeZone('Europe/London'));
                $exam_finish_time =  $finished_time->format('Y-m-d H:i:s');

               
                //insert_student_summary($examid, $_SESSION['user_id'], $examcategoryid, $triggerOn, $exam_finish_time);
                
                redirect(generate_site_link("exam"));

            }

    }

?>