<?php 
	include 'core/session.php';
	
    //checking if the session user id is present, if it is then allow the user to access the exam, if not then redirect the user to another page
    /*if (isset($_SESSION['user_id'])) {
        $_SESSION['error'] = "Please login/register to take an exam.";
        redirect(generate_site_link("exam"));
        exit;
    } else {
        redirect(generate_site_link("login"));
        exit;
    }*/


    if (isset($_POST['mode']) && $_POST['mode'] == 'start') {

        $examid = $_POST['eid']; //getting the exam id 
        $examname = $_POST['ename']; //getting the exam name after form get posted
        $examduration = $_POST['etime']; //getting the exam duration after form posted
        $examstarttime = time(); // time user started the exam
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
                $_SESSION["chosen_exam_start_time"] = $examstarttime;
                
                redirect(generate_site_link("exam"));
                exit();
            }



    }








?>