<?php 
	include 'core/session.php';
	
    //checking if the session user id is present, if it is then allow the user to access the exam, if not then redirect the user to another page
    if (isset($_SESSION['user_id'])) {
        $_SESSION['error'] = "Please login/register to take an exam.";
        redirect(generate_site_link("exam"));
        exit;
    } else {
        redirect(generate_site_link("login"));
        exit;
    }








?>