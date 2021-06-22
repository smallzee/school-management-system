-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 22, 2021 at 04:11 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.3.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `web_fpe_school_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `ch_admin`
--

CREATE TABLE `ch_admin` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `role` int(11) NOT NULL,
  `fname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(11) NOT NULL,
  `password` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ch_admin`
--

INSERT INTO `ch_admin` (`id`, `username`, `role`, `fname`, `email`, `phone`, `password`, `created_at`) VALUES
(1, 'admin', 1, 'Mrs Dolapo', 'nafeesat@gmail.com', '07087182218', 'password', '2020-12-21 13:26:43'),
(2, 'staff0001', 2, 'Mr akeem adewale adekunle', 'akeem@gmail.com', '09078237622', 'staff0001', '2020-12-21 15:36:30'),
(3, 'staff0002', 2, 'mr hammed', 'hammed@gmail.com', '08156221212', 'staff0002', '2021-04-05 11:37:52');

-- --------------------------------------------------------

--
-- Table structure for table `ch_attendance`
--

CREATE TABLE `ch_attendance` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `attendance` enum('present','absent','left') NOT NULL,
  `attendance_date` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ch_attendance`
--

INSERT INTO `ch_attendance` (`id`, `student_id`, `attendance`, `attendance_date`) VALUES
(1, 1, 'present', '2021-04-05'),
(2, 2, 'present', '2021-04-05');

-- --------------------------------------------------------

--
-- Table structure for table `ch_class`
--

CREATE TABLE `ch_class` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `school_fee` double NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ch_class`
--

INSERT INTO `ch_class` (`id`, `name`, `school_fee`, `created_at`) VALUES
(1, 'primary two', 10000, '2020-12-21 15:00:29'),
(2, 'primary one', 15000, '2020-12-21 15:00:47'),
(3, 'primary three', 20000, '2021-04-05 11:41:44');

-- --------------------------------------------------------

--
-- Table structure for table `ch_class_teacher`
--

CREATE TABLE `ch_class_teacher` (
  `id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `term` int(11) NOT NULL,
  `session` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ch_class_teacher`
--

INSERT INTO `ch_class_teacher` (`id`, `staff_id`, `class_id`, `term`, `session`) VALUES
(1, 2, 1, 1, '2019-2020'),
(2, 3, 3, 1, '2020-2021');

-- --------------------------------------------------------

--
-- Table structure for table `ch_offering_subjects`
--

CREATE TABLE `ch_offering_subjects` (
  `id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ch_offering_subjects`
--

INSERT INTO `ch_offering_subjects` (`id`, `class_id`, `subject_id`, `created_at`) VALUES
(1, 1, 1, '2021-01-29 12:03:37'),
(2, 1, 2, '2021-01-29 12:06:57'),
(3, 2, 2, '2021-04-05 11:39:10'),
(4, 2, 1, '2021-04-05 11:39:20'),
(5, 3, 1, '2021-04-05 12:15:03');

-- --------------------------------------------------------

--
-- Table structure for table `ch_parents`
--

CREATE TABLE `ch_parents` (
  `id` int(11) NOT NULL,
  `image` text NOT NULL,
  `parent_id` varchar(100) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `fname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `gender` enum('male','female') NOT NULL DEFAULT 'male',
  `occupation` varchar(100) NOT NULL,
  `school_fee_deduction` varchar(10) DEFAULT NULL,
  `address` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ch_parents`
--

INSERT INTO `ch_parents` (`id`, `image`, `parent_id`, `password`, `fname`, `email`, `phone`, `gender`, `occupation`, `school_fee_deduction`, `address`, `created_at`) VALUES
(1, '', '00001', '00001', 'ibrahim salmon', 'ibrahimsalmanofficial@gmail.com', '09011461962', 'male', 'fpe staff', 'Yes', 'Monatan', '2020-12-22 10:01:56'),
(2, '', '00002', '00002', 'Olayode Philips Adisha', '', '09092992122', 'male', 'trader', '', 'okeola', '2020-12-22 10:05:04'),
(3, '1617623109wp1979483.jpg', '00003', '00003', 'mrs dolapo', 'dolapo@gmail.com', '08148019567', 'female', 'civil servant', 'No', 'federal polytechnic ede', '2021-04-05 11:45:09');

-- --------------------------------------------------------

--
-- Table structure for table `ch_payment`
--

CREATE TABLE `ch_payment` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `amount` double NOT NULL,
  `class_id` int(11) NOT NULL,
  `term_id` int(11) NOT NULL,
  `ref` text NOT NULL,
  `academic_session` varchar(500) NOT NULL,
  `status` enum('successful') NOT NULL DEFAULT 'successful',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `paid_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ch_payment`
--

INSERT INTO `ch_payment` (`id`, `student_id`, `amount`, `class_id`, `term_id`, `ref`, `academic_session`, `status`, `created_at`, `paid_at`) VALUES
(1, 1, 10000, 1, 1, '606ab77c5f2c9', '2020-2021', 'successful', '2021-04-05 07:08:44', '2021-04-05 07:08:44');

-- --------------------------------------------------------

--
-- Table structure for table `ch_results`
--

CREATE TABLE `ch_results` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `score` double NOT NULL,
  `term` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `academic_session` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ch_results`
