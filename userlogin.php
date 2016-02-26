<?php
include 'core/session.php';

$_SESSION['error'] = [];

if(empty($_POST) === false) {
	
	$email_address = $_POST['form-emailaddress'];
	$password = $_POST['form-password'];

	if (empty($email_address) === true || empty($password) === true) {
		$errors[] = 'Enter email address and password ...';

	} else if (user_exists($email_address) === false) {
		
		$errors[] = 'Email address does not exist within our system ...';
	} else if (user_active($email_address) === false) {
		
		$errors[] = 'Email Address is not activated !';
	}else if (freeze_account($email_address) === false) {
		
		$errors[] = 'Your account is temporarily locked, contact <strong> <a href="index.php#contact"> System Administrator </a></strong> ';
	} else {
		$login = login($email_address, $password);

		if ($login === false) {
			$errors[] = 'Email address or Password combination is invalid ...';

		} else {

			//setting user session
			$_SESSION['user_id'] = $login; 
			//redirect user back to home page if there is no error 
			header('Location: index.php');
			exit();
		}

	}
	$_SESSION['error'] = $errors;
	header('Location: login.php');
	
} 

?>