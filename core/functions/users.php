<?php
//function to check if the user exist by checking against email address
function user_exists($emailaddress) {
	//sanitising the user input against a function 
	$emailaddress = sanitise($emailaddress);
	//sql query to check if a user is present in the database
	$query = mysql_query("SELECT COUNT(`user_id`) FROM `mock_exam_users` WHERE `email_address` = '$emailaddress'");
	//if the query returns to be 1 then this function will return true otherwise false
	return (mysql_result($query, 0) == 1) ? true : false; 
}
//function to freeze user account by an email address
function freeze_account($emailaddress) {
	$emailaddress = sanitise($emailaddress);
	$query = mysql_query("SELECT COUNT(`user_id`) FROM `mock_exam_users` WHERE `email_address` = '$emailaddress' AND `freeze_account` = 0");
	return (mysql_result($query, 0) == 1) ? true : false; 
}
//function to activate an user account by email address
function user_active($emailaddress) {
	//sanitising the user input against a function 
	$emailaddress = sanitise($emailaddress);
	//sql query to check if the user's email address has been verified
	$query = mysql_query("SELECT COUNT(`user_id`) FROM `mock_exam_users` WHERE `email_address` = '$emailaddress' AND `active_status` = 1");
	//if the query returns to be 1 then this function will return true otherwise false
	return (mysql_result($query, 0) == 1) ? true : false; 
}
//function to retrive user id by giving the email address
function user_id_from_email_address ($emailaddress) {
	$emailaddress = sanitise($emailaddress);
	return mysql_result(mysql_query("SELECT `user_id` FROM `mock_exam_users` WHERE `email_address` = '$emailaddress'"), 0,'user_id');

}
//function which handles login
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

//function which returns the number of current active users on the site except the admin
function user_count () {
	return mysql_result(mysql_query("SELECT COUNT(`user_id`) FROM `mock_exam_users` WHERE `active_status` = 1 AND `user_type` = 0"), 0);
}

function redirect($url) {
  echo "<script language=\"JavaScript\">\n";
  echo "<!-- hide from old browser\n\n";
  echo "window.location = \"" . $url . "\";\n";
  echo "-->\n";
  echo "</script>\n";

  return true;
}

//function which handles a user characeterstic
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


//function to add student summary after they enter for an exam
function insert_student_summary ($exam_id, $user_id, $category_id, $start_time) {
		$data = array();

		$result = mysql_query("INSERT INTO `mock_exam_student_summary` (`exam_id`, `user_id`,`category_id`, `exam_start_time`) VALUES ('$exam_id', '$user_id', '$category_id', '2222-22-22 22:22:22')");

		while ($row = mysql_fetch_assoc($result)) {
		    $data [] = $row;
		}

		return $data;
} 


function get_student_summary ($id) {
		$data = array();

		$result = mysql_query("SELECT a.*,b.*,c.*,e.* FROM mock_exam_quiz a, mock_exam_student_summary b, mock_exam_users c, mock_exam_category e WHERE a.quiz_id = b.exam_id AND b.user_id = c.user_id AND e.category_id = b.category_id AND b.user_id = '$id'");

		while ($row = mysql_fetch_assoc($result)) {
		    $data [] = $row;
		}

		return $data;
} 


//function to get exam 
function get_exam($id){

	$query = mysql_query("SELECT a.*, b.* FROM mock_exam_quiz a, mock_exam_category b WHERE a.quiz_id = '$id' AND a.quiz_category_id = b.category_id");
	return mysql_fetch_row($query);

}


