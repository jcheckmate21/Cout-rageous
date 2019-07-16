-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 16, 2019 at 01:13 AM
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
-- Database: `coutrageous`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `id` int(11) NOT NULL,
  `date` date DEFAULT current_timestamp(),
  `type` varchar(25) NOT NULL,
  `anumber` varchar(50) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `time_in` time NOT NULL,
  `time_out` time NOT NULL,
  `memo` varchar(555) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`id`, `date`, `type`, `anumber`, `firstname`, `lastname`, `time_in`, `time_out`, `memo`) VALUES
(39, '2019-06-30', 'student', 'A33333', 'Kweku', 'Sintim', '19:29:42', '19:30:03', 'signed in  Signed out'),
(40, '2019-06-30', 'student', 'A33333', 'Kweku', 'Sintim', '19:31:39', '19:32:47', 'signed in  Signed out'),
(41, '2019-06-29', 'student', 'a999', 'Emmanuel', 'Arthur', '19:32:08', '19:32:08', 'signed in  '),
(42, '2019-06-30', 'student', 'a999', 'Emmanuel', 'Arthur', '19:34:05', '19:34:50', 'signed in  Signed out'),
(43, '2019-06-30', 'instructor', 'A113', 'Lixin', 'Yu', '20:14:44', '20:19:30', 'signed in  Signed out'),
(44, '2019-06-30', 'instructor', 'A113', 'Lixin', 'Yu', '20:19:38', '20:21:00', 'signed in  Signed out'),
(45, '2019-06-30', 'instructor', 'a222', 'zzzzPing', 'zzzzZhang', '20:22:46', '20:23:56', 'signed in  Signed out'),
(46, '2019-06-30', 'student', 'A79', 'jerome', 'geddes', '20:24:39', '20:24:39', 'signed in  '),
(47, '2019-06-30', 'instructor', 'a222', 'zzzzPing', 'zzzzZhang', '20:25:06', '20:25:43', 'signed in  Signed out'),
(48, '2019-06-30', 'student', 'a999', 'Emmanuel', 'Arthur', '20:26:11', '20:49:14', 'signed in  Signed out'),
(49, '2019-06-30', 'instructor', 'a222', 'zzzzPing', 'zzzzZhang', '20:26:25', '20:26:38', 'signed in  Signed out'),
(50, '2019-06-30', 'student', 'A10485067', 'Joseph', 'Maxwellson', '20:43:08', '20:43:21', 'signed in  Signed out'),
(51, '2019-06-30', 'instructor', 'a222', 'zzzzPing', 'zzzzZhang', '20:48:23', '20:48:23', 'signed in  '),
(52, '2019-06-30', 'student', 'A10485067', 'Joseph', 'Maxwellson', '20:49:54', '20:49:54', 'signed in  '),
(53, '2019-07-01', 'student', 'A10485067', 'Joseph', 'Maxwellson', '05:39:20', '05:39:20', 'signed in  '),
(54, '2019-07-01', 'instructor', 'a222', 'zzzzPing', 'zzzzZhang', '05:39:36', '05:40:09', 'signed in  Signed out'),
(55, '2019-07-01', 'instructor', 'a222', 'zzzzPing', 'zzzzZhang', '05:40:20', '05:40:20', 'signed in  '),
(56, '2019-07-02', 'instructor', 'a222', 'zzzzPing', 'zzzzZhang', '10:07:48', '10:17:00', 'signed in  Signed out'),
(57, '2019-07-02', 'student', 'A10485067', 'Joseph', 'Maxwellson', '10:17:19', '10:17:22', 'signed in  Signed out'),
(58, '2019-07-02', 'instructor', 'A113', 'Lixin', 'Yu', '10:17:42', '10:17:42', 'signed in  '),
(59, '2019-07-03', 'instructor', 'a222', 'zzzzPing', 'zzzzZhang', '12:29:41', '12:29:44', 'signed in  Signed out'),
(60, '2019-07-03', 'student', 'A10485067', 'Joseph', 'Maxwellson', '12:30:25', '12:30:25', 'signed in  '),
(61, '2019-07-06', 'instructor', 'a222', 'zzzzPing', 'zzzzZhang', '12:59:27', '12:59:30', 'signed in  Signed out'),
(62, '2019-07-06', 'instructor', 'a222', 'zzzzPing', 'zzzzZhang', '13:02:25', '13:02:31', 'signed in  Signed out'),
(63, '2019-07-09', 'student', 'a999', 'Emmanuel', 'Arthur', '10:08:30', '10:14:28', 'signed in  Signed out'),
(64, '2019-07-09', 'instructor', 'a2222', 'zzzzPing', 'zzzzZhang', '10:41:03', '11:17:44', 'signed in  Signed out'),
(65, '2019-07-09', 'instructor', 'a2222', 'zzzzPing', 'zzzzZhang', '11:17:50', '11:23:43', 'signed in  Signed out'),
(66, '2019-07-09', 'instructor', 'A113', 'Lixin', 'Yu', '11:25:43', '12:24:11', 'Signed in Signed out'),
(67, '2019-07-09', 'instructor', 'a2222', 'zzzzPing', 'zzzzZhang', '11:29:28', '11:30:25', 'signed in  Signed out'),
(68, '2019-07-09', 'instructor', 'a2222', 'zzzzPing', 'zzzzZhang', '11:35:22', '12:24:01', 'Signed in Signed out'),
(69, '2019-07-09', 'instructor', 'a2222', 'zzzzPing', 'zzzzZhang', '12:47:58', '12:50:28', 'Signed in Signed out'),
(70, '2019-07-09', 'instructor', 'a2222', 'zzzzPing', 'zzzzZhang', '12:52:09', '12:53:46', 'Signed in Signed out'),
(71, '2019-07-09', 'instructor', 'A113', 'Lixin', 'Yu', '12:52:47', '12:55:15', 'Signed in Signed out'),
(72, '2019-07-09', 'instructor', 'a2222', 'zzzzPing', 'zzzzZhang', '12:55:23', '13:24:20', 'Signed in Signed out'),
(73, '2019-07-09', 'instructor', 'A113', 'Lixin', 'Yu', '13:24:25', '13:37:52', 'Signed in Signed out'),
(74, '2019-07-09', 'student', 'a999', 'Emmanuel', 'Arthur', '13:24:48', '13:24:55', 'signed in  Signed out'),
(75, '2019-07-09', 'student', 'A79', 'jerome', 'geddes', '13:25:07', '13:37:41', 'signed in  Signed out'),
(76, '2019-07-09', 'student', 'A79', 'jerome', 'geddes', '13:37:55', '19:12:16', 'signed in  Signed out'),
(77, '2019-07-09', 'instructor', 'A113', 'Lixin', 'Yu', '13:38:26', '20:09:39', 'Signed in Signed out'),
(78, '2019-07-09', 'student', 'A10485067', 'Joseph', 'Maxwellson', '13:38:58', '13:38:58', 'signed in  '),
(79, '2019-07-09', 'instructor', 'a2222', 'zzzzPing', 'zzzzZhang', '20:08:57', '20:11:04', 'Signed in Signed out'),
(80, '2019-07-09', 'student', 'a999', 'Emmanuel', 'Arthur', '20:09:43', '20:09:43', 'signed in  '),
(81, '2019-07-10', 'student', 'A79', 'jerome', 'geddes', '08:04:07', '08:04:07', 'signed in  '),
(82, '2019-07-10', 'student', 'A10485067', 'Joseph', 'Maxwellson', '13:06:19', '13:06:19', 'signed in  '),
(83, '2019-07-10', 'instructor', 'A113', 'Lixin', 'Yu', '13:06:29', '13:07:49', 'Signed in Signed out'),
(84, '2019-07-10', 'student', 'A0000', 'joooo', 'mooooo', '13:50:35', '13:52:56', 'signed in  Signed out'),
(85, '2019-07-10', 'instructor', 'a2222', 'zzzzPing', 'zzzzZhang', '13:53:13', '13:53:13', 'signed in  '),
(86, '2019-07-10', 'student', 'a999', 'Emmanuel', 'Arthur', '13:53:21', '13:53:25', 'signed in  Signed out'),
(87, '2019-07-11', 'instructor', 'a2222', 'zzzzPing', 'zzzzZhang', '09:29:03', '09:29:03', 'signed in  '),
(88, '2019-07-12', 'student', 'A0000', 'joooo', 'mooooo', '14:41:51', '14:41:51', 'signed in  '),
(89, '2019-07-12', 'instructor', 'A113', 'Lixin', 'Yu', '14:42:13', '14:42:13', 'signed in  '),
(90, '2019-07-15', 'student', 'a999', 'Emmanuel', 'Arthur', '09:22:18', '09:22:39', 'signed in  Signed out');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` int(11) NOT NULL,
  `crn` varchar(25) NOT NULL,
  `class` varchar(255) NOT NULL,
  `instructor` varchar(255) NOT NULL,
  `anumber` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `crn`, `class`, `instructor`, `anumber`) VALUES
(1, '414678', 'MA-121', 'Miss Udemgba', 'A109'),
(2, '234190', 'MA-222', 'Mr Udemgba', 'A11111555'),
(3, '122323', 'PY-291', 'Bubar Monak', 'A3448484'),
(4, '414000', 'GA-234', 'Gasam Nnidaa', 'A44444'),
(5, '999999', 'TF-447', 'Joseph Maxwellson', '7777777'),
(6, '66666', 'CS-400', 'Ping Zhang', 'a2222'),
(7, '75555', 'CD-400', 'Ping Zhang', 'a2222'),
(8, '77777', 'AC-300', 'Lixin Yu', 'A113'),
(9, '94444', 'FX-400', 'Ping Zhang', 'A2222'),
(10, '6444', 'MN-456', 'Lixin Yu', 'A113');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `type` varchar(25) NOT NULL,
  `anumber` varchar(25) NOT NULL,
  `username` varchar(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `major` varchar(255) NOT NULL,
  `classification` varchar(255) NOT NULL,
  `crn` int(25) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `type`, `anumber`, `username`, `firstname`, `lastname`, `email`, `major`, `classification`, `crn`, `password`, `created_at`) VALUES
(26, '', 'A1232', 'jmmaxwellson', 'xxJoseph', 'Maxwellson', 'jmmaxwellson@gmail.com', 'Physics', 'Sophomore', 234190, '$2y$10$7/QNuquGcuxtsYiVhmCCVuAant9a34hchbIN.zsg/TIrwU7COIM2K', '2019-06-27 22:42:09'),
(28, '', 'A33', 'jjj', 'xx', 'mmm', 'jjj@gmail.com', 'Biotechnology', 'junioraaaa', 4127381, '$2y$10$RmZYLMikA4.WMLGjGeuQKOKNgWzsPLJF4PE2SL.p4fHrreTQRNOwO', '2019-06-27 22:53:44'),
(30, '', 'A5578777', 'evfvfjn', 'Joseph', 'Maxwellson', 'evfvfjn@gmail.com', 'Computer Science', 'soph', 414000, '$2y$10$5Ztm5zUomw.akJbQCCToGuF9qRATRT4umHw2kfl.GrilpCt1HBzM.', '2019-06-28 03:16:22'),
(31, '', 'A123231', 'jmax', 'jayo', 'Max', 'jmax@gmail.com', 'Agriculture', 'Sophomore', 123244, '$2y$10$NgJzYahK9Ky7XFr4y9VdVOEWa5ExtP.OiJGjrat9bvwhioe.KCWZ.', '2019-06-28 03:24:35'),
(32, 'student', 'A79', 'jgeddes', 'jerome', 'geddes', 'jgeddes@students.edu', 'Biology', 'senior', 123939, '$2y$10$P/BKf1kLo0ijdjawfNoOv.H0IPrfMokH9I1qgWhO3qWGu4BcgMAMy', '2019-06-28 03:26:43'),
(33, 'student', 'a999', 'earthur', 'Emmanuel', 'Arthur', 'earthur@gmail.com', 'Biotechnology', 'Freshman', 414678, '$2y$10$rFfIWEkBpaQCqKsWFp8JauaOyXq2F79RPSMZa2CwYV3XoMc/eshBm', '2019-06-28 03:27:33'),
(34, '', 'A47590000', 'eade', 'Ife', 'Adebambo', 'eade@gmail.com', 'Computer Science', 'junior', 412738, '$2y$10$9Yn/kcPOAXCGjWgxsCkgIOFDJb98A42VPC9xsErulnA0lBMGfoi9a', '2019-06-28 03:28:17'),
(35, 'student', 'A33333', 'ksintim', 'Kweku', 'Sintim', 'ksintim@gmail.com', 'Computer Science', 'Sophomore', 311910, '$2y$10$uF4g1aSXJ/kKuKW651Aaq.A5.9JIh.aGl9z6IPx4bDEhuz8kwUytC', '2019-06-28 11:59:35'),
(38, 'instructor', 'A113', 'lixin', 'Lixin', 'Yu', 'lixin@alcorn.edu', 'CS 321', 'instructor', 422000, '$2y$10$73NOPqNKwU/I47378AfUzeQGiZ99vFSc3Q0X9spevcouNsHuWOt7.', '2019-06-28 12:29:09'),
(39, 'instructor', 'a2222', 'pzhang', 'zzzzPing', 'zzzzZhang', 'pzhang@alcorn.edu', 'CS 888', 'instructor', 414678, '$2y$10$W6Ex6rFaXLOcFyGZbPr.juALihKuUzaIFwJuLUgAOyPUvJUWGfZ2u', '2019-06-28 12:52:19'),
(40, 'student', 'A0000', 'j000', 'joooo', 'mooooo', 'j000@gmail.com', 'Physics', 'sophomore', 122323, '$2y$10$UaE0wAhxjs6cuX2gD.c.euJ7uN6we0f4D88uqqEhbg4ULon7w7Rvu', '2019-06-30 07:34:33'),
(41, 'student', 'A10485067', 'jmaxwellson', 'Joseph', 'Maxwellson', 'jmaxwellson@students.alcorn.edu', 'Computer Science', 'Junior', 414678, '$2y$10$uCTdvI0OBvhVkwFcxErJI.sZ1VNhSPmFRuYye8.G3D98eSPLLKcgi', '2019-06-30 20:42:21'),
(42, 'student', 'A1232344444', 'jaywellson', 'Emmanuel', 'Arthur', 'jaywellson@gmail.com', 'Computer Science', 'sophomore', 122323, '$2y$10$mrnlGztm7KsX8zksVS/ewePscH7G5oRJFM06/BV4N5JKPlzugxmoK', '2019-07-01 11:37:54'),
(43, 'student', 'A366', 'jmac', 'jay', 'mac', 'jmac@gmail.com', 'French', 'Sophomore', 88888, '$2y$10$ipoPoQ3JR2oMTkZ3RcKxc.3DGpHvsohS45eke6Ohl58pSs4iJQery', '2019-07-03 12:35:12'),
(44, 'instructor', '555555', 'ontim', 'Owura', 'Ntim', 'ontim@fmail.com', 'TW-218', 'instructor', 2222, '$2y$10$CCGdFraU0p7zJJVjmKYc3.FX7KXnPNMvvw81MFUZXss.5P5x6FVry', '2019-07-09 09:37:59');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `position` varchar(50) DEFAULT NULL,
  `username` varchar(50) NOT NULL,
  `firstname` varchar(50) DEFAULT NULL,
  `lastname` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `anumber` varchar(20) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `position`, `username`, `firstname`, `lastname`, `email`, `anumber`, `password`, `created_at`) VALUES
(1, 'admin', 'Admin', 'Kevin', 'McClin', 'kmcclin@gmail.com', 'a10485011', '$2y$10$qK0K3iF0CrvzV/yXRC8Lv.mIxGxYEVgzX7fcX61EiQdjyi0/VhFnq', '2019-06-25 19:43:37'),
(9, 'admin', 'joseph', 'joseph', 'maxwellson', 'jmmaxwellson@gmail.com', 'a10485067', '$2y$10$xzD.VlBvkPoqoKLvne/aWuHwGU3GriVh5CSXRtIpRo5kbFiPB1fgK', '2019-06-25 19:44:53'),
(13, 'tutor', 'mama', 'Maa', 'Dora', 'mamamamamama@gmail.com', 'a1234567', '$2y$10$ClxRrXGRHrl9JB3ypKyJWupR9x4WyRniH6Ocw5Izr/9Czly39hsUK', '2019-06-25 19:59:52'),
(14, 'tutor', 'Emmanuel', 'Emmanuel', 'Arthur', 'maturd457@gmail.com', 'a10435678', '$2y$10$2XomAgVAzyCoC14ApdVvxOoEwCUh/mGxP296rXflLuq7w23lfwT0G', '2019-06-25 20:14:28'),
(19, 'tutor', 'collett', 'Collett', 'Charleton', 'ccharleton@gmail.com', 'a4455555555', '$2y$10$aG5xdkNu9syH3E9K8wlhjOs/do5nMDIw54677GpMo0GVlSD5WeGZy', '2019-06-30 09:31:20');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
