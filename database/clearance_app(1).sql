-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Oct 19, 2023 at 07:07 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `clearance_app`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(1, 'adminuser', '$2y$10$iD1bm3zbDbnxlh086.gKV.RHFBX6alkpESSx0t/VPhuCnwyrIz7jm');

-- --------------------------------------------------------

--
-- Table structure for table `clearance_officers`
--

CREATE TABLE `clearance_officers` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `office` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `clearance_officers`
--

INSERT INTO `clearance_officers` (`id`, `username`, `fullname`, `password`, `office`, `created_at`) VALUES
(1, 'john', 'john', '$2y$10$krqdwXB4qUI97qhh/zwQWOwfD9fR5tty79pmZ3QWHGPS0YM9Hluj6', 'faculty', '2023-09-13 16:55:34'),
(2, 'john123', 'john', '$2y$10$0HmnSPQwi3PHwupwe7LDeOEV/Oi.XeLTG3H9Awh0m/turS6.PPKny', 'faculty', '2023-10-06 06:44:05'),
(3, 'john444', 'john444', '$2y$10$gvLehAIUv04QM6aQITdZoOaonGTVAsUvBGx87ZGZ4kOcYX6kE58bG', 'faculty', '2023-10-14 17:48:53');

-- --------------------------------------------------------

--
-- Table structure for table `clearance_pins`
--

CREATE TABLE `clearance_pins` (
  `id` int(11) NOT NULL,
  `pin_no` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `used_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `clearance_pins`
--

INSERT INTO `clearance_pins` (`id`, `pin_no`, `created_at`, `used_at`) VALUES
(1, '1234567890', '2023-09-08 20:22:03', NULL),
(2, '123456781', '2023-10-19 05:03:19', '2023-10-19 05:03:19'),
(3, '123456784', '2023-10-02 20:52:52', '2023-10-02 20:52:52'),
(4, '123456777', '2023-10-04 11:05:21', '2023-10-04 11:05:21'),
(5, '123456799', '2023-10-06 06:41:06', '2023-10-06 06:41:06'),
(6, '123456791', '2023-10-14 18:44:57', NULL),
(7, '123456708', '2023-10-14 18:45:26', '2023-10-14 18:45:26'),
(14, '4059827163', '2023-10-19 03:29:21', NULL),
(15, '9132765408', '2023-10-19 03:29:21', NULL),
(16, '1562039478', '2023-10-19 03:29:21', NULL),
(17, '8076451923', '2023-10-19 03:30:05', NULL),
(18, '3298741560', '2023-10-19 03:30:05', NULL),
(19, '6741592830', '2023-10-19 03:30:29', NULL),
(20, '5908213647', '2023-10-19 03:30:29', NULL),
(21, '2387461059', '2023-10-19 03:30:47', NULL),
(22, '7653190248', '2023-10-19 03:30:47', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `department_clearance`
--

CREATE TABLE `department_clearance` (
  `id` int(11) NOT NULL,
  `receipt_image` varchar(255) DEFAULT NULL,
  `accomodation_session` varchar(50) NOT NULL,
  `reg_no` varchar(50) NOT NULL,
  `clearance_status` varchar(100) NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `department_clearance`
--

INSERT INTO `department_clearance` (`id`, `receipt_image`, `accomodation_session`, `reg_no`, `clearance_status`) VALUES
(3, NULL, '2022/2023', '2019/SC/10207', 'pending'),
(4, NULL, '2022/2023', '2019/SC/10209', 'pending'),
(5, NULL, '2022/2023', '2019/SC/10208', 'pending'),
(6, NULL, '2022/2023', '2019/SC/10206', 'pending'),
(7, NULL, '2022/2023', '2019/SC/10203', 'pending'),
(8, NULL, '2022/2023', '2019/SC/10204', 'pending'),
(9, NULL, '2022/2023', '2019/SC/10205', 'pending'),
(10, NULL, '2022/2023', '2019/SC/12205', 'pending'),
(11, NULL, '2022/2023', '2019/SC/10267', 'pending'),
(12, NULL, '2022/2023', '2019/SC/10200', 'pending'),
(13, NULL, '2022/2023', '2019/SC/222222', 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `faculty_clearance`
--

CREATE TABLE `faculty_clearance` (
  `id` int(11) NOT NULL,
  `clearance_status` varchar(20) NOT NULL DEFAULT 'cleared',
  `reg_no` varchar(50) NOT NULL,
  `session` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `faculty_clearance`
--

INSERT INTO `faculty_clearance` (`id`, `clearance_status`, `reg_no`, `session`) VALUES
(5, 'pending', '2019/SC/222222', '2022/2023');

-- --------------------------------------------------------

--
-- Table structure for table `library_clearance`
--

CREATE TABLE `library_clearance` (
  `id` int(11) NOT NULL,
  `library_card_image` varchar(255) NOT NULL,
  `reg_no` varchar(50) NOT NULL,
  `session` varchar(50) NOT NULL,
  `clearance_status` varchar(100) NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `reg_no` varchar(50) NOT NULL,
  `session` varchar(255) NOT NULL,
  `clearance_pin` varchar(250) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `password` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `reg_no`, `session`, `clearance_pin`, `created_at`, `password`) VALUES
(8, '2019/SC/222222', '2022/2023', '123456781', '2023-10-19 05:03:19', '$2y$10$hGUeRq1Hs5L0iW2Kft1N3OHNIuS9jFYHmgP4UfMG/xbKSjXriE.by');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `clearance_officers`
--
ALTER TABLE `clearance_officers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `clearance_pins`
--
ALTER TABLE `clearance_pins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pin_no` (`pin_no`);

--
-- Indexes for table `department_clearance`
--
ALTER TABLE `department_clearance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `faculty_clearance`
--
ALTER TABLE `faculty_clearance`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `reg_no` (`reg_no`);

--
-- Indexes for table `library_clearance`
--
ALTER TABLE `library_clearance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `clearance_officers`
--
ALTER TABLE `clearance_officers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `clearance_pins`
--
ALTER TABLE `clearance_pins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `department_clearance`
--
ALTER TABLE `department_clearance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `faculty_clearance`
--
ALTER TABLE `faculty_clearance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `library_clearance`
--
ALTER TABLE `library_clearance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
