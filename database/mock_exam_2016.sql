-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 24, 2016 at 07:33 PM
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
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mock_exam_answers`
--

INSERT INTO `mock_exam_answers` (`answer_id`, `question_id`, `answer_name`, `is_true`) VALUES
(1, 1, 'A', 0),
(2, 1, 'B', 1),
(3, 1, 'C', 0),
(4, 1, 'D', 0),
(15, 6, 'RAndsdasd asdasd asd sadsdas', 1),
(16, 7, 'A', 0),
(17, 7, 'B', 1),
(18, 7, 'C', 0),
(19, 7, 'D', 0),
(20, 8, '1', 1),
(21, 9, '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `mock_exam_category`
--

CREATE TABLE IF NOT EXISTS `mock_exam_category` (
`category_id` int(11) NOT NULL,
  `category_name` varchar(50) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=latin1;

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
(33, 'English', 1, '2016-03-11 10:43:05');

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
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mock_exam_questions`
--

INSERT INTO `mock_exam_questions` (`question_id`, `question_name`, `question_type`, `quiz_id`) VALUES
(1, 'Which is the right answer', 'Multiple_Choice', 23),
(6, 'What does RAM stands for ?', 'Acronym_Answer', 24),
(7, 'Waht is the right answer ?', 'Multiple_Choice', 25),
(8, 'Is this correct ?', 'True_False', 25),
(9, 'What is TCP ???', 'Essay', 25);

-- --------------------------------------------------------

--
-- Table structure for table `mock_exam_quiz`
--

CREATE TABLE IF NOT EXISTS `mock_exam_quiz` (
`quiz_id` int(11) NOT NULL,
  `quiz_name` varchar(255) NOT NULL,
  `quiz_category_id` int(11) NOT NULL,
  `quiz_duration` int(11) NOT NULL DEFAULT '0',
  `quiz_status` int(11) NOT NULL DEFAULT '1',
  `quiz_password_required` int(1) NOT NULL DEFAULT '0',
  `quiz_secret_password` varchar(255) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `mock_exam_quiz`
--

INSERT INTO `mock_exam_quiz` (`quiz_id`, `quiz_name`, `quiz_category_id`, `quiz_duration`, `quiz_status`, `quiz_password_required`, `quiz_secret_password`, `date_created`) VALUES
(23, 'Java Exam', 23, 30, 1, 0, '', '2016-03-11 11:27:22'),
(24, 'Literacy Test', 33, 60, 1, 0, '', '2016-03-24 11:27:50'),
(25, 'Science Exam', 31, 1, 1, 0, '', '2016-03-17 20:06:56');

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
  `profile_picture` varchar(55) NOT NULL,
  `freeze_account` int(11) NOT NULL DEFAULT '0',
  `active_status` int(11) NOT NULL DEFAULT '0',
  `date_created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `password_recover` int(11) NOT NULL DEFAULT '0',
  `user_type` int(1) NOT NULL DEFAULT '0',
  `admin_password_check` tinyint(1) NOT NULL DEFAULT '0',
  `session_start` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=72 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mock_exam_users`
--

INSERT INTO `mock_exam_users` (`user_id`, `email_address`, `password`, `first_name`, `last_name`, `email_code`, `profile_picture`, `freeze_account`, `active_status`, `date_created`, `password_recover`, `user_type`, `admin_password_check`, `session_start`) VALUES
(64, 'jomink@yahoo.co.uk', '5f4dcc3b5aa765d61d8327deb882cf99', 'Jomin', 'George', 'ddcab504a7cb9e285dbbc2796b5a6934', 'images/profile/0af0ce5c4c.jpg', 0, 1, '2016-02-15 10:18:32', 0, 1, 1, 0),
(71, 'gkaitholil@yahoo.co.uk', '40d95b4e3d352ee3125684406f2f8cae', 'georgekutty', 'itty kunju', '6bb77730b25c2737b404e94aa75d485c', '', 0, 1, '2016-03-11 10:32:09', 0, 0, 0, 0);

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
MODIFY `answer_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT for table `mock_exam_category`
--
ALTER TABLE `mock_exam_category`
MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=34;
--
-- AUTO_INCREMENT for table `mock_exam_faq`
--
ALTER TABLE `mock_exam_faq`
MODIFY `faq_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `mock_exam_questions`
--
ALTER TABLE `mock_exam_questions`
MODIFY `question_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `mock_exam_quiz`
--
ALTER TABLE `mock_exam_quiz`
MODIFY `quiz_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT for table `mock_exam_users`
--
ALTER TABLE `mock_exam_users`
MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=72;
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
