-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 07, 2016 at 09:04 PM
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
) ENGINE=InnoDB AUTO_INCREMENT=1113 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mock_exam_answers`
--

INSERT INTO `mock_exam_answers` (`answer_id`, `question_id`, `answer_name`, `is_true`) VALUES
(1107, 58, 'JUICY', 1),
(1108, 59, 'a', 1),
(1109, 59, 'b', 1),
(1110, 59, 'c', 1),
(1111, 59, 'd', 1),
(1112, 60, 'HAG', 1);

-- --------------------------------------------------------

--
-- Table structure for table `mock_exam_category`
--

CREATE TABLE IF NOT EXISTS `mock_exam_category` (
`category_id` int(11) NOT NULL,
  `category_name` varchar(50) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mock_exam_category`
--

INSERT INTO `mock_exam_category` (`category_id`, `category_name`, `status`, `date_created`) VALUES
(23, 'Java', 1, '2016-03-05 16:09:24'),
(24, 'Computer Networks', 0, '2016-03-05 16:09:51'),
(25, 'Maths', 1, '2016-03-05 16:09:59'),
(26, 'Python', 1, '2016-03-05 16:10:02'),
(27, 'HTML', 1, '2016-03-05 16:10:08'),
(29, 'Marie', 0, '2016-03-07 15:32:17');

-- --------------------------------------------------------

--
-- Table structure for table `mock_exam_questions`
--

CREATE TABLE IF NOT EXISTS `mock_exam_questions` (
`question_id` int(11) NOT NULL,
  `question_name` varchar(1024) NOT NULL,
  `question_type` varchar(255) NOT NULL,
  `quiz_id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mock_exam_questions`
--

INSERT INTO `mock_exam_questions` (`question_id`, `question_name`, `question_type`, `quiz_id`) VALUES
(58, 'Marie', 'Essay', 5),
(59, 'JUICUIEST IS', 'Multiple_Choice', 5),
(60, 'MARIEEEE2', '', 5);

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
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `mock_exam_quiz`
--

INSERT INTO `mock_exam_quiz` (`quiz_id`, `quiz_name`, `quiz_category_id`, `quiz_duration`, `quiz_status`, `date_created`) VALUES
(5, 'MARIES PUSSY', 26, 54, 1, '2016-03-07 11:33:24'),
(6, 'Java final exam', 29, 78, 0, '2016-03-07 11:55:10');

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
) ENGINE=InnoDB AUTO_INCREMENT=70 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mock_exam_users`
--

INSERT INTO `mock_exam_users` (`user_id`, `email_address`, `password`, `first_name`, `last_name`, `email_code`, `profile_picture`, `freeze_account`, `active_status`, `date_created`, `password_recover`, `user_type`, `admin_password_check`, `session_start`) VALUES
(64, 'jomink@yahoo.co.uk', '5f4dcc3b5aa765d61d8327deb882cf99', 'Jomin', 'George', 'ddcab504a7cb9e285dbbc2796b5a6934', 'images/profile/0af0ce5c4c.jpg', 0, 1, '2016-02-15 10:18:32', 0, 1, 1, 0),
(69, 'sdasdas', 'asdasd', 'asda', 'sdasd', 'asdas', '', 1, 1, '2016-02-26 13:08:10', 0, 0, 0, 0);

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
MODIFY `answer_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1113;
--
-- AUTO_INCREMENT for table `mock_exam_category`
--
ALTER TABLE `mock_exam_category`
MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=30;
--
-- AUTO_INCREMENT for table `mock_exam_questions`
--
ALTER TABLE `mock_exam_questions`
MODIFY `question_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=61;
--
-- AUTO_INCREMENT for table `mock_exam_quiz`
--
ALTER TABLE `mock_exam_quiz`
MODIFY `quiz_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `mock_exam_users`
--
ALTER TABLE `mock_exam_users`
MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=70;
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
