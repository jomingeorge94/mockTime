<?php
session_start();
error_reporting(0);

require 'database/config.php';
require 'functions/users.php';
require 'functions/helper.php';

//finding the page the user is currently on 
$current_page = end(explode('/', $_SERVER['SCRIPT_NAME']));

if(user_logged_in() === true){
	$session_user_id = $_SESSION['user_id'];
	$user_data = user_data($session_user_id, 'user_id', 'first_name', 'last_name', 'email_address', 'password', 'password_recover', 'profile_picture', 'user_type', 'admin_password_check', 'date_created', 'session_start', 'freeze_account');

	//condition to check if the user has verified their email address and if they are not then session will be destroyed 
	// and redirected back to index.php page
	if (user_active($user_data['email_address']) === false) {
		session_destroy();
		header('Location: index.php');
		exit();
	}

	if (freeze_account($user_data['email_address']) === false) {
		session_destroy();
		header('Location: index.php');
		exit();
		
	}
	
	//if the file is not profile, logout and the password_recover field set to be 1 then forcing user to change password
	if ($current_page !== 'profile.php' && $user_data['password_recover'] ==1 ) {
		header('Location: profile.php?force');
		exit();
	}

}

$errors = array();

?>