-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 03, 2016 at 08:29 PM
-- Server version: 5.6.21
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `mock_exam_2016`
--

-- --------------------------------------------------------

--
-- Table structure for table `mock_exam_answers`
--

CREATE TABLE IF NOT EXISTS `mock_exam_answers` (
`answer_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `answer_name` varchar(255) NOT NULL,
  `is_true` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=395 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mock_exam_answers`
--

INSERT INTO `mock_exam_answers` (`answer_id`, `question_id`, `answer_name`, `is_true`) VALUES
(259, 125, 'wave', 1),
(260, 126, 'O(n2)', 1),
(306, 147, 'Int', 0),
(307, 147, 'Double', 0),
(308, 147, 'Boolean', 1),
(309, 147, 'String', 0),
(310, 148, 'System.out.print("The number is : " + nums[0]);', 1),
(311, 149, '1', 1),
(312, 150, 'Just Another Vulnerability Announcement', 1),
(313, 151, '0', 0),
(314, 151, '5', 1),
(315, 151, '6', 0),
(316, 151, '7', 0),
(317, 151, 'Impossible to calculate', 0),
(318, 152, 'Graphical User Interface', 1),
(319, 153, 'A thing', 0),
(320, 153, 'Something you wear', 0),
(321, 153, 'An instance of a class', 1),
(322, 154, 'Create an instance of a class (an object)', 1),
(323, 155, 'java.util', 0),
(324, 155, 'java.io', 1),
(325, 155, 'java.awt.event', 0),
(326, 155, 'java.awt', 0),
(327, 156, 'ArithmeticException', 0),
(328, 156, 'NoSuchMethodException', 0),
(329, 156, 'IOException', 1),
(330, 156, 'InputException', 0),
(331, 157, 'dasdasdas', 1),
(332, 158, 'deniz', 1),
(391, 188, '0', 0),
(392, 189, 'updated again', 1),
(393, 190, 'sdasdasdasdasd', 1),
(394, 191, 'sdasdasdasdasdasdasdas', 1);

-- --------------------------------------------------------

--
-- Table structure for table `mock_exam_category`
--

CREATE TABLE IF NOT EXISTS `mock_exam_category` (
`category_id` int(11) NOT NULL,
  `category_name` varchar(50) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mock_exam_category`
--

INSERT INTO `mock_exam_category` (`category_id`, `category_name`, `status`, `date_created`) VALUES
(23, 'Java', 1, '2016-03-05 16:09:24'),
(24, 'Computer Networks', 1, '2016-03-05 16:09:51'),
(26, 'Python', 1, '2016-03-05 16:10:02'),
(27, 'HTML', 1, '2016-03-05 16:10:08'),
(31, 'Science', 1, '2016-03-09 09:29:18'),
(32, 'C #', 1, '2016-03-09 11:10:31'),
(33, 'English', 1, '2016-03-11 10:43:05'),
(34, 'Maths', 1, '2016-04-13 11:32:39'),
(35, 'HAG LIFE', 1, '2016-05-02 14:04:40');

-- --------------------------------------------------------

--
-- Table structure for table `mock_exam_faq`
--

CREATE TABLE IF NOT EXISTS `mock_exam_faq` (
`faq_id` int(11) NOT NULL,
  `faq_question` varchar(1024) NOT NULL,
  `faq_answer` varchar(1024) NOT NULL,
  `faq_date_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mock_exam_faq`
--

INSERT INTO `mock_exam_faq` (`faq_id`, `faq_question`, `faq_answer`, `faq_date_updated`) VALUES
(2, 'What is mockTime ?', 'ABCD', '2016-03-24 17:36:58'),
(3, 'How to active your mockTime account ?', 'After registering on mockTime, you should be getting an email about how to activate your account. Click on the link from your email and it will activate your account.', '2016-03-24 18:06:10');

-- --------------------------------------------------------

--
-- Table structure for table `mock_exam_questions`
--

CREATE TABLE IF NOT EXISTS `mock_exam_questions` (
`question_id` int(11) NOT NULL,
  `question_name` varchar(1024) NOT NULL,
  `question_type` varchar(255) NOT NULL,
  `quiz_id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=192 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mock_exam_questions`
--

INSERT INTO `mock_exam_questions` (`question_id`, `question_name`, `question_type`, `quiz_id`) VALUES
(125, 'Light behaves as a particle and a ?', 'Fill_Blank', 31),
(126, 'Explain what big O is?', 'Essay', 32),
(147, 'Choose the appropriate data type for this value: true   ', 'Multiple_Choice', 27),
(148, 'Given the declaration int [ ] nums = {8, 12, 23, 4, 15}, write an expression that will display the first element in the array (ie the number 8)', 'Essay', 27),
(149, 'Primitive datatypes are allocated on a stack', 'True_False', 27),
(150, 'What does Java stands for', 'Acronym_Answer', 27),
(151, 'If we declare int [ ] ar = {1,2,3,4,5,6}; The size of array ar is:', 'Multiple_Choice', 27),
(152, 'What does GUI stand for?', 'Acronym_Answer', 27),
(153, 'Choose the best definition of an object', 'Multiple_Choice', 27),
(154, 'What is the role of the constructor? ', 'Essay', 27),
(155, 'Which package needs to be imported so that you can accept user input?', 'Multiple_Choice', 27),
(156, 'Which Java exception should be used to handle input/output errors?', 'Multiple_Choice', 27),
(157, 'asdas', 'Essay', 27),
(158, 'sdasdas', 'Acronym_Answer', 27),
(188, 'sdasds', 'True_False', 34),
(189, 'sdasdasd', 'Essay', 34),
(190, 'sdasdasd', 'Acronym_Answer', 34),
(191, 'sdasdasdasdasdas', 'Essay', 34);

-- --------------------------------------------------------

--
-- Table structure for table `mock_exam_quiz`
--

CREATE TABLE IF NOT EXISTS `mock_exam_quiz` (
`quiz_id` int(11) NOT NULL,
  `quiz_name` varchar(255) NOT NULL,
  `quiz_category_id` int(11) NOT NULL,
  `quiz_duration` int(11) NOT NULL DEFAULT '0',
  `total_questions` int(11) NOT NULL DEFAULT '0',
  `quiz_status` int(11) NOT NULL DEFAULT '1',
  `quiz_password_required` int(1) NOT NULL DEFAULT '0',
  `quiz_secret_password` varchar(255) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `mock_exam_quiz`
--

INSERT INTO `mock_exam_quiz` (`quiz_id`, `quiz_name`, `quiz_category_id`, `quiz_duration`, `total_questions`, `quiz_status`, `quiz_password_required`, `quiz_secret_password`, `date_created`) VALUES
(27, 'Java Exam', 23, 60, 12, 1, 0, '', '2016-04-11 19:20:39'),
(31, 'science', 31, 1, 1, 1, 0, '', '2016-04-13 17:43:03'),
(32, 'Algorithms', 23, 10, 1, 1, 0, '', '2016-04-13 17:43:17'),
(34, 'test', 24, 12, 0, 1, 0, '', '2016-05-03 17:14:00');

-- --------------------------------------------------------

--
-- Table structure for table `mock_exam_student_result`
--

CREATE TABLE IF NOT EXISTS `mock_exam_student_result` (
`student_result_id` int(11) NOT NULL,
  `student_summary_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `exam_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `student_answer` varchar(255) NOT NULL DEFAULT 'not answered',
  `student_result_status` varchar(255) DEFAULT NULL,
  `difficulty_level` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=486 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mock_exam_student_result`
--

INSERT INTO `mock_exam_student_result` (`student_result_id`, `student_summary_id`, `user_id`, `exam_id`, `question_id`, `student_answer`, `student_result_status`, `difficulty_level`) VALUES
(450, 292, 71, 27, 114, '', '10', 0),
(451, 293, 71, 31, 125, 'wave', '10', 1),
(452, 294, 77, 27, 114, 'Boolean', '10', 1),
(453, 294, 77, 27, 115, '  ', '10', 2),
(454, 294, 77, 27, 116, '0', '10', 2),
(455, 294, 77, 27, 117, '', '10', 3),
(456, 294, 77, 27, 118, '', '10', 3),
(457, 294, 77, 27, 119, '', '10', 2),
(458, 294, 77, 27, 120, '', '0', 2),
(459, 294, 77, 27, 121, '  ', '0', 2),
(460, 294, 77, 27, 122, '', '0', 1),
(461, 295, 64, 31, 125, 'wave', '10', 3),
(462, 296, 64, 27, 114, 'Boolean', '10', 1),
(463, 296, 64, 27, 115, '  sdasdasd  ', '0', 3),
(464, 296, 64, 27, 116, '1', '0', 3),
(465, 297, 64, 27, 114, 'Double', '0', 1),
(466, 297, 64, 27, 115, '  ', '0', 3),
(467, 297, 64, 27, 116, '1', '0', 2),
(468, 298, 64, 27, 114, 'Boolean', '0', 1),
(469, 299, 64, 27, 114, 'Double', '0', 0),
(470, 299, 64, 27, 115, '  ', '0', 0),
(471, 299, 64, 27, 116, '0', '0', 2),
(472, 299, 64, 27, 117, '', '0', 3),
(473, 299, 64, 27, 118, '', '0', 1),
(474, 302, 64, 27, 114, 'Boolean', '0', 1),
(475, 302, 64, 27, 115, '        ', '0', 3),
(476, 302, 64, 27, 116, '1', '0', 2),
(477, 302, 64, 27, 117, 'jsjdasd', '0', 0),
(478, 302, 64, 27, 118, '6', '0', 0),
(479, 302, 64, 27, 119, 'dafdfdfdf', '0', 0),
(480, 302, 64, 27, 120, '', '0', 0),
(481, 303, 64, 27, 114, '', '0', 0),
(482, 304, 64, 32, 126, '  sadsd', '0', 0),
(483, 305, 64, 27, 147, '', '0', 0),
(484, 305, 64, 27, 148, '  ', '0', 0),
(485, 305, 64, 27, 149, '0', '0', 0);

-- --------------------------------------------------------

--
-- Table structure for table `mock_exam_student_summary`
--

CREATE TABLE IF NOT EXISTS `mock_exam_student_summary` (
`student_summary_id` int(11) NOT NULL,
  `exam_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `exam_result_status` int(11) NOT NULL DEFAULT '0',
  `time_taken` varchar(255) NOT NULL,
  `star_rating` varchar(255) DEFAULT NULL,
  `student_result` varchar(255) NOT NULL DEFAULT 'Pending',
  `exam_start_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `exam_end_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=306 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mock_exam_student_summary`
--

INSERT INTO `mock_exam_student_summary` (`student_summary_id`, `exam_id`, `user_id`, `category_id`, `exam_result_status`, `time_taken`, `star_rating`, `student_result`, `exam_start_time`, `exam_end_time`) VALUES
(292, 27, 71, 23, 1, '00:00:04', '2', '10', '2016-04-19 18:19:47', '2016-04-19 18:19:51'),
(293, 31, 71, 31, 1, '00:00:07', '5', '10', '2016-04-19 18:22:55', '2016-04-19 18:23:02'),
(294, 27, 77, 23, 1, '00:00:11', '3', '60', '2016-04-19 18:45:16', '2016-04-19 18:45:27'),
(295, 31, 64, 31, 1, '00:00:09', '5', '10', '2016-04-21 18:17:22', '2016-04-21 18:17:31'),
(296, 27, 64, 23, 1, '00:00:35', '5', '10', '2016-04-21 20:04:08', '2016-04-21 20:04:43'),
(297, 27, 64, 23, 1, '00:00:13', NULL, '0', '2016-04-25 06:57:53', '2016-04-25 06:58:06'),
(298, 27, 64, 23, 1, '00:00:07', NULL, '0', '2016-04-25 08:29:53', '2016-04-25 08:30:00'),
(299, 27, 64, 23, 1, '00:00:13', NULL, '0', '2016-04-25 08:30:54', '2016-04-25 08:31:07'),
(300, 27, 64, 23, 0, '01:00:00', NULL, 'Pending', '2016-04-25 11:40:26', '2016-04-25 12:40:26'),
(301, 27, 64, 23, 0, '01:00:00', NULL, 'Pending', '2016-04-25 13:09:15', '2016-04-25 14:09:15'),
(302, 27, 64, 23, 1, '00:00:42', NULL, '0', '2016-04-26 09:39:31', '2016-04-26 09:40:13'),
(303, 27, 64, 23, 0, '00:01:05', NULL, 'Pending', '2016-05-02 12:36:31', '2016-05-02 12:37:36'),
(304, 32, 64, 23, 0, '00:00:03', NULL, 'Pending', '2016-05-03 13:14:19', '2016-05-03 13:14:22'),
(305, 27, 64, 23, 0, '00:01:25', NULL, 'Pending', '2016-05-03 13:16:57', '2016-05-03 13:18:22');

-- --------------------------------------------------------

--
-- Table structure for table `mock_exam_users`
--

CREATE TABLE IF NOT EXISTS `mock_exam_users` (
`user_id` int(11) NOT NULL,
  `email_address` varchar(1024) NOT NULL,
  `password` varchar(32) NOT NULL,
  `first_name` varchar(32) NOT NULL,
  `last_name` varchar(32) NOT NULL,
  `email_code` varchar(32) NOT NULL,
  `lastSeen` varchar(255) DEFAULT NULL,
  `profile_picture` varchar(55) NOT NULL,
  `freeze_account` int(11) NOT NULL DEFAULT '0',
  `active_status` int(11) NOT NULL DEFAULT '0',
  `date_created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `password_recover` int(11) NOT NULL DEFAULT '0',
  `user_type` int(1) NOT NULL DEFAULT '0',
  `admin_password_check` tinyint(1) NOT NULL DEFAULT '0',
  `session_start` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=78 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mock_exam_users`
--

INSERT INTO `mock_exam_users` (`user_id`, `email_address`, `password`, `first_name`, `last_name`, `email_code`, `lastSeen`, `profile_picture`, `freeze_account`, `active_status`, `date_created`, `password_recover`, `user_type`, `admin_password_check`, `session_start`) VALUES
(64, 'jomink@yahoo.co.uk', '5f4dcc3b5aa765d61d8327deb882cf99', 'Jomin', 'George', 'ddcab504a7cb9e285dbbc2796b5a6934', '2016-05-03 18:18:52', 'images/profile/0af0ce5c4c.jpg', 0, 1, '2016-02-15 10:18:32', 0, 1, 0, 0),
(71, 'gkaitholil@yahoo.co.uk', '40d95b4e3d352ee3125684406f2f8cae', 'george', 'itty kunju', '6bb77730b25c2737b404e94aa75d485c', '2016-04-26 10:16:49', '', 0, 1, '2016-03-11 10:32:09', 0, 0, 0, 0),
(76, 'jibinkaitholil@yahoo.co.uk', '5f4dcc3b5aa765d61d8327deb882cf99', 'jibin', 'george', '00c28a5c677739cbe193010168d485d8', '2016-04-13 19:00:57', '', 0, 1, '2016-04-09 18:25:58', 0, 0, 0, 0),
(77, 'sdasdas@sdasd.com', '5f4dcc3b5aa765d61d8327deb882cf99', 'sdasd', 'casdasdasd', '', '2016-04-19 19:45:52', '', 0, 1, '2016-04-13 20:04:12', 0, 0, 0, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `mock_exam_answers`
--
ALTER TABLE `mock_exam_answers`
 ADD PRIMARY KEY (`answer_id`), ADD KEY `question_id` (`question_id`);

--
-- Indexes for table `mock_exam_category`
--
ALTER TABLE `mock_exam_category`
 ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `mock_exam_faq`
--
ALTER TABLE `mock_exam_faq`
 ADD PRIMARY KEY (`faq_id`);

--
-- Indexes for table `mock_exam_questions`
--
ALTER TABLE `mock_exam_questions`
 ADD PRIMARY KEY (`question_id`), ADD KEY `quiz_id` (`quiz_id`);

--
-- Indexes for table `mock_exam_quiz`
--
ALTER TABLE `mock_exam_quiz`
 ADD PRIMARY KEY (`quiz_id`), ADD UNIQUE KEY `quiz_name` (`quiz_name`), ADD KEY `quiz_category_id` (`quiz_category_id`);

--
-- Indexes for table `mock_exam_student_result`
--
ALTER TABLE `mock_exam_student_result`
 ADD PRIMARY KEY (`student_result_id`);

--
-- Indexes for table `mock_exam_student_summary`
--
ALTER TABLE `mock_exam_student_summary`
 ADD PRIMARY KEY (`student_summary_id`);

--
-- Indexes for table `mock_exam_users`
--
ALTER TABLE `mock_exam_users`
 ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `mock_exam_answers`
--
ALTER TABLE `mock_exam_answers`
MODIFY `answer_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=395;
--
-- AUTO_INCREMENT for table `mock_exam_category`
--
ALTER TABLE `mock_exam_category`
MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=36;
--
-- AUTO_INCREMENT for table `mock_exam_faq`
--
ALTER TABLE `mock_exam_faq`
MODIFY `faq_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `mock_exam_questions`
--
ALTER TABLE `mock_exam_questions`
MODIFY `question_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=192;
--
-- AUTO_INCREMENT for table `mock_exam_quiz`
--
ALTER TABLE `mock_exam_quiz`
MODIFY `quiz_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=35;
--
-- AUTO_INCREMENT for table `mock_exam_student_result`
--
ALTER TABLE `mock_exam_student_result`
MODIFY `student_result_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=486;
--
-- AUTO_INCREMENT for table `mock_exam_student_summary`
--
ALTER TABLE `mock_exam_student_summary`
MODIFY `student_summary_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=306;
--
-- AUTO_INCREMENT for table `mock_exam_users`
--
ALTER TABLE `mock_exam_users`
MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=78;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `mock_exam_answers`
--
ALTER TABLE `mock_exam_answers`
ADD CONSTRAINT `mock_exam_answers_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `mock_exam_questions` (`question_id`);

--
-- Constraints for table `mock_exam_questions`
--
ALTER TABLE `mock_exam_questions`
ADD CONSTRAINT `mock_exam_questions_ibfk_1` FOREIGN KEY (`quiz_id`) REFERENCES `mock_exam_quiz` (`quiz_id`);

--
-- Constraints for table `mock_exam_quiz`
--
ALTER TABLE `mock_exam_quiz`
ADD CONSTRAINT `mock_exam_quiz_ibfk_1` FOREIGN KEY (`quiz_category_id`) REFERENCES `mock_exam_category` (`category_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