//function to get answers
function get_answer($id){

	$query = mysql_query("SELECT `answer_name` FROM `mock_exam_answers` WHERE `question_id` = '$id'");
	return mysql_fetch_row($query);

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

//get all the categories from the category table
function get_all_categories () {
		$data = array();

		$result = mysql_query("SELECT * FROM `mock_exam_category` ORDER BY category_name ASC");

		while ($row = mysql_fetch_assoc($result)) {
		    $data [] = $row;
		}

		return $data;
} 

//get all the exam details from the exam table
function get_all_exam () {
		$data = array();

		$result = mysql_query("SELECT a.*, b.*
        FROM mock_exam_quiz a, mock_exam_category b
        WHERE a.quiz_category_id = b.category_id");

		while ($row = mysql_fetch_assoc($result)) {
		    $data [] = $row;
		}

		return $data;
} 


//get all the exam details from the exam table which is set to be active
function get_all_exam_status () {
		$data = array();

		$result = mysql_query("SELECT a.*, b.*
        FROM mock_exam_quiz a, mock_exam_category b
        WHERE a.quiz_category_id = b.category_id AND `quiz_status` = 1");

		while ($row = mysql_fetch_assoc($result)) {
		    $data [] = $row;
		}

		return $data;
}

//function to get all the available categories
function get_available_categories(){
	$ret = array();
	$ret[] = "Multiple_Choice";
	$ret[] = "True_False";
	$ret[] = "Essay";
	$ret[] = "Fill_Blank";
	$ret[] = "Acronym_Answer";
	return $ret;
}

//function to clear all the questions - this take care of foriegn key constraints
function clear_questions($exam_id){
	$data = array();

	$result = mysql_query("SELECT * FROM `mock_exam_questions` WHERE `quiz_id` = '$exam_id'");

	while ($row = mysql_fetch_assoc($result)) {
	    $data [] = $row;
	}

	foreach($data as $d){
		clear_answers($d['question_id']);
	}

	$id = (int)$exam_id;
	// Delete the question to update
	mysql_query("DELETE FROM `mock_exam_questions` WHERE `quiz_id` = '$id'");

}

//clearning all the answers linked with an exam
function clear_answers($qid){
	$id = (int)$qid;
	// Delete the question to update
	$r = mysql_query("DELETE FROM `mock_exam_answers` WHERE `question_id` = '$id'");

}

//function to delete all the questions
function delete_all_questions($id){
	clear_questions($id);
}

//function to add exam 
function add_exam( $name, $category, $duration, $status) {

	if(empty($name) || empty($category) || empty($duration))
		return false;

	mysql_query("INSERT INTO `mock_exam_quiz` (`quiz_name`, `quiz_category_id`, `quiz_duration`, `quiz_status`) VALUES ('$name', '$category', '$duration', '$status')");

	return true;
}

//function to add question 
function add_question($exam_id, $q_name, $q_type){
	
	// Add them anew
	mysql_query("INSERT INTO `mock_exam_questions` (`quiz_id`, `question_name`, `question_type`) VALUES ('$exam_id', '$q_name', '$q_type')");
	return mysql_insert_id();
}


//function to add answer for a question
function add_answer($qid, $a_name, $is_true){
	
	// Add them anew
	mysql_query("INSERT INTO `mock_exam_answers` (`question_id`, `answer_name`, `is_true`) VALUES ('$qid', '$a_name', '$is_true')");
}

//function to get all the questions from an exam
function get_questions_from_exam($examid){
	$data = array();

	$result = mysql_query("SELECT * FROM `mock_exam_questions` WHERE `quiz_id` = '$examid'");

	while ($row = mysql_fetch_assoc($result)) {
	    $data [] = $row;
	}

	return $data;
}

//function to get all the answers from an exam
function get_answers_from_exam($qid){
	$data = array();

	$result = mysql_query("SELECT * FROM `mock_exam_answers` WHERE `question_id` = '$qid'");

	while ($row = mysql_fetch_assoc($result)) {
	    $data [] = $row;
	}

	return $data;
}





function get_category_name($id){

	$query = mysql_query("SELECT * FROM `mock_exam_category` WHERE `category_id` = '$id'");
	return mysql_fetch_row($query);

}






function get_faq(){
	$data = array();

	$query = mysql_query("SELECT * FROM `mock_exam_faq`");
	while ($row = mysql_fetch_assoc($query)) {
		$data [] = $row;
	}
    return $data;
}










function update_exam($id, $name, $category, $duration, $status) {
	if(empty($id) || empty($name) || empty($category) || empty($duration))
		return false;

	mysql_query("UPDATE `mock_exam_quiz` SET `quiz_name` = '$name', `quiz_category_id` = '$category', `quiz_duration` = '$duration', `quiz_status` = $status WHERE `quiz_id` = '$id'");

	return true;
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



function set_exam_active ($quiz_id) {
	$quiz_id = (int)$quiz_id;
	mysql_query("UPDATE `mock_exam_quiz` SET `quiz_status` = 1 WHERE `quiz_id` = '$quiz_id'");
}

function unset_exam_active ($quiz_id) {
	$quiz_id = (int)$quiz_id;
	mysql_query("UPDATE `mock_exam_quiz` SET `quiz_status` = 0 WHERE `quiz_id` = '$quiz_id'");
}

function set_category_active ($category_id) {
	$category_id = (int)$category_id;
	mysql_query("UPDATE `mock_exam_category` SET `status` = 1 WHERE `category_id` = '$category_id'");
}

function unset_category_active ($category_id) {
	$category_id = (int)$category_id;
	mysql_query("UPDATE `mock_exam_category` SET `status` = 0 WHERE `category_id` = '$category_id'");
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

function delete_category ($category_id) {
	$category_id = (int)$category_id;

	mysql_query("DELETE FROM `mock_exam_category` WHERE `category_id` = '$category_id'");
}

function delete_exam ($quiz_id) {
	clear_questions($quiz_id);
	$quiz_id = (int)$quiz_id;

	mysql_query("DELETE FROM `mock_exam_quiz` WHERE `quiz_id` = '$quiz_id'");
}

function change_category_name ($category_id, $categoryname) {
	$category_id = (int)$category_id;
	mysql_query("UPDATE `mock_exam_category` SET `category_name` = '$categoryname' WHERE `category_id` = '$category_id'");
	
}

function add_new_category ($category_id, $categoryname) {
	$category_id = (int)$category_id;
	mysql_query("INSERT INTO `mock_exam_category` (`category_id`, `category_name`, `status`, `date_created`) VALUES ('$category_id', '$categoryname', '1', CURRENT_TIMESTAMP)");
	
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

// this code is been used from http://www.thesoftwareguy.in/
function generate_admin_link($page = '', $parameters = '') {

  if ($page == '') {
    die('<font color="#ff0"><b>Error!</b></font><br><br><b>Unable to determine the page link!</b>');
  }


  if (!strstr($page, '.php'))
    $page .= '.php';

  if ($parameters == '') {
    $link = $link . $page;
    $separator = '?';
  } else {
    $link = $link . $page . '?' . $parameters;
    $separator = '&';
  }

  while ((substr($link, -1) == '&') || (substr($link, -1) == '?'))
    $link = substr($link, 0, -1);
  return $link;
}

// this code is been used from http://www.thesoftwareguy.in/
function get_all_get_params($exclude_array = '') {

  if (!is_array($exclude_array))
    $exclude_array = array();

  $get_url = '';
  if (is_array($_GET) && (sizeof($_GET) > 0)) {
    reset($_GET);

    $arr = $_GET;
    foreach ($arr as $k => $value) {
      if (gettype($arr[$k]) == "array") {
        foreach ($arr[$k] as $key => $values) {
          if ((strlen($values) > 0) && (!in_array($key, $exclude_array))) {
            $get_url .= sanitize_string($k) . '[]=' . rawurlencode(stripslashes($values)) . '&';
          }
        }
      } else {
        if ((strlen($value) > 0) && ($k != 'error') && (!in_array($k, $exclude_array)) && ($k != 'x') && ($k != 'y')) {
          $get_url .= sanitize_string($k) . '=' . rawurlencode(stripslashes($value)) . '&';
        }
      }
    }
  }

  while (strstr($get_url, '&&'))
    $get_url = str_replace('&&', '&', $get_url);
  while (strstr($get_url, '&amp;&amp;'))
    $get_url = str_replace('&amp;&amp;', '&amp;', $get_url);

  return $get_url;
}

function generate_site_link($page = '', $parameters = '') {

  if ($page == '') {
    die('<font color="#ff0"><b>Error!</b></font><br><br><b>Unable to determine the page link!</b>');
  }

  if (!strstr($page, '.php'))
    $page .= '.php';

  if ($parameters == '') {
    $link = $link . $page;
    $separator = '?';
  } else {
    $link = $link . $page . '?' . $parameters;
    $separator = '&';
  }

  while ((substr($link, -1) == '&') || (substr($link, -1) == '?'))
    $link = substr($link, 0, -1);
  return $link;
}


?>