-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 25, 2019 at 08:52 PM
-- Server version: 5.7.26-0ubuntu0.18.04.1
-- PHP Version: 7.3.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `umrmms`
--

-- --------------------------------------------------------

--
-- Table structure for table `checklist`
--

CREATE TABLE `checklist` (
  `ID` int(11) NOT NULL,
  `title` varchar(100) DEFAULT 'No Title',
  `time` datetime NOT NULL,
  `comment` varchar(20000) NOT NULL,
  `favourite` tinyint(1) DEFAULT '0',
  `checked` tinyint(1) DEFAULT '0',
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `checklist`
--

INSERT INTO `checklist` (`ID`, `title`, `time`, `comment`, `favourite`, `checked`, `user_id`) VALUES
(1, 'No Title', '2019-05-18 00:00:00', 'Deadline for project topic.', 1, 1, 20),
(2, 'No Title', '2019-05-20 00:00:00', 'Deadline for submission of project features', 1, 1, 20),
(3, 'jiaxiong', '2019-12-12 00:42:00', 'hahaas', 0, 0, 20),
(4, 'jiawei', '2020-12-12 00:12:00', 'aisojdoiajd', 0, 0, 20),
(5, 'qjwojq', '2019-12-12 00:12:00', 'jiasodjioajs', 0, 0, 20),
(6, 'finish assignment', '2019-12-12 12:12:00', 'ajsidojasid', 0, 1, 21),
(7, 'finish assignment again', '2019-12-21 12:12:00', 'ioasjdoajisd', 1, 1, 21);

-- --------------------------------------------------------

--
-- Table structure for table `guest`
--

CREATE TABLE `guest` (
  `ID` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `meeting_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `guest`
--

INSERT INTO `guest` (`ID`, `user_id`, `meeting_id`) VALUES
(13, 20, 7),
(14, 21, 8),
(15, 21, 9),
(16, 21, 10),
(17, 21, 11),
(18, 5, 12),
(19, 21, 13),
(20, 21, 14),
(21, 21, 15),
(22, 21, 16),
(23, 21, 17),
(24, 21, 18),
(25, 21, 19),
(26, 21, 20),
(27, 21, 21),
(28, 21, 22),
(29, 21, 23),
(30, 21, 24),
(31, 21, 25),
(32, 21, 26),
(33, 21, 27),
(34, 21, 28),
(35, 21, 29),
(36, 21, 30),
(37, 21, 31),
(38, 21, 32),
(39, 21, 33),
(40, 21, 34),
(41, 21, 35),
(42, 21, 36),
(43, 21, 37),
(44, 21, 38),
(45, 21, 39),
(46, 21, 40),
(47, 21, 41),
(48, 21, 42),
(49, 21, 43),
(50, 21, 44),
(51, 21, 45),
(52, 21, 46),
(53, 21, 47),
(54, 21, 48),
(55, 21, 51),
(56, 21, 52),
(57, 20, 51),
(58, 20, 52);

-- --------------------------------------------------------

--
-- Table structure for table `meeting`
--

CREATE TABLE `meeting` (
  `ID` int(5) NOT NULL,
  `user_id` int(8) NOT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime NOT NULL,
  `title` varchar(100) NOT NULL,
  `venue` varchar(100) NOT NULL,
  `notification` varchar(100) NOT NULL,
  `description` varchar(20000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `meeting`
--

INSERT INTO `meeting` (`ID`, `user_id`, `start_time`, `end_time`, `title`, `venue`, `notification`, `description`) VALUES
(4, 1, '2019-01-01 12:12:12', '2019-01-02 12:12:12', 'ASJDIAO', 'jiasojdoa', 'ajsidoja', 'jasiodja'),
(5, 20, '2015-12-12 00:12:00', '2015-12-12 12:12:00', '12asasj', 'MM4, FCSIT', '1', 'asldasldj'),
(7, 20, '2015-12-12 00:12:00', '2015-12-12 12:12:00', '12asasj', 'MM4, FCSIT', '1', 'asldasldj'),
(8, 20, '2015-12-14 00:12:00', '2015-12-14 12:12:00', 'jaiojdiaosjdioja', 'MM4, FCSIT', '1', 'asdoajsdoiajio'),
(9, 20, '2019-03-19 00:12:00', '2019-03-19 12:12:00', 'jiojasdo', 'MM4, FCSIT', '1', 'asjidadi'),
(47, 20, '2013-03-20 00:00:00', '2013-03-20 12:00:00', 'jaisodjiao', 'DK2, FCSIT', '1', 'asjidojasoidj'),
(48, 20, '2013-03-23 12:00:00', '2013-03-23 12:30:00', 'Minute Meeting', 'MM4, FCSIT', '1', 'jiaxiong'),
(49, 20, '2013-03-25 12:00:00', '2013-03-25 13:00:00', 'iaosjd', 'MM4, FCSIT', '1', 'jaiodjasd'),
(50, 20, '2013-03-27 12:00:00', '2013-03-27 12:30:00', 'jiaosd', 'MM4, FCSIT', '1', 'jaiosdjoa');

-- --------------------------------------------------------

--
-- Table structure for table `meeting_notes`
--

CREATE TABLE `meeting_notes` (
  `ID` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` varchar(20000) NOT NULL,
  `meeting_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `meeting_notes`
--

INSERT INTO `meeting_notes` (`ID`, `title`, `description`, `meeting_id`, `user_id`) VALUES
(1, 'Standardize the design using bootstrap', 'Make all the buttons and color consistent in the entire website.', 49, 20),
(2, 'Submit a report for your website features.', 'A report included all the features and its description provided by your website.', 49, 20),
(3, '12asasj', 'jiaxiong', 7, 21),
(4, 'jiaosd', 'jiaxiong jiaxiong', 50, 21),
(5, 'jaiojdiaosjdioja', 'jiaxiong jiaxiong jiaxiong', 8, 21),
(6, 'jiojasdo', 'jiaxiong', 9, 21),
(10, 'jaiojdiaosjdioja', 'asd', 8, 21);

-- --------------------------------------------------------

--
-- Table structure for table `report`
--

CREATE TABLE `report` (
  `ID` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `rec_id` int(11) NOT NULL,
  `name` varchar(1000) NOT NULL,
  `status` varchar(255) DEFAULT 'Pending',
  `review` varchar(20000) DEFAULT '',
  `file_path` varchar(1000) DEFAULT '',
  `review_path` varchar(1000) DEFAULT '',
  `submission_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `report`
--

INSERT INTO `report` (`ID`, `user_id`, `rec_id`, `name`, `status`, `review`, `file_path`, `review_path`, `submission_date`) VALUES
(17, 20, 21, 'jiaxiong', 'Reviewed', 'New review', 'reports/17.pdf', 'reviews/17.pdf', '2019-05-23'),
(18, 20, 21, 'kk', '', 'asdasda', 'reports/18.pdf', 'reviews/18.pdf', '2019-05-25');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `ID` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`ID`, `user_id`, `student_id`) VALUES
(1, 21, 20),
(5, 21, 8),
(8, 21, 9),
(9, 21, 13);

-- --------------------------------------------------------

--
-- Table structure for table `task`
--

CREATE TABLE `task` (
  `ID` int(11) NOT NULL,
  `task_name` varchar(255) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `percent` double NOT NULL,
  `dependencies` varchar(1000) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `task`
--

INSERT INTO `task` (`ID`, `task_name`, `start_date`, `end_date`, `percent`, `dependencies`, `user_id`) VALUES
(1, 'Choose project topic', '2019-05-16', '2019-05-17', 100, '', 170010),
(2, 'List of project features', '2019-05-18', '2019-05-19', 70, 'Choose project topic', 170010),
(8, 'Middle of Assignment', '2018-12-20', '2018-12-25', 100, '', 20);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `ID` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `full_name` varchar(1000) NOT NULL,
  `role` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`ID`, `email`, `password`, `full_name`, `role`) VALUES
(1, 'wah123@gmail.com', 'wah123wah123', 'wahwahwah', 'student'),
(2, 'xiong123@gmail.com', 'xiong123xiong123', 'xiongxiongxiong', 'supervisor'),
(3, 'asidj@oiasdj.copsad', 'ajsuidja', 'asjidoja', 'student'),
(4, 'jasiodj@jaisodj.asiod', '123123', 'asiodj', 'student'),
(5, 'cjx@gmail.com', '123123', 'cjx', 'student'),
(6, 'ajsid@jaisojd.asjdoiaj', '123123', 'jiaosjda', 'student'),
(7, 'jasiodj@jaisodj.sajidoj', '$2y$10$wXe/zMJmsMP4LvIqOq5nJOJpL0CbajBkRoYJadMhcuETW9IkF026a', 'jaisodja', 'student'),
(8, 'asjiodj@jioadj.asjdio', '$2y$10$hzQ0vIWBhOYLVtzyZNe31OA3HMa2RjRUtw0CKXTWw5Np8Z9aIXtuO', 'jaiosdj', 'student'),
(9, 'ajsi@jioadsj.ajsdioj', '$2y$10$2jXyilCVgGKPfFJ0C.s2leZcFkPLVJFML0O8NXSsTzkLrUWURXDVG', 'qweqwe', 'student'),
(10, 'ajiodj@jaisodj.asdioj', '$2y$10$OaqVtTxgd3ZJ9WfHOoZnge2gxCebTfrCmnwCDeQEyJPYUKGPvNzt6', 'werwer', 'student'),
(12, 'ljk@jisaoj.sjaid', '$2y$10$3PsbecD31EybspqqFXY8Kes66jmk8WZ7sLx1g38OHEsmqlHs483Za', 'ljk', 'student'),
(13, 'ljk@jisaoj.sjaidasd', '$2y$10$nIV4SwjvTePLiojFQgzDAuBha903ONwbWYthdsLSDnjPHhI9TDeJW', 'ajsodaiodj', 'student'),
(14, 'ljk@jisaoj.sjaidasdasd', '$2y$10$d0fNu8eb.Vmsoj9rZN9r1.Mi2UtT2pskZjBR.rF5Hx/N6jnnxQyTu', 'ajsodaiodj', 'student'),
(15, 'ljk@jisaoj.sjaid123123', '$2y$10$Ng9w2SUC.T1js1MzJmhDjuzd6OIoMFLlPpOi/m0KKTXAOLfq8zZxa', 'ajsiodj', 'student'),
(16, 'jiaodsj@jiasojd.ajisd', '$2y$10$zh3QWhkYtWHBqIDauTUM0e22LSEFDKHXBJcKIgNi7LbN/bSXDrrq2', 'asldkjalj', 'supervisor'),
(17, 'joijaiodja@iasojd.ajsidoj', '$2y$10$oYavP3z39D76lj22V7LOhuEuRf06x97n73j/we.4POHmwwwtsdnaS', 'aoidjadjl', 'student'),
(18, 'jaoisdj@jiasod.asjdio', '$2y$10$/lqHf7a50Kcu6J89eX/gHeQMFZtwrE2u.kY8dBUZfhkst8Wph6CGG', 'asjdoa', 'student'),
(19, 'chinxiongwe@hotmail.com', '$2y$10$NZolRpfigCjMM.bMIoS0XO3Z3vGY8WW/VdCeOH8RuyLMrYlMeEpCG', 'Chin Xiong Xiong', 'student'),
(20, 'chinxiongwei@hotmail.com', '$2y$10$3rZB/Onu69sd1YKzVym/XuDKQiRO2MTlsFvN9A8EzIitVi26LVol.', 'Chin Xiong Xiong', 'student'),
(21, 'chinxiongwei@yahoo.com', '$2y$10$9pmP18kkV5gYtdyiBrNZwONox.0ao5fzUbkQzvf475ovIoPoLuRom', 'Chin Xiong Xiong', 'supervisor');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `checklist`
--
ALTER TABLE `checklist`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `guest`
--
ALTER TABLE `guest`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `meeting`
--
ALTER TABLE `meeting`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `meeting_notes`
--
ALTER TABLE `meeting_notes`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `report`
--
ALTER TABLE `report`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `task`
--
ALTER TABLE `task`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `checklist`
--
ALTER TABLE `checklist`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `guest`
--
ALTER TABLE `guest`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `meeting`
--
ALTER TABLE `meeting`
  MODIFY `ID` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `meeting_notes`
--
ALTER TABLE `meeting_notes`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `report`
--
ALTER TABLE `report`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `task`
--
ALTER TABLE `task`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
