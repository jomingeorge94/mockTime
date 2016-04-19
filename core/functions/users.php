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
//function which returns the number of current active exams 
function quiz_count () {
	return mysql_result(mysql_query("SELECT COUNT(`quiz_id`) FROM `mock_exam_quiz` WHERE `quiz_status` = 1"), 0);
}
//function which returns the number of current active categories 
function category_count () {
	return mysql_result(mysql_query("SELECT COUNT(`category_id`) FROM `mock_exam_category` WHERE `status` = 1"), 0);
}
//function to update the lastSeen Column on database everytime user visits a page
function updateLastSeenUser($user_id) {
	return mysql_result(mysql_query("UPDATE `mock_exam_users` SET `lastSeen` = NOW() WHERE `user_id` = '$user_id'"), 0);
}

//function to retrieve currently logged in user based on an interval
function getLoggedInUsers() {
	return mysql_result(mysql_query("SELECT COUNT(*) FROM `mock_exam_users` WHERE `user_type` = 0 AND `lastSeen` > DATE_SUB(NOW(), INTERVAL 5 MINUTE)"), 0);
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
function insert_student_summary ($exam_id, $user_id, $category_id, $start_time, $finish_time) {
		$data = array();
		$result = mysql_query("INSERT INTO `mock_exam_student_summary` (`exam_id`, `user_id`,`category_id`, `exam_start_time`, `exam_end_time`) VALUES ('$exam_id', '$user_id', '$category_id', '$start_time', '$finish_time')");
		while ($row = mysql_fetch_assoc($result)) {
		    $data [] = $row;
		}
		return $data;
} 
//function to add student result on each next click during an exam
function insert_student_result ($student_summary_id, $user_id, $exam_id, $question_id, $answer, $student_result_status) {
		$data = array();
		$result = mysql_query("INSERT INTO `mock_exam_student_result` (`student_summary_id`, `user_id`, `exam_id`,`question_id`, `student_answer`, `student_result_status`) VALUES ('$student_summary_id', '$user_id', '$exam_id', '$question_id', '$answer', '$student_result_status')");
		while ($row = mysql_fetch_assoc($result)) {
		    $data [] = $row;
		}
		return $data;
}
function insert_total_questions_into_quiz ($total_question, $quiz_id, $quiz_duration, $quiz_category_id) {
		$data = array();
		
		$result = mysql_query("UPDATE `mock_exam_quiz` SET `total_questions` = '$total_question' WHERE `quiz_id` = '$quiz_id' AND `quiz_duration` = '$quiz_duration' AND `quiz_category_id` = '$quiz_category_id'");
		while ($row = mysql_fetch_assoc($result)) {
		    $data [] = $row;
		}
		return $data;
}
function update_student_result_for_each_question ($summary_id) {
		$data = array();
		
		$result = mysql_query("UPDATE `mock_exam_student_summary` SET `exam_result_status` = 1 WHERE `student_summary_id` = '$summary_id'");
		while ($row = mysql_fetch_assoc($result)) {
		    $data [] = $row;
		}
		
		return $data;
		
}





function update_ratingColumnInDatabase ($numberofRating, $user_id, $examid) {
		$data = array();
		
		$result = mysql_query("UPDATE `mock_exam_student_summary` SET `star_rating` = '$numberofRating' WHERE `user_id` = '$user_id' AND `exam_id` = '$examid'");
		while ($row = mysql_fetch_assoc($result)) {
		    $data [] = $row;
		}
		return $data;		
}

function retrieve_ratingColumnInDatabase ($user_id, $exam_id) {
		$data = array();
		
		$result = mysql_query("SELECT `star_rating` FROM `mock_exam_student_summary` WHERE `user_id` = '$user_id' AND `exam_id` = '$exam_id'");
		while ($row = mysql_fetch_assoc($result)) {
		    $data [] = $row;
		}
		return $data;		
}

function check_if_attempted($ssid, $uid, $eid, $qid){
	$data = array();
		
	$result = mysql_query("SELECT `difficulty_level` FROM `mock_exam_student_result` WHERE `user_id` = '$uid' AND `exam_id` = '$eid' AND `question_id` = '$qid' AND `student_summary_id` = '$ssid'");
	while ($row = mysql_fetch_assoc($result)) {
	    $data [] = $row;
	}
	return empty($data);
}

function check_if_not_done($ssid, $uid, $eid, $qid){
	$data = array();
		
	$result = mysql_query("SELECT `difficulty_level` FROM `mock_exam_student_result` WHERE `user_id` = '$uid' AND `exam_id` = '$eid' AND `question_id` = '$qid' AND `student_summary_id` = '$ssid'");
	while ($row = mysql_fetch_assoc($result)) {
	    $data [] = $row;
	}
	return $data[0]['difficulty_level'] == 0;
}

function get_difficulty($ssid, $uid, $eid, $qid){
	$data = array();
		
	$result = mysql_query("SELECT `difficulty_level` FROM `mock_exam_student_result` WHERE `user_id` = '$uid' AND `exam_id` = '$eid' AND `question_id` = '$qid' AND `student_summary_id` = '$ssid'");
	while ($row = mysql_fetch_assoc($result)) {
	    $data [] = $row;
	}
	return $data[0];
}






function update_student_mark_for_each_question ($student_summary_id, $user_id, $exam_id, $question_id, $mark) {
		$data = array();
		
		$result = mysql_query("UPDATE `mock_exam_student_result` SET `student_result_status` = '$mark' WHERE `user_id` = '$user_id' AND `exam_id` = '$exam_id' AND `question_id` = '$question_id' AND `student_summary_id` = '$student_summary_id'");
		while ($row = mysql_fetch_assoc($result)) {
		    $data [] = $row;
		}
		
		return $data;
		
}

function update_difficulty_for_each_question ($student_summary_id, $user_id, $exam_id, $question_id, $diff) {
		$data = array();
		
		$result = mysql_query("UPDATE `mock_exam_student_result` SET `difficulty_level` = '$diff' WHERE `user_id` = '$user_id' AND `exam_id` = '$exam_id' AND `question_id` = '$question_id' AND `student_summary_id` = '$student_summary_id'");
		while ($row = mysql_fetch_assoc($result)) {
		    $data [] = $row;
		}
		
		return $data;
		
}

function update_student_final_result ($summary_id, $result) {
		$data = array();
		
		$result = mysql_query("UPDATE `mock_exam_student_summary` SET `student_result` = '$result' WHERE `student_summary_id` = '$summary_id'");
		while ($row = mysql_fetch_assoc($result)) {
		    $data [] = $row;
		}
		
		return $data;
		
}
function get_sum_of_student_marks ($user_id, $exam_id, $summary_id) {
		$data = array();
		
		$result = mysql_query("SELECT SUM(student_result_status) FROM `mock_exam_student_result` WHERE `user_id` = '$user_id' AND `exam_id` = '$exam_id' AND `student_summary_id` = '$summary_id'");
		while ($row = mysql_fetch_assoc($result)) {
		    $data [] = $row;
		}
		
		return $data;
		
}
function insert_time_taken_for_exam($time_taken, $student_sum_id){
	$data = array();
		
		$result = mysql_query("UPDATE `mock_exam_student_summary` SET `time_taken` = '$time_taken' WHERE `student_summary_id` = '$student_sum_id'");
		while ($row = mysql_fetch_assoc($result)) {
		    $data [] = $row;
		}
		return $data;
}
//function to retrieve student result 
function retrieve_student_result ($user_id, $exam_id, $question_id, $student_summary) {
		$data = array();
		$result = mysql_query("SELECT `student_answer` from `mock_exam_student_result` WHERE `user_id` = $user_id AND `exam_id` = $exam_id AND `question_id` = $question_id AND `student_summary_id` = '$student_summary' LIMIT 1");
		$row = mysql_fetch_assoc($result);
		return $row ["student_answer"];
}
//function to retrieve student result 
function retrieve_student_result_status ($student_summary_id, $user_id, $exam_id, $question_id) {
		$data = array();
		$result = mysql_query("SELECT `student_result_status` from `mock_exam_student_result` WHERE `student_summary_id` = '$student_summary_id' AND `user_id` = $user_id AND `exam_id` = '$exam_id' AND `question_id` = '$question_id'");
		while ($row = mysql_fetch_assoc($result)) {
		    $data [] = $row;
		}
		return $data;
}
function get_student_summary ($id) {
		$data = array();
		$result = mysql_query("SELECT a.*,b.*,c.*,e.* FROM mock_exam_quiz a, mock_exam_student_summary b, mock_exam_users c, mock_exam_category e WHERE a.quiz_id = b.exam_id AND b.user_id = c.user_id AND e.category_id = b.category_id AND b.user_id = '$id' ORDER BY b.exam_start_time DESC");
		while ($row = mysql_fetch_assoc($result)) {
		    $data [] = $row;
		}
		return $data;
} 
//function to get all the questions and answers from an exam
function get_questions_from_exam_and_answers($examid){
	$data = array();
	$result = mysql_query("SELECT a.*, b.* FROM mock_exam_questions a, mock_exam_answers b WHERE a.quiz_id = '$examid' AND b.question_id = a.question_id");
	while ($row = mysql_fetch_assoc($result)) {
	    $data [] = $row;
	}
	return $data;
}
//function to get all the questions and answers from an exam
function get_all_answers_belongToOne_question($questionid){
	$data = array();
	$result = mysql_query("SELECT a.*, b.* FROM mock_exam_questions a, mock_exam_answers b WHERE b.question_id = a.question_id AND a.question_id = '$questionid'");
	while ($row = mysql_fetch_assoc($result)) {
	    $data [] = $row;
	}
	return $data;
}
//function to get all the questions and answers from an exam
function count_answers_belongToOne_question($questionid){
	$data = array();
	$result = mysql_query("SELECT count(*) FROM mock_exam_questions a, mock_exam_answers b WHERE b.question_id = a.question_id AND a.question_id = '$questionid'");
	while ($row = mysql_fetch_assoc($result)) {
	    $data [] = $row;
	}
	return $data;
}
//function to get correct answer for a question
function count_answers_belongToOne_questionNew($questionid){
	$data = array();
	$result = mysql_query("SELECT a.*, b.* FROM mock_exam_questions a, mock_exam_answers b WHERE b.question_id = a.question_id AND a.question_id = '$questionid' AND b.is_true = 1");
	while ($row = mysql_fetch_assoc($result)) {
	    $data [] = $row;
	}
	return $data;
}
function retrieve_exam_user_detail_basedon_student_summaryid ($stud_sum_id,$quiz_id) {
	
	$data = array();
	$result = mysql_query("SELECT a.*, b.* FROM mock_exam_student_summary a, mock_exam_quiz b WHERE a.student_summary_id = '$stud_sum_id' AND b.quiz_id = '$quiz_id' ");
	while ($row = mysql_fetch_assoc($result)) {
	    $data [] = $row;
	}
	return $data;
}
function get_student_summary_id ($exam_start_time) {
		
		$query = mysql_query("SELECT `student_summary_id` FROM mock_exam_student_summary WHERE `exam_start_time` = '$exam_start_time'");
		return mysql_fetch_row($query);
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

function get_question_name($id){
	$query = mysql_query("SELECT question_name FROM mock_exam_questions WHERE question_id = " . $id);
	return mysql_fetch_row($query)[0];
}




function get_question_breakdown($eid){
	
	$data = array();
	$result = mysql_query("select a.user_id, b.question_id, b.question_name, a.student_result_status from mock_exam_student_result a, mock_exam_questions b WHERE a.question_id=b.question_id AND a.exam_id = " . $eid);
	while ($row = mysql_fetch_assoc($result)) {
	    $data [] = $row;
	}

	$ret = array();

	$data2 = array();


	foreach($data as $d){
		$query = mysql_query("select count(distinct a.user_id) from mock_exam_student_result a WHERE a.exam_id = " . $eid . " AND question_id = " . $d["question_id"] . ";");
		$data2[$d["question_id"]] = (mysql_fetch_row($query)[0]);
	}


	$dataRIGHT = array();

	foreach($data as $d){
		$query = mysql_query("select count(distinct a.user_id) from mock_exam_student_result a WHERE a.exam_id = " . $eid . " AND question_id = " . $d["question_id"] . " AND student_result_status = 10;");
		$dataRIGHT[$d["question_id"]] = (mysql_fetch_row($query)[0]);
	}
	

	$ret[] = $data2;
	$ret[] = $dataRIGHT;

	

	return $ret;
}



function get_mark_breakdown_max($eid){
	 
	$data = array();
	$result = mysql_query("select user_id, MAX(student_result) from mock_exam_student_summary where exam_id = " . $eid . " GROUP BY(user_id);");
	while ($row = mysql_fetch_assoc($result)) {
	    $data [] = $row;
	}

	$data2 = array();

	foreach($data as $val){
		  if(intval($val['MAX(student_result)']) <35 && $val['MAX(student_result)'] != "Pending"){
            if(isset($data2['Fail'])){
            	$data2['Fail'] = $data2['Fail'] + 1;
            }else{
            	$data2['Fail'] = 1;
            }
         }else if(intval($val['MAX(student_result)']) >= 35 && intval($val['MAX(student_result)']) <40 && $val['MAX(student_result)'] != "Pending"){
            if(isset($data2['Pass by Compensation'])){
            	$data2['Pass by Compensation'] = $data2['Pass by Compensation'] + 1;
            }else{
            	$data2['Pass by Compensation'] = 1;
            }
         }else if(intval($val['MAX(student_result)']) >= 40 && intval($val['MAX(student_result)']) <50 && $val['MAX(student_result)'] != "Pending"){
            if(isset($data2['Pass'])){
            	$data2['Pass'] = $data2['Pass'] + 1;
            }else{
            	$data2['Pass'] = 1;
            }
         }else if(intval($val['MAX(student_result)']) >= 50 && intval($val['MAX(student_result)']) <60 && $val['MAX(student_result)'] != "Pending"){
            if(isset($data2['Second Lower Class'])){
            	$data2['Second Lower Class'] = $data2['Second Lower Class'] + 1;
            }else{
            	$data2['Second Lower Class'] = 1;
            }
         }else if(intval($val['MAX(student_result)']) >= 60 && intval($val['MAX(student_result)']) <70 && $val['MAX(student_result)'] != "Pending"){
            if(isset($data2['Second Upper Class'])){
            	$data2['Second Upper Class'] = $data2['Second Upper Class'] + 1;
            }else{
            	$data2['Second Upper Class'] = 1;
            }
         }else if(intval($val['MAX(student_result)']) >= 70 && intval($val['MAX(student_result)']) <= 100 && $val['MAX(student_result)'] != "Pending"){
         	if(isset($data2['First'])){
            	$data2['First'] = $data2['First'] + 1;
            }else{
            	$data2['First'] = 1;
            }
         }else if(intval($val['MAX(student_result)']) == "Pending"){
	        if(isset($data2['Pending'])){
	        	$data2['Pending'] = $data2['PendingPending'] + 1;
	        }else{
	        	$data2['Pending'] = 1;
	        }
}}

	return $data2;
}




 function get_rating_avg($eid){
	 
	$data = array();
	$result = mysql_query(" select user_id, MAX(star_rating) from mock_exam_student_summary where exam_id = " . $eid . " GROUP BY(user_id);");
	while ($row = mysql_fetch_assoc($result)) {
	    $data [] = $row;
	}

	$data2 = array();

	foreach($data as $val){
		  if(intval($val['MAX(star_rating)']) == 1){
            if(isset($data2['1'])){
            	$data2['1'] = $data2['1'] + 1;
            }else{
            	$data2['1'] = 1;
            }
         }else if(intval($val['MAX(star_rating)']) == 2){
            if(isset($data2['2'])){
            	$data2['2'] = $data2['2'] + 1;
            }else{
            	$data2['2'] = 1;
            }
         }else if(intval($val['MAX(star_rating)']) == 3){
            if(isset($data2['3'])){
            	$data2['3'] = $data2['3'] + 1;
            }else{
            	$data2['3'] = 1;
            }
         }else if(intval($val['MAX(star_rating)']) == 4){
            if(isset($data2['4'])){
            	$data2['4'] = $data2['4'] + 1;
            }else{
            	$data2['4'] = 1;
            }
         }else if(intval($val['MAX(star_rating)']) == 5){
            if(isset($data2['5'])){
            	$data2['5'] = $data2['5'] + 1;
            }else{
            	$data2['5'] = 1;
            }
         }
}

	return $data2;
}


function get_mark_breakdown_avg($eid){
	 
	$data = array();
	$result = mysql_query("select user_id, AVG(student_result) from mock_exam_student_summary where exam_id = " . $eid . " and student_result != 'Pending' GROUP BY(user_id);");
	while ($row = mysql_fetch_assoc($result)) {
	    $data [] = $row;
	}

	$data2 = array();

	foreach($data as $val){
		  if(intval($val['AVG(student_result)']) <35 && $val['AVG(student_result)'] != "Pending"){
            if(isset($data2['Fail'])){
            	$data2['Fail'] = $data2['Fail'] + 1;
            }else{
            	$data2['Fail'] = 1;
            }
         }else if(intval($val['AVG(student_result)']) >= 35 && intval($val['AVG(student_result)']) <40 && $val['AVG(student_result)'] != "Pending"){
            if(isset($data2['Pass by Compensation'])){
            	$data2['Pass by Compensation'] = $data2['Pass by Compensation'] + 1;
            }else{
            	$data2['Pass by Compensation'] = 1;
            }
         }else if(intval($val['AVG(student_result)']) >= 40 && intval($val['AVG(student_result)']) <50 && $val['AVG(student_result)'] != "Pending"){
            if(isset($data2['Pass'])){
            	$data2['Pass'] = $data2['Pass'] + 1;
            }else{
            	$data2['Pass'] = 1;
            }
         }else if(intval($val['AVG(student_result)']) >= 50 && intval($val['AVG(student_result)']) <60 && $val['AVG(student_result)'] != "Pending"){
            if(isset($data2['Second Lower Class'])){
            	$data2['Second Lower Class'] = $data2['Second Lower Class'] + 1;
            }else{
            	$data2['Second Lower Class'] = 1;
            }
         }else if(intval($val['AVG(student_result)']) >= 60 && intval($val['AVG(student_result)']) <70 && $val['AVG(student_result)'] != "Pending"){
            if(isset($data2['Second Upper Class'])){
            	$data2['Second Upper Class'] = $data2['Second Upper Class'] + 1;
            }else{
            	$data2['Second Upper Class'] = 1;
            }
         }else if(intval($val['AVG(student_result)']) >= 70 && intval($val['AVG(student_result)']) <= 100 && $val['AVG(student_result)'] != "Pending"){
         	if(isset($data2['First'])){
            	$data2['First'] = $data2['First'] + 1;
            }else{
            	$data2['First'] = 1;
            }
         }else if(intval($val['AVG(student_result)']) == "Pending"){
	        if(isset($data2['Pending'])){
	        	$data2['Pending'] = $data2['PendingPending'] + 1;
	        }else{
	        	$data2['Pending'] = 1;
	        }
}}

	return $data2;
}



function get_student_detail () {
		$data = array();
		$result = mysql_query("SELECT a.*, b.*, c.* FROM mock_exam_users a, mock_exam_quiz b, mock_exam_student_summary c WHERE a.user_id = c.user_id AND b.quiz_id = c.exam_id");
		while ($row = mysql_fetch_assoc($result)) {
		    $data [] = $row;
		}
		return $data;
}

function get_student_detail_unique_count () {
		$data = array();
		$result = mysql_query("select a.exam_id, count(distinct a.user_id) FROM mock_exam_student_summary a, mock_exam_quiz b WHERE a.exam_id = b.quiz_id GROUP BY(a.exam_id) ORDER BY b.quiz_name");
		while ($row = mysql_fetch_assoc($result)) {
		    $data [] = $row;
		}
		return $data;
}

function get_duration_detail_unique_count () {
		$data = array();
		$result = mysql_query("select a.exam_id, a.time_taken FROM mock_exam_student_summary a, mock_exam_quiz b WHERE a.exam_id = b.quiz_id ORDER BY b.quiz_name");
		while ($row = mysql_fetch_assoc($result)) {
		    $data [] = $row;
		}

		$temp = array();

		foreach($data as $v)
		{   

			$algo = explode(":", $v["time_taken"]);

			$ct = (intval($algo[0]) * 3600) + (intval($algo[1]) * 60) + (intval($algo[2]));

			$k = $v["exam_id"];


		   if(!isset($temp[$k])){
		   		$temp[$v["exam_id"]] = $ct;
		   }else{

		   		$temp[$v["exam_id"]] += $ct;
		   }
		}


		$temp2 = array();

		foreach($temp as $k => $t){
			$temp2[$k] = $temp[$k] /= get_values_for_keys($data, $k);
		}


		return $temp2;


}

function get_values_for_keys($mapping, $keys) {
	$i = 0;

    foreach($mapping as $k => $v) {
        if(intval($v["exam_id"]) == $keys)
        	$i++;
    }

    return $i;
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
function count_questions_of_an_exam($examid){
	$query = mysql_query("SELECT COUNT(*) FROM `mock_exam_questions` WHERE `quiz_id` = '$examid'");
	return mysql_fetch_row($query);
}
function getuserdetail ($user_id) {
	$query = mysql_query("SELECT * FROM `mock_exam_users` WHERE `user_id` = '$user_id'");
	return mysql_fetch_row($query);
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
//function to update student result on each next click during an exam
function update_student_result ($student_summary_id, $user_id, $exam_id, $question_id, $studentanswer) {
	if(empty($user_id) || empty($exam_id) || empty($question_id) || empty($student_summary_id))
		return false;
		mysql_query("UPDATE `mock_exam_student_result` SET `student_answer` = '$studentanswer' WHERE `student_summary_id` = '$student_summary_id' AND `user_id` = '$user_id' AND `exam_id` = '$exam_id' AND `question_id` = '$question_id'");
		return true;
		
}
//function to update student summary after they submit their exam
function update_student_summary($student_summary_id, $exam_end_time) {
		if(empty($exam_end_time) || empty($student_summary_id))
			return false;
		mysql_query("UPDATE `mock_exam_student_summary` SET `exam_end_time` = '$exam_end_time' WHERE `student_summary_id` = '$student_summary_id'");
		return true;
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


function get_all_exams () {
	$data = array();
	$query = mysql_query("SELECT `quiz_name` FROM `mock_exam_quiz`");
	while ($row = mysql_fetch_assoc($query)) {
		$data [] = $row;
	}
    return $data;
}

?>