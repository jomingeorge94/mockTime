<?php

function user_exists($emailaddress) {
	//sanitising the user input against a function 
	$emailaddress = sanitise($emailaddress);
	//sql query to check if a user is present in the database
	$query = mysql_query("SELECT COUNT(`user_id`) FROM `mock_exam_users` WHERE `email_address` = '$emailaddress'");
	//if the query returns to be 1 then this function will return true otherwise false
	return (mysql_result($query, 0) == 1) ? true : false; 
}

function freeze_account($emailaddress) {
	$emailaddress = sanitise($emailaddress);
	$query = mysql_query("SELECT COUNT(`user_id`) FROM `mock_exam_users` WHERE `email_address` = '$emailaddress' AND `freeze_account` = 0");
	return (mysql_result($query, 0) == 1) ? true : false; 
}

function user_active($emailaddress) {
	//sanitising the user input against a function 
	$emailaddress = sanitise($emailaddress);
	//sql query to check if the user's email address has been verified
	$query = mysql_query("SELECT COUNT(`user_id`) FROM `mock_exam_users` WHERE `email_address` = '$emailaddress' AND `active_status` = 1");
	//if the query returns to be 1 then this function will return true otherwise false
	return (mysql_result($query, 0) == 1) ? true : false; 
}

function user_id_from_email_address ($emailaddress) {
	$emailaddress = sanitise($emailaddress);
	return mysql_result(mysql_query("SELECT `user_id` FROM `mock_exam_users` WHERE `email_address` = '$emailaddress'"), 0,'user_id');

}

function login ($emailaddress, $password) {
	$user_id = user_id_from_email_address($emailaddress);

	$emailaddress = sanitise ($emailaddress);
	$password = md5($password);

	//if this statement is true then return the users id otherwise return false
	return (mysql_result(mysql_query("SELECT COUNT(`user_id`) FROM `mock_exam_users` WHERE `email_address` = '$emailaddress' AND `password` = '$password'"), 0) == 1) ? $user_id : false;
}

//function that returns whether or not if user is logged in
function user_logged_in () {
	return (isset($_SESSION['user_id'])) ? true : false;
}

//returns the number of current active users on the site except the admin
function user_count () {
	return mysql_result(mysql_query("SELECT COUNT(`user_id`) FROM `mock_exam_users` WHERE `active_status` = 1 AND `user_type` = 0"), 0);
}

function user_data ($user_id) {
	$data = array();
	$user_id = (int)$user_id;

	//counting the number of arguments
	$func_num_args = func_num_args();
	
	//return an array of arguments passed through the function
	$func_get_args = func_get_args();

	if ($func_num_args > 1) {
		unset($func_get_args[0]);

		$fields = '`' . implode('`, `', $func_get_args) . '`';
		
		$data = mysql_fetch_assoc(mysql_query("SELECT $fields FROM `mock_exam_users` WHERE `user_id` = $user_id"));


		return $data;
	}
} 

//get all the users in the database except the admin
function get_all_users () {
		$data = array();

		$result = mysql_query("SELECT * FROM `mock_exam_users` WHERE `user_type` = 0 AND `active_status` =1");

		while ($row = mysql_fetch_assoc($result)) {
		    $data [] = $row;
		}

		return $data;
} 

//update user details on the database
function update_user($update_data) {
	$update_detail = array();
	array_walk($update_data, 'sanitise_array');

	foreach ($update_data as $field=>$data) {
		$update_detail[] = '`' . $field . '` = \'' . $data . '\'';
	}

	mysql_query("UPDATE `mock_exam_users` SET " . implode(', ', $update_detail) . "WHERE `user_id` = " . $_SESSION['user_id']);

}

