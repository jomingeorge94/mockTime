<?php
include '../core/session.php';

$_SESSION['error'] = [];

if(empty($_POST) === false) {

	$password = $_POST['admin_password'];
	$username = $_POST['username'];

	if (empty($password) === true) {
		$errors[] = 'Please enter your password ...';

	} else {
		$login = login($username, $password);

		if ($login === false) {
			$errors[] = 'Login credentials do not match !!';

		} else {

			
			set_password_check($login);
			//redirect user back to home page if there is no error 
			header('Location: /mocktime/admin/admin_dashboard.php');
			exit();
		}

	}
	$_SESSION['error'] = $errors;
	header('Location: /mocktime/admin/index.php');
	
} 

?>