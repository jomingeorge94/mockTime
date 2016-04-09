<?php

function sanitise($data) {
	return mysql_real_escape_string($data);
}

function redirect_logged_in () {
	if (user_logged_in () === true) {
		header('Location: index.php');
		exit();
	}
}

function generic_page () {
	if (user_logged_in () === false) {
		header('Location: generic.php');
		exit();
	}
}

function admin_protect () {
	global $user_data;
	if (is_admin($user_data['user_id']) === false ) {
		header('Location: /mocktime/');
		exit();
	} 
}


function sanitise_array (&$item) {
	$item = mysql_real_escape_string($item);
}

function email($to, $subject, $body) {
	mail ($to, $subject, $body);
}

function error_output($errors) {
	return '<ul style="list-style-type: none"><li>' . implode('</li><li>', $errors) . '</li></ul>';
}

?>