//function to signup users
function user_register ($register_data) {
	array_walk($register_data, 'sanitise_array');
	$register_data['password'] = md5($register_data['password']);

	$fields = '`' . implode('`, `', array_keys($register_data)) . '`';
	$data = '\'' . implode('\', \'', $register_data) . '\'';

	mysql_query("INSERT INTO `mock_exam_users` ($fields) VALUES ($data)");
	email($register_data['email_address'], 'Activate your account', "Hello " . $register_data['first_name'] .",\n\nTo activate your account, click on the link below or copy and paste the URL on to your browser.\nhttp://" . $_SERVER['SERVER_NAME'] . "/mocktime/activate.php?email=" . $register_data['email_address'] . "&email_code=" . $register_data['email_code'] ." \n\nmockTime");
}

function activate($email, $email_code) {
	$email = mysql_real_escape_string($email);
	$email_code = mysql_real_escape_string($email_code);

	// condition to update the user active status - if the email, email code to match on the database
	// and active status to be 0 
	if (mysql_result(mysql_query("SELECT COUNT(`user_id`) FROM `mock_exam_users` WHERE `email_address` = '$email' AND `email_code` = '$email_code' AND `active_status` = 0"), 0) == 1) {
		mysql_query("UPDATE `mock_exam_users` SET `active_status` = 1 WHERE `email_address` = '$email'");
		return true;
	} else {
		return false;
	}

}

//function to change profile picture
function change_profile_image($user_id, $file_temp, $file_explode) {
	//taking current time, hashed it using mdg5 and then taking legth of 10
	$file_path = 'images/profile/' . substr(md5(time()), 0, 10) . '.' . $file_explode;
	//moving the file from the temporary place to the path specified
	move_uploaded_file($file_temp, $file_path);
	//inserting it the data
	mysql_query("UPDATE `mock_exam_users` SET `profile_picture` ='" . mysql_real_escape_string($file_path) . "' WHERE `user_id` = " . (int)$user_id);


}

function change_password ($user_id, $password) {
	$user_id = (int)$user_id;
	$password = md5($password);

	mysql_query("UPDATE `mock_exam_users` SET `password` = '$password', `password_recover` = 0 WHERE `user_id` = '$user_id'");
}

function set_freeze_user_account ($user_id) {
	$user_id = (int)$user_id;

	mysql_query("UPDATE `mock_exam_users` SET `freeze_account` = 1 WHERE `user_id` = '$user_id'");
}

function unset_freeze_user_account ($user_id) {
	$user_id = (int)$user_id;

	mysql_query("UPDATE `mock_exam_users` SET `freeze_account` = 0 WHERE `user_id` = '$user_id'");
}

function delete_user ($user_id) {
	$user_id = (int)$user_id;

	mysql_query("DELETE FROM `mock_exam_users` WHERE `user_id` = '$user_id'");
}

function set_password_check ($user_id) {
	$user_id = (int)$user_id;

	mysql_query("UPDATE `mock_exam_users` SET `admin_password_check` = '1' WHERE `user_id` = '$user_id'");
}

function unset_password_check ($user_id) {
	$user_id = (int)$user_id;

	mysql_query("UPDATE `mock_exam_users` SET `admin_password_check` = '0' WHERE `user_id` = '$user_id'");
}

//function to recover password based on what the mode is
function recover($mode, $email) {
	$mode = sanitise($mode);
	$email = sanitise($email);

	$user_data = user_data(user_id_from_email_address($email), 'first_name', 'user_id');

	if ($mode == 'password') {
		//use the rand function which generates between the specified numbers
		//hashed the genarated number and used the substring function to specify starting and the end
		$password_generate = substr(md5(rand(99,999999)), 0, 8);
		change_password ($user_data['user_id'], $password_generate);
		mysql_query("UPDATE `mock_exam_users` SET `password_recover` = 1 WHERE `email_address` = '$email'");
		email($email, 'Password Recovery', "Hello " . $user_data['first_name'] . ",\n\nYour new password is: " . $password_generate . "\n\nmockTime" );	
	}
}

function is_admin ($user_id) {
	$user_id = (int)$user_id;
	return (mysql_result(mysql_query("SELECT COUNT(`user_id`) FROM `mock_exam_users` WHERE `user_id` = $user_id AND `user_type` = 1"), 0) == 1) ? true : false;
}

function safe_output($string) {
  return trim((stripslashes($string)));
}

?>