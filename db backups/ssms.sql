-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 02, 2019 at 08:01 PM
-- Server version: 10.3.15-MariaDB
-- PHP Version: 7.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ssms`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `privilege` enum('admin','principal','teacher','exam officer','bursar') NOT NULL,
  `active` enum('No','Yes') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `name`, `email`, `password`, `privilege`, `active`) VALUES
(1, 'Moses Bien', 'bienmoses@gmail.com', '5f4dcc3b5aa765d61d8327deb882cf99', 'admin', 'Yes'),
(2, 'Nwinate Bien', 'biennwinate@gmail.com', '5f4dcc3b5aa765d61d8327deb882cf99', 'bursar', 'Yes'),
(4, 'Stephen Bien', 'steve@gmail.com', '5f4dcc3b5aa765d61d8327deb882cf99', 'teacher', 'Yes'),
(5, 'Barigboma Bien', 'bg@gmail.com', '5f4dcc3b5aa765d61d8327deb882cf99', 'principal', 'Yes'),
(6, 'Daniel Bien', 'dani@gmail.com', '5f4dcc3b5aa765d61d8327deb882cf99', 'exam officer', 'Yes');

-- --------------------------------------------------------

--
-- Table structure for table `all_payments`
--

CREATE TABLE `all_payments` (
  `id` int(11) NOT NULL,
  `student_id` varchar(255) NOT NULL,
  `session_id` int(11) NOT NULL,
  `term_id` int(11) NOT NULL,
  `amount` varchar(255) NOT NULL,
  `receipt_no` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `all_payments`
--

INSERT INTO `all_payments` (`id`, `student_id`, `session_id`, `term_id`, `amount`, `receipt_no`) VALUES
(1, 'JSS3/0001', 2, 1, '10000', '0005676'),
(5, 'JSS3/0001', 1, 1, '28000', '0005677'),
(6, 'JSS3/0001', 2, 1, '10000', '0005678'),
(38, 'JSS3/0001', 2, 1, '30000', '0005679'),
(40, 'JSS3/0001', 1, 1, '32000', '0005680');

-- --------------------------------------------------------

--
-- Table structure for table `class`
--

CREATE TABLE `class` (
  `id` int(11) NOT NULL,
  `class` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `class`
--

INSERT INTO `class` (`id`, `class`) VALUES
(1, 'JSS1'),
(2, 'JSS2'),
(3, 'JSS3'),
(7, 'SS1');

-- --------------------------------------------------------

--
-- Table structure for table `grades`
--

CREATE TABLE `grades` (
  `id` int(11) NOT NULL,
  `grade` varchar(255) NOT NULL,
  `score` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `grades`
--

INSERT INTO `grades` (`id`, `grade`, `score`) VALUES
(1, 'A', '70'),
(2, 'B', '60'),
(3, 'C', '50'),
(4, 'D', '45'),
(5, 'E', '40'),
(6, 'F', '0');

-- --------------------------------------------------------

--
-- Table structure for table `parents`
--

CREATE TABLE `parents` (
  `id` int(11) NOT NULL,
  `student_id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(16) NOT NULL,
  `occupation` varchar(255) NOT NULL,
  `address` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `parents`
--

INSERT INTO `parents` (`id`, `student_id`, `name`, `phone`, `occupation`, `address`) VALUES
(1, 'JSS3/0001', 'Moses Bien', '08124079283', 'Civil Servant', 'Eneka'),
(2, 'JSS3/0002', 'Daniel Bien', '08124079283', 'Civil Servant', 'Eneka');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `student_id` varchar(255) NOT NULL,
  `session_id` int(11) NOT NULL,
  `term_id` int(11) NOT NULL,
  `amount` varchar(255) NOT NULL,
  `receipt_no` varchar(255) NOT NULL,
  `pin` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `student_id`, `session_id`, `term_id`, `amount`, `receipt_no`, `pin`) VALUES
(1, 'JSS3/0001', 2, 1, '50000', '0005679', '9'),
(16, 'JSS3/0001', 2, 1, '60000', '00056780', '2');

-- --------------------------------------------------------

--
-- Table structure for table `result_computation`
--

CREATE TABLE `result_computation` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `session_id` int(11) NOT NULL,
  `term_id` int(11) NOT NULL,
  `total` varchar(255) NOT NULL,
  `average` varchar(255) NOT NULL,
  `grade` enum('A','B','C','D','E','F') NOT NULL,
  `position` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `result_pin`
--

