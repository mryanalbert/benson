-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 06, 2023 at 01:53 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `benson`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(1, 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997');

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `at_id` int(11) NOT NULL,
  `at_sch_id` int(11) NOT NULL,
  `at_in` timestamp NULL DEFAULT NULL,
  `at_out` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`at_id`, `at_sch_id`, `at_in`, `at_out`) VALUES
(3, 79, '2023-10-06 09:38:57', '2023-10-06 11:18:45'),
(4, 81, '2023-10-06 11:34:52', '2023-10-06 11:35:19');

-- --------------------------------------------------------

--
-- Table structure for table `current`
--

CREATE TABLE `current` (
  `id` int(11) NOT NULL,
  `cur_ay_from` int(11) NOT NULL,
  `cur_ay_to` int(11) NOT NULL,
  `cur_sem` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `current`
--

INSERT INTO `current` (`id`, `cur_ay_from`, `cur_ay_to`, `cur_sem`) VALUES
(1, 2023, 2024, '2');

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `dep_id` int(11) NOT NULL,
  `dep_name` varchar(50) NOT NULL,
  `dep_desc` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`dep_id`, `dep_name`, `dep_desc`) VALUES
(10, 'CIT', 'College of Information Technology'),
(11, 'COB', 'College of Business'),
(14, 'BSTM', 'Bachelor of Science');

-- --------------------------------------------------------

--
-- Table structure for table `faculty`
--

