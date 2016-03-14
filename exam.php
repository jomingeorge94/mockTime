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

    include 'includes/footer.php';




?>