CREATE TABLE `result_pin` (
  `id` int(11) NOT NULL,
  `session_id` int(11) NOT NULL,
  `term_id` int(11) NOT NULL,
  `pin` varchar(255) NOT NULL,
  `pin_count` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `result_pin`
--

INSERT INTO `result_pin` (`id`, `session_id`, `term_id`, `pin`, `pin_count`) VALUES
(2, 1, 1, 'efvoi8zkwh', 6),
(9, 2, 1, 'twcfqdyg58', 6);

-- --------------------------------------------------------

--
-- Table structure for table `school_fees`
--

CREATE TABLE `school_fees` (
  `id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `session_id` int(11) NOT NULL,
  `term_id` int(11) NOT NULL,
  `amount` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `school_fees`
--

INSERT INTO `school_fees` (`id`, `class_id`, `session_id`, `term_id`, `amount`) VALUES
(1, 3, 2, 1, '50000'),
(7, 2, 2, 1, '55000'),
(8, 3, 1, 1, '60000');

-- --------------------------------------------------------

--
-- Table structure for table `session`
--

CREATE TABLE `session` (
  `id` int(11) NOT NULL,
  `session` varchar(255) NOT NULL,
  `current_session` enum('*','-') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `session`
--

INSERT INTO `session` (`id`, `session`, `current_session`) VALUES
(1, '2018/2019', '-'),
(2, '2019/2020', '*'),
(3, '2020/2021', '-'),
(4, '2021/2022', '-');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `adm_id` varchar(255) NOT NULL,
  `class_id` int(11) NOT NULL,
  `passport` varchar(255) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `mname` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `gender` varchar(8) NOT NULL,
  `dob` date NOT NULL,
  `pnum` varchar(20) NOT NULL,
  `sor` varchar(255) NOT NULL,
  `lga` varchar(255) NOT NULL,
  `med_con` enum('no','yes') NOT NULL,
  `med_con_det` longtext NOT NULL,
  `r_address` longtext NOT NULL,
  `religion` varchar(255) NOT NULL,
  `pcode` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `reg_date` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `adm_id`, `class_id`, `passport`, `fname`, `mname`, `lname`, `gender`, `dob`, `pnum`, `sor`, `lga`, `med_con`, `med_con_det`, `r_address`, `religion`, `pcode`, `token`, `reg_date`) VALUES
(1, 'JSS3/0001', 3, './data/student_pics/JSS3-0001/2019-11-21/L7uGa5nINz/2019-11-21_IMG-20180821-113736-5-1535340322676.jpg', 'Nwinate', 'Moses', 'Bien', 'Male', '2008-08-06', '08124079283', 'Cross-Rivers State', 'Ogoja', 'no', '', 'No 59c Rumuagholu', 'christian', 'd7e3f3980e4b5593f3becf868c16633c', '1uan08tq5s', '2019-10-20'),
(2, 'JSS3/0002', 3, './data/student_pics/JSS3-0002/2019-10-23/0CZubO1f2c/2019-10-23_12801-dragon-ball-z-wallpaper-1920x1200-retina.jpg', 'Barielnen', 'Daniel', 'Bien', 'Male', '2008-08-06', '08124079283', 'Cross-Rivers State', 'Ogoja', 'no', '', 'Eneka', 'christian', 'd7e3f3980e4b5593f3becf868c16633c', '', '2019-10-20');

-- --------------------------------------------------------

--
-- Table structure for table `student_passports`
--

CREATE TABLE `student_passports` (
  `id` int(11) NOT NULL,
  `student_id` varchar(255) NOT NULL,
  `passport` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `student_passports`
--

INSERT INTO `student_passports` (`id`, `student_id`, `passport`) VALUES
(1, 'JSS3/0001', './data/student_pics/JSS3-0001/2019-10-23/Zb3LJsu5Eh/2019-10-23_IMG-20180821-113736-5-1535340322676.jpg'),
(2, 'JSS3/0002', './data/student_pics/JSS3-0002/2019-10-23/0CZubO1f2c/2019-10-23_12801-dragon-ball-z-wallpaper-1920x1200-retina.jpg'),
(10, 'JSS3/0001', './data/student_pics/JSS3-0001/2019-11-18/Agizk9IQUN/2019-11-18_7957a15ac9ab7c09e9d9dc413b22ab9f.jpg'),
(11, 'JSS3/0001', './data/student_pics/JSS3-0001/2019-11-18/zumxW4OBb0/2019-11-18_IMG-20180821-113736-5-1535340322676.jpg'),
(12, 'JSS3/0001', './data/student_pics/JSS3-0001/2019-11-21/aZ3oxrN0ID/2019-11-21_7957a15ac9ab7c09e9d9dc413b22ab9f.jpg'),
(13, 'JSS3/0001', './data/student_pics/JSS3-0001/2019-11-21/L7uGa5nINz/2019-11-21_IMG-20180821-113736-5-1535340322676.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `student_results`
--

CREATE TABLE `student_results` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `session_id` int(11) NOT NULL,
  `term_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `CA1_score` varchar(255) NOT NULL,
  `CA2_score` varchar(255) NOT NULL,
  `exam_score` varchar(255) NOT NULL,
  `total` varchar(255) NOT NULL,
  `grade_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `student_results`
--

INSERT INTO `student_results` (`id`, `student_id`, `class_id`, `session_id`, `term_id`, `subject_id`, `CA1_score`, `CA2_score`, `exam_score`, `total`, `grade_id`) VALUES
(1, 1, 3, 2, 1, 1, '20', '18', '50', '88', 1),
(2, 2, 3, 2, 1, 1, '18', '20', '60', '98', 1),
(3, 1, 3, 2, 1, 2, '10', '18', '50', '78', 1);

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `session_id` int(11) NOT NULL,
  `term_id` int(11) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `teacher(s)` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`id`, `class_id`, `session_id`, `term_id`, `subject`, `teacher(s)`) VALUES
(1, 3, 2, 1, 'Mathematics', ''),
(2, 3, 2, 1, 'English Language', ''),
(3, 3, 1, 2, 'Basic Science', '');

-- --------------------------------------------------------

--
-- Table structure for table `term`
--

CREATE TABLE `term` (
  `id` int(11) NOT NULL,
  `term` varchar(255) NOT NULL,
  `current_term` enum('*','-') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `term`
--

INSERT INTO `term` (`id`, `term`, `current_term`) VALUES
(1, 'First Term', '*'),
(2, 'Second Term', '-'),
(3, 'Third Term', '-');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `all_payments`
--
ALTER TABLE `all_payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `PAYMENTS_SESSION_FK` (`session_id`),
  ADD KEY `PAYMENTS_STUDENT_FK` (`student_id`),
  ADD KEY `PAYMENTS_TERM_FK` (`term_id`);

--
-- Indexes for table `class`
--
ALTER TABLE `class`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `grades`
--
ALTER TABLE `grades`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `parents`
--
ALTER TABLE `parents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `PARENT_STUDENT_FK` (`student_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `PAYMENTS_SESSION_FK` (`session_id`),
  ADD KEY `PAYMENTS_STUDENT_FK` (`student_id`),
  ADD KEY `PAYMENTS_TERM_FK` (`term_id`);

--
-- Indexes for table `result_computation`
--
ALTER TABLE `result_computation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `result_pin`
--
ALTER TABLE `result_pin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `school_fees`
--
ALTER TABLE `school_fees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `session`
--
ALTER TABLE `session`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD KEY `adm_id` (`adm_id`),
  ADD KEY `STUDENT_CLASS_FK` (`class_id`);

--
-- Indexes for table `student_passports`
--
ALTER TABLE `student_passports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `PASSPORTS_STUDENTS_FK` (`student_id`);

--
-- Indexes for table `student_results`
--
ALTER TABLE `student_results`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `term`
--
ALTER TABLE `term`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `all_payments`
--
ALTER TABLE `all_payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `class`
--
ALTER TABLE `class`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `grades`
--
ALTER TABLE `grades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `parents`
--
ALTER TABLE `parents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `result_computation`
--
ALTER TABLE `result_computation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `result_pin`
--
ALTER TABLE `result_pin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `school_fees`
--
ALTER TABLE `school_fees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `session`
--
ALTER TABLE `session`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `student_passports`
--
ALTER TABLE `student_passports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `student_results`
--
ALTER TABLE `student_results`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `term`
--
ALTER TABLE `term`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `parents`
--
ALTER TABLE `parents`
  ADD CONSTRAINT `PARENT_STUDENT_FK` FOREIGN KEY (`student_id`) REFERENCES `students` (`adm_id`);

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `PAYMENTS_SESSION_FK` FOREIGN KEY (`session_id`) REFERENCES `session` (`id`),
  ADD CONSTRAINT `PAYMENTS_STUDENT_FK` FOREIGN KEY (`student_id`) REFERENCES `students` (`adm_id`),
  ADD CONSTRAINT `PAYMENTS_TERM_FK` FOREIGN KEY (`term_id`) REFERENCES `term` (`id`);

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `STUDENT_CLASS_FK` FOREIGN KEY (`class_id`) REFERENCES `class` (`id`);

--
-- Constraints for table `student_passports`
--
ALTER TABLE `student_passports`
  ADD CONSTRAINT `PASSPORTS_STUDENTS_FK` FOREIGN KEY (`student_id`) REFERENCES `students` (`adm_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