CREATE TABLE `faculty` (
  `fac_id` int(11) NOT NULL,
  `fac_fname` varchar(100) NOT NULL,
  `fac_mname` varchar(100) NOT NULL,
  `fac_lname` varchar(100) NOT NULL,
  `fac_img` text NOT NULL,
  `dep_id` int(11) NOT NULL,
  `gender` int(2) NOT NULL,
  `qrcode` text NOT NULL,
  `qrcode_img` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `faculty`
--

INSERT INTO `faculty` (`fac_id`, `fac_fname`, `fac_mname`, `fac_lname`, `fac_img`, `dep_id`, `gender`, `qrcode`, `qrcode_img`) VALUES
(29, 'Ryan Albert', 'Sulapas', 'Masungsong', '', 10, 1, '', ''),
(31, 'Carol', '', 'Villamor', 'tampus.jpg', 11, 0, '', ''),
(36, 'Fermin', 'Cabug-os', 'Perez', '', 14, 1, '651ce228a3529', '1696391720.png'),
(37, 'Aries', 'Deqiut', 'Escosura', 'IMG_4785.jpeg', 14, 1, '651d63b8811a1', '1696424888.png');

-- --------------------------------------------------------

--
-- Table structure for table `room`
--

CREATE TABLE `room` (
  `ro_id` int(11) NOT NULL,
  `room` varchar(50) NOT NULL,
  `bldg` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `room`
--

INSERT INTO `room` (`ro_id`, `room`, `bldg`) VALUES
(15, 'df', 'df'),
(17, 'comlab', 'maria');

-- --------------------------------------------------------

--
-- Table structure for table `schedule`
--

CREATE TABLE `schedule` (
  `sch_id` int(11) NOT NULL,
  `school_year_from` int(6) NOT NULL,
  `school_year_to` int(6) NOT NULL,
  `sem` varchar(50) NOT NULL,
  `sch_time_from` text NOT NULL,
  `sch_time_to` text NOT NULL,
  `day` varchar(30) NOT NULL,
  `ro_id` int(11) NOT NULL,
  `sub_id` int(11) NOT NULL,
  `fac_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `schedule`
--

INSERT INTO `schedule` (`sch_id`, `school_year_from`, `school_year_to`, `sem`, `sch_time_from`, `sch_time_to`, `day`, `ro_id`, `sub_id`, `fac_id`) VALUES
(55, 2023, 2024, '2', '12:30', '14:00', 'Monday', 17, 6, 29),
(56, 2023, 2024, '2', '12:30', '14:00', 'Thursday', 17, 6, 29),
(57, 2023, 2024, '2', '11:00', '12:30', 'Monday', 17, 6, 31),
(58, 2023, 2024, '2', '11:00', '12:30', 'Thursday', 17, 6, 31),
(59, 2023, 2024, '2', '08:30', '10:00', 'Tuesday', 15, 6, 31),
(60, 2023, 2024, '2', '08:30', '10:00', 'Tuesday', 17, 6, 31),
(61, 2023, 2024, '2', '09:00', '10:00', 'Friday', 15, 4, 31),
(62, 2023, 2024, '2', '08:30', '10:00', 'Wednesday', 15, 6, 29),
(63, 2023, 2024, '1', '13:00', '15:00', 'Wednesday', 15, 6, 31),
(64, 2023, 2024, '1', '13:00', '15:00', 'Saturday', 15, 6, 31),
(65, 2023, 2024, 'summer', '07:00', '08:00', 'Monday', 15, 4, 29),
(68, 2023, 2024, '2', '06:00', '06:30', 'Monday', 17, 6, 36),
(69, 2024, 2025, '1', '05:00', '05:30', 'Sunday', 15, 4, 29),
(70, 2023, 2024, '2', '21:00', '22:00', 'Thursday', 17, 4, 37),
(71, 2023, 2024, '2', '20:00', '21:00', 'Tuesday', 15, 6, 37),
(72, 2023, 2024, '2', '20:00', '21:00', 'Monday', 15, 6, 37),
(73, 2023, 2024, '2', '19:00', '21:30', 'Sunday', 15, 6, 29),
(74, 2023, 2024, '2', '21:27', '22:00', 'Monday', 15, 4, 37),
(75, 2023, 2024, '2', '14:00', '15:00', 'Friday', 15, 6, 37),
(76, 2023, 2024, '2', '16:00', '17:00', 'Friday', 15, 4, 36),
(77, 2023, 2024, '2', '15:00', '16:00', 'Friday', 15, 4, 37),
(78, 2023, 2024, '2', '17:00', '19:30', 'Tuesday', 15, 4, 37),
(79, 2023, 2024, '2', '17:00', '19:30', 'Friday', 15, 4, 37),
(80, 2023, 2024, '2', '19:30', '20:30', 'Tuesday', 17, 4, 36),
(81, 2023, 2024, '2', '19:30', '20:30', 'Friday', 17, 4, 36);

-- --------------------------------------------------------

--
-- Table structure for table `subject`
--

CREATE TABLE `subject` (
  `sub_id` int(11) NOT NULL,
  `sub_code` varchar(50) NOT NULL,
  `sub_title` varchar(100) NOT NULL,
  `sub_desc` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subject`
--

INSERT INTO `subject` (`sub_id`, `sub_code`, `sub_title`, `sub_desc`) VALUES
(4, '2313000', 'DIT112', 'Computer Programming 1'),
(6, '231404', 'ITP112', 'Data Structures and Algorithms');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`at_id`);

--
-- Indexes for table `current`
--
ALTER TABLE `current`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`dep_id`);

--
-- Indexes for table `faculty`
--
ALTER TABLE `faculty`
  ADD PRIMARY KEY (`fac_id`);

--
-- Indexes for table `room`
--
ALTER TABLE `room`
  ADD PRIMARY KEY (`ro_id`);

--
-- Indexes for table `schedule`
--
ALTER TABLE `schedule`
  ADD PRIMARY KEY (`sch_id`);

--
-- Indexes for table `subject`
--
ALTER TABLE `subject`
  ADD PRIMARY KEY (`sub_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `at_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `current`
--
ALTER TABLE `current`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `dep_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `faculty`
--
ALTER TABLE `faculty`
  MODIFY `fac_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `room`
--
ALTER TABLE `room`
  MODIFY `ro_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `schedule`
--
ALTER TABLE `schedule`
  MODIFY `sch_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT for table `subject`
--
ALTER TABLE `subject`
  MODIFY `sub_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
