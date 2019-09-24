-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 24, 2019 at 12:20 PM
-- Server version: 10.3.16-MariaDB
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
-- Database: `test_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE `tbl_users` (
  `id` int(5) UNSIGNED ZEROFILL NOT NULL,
  `uname` varchar(50) NOT NULL,
  `pass` text NOT NULL,
  `refferal_code` text NOT NULL,
  `date_input` datetime NOT NULL,
  `address` text NOT NULL,
  `city` text NOT NULL,
  `province` text NOT NULL,
  `zip` varchar(6) NOT NULL,
  `contact` text NOT NULL,
  `fullname` text NOT NULL,
  `email` text NOT NULL,
  `dob` date NOT NULL,
  `gender` enum('m','f') NOT NULL,
  `last_login` datetime NOT NULL,
  `ip` text NOT NULL,
  `usertype` enum('1','2','3','0') NOT NULL,
  `status` enum('0','1') NOT NULL,
  `on_off` enum('0','1') NOT NULL,
  `parent_main` int(5) UNSIGNED ZEROFILL NOT NULL,
  `parent_1` int(5) UNSIGNED ZEROFILL NOT NULL,
  `position` enum('L','R') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`id`, `uname`, `pass`, `refferal_code`, `date_input`, `address`, `city`, `province`, `zip`, `contact`, `fullname`, `email`, `dob`, `gender`, `last_login`, `ip`, `usertype`, `status`, `on_off`, `parent_main`, `parent_1`, `position`) VALUES
(00001, 'admin', 'admin123', 'ja010100001', '2010-01-01 00:00:00', 'marilao', 'marilao', 'bulacna', '3019', '09355346790', 'james marwin pogi', 'jamesrobledogwapo@gmail.com', '2010-01-01', 'm', '2019-09-24 18:19:05', '::1', '0', '1', '1', 00001, 00001, 'L'),
(00002, 'James_test', '123123', 'su09241900002', '2019-09-24 07:52:06', '', '', '', '', '', 'Candy Heppard', 'support@refreshdietcleanses.com', '0000-00-00', 'm', '0000-00-00 00:00:00', '', '1', '1', '0', 00001, 00001, 'L'),
(00003, 'testd', '123123', 'fd09241900003', '2019-09-24 08:36:54', '', '', '', '', '', 'Kimberly L. Ware', 'fdgt@email.com', '0000-00-00', 'm', '0000-00-00 00:00:00', '', '1', '1', '0', 00001, 00002, 'L'),
(00004, 'valene', '123123', 'va09241900004', '2019-09-24 17:56:35', '', '', '', '', '', 'valene quindoyos', 'valene@gmail.com', '0000-00-00', 'm', '0000-00-00 00:00:00', '', '1', '1', '0', 00001, 00003, 'L'),
(00005, 'Ethyl', '123123', 'et09241900005', '2019-09-24 18:15:24', '', '', '', '', '', 'Ethykl ALcohol', 'ethyl@gmail.com', '0000-00-00', 'm', '0000-00-00 00:00:00', '', '1', '1', '0', 00001, 00003, 'L'),
(00006, 'orocan', '123123', 'or09241900006', '2019-09-24 18:18:57', '', '', '', '', '', 'koolit orocan', 'oro@gmail.com', '0000-00-00', 'm', '0000-00-00 00:00:00', '', '1', '1', '0', 00001, 00003, 'L');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `id` int(5) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