--

INSERT INTO `ch_results` (`id`, `student_id`, `subject_id`, `score`, `term`, `class_id`, `academic_session`, `created_at`) VALUES
(1, 1, 3, 50, 1, 2, '2020-2021', '2021-06-22 13:37:08'),
(2, 1, 4, 40, 1, 2, '2020-2021', '2021-06-22 13:37:08');

-- --------------------------------------------------------

--
-- Table structure for table `ch_role`
--

CREATE TABLE `ch_role` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ch_role`
--

INSERT INTO `ch_role` (`id`, `name`) VALUES
(1, 'admin'),
(2, 'staff'),
(3, 'student');

-- --------------------------------------------------------

--
-- Table structure for table `ch_students`
--

CREATE TABLE `ch_students` (
  `id` int(11) NOT NULL,
  `image` text NOT NULL,
  `application_id` varchar(100) NOT NULL DEFAULT '0',
  `password` varchar(100) DEFAULT NULL,
  `parent_id` int(11) NOT NULL,
  `fname` varchar(150) NOT NULL,
  `class_id` int(11) NOT NULL,
  `term` int(11) NOT NULL,
  `academic_session` varchar(100) NOT NULL,
  `gender` enum('male','female') NOT NULL DEFAULT 'male',
  `birth` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ch_students`
--

INSERT INTO `ch_students` (`id`, `image`, `application_id`, `password`, `parent_id`, `fname`, `class_id`, `term`, `academic_session`, `gender`, `birth`, `created_at`) VALUES
(1, '1617623841anonymus-quote-2560x1440.jpg', '00001', '00001', 3, 'dolapo jamal', 2, 1, '2020-2021', 'male', '2020-10-05', '2021-04-05 11:57:21'),
(2, '1617624779981571-free-download-apple-logo-hd-wallpaper-1920x1080-mac.jpg', '00002', '00002', 3, 'akeem mutmaeenat', 3, 1, '2020-2021', 'female', '2020-12-07', '2021-04-05 12:12:59');

-- --------------------------------------------------------

--
-- Table structure for table `ch_student_position`
--

CREATE TABLE `ch_student_position` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `term` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `academic_session` varchar(50) NOT NULL,
  `position` text NOT NULL,
  `comment` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ch_student_position`
--

INSERT INTO `ch_student_position` (`id`, `student_id`, `term`, `class_id`, `academic_session`, `position`, `comment`, `created_at`) VALUES
(1, 1, 1, 2, '2020-2021', '1st', 'good boy', '2021-06-22 13:37:08');

-- --------------------------------------------------------

--
-- Table structure for table `ch_subjects`
--

CREATE TABLE `ch_subjects` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ch_subjects`
--

INSERT INTO `ch_subjects` (`id`, `name`, `created_at`) VALUES
(1, 'mathematics', '2021-01-29 11:14:35'),
(2, 'english language', '2021-01-29 11:20:04');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ch_admin`
--
ALTER TABLE `ch_admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ch_attendance`
--
ALTER TABLE `ch_attendance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ch_class`
--
ALTER TABLE `ch_class`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ch_class_teacher`
--
ALTER TABLE `ch_class_teacher`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ch_offering_subjects`
--
ALTER TABLE `ch_offering_subjects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ch_parents`
--
ALTER TABLE `ch_parents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ch_payment`
--
ALTER TABLE `ch_payment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ch_results`
--
ALTER TABLE `ch_results`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ch_role`
--
ALTER TABLE `ch_role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ch_students`
--
ALTER TABLE `ch_students`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ch_student_position`
--
ALTER TABLE `ch_student_position`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ch_subjects`
--
ALTER TABLE `ch_subjects`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ch_admin`
--
ALTER TABLE `ch_admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `ch_attendance`
--
ALTER TABLE `ch_attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `ch_class`
--
ALTER TABLE `ch_class`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `ch_class_teacher`
--
ALTER TABLE `ch_class_teacher`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `ch_offering_subjects`
--
ALTER TABLE `ch_offering_subjects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `ch_parents`
--
ALTER TABLE `ch_parents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `ch_payment`
--
ALTER TABLE `ch_payment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `ch_results`
--
ALTER TABLE `ch_results`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `ch_role`
--
ALTER TABLE `ch_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `ch_students`
--
ALTER TABLE `ch_students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `ch_student_position`
--
ALTER TABLE `ch_student_position`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `ch_subjects`
--
ALTER TABLE `ch_subjects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
