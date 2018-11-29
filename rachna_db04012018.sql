-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 04, 2018 at 03:57 PM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 7.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rachna_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `t_attendances`
--

CREATE TABLE `t_attendances` (
  `att_id` int(15) NOT NULL,
  `student_id` int(4) NOT NULL,
  `room_id` int(4) NOT NULL,
  `att_date` datetime NOT NULL,
  `approve_by` int(4) NOT NULL,
  `att_type` int(11) NOT NULL,
  `reason` varchar(150) NOT NULL,
  `register_user` tinyint(4) NOT NULL,
  `register_date` datetime NOT NULL,
  `update_user` tinyint(4) NOT NULL,
  `update_date` datetime NOT NULL,
  `del_flag` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `t_certificates`
--

CREATE TABLE `t_certificates` (
  `cert_id` int(15) NOT NULL,
  `student_id` int(15) NOT NULL,
  `cert_type` int(4) NOT NULL DEFAULT '1',
  `level` varchar(150) NOT NULL,
  `level_id` int(11) NOT NULL,
  `score` float NOT NULL,
  `grade` varchar(25) NOT NULL,
  `date` datetime NOT NULL,
  `issus_date` datetime NOT NULL,
  `no` varchar(150) NOT NULL,
  `detail` varchar(250) NOT NULL,
  `type_month` int(11) NOT NULL,
  `month` int(11) NOT NULL,
  `year` int(11) NOT NULL,
  `register_user` int(150) NOT NULL,
  `register_date` datetime NOT NULL,
  `update_user` int(150) NOT NULL,
  `update_date` datetime NOT NULL,
  `del_flag` int(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `t_classes`
--

CREATE TABLE `t_classes` (
  `class_id` int(7) NOT NULL,
  `class_name` varchar(150) NOT NULL,
  `teacher_name` varchar(100) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `level_id` tinyint(3) NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `time_shift` tinyint(3) DEFAULT NULL,
  `register_user` tinyint(7) NOT NULL,
  `register_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `update_user` tinyint(7) NOT NULL,
  `update_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `del_flag` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `t_courses`
--

CREATE TABLE `t_courses` (
  `course_id` int(7) NOT NULL,
  `course_name` varchar(150) NOT NULL,
  `duration` tinyint(3) DEFAULT NULL,
  `register_user` int(7) DEFAULT NULL,
  `register_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `update_user` int(7) DEFAULT NULL,
  `update_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `del_flag` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `t_emergency`
--

CREATE TABLE `t_emergency` (
  `emergency_id` int(10) NOT NULL,
  `student_id` int(10) NOT NULL,
  `emergency_name` varchar(150) DEFAULT NULL,
  `age` tinyint(3) DEFAULT NULL,
  `relationship` tinyint(3) DEFAULT NULL,
  `position` varchar(150) DEFAULT NULL,
  `contact_number` varchar(15) DEFAULT NULL,
  `address` varchar(300) DEFAULT NULL,
  `register_user` int(7) NOT NULL,
  `register_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `update_user` int(7) NOT NULL,
  `update_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `del_flag` tinyint(7) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `t_exam`
--

CREATE TABLE `t_exam` (
  `exam_id` int(7) NOT NULL,
  `exam_name` varchar(150) NOT NULL,
  `exam_month` int(11) NOT NULL,
  `exam_year` int(11) NOT NULL,
  `description` text NOT NULL,
  `register_user` int(11) NOT NULL,
  `register_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `update_user` tinyint(7) NOT NULL,
  `update_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `del_flag` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `t_exam_marks`
--

CREATE TABLE `t_exam_marks` (
  `mark_id` int(7) NOT NULL,
  `student_id` int(10) NOT NULL,
  `room_id` int(11) DEFAULT NULL,
  `exam_id` int(10) NOT NULL,
  `absence_a` int(10) DEFAULT NULL,
  `absence_p` int(10) DEFAULT NULL,
  `home_work` float DEFAULT NULL,
  `class_work` float DEFAULT NULL,
  `quiz1` float DEFAULT NULL,
  `quiz2` float DEFAULT NULL,
  `quiz3` float DEFAULT NULL,
  `final_exam` float DEFAULT NULL,
  `total` float DEFAULT NULL,
  `register_user` int(7) NOT NULL,
  `register_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_user` int(11) NOT NULL,
  `update_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `del_flag` tinyint(7) DEFAULT '0',
  `leave_flag` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `t_invoice`
--

CREATE TABLE `t_invoice` (
  `invoice_id` int(6) NOT NULL,
  `invoice_number` varchar(150) DEFAULT '0000',
  `student_id` int(10) NOT NULL,
  `class_name` varchar(150) DEFAULT NULL,
  `duration` int(3) DEFAULT NULL,
  `level` varchar(150) DEFAULT NULL,
  `time_shift` tinyint(3) DEFAULT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `fee` double DEFAULT NULL,
  `invoice_date` datetime DEFAULT NULL,
  `enroll_date` datetime DEFAULT NULL,
  `expire_paymentdate` datetime DEFAULT NULL,
  `receptionist` varchar(150) DEFAULT NULL,
  `register_user` int(7) NOT NULL,
  `register_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `update_user` int(7) NOT NULL,
  `update_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `del_flag` tinyint(7) DEFAULT '0',
  `start_new` datetime DEFAULT NULL,
  `expire_new` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `t_leave_students`
--

CREATE TABLE `t_leave_students` (
  `leave_id` tinyint(7) NOT NULL,
  `student_id` tinyint(7) NOT NULL,
  `leave_date` datetime NOT NULL,
  `back_date` datetime NOT NULL,
  `leave_type` int(11) NOT NULL,
  `register_date` datetime NOT NULL,
  `register_user` tinyint(7) NOT NULL,
  `update_date` datetime NOT NULL,
  `update_user` tinyint(7) NOT NULL,
  `del_flag` tinyint(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `t_level`
--

CREATE TABLE `t_level` (
  `level_id` tinyint(3) NOT NULL,
  `level_name` varchar(150) DEFAULT NULL,
  `register_user` tinyint(7) NOT NULL,
  `register_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `update_user` tinyint(7) NOT NULL,
  `update_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `del_flag` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `t_nationality`
--

CREATE TABLE `t_nationality` (
  `nationality_id` int(4) NOT NULL,
  `nationality_name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `t_parents`
--

CREATE TABLE `t_parents` (
  `parent_id` int(10) NOT NULL,
  `student_id` int(10) NOT NULL,
  `parent_name` varchar(150) DEFAULT NULL,
  `relationship` tinyint(3) DEFAULT NULL,
  `position` varchar(150) DEFAULT NULL,
  `contact_number` varchar(15) DEFAULT NULL,
  `nationality` varchar(100) DEFAULT NULL,
  `address` varchar(300) DEFAULT NULL,
  `register_user` int(7) NOT NULL,
  `register_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `update_user` int(7) NOT NULL,
  `update_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `del_flag` tinyint(7) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `t_rank`
--

CREATE TABLE `t_rank` (
  `rank_id` int(7) NOT NULL,
  `rank_name` varchar(150) CHARACTER SET utf8 NOT NULL,
  `year` int(11) NOT NULL,
  `description` varchar(500) CHARACTER SET utf8 NOT NULL DEFAULT 'No Description',
  `register_user` int(11) NOT NULL,
  `register_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `update_user` int(11) NOT NULL,
  `update_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `del_flag` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `t_relationship`
--

CREATE TABLE `t_relationship` (
  `relationship_id` tinyint(3) NOT NULL,
  `relationship_name` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `t_report`
--

CREATE TABLE `t_report` (
  `report_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `mark_id` int(11) NOT NULL,
  `attentiveness` int(11) NOT NULL,
  `discipline` int(11) NOT NULL,
  `reading` int(11) NOT NULL,
  `writing` int(11) NOT NULL,
  `speaking` int(11) NOT NULL,
  `listening` int(11) NOT NULL,
  `memory` int(11) NOT NULL,
  `rank` int(125) NOT NULL,
  `stu_total` int(125) NOT NULL,
  `result_last` int(125) NOT NULL,
  `register_user` int(11) NOT NULL,
  `register_Date` datetime NOT NULL,
  `update_user` int(11) NOT NULL,
  `update_date` datetime NOT NULL,
  `del_flag` int(11) NOT NULL,
  `att` int(11) NOT NULL,
  `homework` int(11) NOT NULL,
  `classwork` int(11) NOT NULL,
  `q1` int(11) NOT NULL,
  `q2` int(11) NOT NULL,
  `q3` int(11) NOT NULL,
  `final` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `t_settings`
--

CREATE TABLE `t_settings` (
  `id` int(15) NOT NULL,
  `school_name_en` varchar(150) CHARACTER SET utf8 NOT NULL,
  `school_name_kh` varchar(150) CHARACTER SET utf8 NOT NULL,
  `phone_number` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `website` varchar(200) NOT NULL,
  `address` varchar(200) CHARACTER SET utf8 NOT NULL,
  `logo` varchar(100) NOT NULL,
  `register_user` int(11) NOT NULL,
  `register_date` datetime NOT NULL,
  `update_user` int(11) NOT NULL,
  `update_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `t_students`
--

CREATE TABLE `t_students` (
  `student_id` int(10) NOT NULL,
  `student_name` varchar(100) NOT NULL,
  `latin_name` varchar(100) NOT NULL,
  `student_no` varchar(20) NOT NULL,
  `class_id` int(7) DEFAULT NULL,
  `duration` int(3) DEFAULT NULL,
  `gender` tinyint(1) DEFAULT NULL,
  `dob` datetime DEFAULT NULL,
  `birth_place` varchar(300) DEFAULT NULL,
  `religion` varchar(30) DEFAULT NULL,
  `nationality` varchar(100) DEFAULT NULL,
  `address` varchar(300) DEFAULT NULL,
  `enroll_date` datetime DEFAULT NULL,
  `switch_time` tinyint(3) DEFAULT NULL,
  `fee` double DEFAULT NULL,
  `paid` tinyint(1) DEFAULT '0',
  `leave_flag` tinyint(1) DEFAULT '0',
  `expire_paymentdate` datetime DEFAULT NULL,
  `payment_date` datetime DEFAULT NULL,
  `paid_date` datetime DEFAULT NULL,
  `leave_date` datetime DEFAULT NULL,
  `register_user` int(7) NOT NULL,
  `register_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `update_user` int(7) NOT NULL,
  `update_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `del_flag` tinyint(4) NOT NULL DEFAULT '0',
  `photo` varchar(100) DEFAULT 'no-img.png',
  `start_new` datetime DEFAULT NULL,
  `expire_new` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `t_users`
--

CREATE TABLE `t_users` (
  `user_id` int(7) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(256) NOT NULL,
  `role` varchar(30) DEFAULT NULL,
  `register_user` tinyint(7) DEFAULT NULL,
  `register_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `update_user` tinyint(7) DEFAULT NULL,
  `update_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `del_flag` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `t_attendances`
--
ALTER TABLE `t_attendances`
  ADD PRIMARY KEY (`att_id`);

--
-- Indexes for table `t_certificates`
--
ALTER TABLE `t_certificates`
  ADD PRIMARY KEY (`cert_id`);

--
-- Indexes for table `t_classes`
--
ALTER TABLE `t_classes`
  ADD PRIMARY KEY (`class_id`),
  ADD KEY `level_id` (`level_id`);

--
-- Indexes for table `t_courses`
--
ALTER TABLE `t_courses`
  ADD PRIMARY KEY (`course_id`);

--
-- Indexes for table `t_emergency`
--
ALTER TABLE `t_emergency`
  ADD PRIMARY KEY (`emergency_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `t_exam`
--
ALTER TABLE `t_exam`
  ADD PRIMARY KEY (`exam_id`);

--
-- Indexes for table `t_exam_marks`
--
ALTER TABLE `t_exam_marks`
  ADD PRIMARY KEY (`mark_id`);

--
-- Indexes for table `t_invoice`
--
ALTER TABLE `t_invoice`
  ADD PRIMARY KEY (`invoice_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `t_leave_students`
--
ALTER TABLE `t_leave_students`
  ADD PRIMARY KEY (`leave_id`);

--
-- Indexes for table `t_level`
--
ALTER TABLE `t_level`
  ADD PRIMARY KEY (`level_id`);

--
-- Indexes for table `t_nationality`
--
ALTER TABLE `t_nationality`
  ADD PRIMARY KEY (`nationality_id`);

--
-- Indexes for table `t_parents`
--
ALTER TABLE `t_parents`
  ADD PRIMARY KEY (`parent_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `t_rank`
--
ALTER TABLE `t_rank`
  ADD PRIMARY KEY (`rank_id`);

--
-- Indexes for table `t_relationship`
--
ALTER TABLE `t_relationship`
  ADD PRIMARY KEY (`relationship_id`);

--
-- Indexes for table `t_report`
--
ALTER TABLE `t_report`
  ADD PRIMARY KEY (`report_id`);

--
-- Indexes for table `t_settings`
--
ALTER TABLE `t_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_students`
--
ALTER TABLE `t_students`
  ADD PRIMARY KEY (`student_id`),
  ADD KEY `class_id` (`class_id`);

--
-- Indexes for table `t_users`
--
ALTER TABLE `t_users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `t_attendances`
--
ALTER TABLE `t_attendances`
  MODIFY `att_id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT for table `t_certificates`
--
ALTER TABLE `t_certificates`
  MODIFY `cert_id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;
--
-- AUTO_INCREMENT for table `t_classes`
--
ALTER TABLE `t_classes`
  MODIFY `class_id` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT for table `t_courses`
--
ALTER TABLE `t_courses`
  MODIFY `course_id` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `t_emergency`
--
ALTER TABLE `t_emergency`
  MODIFY `emergency_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=295;
--
-- AUTO_INCREMENT for table `t_exam`
--
ALTER TABLE `t_exam`
  MODIFY `exam_id` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;
--
-- AUTO_INCREMENT for table `t_exam_marks`
--
ALTER TABLE `t_exam_marks`
  MODIFY `mark_id` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1002;
--
-- AUTO_INCREMENT for table `t_invoice`
--
ALTER TABLE `t_invoice`
  MODIFY `invoice_id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=413;
--
-- AUTO_INCREMENT for table `t_leave_students`
--
ALTER TABLE `t_leave_students`
  MODIFY `leave_id` tinyint(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
--
-- AUTO_INCREMENT for table `t_level`
--
ALTER TABLE `t_level`
  MODIFY `level_id` tinyint(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `t_nationality`
--
ALTER TABLE `t_nationality`
  MODIFY `nationality_id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=192;
--
-- AUTO_INCREMENT for table `t_parents`
--
ALTER TABLE `t_parents`
  MODIFY `parent_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=169;
--
-- AUTO_INCREMENT for table `t_rank`
--
ALTER TABLE `t_rank`
  MODIFY `rank_id` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `t_relationship`
--
ALTER TABLE `t_relationship`
  MODIFY `relationship_id` tinyint(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `t_report`
--
ALTER TABLE `t_report`
  MODIFY `report_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `t_settings`
--
ALTER TABLE `t_settings`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `t_students`
--
ALTER TABLE `t_students`
  MODIFY `student_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=295;
--
-- AUTO_INCREMENT for table `t_users`
--
ALTER TABLE `t_users`
  MODIFY `user_id` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
