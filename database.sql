-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 24, 2021 at 08:50 PM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.4.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `database`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `id` int(11) NOT NULL,
  `Company_Name` varchar(255) NOT NULL,
  `ContactPerson` varchar(100) NOT NULL,
  `MobileNo` int(20) NOT NULL,
  `work_order_date` varchar(20) NOT NULL,
  `bill_submission_date` varchar(20) NOT NULL,
  `total` int(11) NOT NULL,
  `due` int(11) NOT NULL,
  `file` varchar(255) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `Company_Name`, `ContactPerson`, `MobileNo`, `work_order_date`, `bill_submission_date`, `total`, `due`, `file`) VALUES
(3, 'Envoy - Olio Apparel ', 'Mr. Ujjal Bhowmik', 1236548, '2020-10-31', '2020-11-01', 66000, 66000, 'upload/workorder/1_Envoy - Olio Apparel .pdf'),
(4, 'Partex- Partex Paper Mills', 'M.A. Bashir', 486786384, '2020-10-31', '2020-11-01', 110000, 0, 'upload/workorder/4_Partex- Partex Paper Mills.doc'),
(5, 'Vigor Roar Industries Limited ', 'Shihab', 43543453, '2020-11-01', '2020-11-02', 2500, 0, 'upload/workorder/5_Vigor Roar Industries Limited .doc'),
(6, 'Purbani - Purbani fabrics', 'Mahbubul Islam Ripon', 1234567, '2020-10-04', '2020-11-03', 45000, 0, 'upload/workorder/6_Purbani - Purbani fabrics.pdf'),
(7, 'Dhaka Fiber Net Ltd ', 'Akash Saha', 1234567, '2020-11-15', '2020-11-15', 33400, 0, 'upload/workorder/7_Dhaka Fiber Net Ltd .doc'),
(8, 'Dhaka Fiber Net Ltd ', 'Akash Saha', 123457, '2020-11-16', '2020-11-16', 39000, 0, 'upload/workorder/8_Dhaka Fiber Net Ltd .doc'),
(9, 'Partex- Partex Paper Mills', 'M.A. Bashir', 123456, '2020-11-16', '2020-11-16', 28000, 0, 'upload/workorder/9_Partex- Partex Paper Mills.doc');

-- --------------------------------------------------------

--
-- Table structure for table `admin_accounts`
--

CREATE TABLE `admin_accounts` (
  `id` int(25) NOT NULL,
  `user_name` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `series_id` varchar(60) DEFAULT NULL,
  `remember_token` varchar(255) DEFAULT NULL,
  `expires` datetime DEFAULT NULL,
  `admin_type` varchar(10) NOT NULL,
  `email` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `admin_accounts`
--

INSERT INTO `admin_accounts` (`id`, `user_name`, `password`, `series_id`, `remember_token`, `expires`, `admin_type`, `email`) VALUES
(1, 'Sakeef', '$2y$10$QSzI0vapuaK.rzeJTq5GGe3At/DEJiuikjYe4kcNJMhywZWlo2ltK', NULL, NULL, NULL, 'super', 'ameer.bd.sa@gmail.com'),
(2, 'Admin', '$2y$10$vf9HiMzZg2U.Oth.sMKI9eeZ9aQhhfKhwZ2UPTddThn3.M5DrvUvm', 'X78TpldrgmfgstWY', '$2y$10$f1/GlOCRXHhQJFGSySdp..WI.xYBwdGdsEivlQHBlz6nxZ5TE1CkC', '2020-12-15 10:27:41', 'super', 'sales@paxzonebd.com'),
(7, 'paxzone', '$2y$10$2k6.g8m3wMQNMHQB3LSEfeOvzYr4ytVORt8zzdV7Tr3L43RoGNG5G', NULL, NULL, NULL, 'super', 'asif@paxzonebd.com'),
(9, 'mumu', '$2y$10$ErWIStn3.NK91WAEo3/9C.6bQR/gxHxyEkMNhfr.X07WVuS6HIke2', NULL, NULL, NULL, 'user', 'mumu@salespaxzonebd.com');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(10) NOT NULL,
  `f_name` varchar(25) NOT NULL,
  `l_name` varchar(25) NOT NULL,
  `gender` varchar(6) DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL,
  `city` varchar(15) DEFAULT NULL,
  `state` varchar(30) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `created_by` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_by` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `f_name`, `l_name`, `gender`, `address`, `city`, `state`, `phone`, `email`, `date_of_birth`, `created_by`, `created_at`, `updated_by`, `updated_at`) VALUES
(18, 'bhushan', 'Chhadva', 'male', 'Padmavati', 'mumbai', 'Maharashtra', '34343432', 'bhusahan2@gmail.com', '1991-06-18', 0, NULL, 0, NULL),
(19, 'Jayant', 'atre', 'male', 'Priyadarshini A102, adwa2', 'wad', 'Maharashtra', '34343432', 'bhusahan2@gmail.com', '1998-05-18', 0, NULL, 0, NULL),
(21, 'bhushan', 'sutar', 'male', 'Priyadarshini A102, adwa2', 'mumbai', 'Maharashtra', '34343432', 'bhusahan2@gmail.com', '2016-11-24', 0, NULL, 0, NULL),
(23, 'Paolo', ' Accorti', 'male', 'Priyadarshini A102, adwa2', 'mumbai', 'Maharashtra', '34343432', 'bhusahan2@gmail.com', '1992-02-04', 0, NULL, 0, NULL),
(24, 'Roland', ' Mendel', 'male', 'Priyadarshini A102, adwa2', 'mumbai', 'Maharashtra', '34343432', 'bhusahan2@gmail.com', '2016-11-30', 0, NULL, 0, NULL),
(25, 'John', 'doe', 'male', 'City, view', '', 'Maharashtra', '8875207658', 'john@abc.com', '2017-01-27', 0, NULL, 0, NULL),
(26, 'Maria', 'Anders', 'female', 'New york city', '', 'Maharashtra', '8856705387', 'chetanshenai9@gmail.com', '2017-01-28', 0, NULL, 0, NULL),
(27, 'Ana', ' Trujillo', 'female', 'Street view', '', 'Maharashtra', '9975658478', 'chetanshenai9@gmail.com', '1992-07-16', 0, NULL, 0, NULL),
(28, 'Thomas', 'Hardy', 'male', '120 Hanover Sq', '', 'Maharashtra', '885115323', 'abc@abc.com', '1985-06-24', 0, NULL, 0, NULL),
(29, 'Christina', 'Berglund', 'female', 'Berguvsvägen 8', '', 'Maharashtra', '9985125366', 'chetanshenai9@gmail.com', '1997-02-12', 0, NULL, 0, NULL),
(30, 'Ann', 'Devon', 'male', '35 King George', '', 'Maharashtra', '8865356988', 'abc@abc.com', '1988-02-09', 0, NULL, 0, NULL),
(31, 'Helen', 'Bennett', 'female', 'Garden House Crowther Way', '', 'Maharashtra', '75207654', 'chetanshenai9@gmail.com', '1983-06-15', 0, NULL, 0, NULL),
(32, 'Annette', 'Roulet', 'female', '1 rue Alsace-Lorraine', '', ' ', '3410005687', 'abc@abc.com', '1992-01-13', 0, NULL, 0, NULL),
(33, 'Yoshi', 'Tannamuri', 'male', '1900 Oak St.', '', 'Maharashtra', '8855647899', 'chetanshenai9@gmail.com', '1994-07-28', 0, NULL, 0, NULL),
(34, 'Carlos', 'González', 'male', 'Barquisimeto', '', 'Maharashtra', '9966447554', 'abc@abc.com', '1997-06-24', 0, NULL, 0, NULL),
(35, 'Fran', ' Wilson', 'male', 'Priyadarshini ', '', 'Maharashtra', '5844775565', 'fran@abc.com', '1997-01-27', 0, NULL, 0, NULL),
(36, 'Jean', ' Fresnière', 'female', '43 rue St. Laurent', '', 'Maharashtra', '9975586123', 'chetanshenai9@gmail.com', '2002-01-28', 0, NULL, 0, NULL),
(37, 'Jose', 'Pavarotti', 'male', '187 Suffolk Ln.', '', 'Maharashtra', '875213654', ' Pavarotti@gmail.com', '1997-02-04', 0, NULL, 0, NULL),
(38, 'Palle', 'Ibsen', 'female', 'Smagsløget 45', '', 'Maharashtra', '9975245588', 'Palle@gmail.com', '1991-06-17', 0, NULL, 0, '2018-01-14 17:11:42'),
(39, 'Paula', 'Parente', 'male', 'Rua do Mercado, 12', '', 'Maharashtra', '659984878', 'abc@gmail.com', '1996-02-06', 0, NULL, 0, NULL),
(40, 'Matti', ' Karttunen', 'female', 'Keskuskatu 45', '', 'Maharashtra', '845555125', 'abc@abc.com', '1984-06-19', 0, NULL, 0, NULL),
(47, 'Chetan ', 'Doe', 'male', 'afa', NULL, 'Maharashtra', '9934678658', 'chetanshenai9@gmail.com', NULL, 0, '2018-11-17 18:26:16', 0, NULL),
(48, 'Chetan ', 'Singh', 'male', NULL, NULL, ' ', NULL, NULL, NULL, 0, '2018-11-18 06:51:27', 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `email_details`
--

CREATE TABLE `email_details` (
  `id` int(11) NOT NULL,
  `u_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `from_name` varchar(255) NOT NULL,
  `smtp_host` varchar(255) NOT NULL,
  `smtp_port` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `email_details`
--

INSERT INTO `email_details` (`id`, `u_id`, `username`, `password`, `from_name`, `smtp_host`, `smtp_port`) VALUES
(2, 7, 'admin@admin.com', 'paxzoneelectronics', 'Sakeef Ameer', 'prod.sin2.secureserver.net', 465);

-- --------------------------------------------------------

--
-- Table structure for table `file_list`
--

CREATE TABLE `file_list` (
  `No` int(20) NOT NULL,
  `File_name` text NOT NULL,
  `Path` text NOT NULL,
  `URL` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `mailcounter`
--

CREATE TABLE `mailcounter` (
  `id` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `user_id` int(11) NOT NULL,
  `counter` int(11) NOT NULL,
  `user_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `mailcounter`
--

INSERT INTO `mailcounter` (`id`, `timestamp`, `user_id`, `counter`, `user_name`) VALUES
(2, '2020-10-12 18:00:00', 14, 19, 'irtifa '),
(3, '2020-10-12 17:00:00', 14, 6, 'irtifa '),
(4, '2020-10-12 18:00:00', 14, 20, 'irtifa '),
(5, '2020-10-12 18:00:00', 14, 21, 'irtifa '),
(6, '2020-10-12 18:00:00', 16, 73, 'nusrat'),
(7, '2020-10-12 18:00:00', 14, 32, 'irtifa '),
(8, '2020-10-12 18:00:00', 15, 23, 'shahrin'),
(9, '2020-10-12 18:00:00', 16, 42, 'nusrat'),
(10, '2020-10-12 19:00:00', 15, 49, 'shahrin'),
(11, '2020-10-12 19:00:00', 14, 39, 'irtifa '),
(12, '2020-10-12 19:00:00', 16, 31, 'nusrat'),
(13, '2020-10-12 09:00:00', 14, 250, 'irtifa '),
(14, '2020-10-12 10:00:00', 14, 364, 'irtifa '),
(15, '2020-10-12 11:00:00', 14, 242, 'irtifa '),
(16, '2020-10-12 12:00:00', 14, 192, 'irtifa '),
(17, '2020-10-12 14:00:00', 14, 43, 'irtifa '),
(18, '2020-10-13 17:00:00', 15, 266, 'shahrin'),
(19, '2020-10-13 18:00:00', 15, 167, 'shahrin'),
(20, '2020-10-13 19:00:00', 15, 364, 'shahrin'),
(21, '2020-10-13 08:00:00', 15, 62, 'shahrin'),
(22, '2020-10-13 10:00:00', 15, 148, 'shahrin'),
(23, '2020-10-13 11:00:00', 15, 284, 'shahrin'),
(24, '2020-10-14 17:00:00', 16, 59, 'nusrat'),
(25, '2020-10-14 18:00:00', 16, 331, 'nusrat'),
(26, '2020-10-14 19:00:00', 16, 368, 'nusrat'),
(27, '2020-10-14 08:00:00', 16, 98, 'nusrat'),
(28, '2020-10-14 09:00:00', 16, 109, 'nusrat'),
(29, '2020-10-17 18:00:00', 14, 101, 'irtifa '),
(30, '2020-10-17 19:00:00', 14, 272, 'irtifa '),
(31, '2020-10-17 19:00:00', 15, 131, 'shahrin'),
(32, '2020-10-17 09:00:00', 14, 256, 'irtifa '),
(33, '2020-10-17 09:00:00', 15, 151, 'shahrin'),
(34, '2020-10-17 10:00:00', 15, 181, 'shahrin'),
(35, '2020-10-17 10:00:00', 14, 215, 'irtifa '),
(36, '2020-10-17 11:00:00', 14, 207, 'irtifa '),
(37, '2020-10-17 11:00:00', 15, 182, 'shahrin'),
(38, '2020-10-17 12:00:00', 14, 27, 'irtifa '),
(39, '2020-10-18 17:00:00', 7, 0, 'ameer'),
(40, '2020-10-18 17:00:00', 14, 19, 'irtifa '),
(41, '2020-10-18 18:00:00', 14, 95, 'irtifa '),
(42, '2020-10-18 18:00:00', 15, 244, 'shahrin'),
(43, '2020-10-18 19:00:00', 14, 201, 'irtifa '),
(44, '2020-10-18 19:00:00', 15, 183, 'shahrin'),
(45, '2020-10-18 09:00:00', 14, 225, 'irtifa '),
(46, '2020-10-19 18:00:00', 16, 133, 'nusrat'),
(47, '2020-10-19 19:00:00', 16, 100, 'nusrat'),
(48, '2020-10-19 19:00:00', 14, 0, 'irtifa '),
(49, '2020-10-19 08:00:00', 16, 25, 'nusrat'),
(50, '2020-10-19 09:00:00', 16, 36, 'nusrat'),
(51, '2020-10-19 10:00:00', 16, 156, 'nusrat'),
(52, '2020-10-19 11:00:00', 16, 148, 'nusrat'),
(53, '2020-10-20 17:00:00', 16, 80, 'nusrat'),
(54, '2020-10-20 18:00:00', 16, 272, 'nusrat'),
(55, '2020-10-20 19:00:00', 16, 52, 'nusrat'),
(56, '2020-10-20 08:00:00', 16, 108, 'nusrat'),
(57, '2020-10-20 10:00:00', 16, 62, 'nusrat'),
(58, '2020-10-20 11:00:00', 16, 14, 'nusrat'),
(59, '2020-10-24 09:00:00', 14, 1, 'irtifa '),
(60, '2020-10-28 17:00:00', 1, 4, 'Sakeef'),
(61, '2020-10-28 17:00:00', 3, 7, 'Nusrat'),
(62, '2020-10-28 18:00:00', 3, 124, 'Nusrat'),
(63, '2020-10-28 19:00:00', 3, 165, 'Nusrat'),
(64, '2020-10-28 09:00:00', 3, 36, 'Nusrat'),
(65, '2020-10-28 10:00:00', 3, 23, 'Nusrat'),
(66, '2020-10-28 11:00:00', 3, 1, 'Nusrat'),
(67, '2020-10-29 17:00:00', 3, 1, 'Nusrat'),
(68, '2020-10-29 18:00:00', 3, 30, 'Nusrat'),
(69, '2020-10-29 09:00:00', 3, 1, 'Nusrat'),
(70, '2020-10-29 10:00:00', 3, 67, 'Nusrat'),
(71, '2020-11-01 17:00:00', 3, 85, 'Nusrat'),
(72, '2020-11-01 18:00:00', 3, 56, 'Nusrat'),
(73, '2020-11-01 19:00:00', 3, 157, 'Nusrat'),
(74, '2020-11-01 10:00:00', 3, 23, 'Nusrat'),
(75, '2020-11-01 11:00:00', 3, 190, 'Nusrat'),
(76, '2020-11-01 12:00:00', 3, 166, 'Nusrat'),
(77, '2020-11-02 10:00:00', 5, 1, 'Tajmee'),
(78, '2020-11-02 10:00:00', 4, 1, 'Irtifa'),
(79, '2020-11-03 10:00:00', 4, 1, 'Irtifa'),
(80, '2020-11-04 18:00:00', 4, 3, 'Irtifa'),
(81, '2020-11-04 10:00:00', 4, 1, 'Irtifa'),
(82, '2020-11-05 17:00:00', 4, 1, 'Irtifa'),
(83, '2020-11-05 18:00:00', 4, 3, 'Irtifa'),
(84, '2020-11-05 18:00:00', 3, 1, 'Nusrat'),
(85, '2020-11-08 17:00:00', 4, 1, 'Irtifa'),
(86, '2020-11-08 17:00:00', 3, 58, 'Nusrat'),
(87, '2020-11-08 18:00:00', 3, 163, 'Nusrat'),
(88, '2020-11-08 19:00:00', 3, 153, 'Nusrat'),
(89, '2020-11-08 19:00:00', 4, 4, 'Irtifa'),
(90, '2020-11-08 09:00:00', 3, 41, 'Nusrat'),
(91, '2020-11-08 10:00:00', 3, 133, 'Nusrat'),
(92, '2020-11-08 11:00:00', 3, 169, 'Nusrat'),
(93, '2020-11-09 17:00:00', 3, 74, 'Nusrat'),
(94, '2020-11-09 18:00:00', 3, 81, 'Nusrat'),
(95, '2020-11-09 19:00:00', 3, 78, 'Nusrat'),
(96, '2020-11-09 08:00:00', 3, 189, 'Nusrat'),
(97, '2020-11-09 09:00:00', 3, 16, 'Nusrat'),
(98, '2020-11-09 10:00:00', 3, 112, 'Nusrat'),
(99, '2020-11-09 11:00:00', 4, 1, 'Irtifa'),
(100, '2020-11-10 17:00:00', 3, 5, 'Nusrat'),
(101, '2020-11-10 18:00:00', 3, 118, 'Nusrat'),
(102, '2020-11-22 16:00:00', 1, 1, 'Sakeef'),
(103, '2020-11-26 18:00:00', 7, 0, 'paxzone'),
(104, '2021-01-25 17:00:00', 2, 0, 'Admin');

-- --------------------------------------------------------

--
-- Table structure for table `otp_expiry`
--

CREATE TABLE `otp_expiry` (
  `user_id` int(11) NOT NULL,
  `otp` varchar(100) NOT NULL,
  `is_expired` tinyint(1) NOT NULL DEFAULT 0,
  `create_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `duration` int(11) NOT NULL DEFAULT 8
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `paxzone_client_master`
--

CREATE TABLE `paxzone_client_master` (
  `id` int(20) NOT NULL,
  `CompanyName` varchar(255) NOT NULL DEFAULT '',
  `CompanyAddress` varchar(255) NOT NULL DEFAULT '',
  `ContactPerson` varchar(255) NOT NULL DEFAULT '',
  `Designation` varchar(255) NOT NULL DEFAULT '  ',
  `MobileNo` varchar(20) NOT NULL DEFAULT ' ',
  `EmailAddress` varchar(255) NOT NULL DEFAULT '  ',
  `ITManager` varchar(255) NOT NULL DEFAULT '',
  `ContactNo` varchar(20) NOT NULL DEFAULT '',
  `EmailAddress_IT` varchar(255) NOT NULL DEFAULT '',
  `Valid` tinyint(1) NOT NULL DEFAULT 1,
  `Zone` varchar(255) NOT NULL DEFAULT '',
  `Remarks` text DEFAULT NULL,
  `Status` varchar(100) NOT NULL DEFAULT 'Ready'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `paxzone_email_data`
--

CREATE TABLE `paxzone_email_data` (
  `id` int(20) NOT NULL,
  `EmailAddress` varchar(255) NOT NULL,
  `Valid` tinyint(1) NOT NULL,
  `Remarks` text DEFAULT NULL,
  `Status` varchar(20) NOT NULL DEFAULT 'Ready'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `payment_details`
--

CREATE TABLE `payment_details` (
  `id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `method` varchar(10) NOT NULL,
  `cheque_no` varchar(100) DEFAULT '',
  `bank` varchar(255) NOT NULL DEFAULT '',
  `amount` int(100) NOT NULL,
  `date` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `payment_details`
--

INSERT INTO `payment_details` (`id`, `account_id`, `method`, `cheque_no`, `bank`, `amount`, `date`) VALUES
(4, 1, 'Cheque', '6543', 'Asia', 100000, '2020-10-27'),
(5, 4, 'Cash', '', '', 55000, '2020-11-01'),
(6, 6, 'Cheque', '1117892', 'Dhaka Bank ', 45000, '2020-11-15'),
(7, 5, 'Cash', '', '', 2500, '2020-11-02'),
(8, 4, 'Cash', '', '', 55000, '2020-11-16'),
(9, 7, 'Cash', '', '', 33400, '2020-11-10'),
(10, 8, 'Cash', '', '', 39000, '2020-11-21'),
(11, 9, 'Cash', '', '', 28000, '2020-11-22');

-- --------------------------------------------------------

--
-- Table structure for table `proposals`
--

CREATE TABLE `proposals` (
  `id` int(11) NOT NULL,
  `create_at` varchar(25) NOT NULL,
  `Company_Name` varchar(255) NOT NULL DEFAULT '',
  `ContactPerson` varchar(100) NOT NULL DEFAULT '',
  `MobileNo` varchar(100) NOT NULL DEFAULT '',
  `EmailAddress` varchar(255) NOT NULL,
  `reference` varchar(20) NOT NULL,
  `user_name` varchar(20) NOT NULL,
  `note` text NOT NULL,
  `path` varchar(255) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `reminder`
--

CREATE TABLE `reminder` (
  `id` int(11) NOT NULL,
  `Company_Name` varchar(255) NOT NULL DEFAULT '',
  `user_name` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `date` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `table_details`
--

CREATE TABLE `table_details` (
  `id` int(11) NOT NULL,
  `tables` varchar(255) NOT NULL,
  `columns` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `table_details`
--

INSERT INTO `table_details` (`id`, `tables`, `columns`) VALUES
(1, 'paxzone_client_master', '[\"id\", \"CompanyName\", \"CompanyAddress\", \"ContactPerson\", \"Designation\", \"MobileNo\", \"EmailAddress\", \"ITManager\", \"ContactNo\", \"EmailAddress_IT\", \"Valid\", \"Zone\", \"Remarks\", \"Status\"]'),
(2, 'paxzone_email_data', '[\"id\", \"EmailAddress\", \"Valid\", \"Remarks\", \"Status\"]');

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `tables` varchar(255) NOT NULL,
  `start_no` int(11) NOT NULL,
  `end_no` int(11) NOT NULL,
  `assign_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `assign_by` varchar(255) NOT NULL,
  `completed_at` timestamp NULL DEFAULT NULL,
  `remarks` text NOT NULL,
  `status` varchar(11) NOT NULL DEFAULT 'Not Checked'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `user_details`
--

CREATE TABLE `user_details` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `designation` varchar(255) NOT NULL,
  `cell_no` varchar(20) NOT NULL,
  `path` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_details`
--

INSERT INTO `user_details` (`id`, `name`, `designation`, `cell_no`, `path`) VALUES
(1, 'Sakeef Ameer Prodhan', 'Software engineer', '01749596584', 'upload/user_image/Sakeef.jpg'),
(2, 'Paxzone Electronics', 'Business Development Officer', '236548', 'upload/user_image/Admin.jpg'),
(7, 'Md.Asifuzzaman', 'Business Development Officer', '0123456789', 'upload/user_image/paxzone.jpg'),
(9, 'mumu ', 'Business Development Officer', '1234520', 'upload/user_image/Sakeef.jpg'),
(13, 'Nusrat Sharmin Nisa', 'Business Development Officer', '2365452', 'upload/user_image/Sakeef.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `user_privillage`
--

CREATE TABLE `user_privillage` (
  `id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `tables_columns` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `email_id` varchar(255) NOT NULL DEFAULT '1',
  `otp_on` tinyint(1) NOT NULL DEFAULT 0,
  `otp_mail` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_privillage`
--

INSERT INTO `user_privillage` (`id`, `admin_id`, `tables_columns`, `email_id`, `otp_on`, `otp_mail`) VALUES
(12, 7, '{\"paxzone_email_data\":[\"id\",\"EmailAddress\",\"Valid\",\"Remarks\",\"Status\"]}', '[\"\"]', 0, ''),
(14, 7, '{\"paxzone_client_master\":[\"id\",\"Company_Name\",\"CompanyAddress\",\"ContactPerson\",\"Designation\",\"MobileNo\",\"EmailAddress\",\"ITManager\",\"ContactNo\",\"EmailAddress_IT\",\"Valid\",\"Zone\",\"Remarks\",\"Status\"]}', '[\"sales@paxzonebd.com\"]', 0, ''),
(15, 7, '{\"paxzone_client_master\":[\"id\",\"Company_Name\",\"CompanyAddress\",\"ContactPerson\",\"Designation\",\"MobileNo\",\"EmailAddress\",\"ITManager\",\"ContactNo\",\"EmailAddress_IT\",\"Valid\",\"Zone\",\"Remarks\",\"Status\"]}', '[\"sales@paxzonebd.com\"]', 0, ''),
(7, 7, '{\"paxzone_client_master\":[\"id\",\"CompanyName\",\"CompanyAddress\",\"ContactPerson\",\"Designation\",\"MobileNo\",\"EmailAddress\",\"ITManager\",\"ContactNo\",\"EmailAddress_IT\",\"Valid\",\"Zone\",\"Remarks\",\"Status\"],\"paxzone_email_data\":[\"id\",\"EmailAddress\",\"Valid\",\"Remarks\",\"Status\"],\"ecofarms_wholesale\":[\"id\",\"CompanyName\",\"CompanyAddress\",\"ContactPerson\",\"MobileNo\",\"EmailAddress\",\"Zone\",\"Remarks\",\"Status\"]}', '[\"sales@paxzonebd.com\",\"sales@vasttechnologybd.com\"]', 0, ''),
(13, 13, '{\"paxzone_client_master\":[\"id\",\"Company_Name\",\"CompanyAddress\",\"ContactPerson\",\"Designation\",\"MobileNo\",\"EmailAddress\",\"ITManager\",\"ContactNo\",\"EmailAddress_IT\",\"Zone\",\"Remarks\",\"Status\"],\"paxzone_email_data\":[\"id\",\"EmailAddress\",\"Valid\",\"Remarks\",\"Status\"]}', '[\"\"]', 0, ''),
(16, 7, '{\"paxzone_client_master\":[\"id\",\"Company_Name\",\"CompanyAddress\",\"ContactPerson\",\"Designation\",\"MobileNo\",\"EmailAddress\",\"ITManager\",\"ContactNo\",\"EmailAddress_IT\",\"Zone\",\"Remarks\",\"Status\"]}', '[\"sales@paxzonebd.com\"]', 0, ''),
(17, 7, '{\"paxzone_client_master\":[\"id\",\"Company_Name\",\"CompanyAddress\",\"ContactPerson\",\"Designation\",\"MobileNo\",\"EmailAddress\",\"ITManager\",\"ContactNo\",\"EmailAddress_IT\",\"Zone\",\"Remarks\",\"Status\"]}', '[\"sales@paxzonebd.com\"]', 0, ''),
(2, 1, '{\"paxzone_client_master\":[\"id\",\"CompanyName\",\"CompanyAddress\",\"ContactPerson\",\"Designation\",\"MobileNo\",\"EmailAddress\",\"ITManager\",\"ContactNo\",\"EmailAddress_IT\",\"Valid\",\"Zone\",\"Remarks\",\"Status\"],\"paxzone_email_data\":[\"id\",\"EmailAddress\",\"Valid\",\"Remarks\",\"Status\"]}', '[\"sales@paxzonebd.com\"]', 0, ''),
(1, 1, '{\"paxzone_client_master\":[\"id\",\"CompanyName\",\"CompanyAddress\",\"ContactPerson\",\"Designation\",\"MobileNo\",\"EmailAddress\",\"ITManager\",\"ContactNo\",\"EmailAddress_IT\",\"Valid\",\"Zone\",\"Remarks\",\"Status\"],\"paxzone_email_data\":[\"id\",\"EmailAddress\",\"Valid\",\"Remarks\",\"Status\"],\"ecofarms_wholesale\":[\"id\",\"CompanyName\",\"CompanyAddress\",\"ContactPerson\",\"MobileNo\",\"EmailAddress\",\"Zone\",\"Remarks\",\"Status\"]}', '[\"sales@paxzonebd.com\",\"sales@vasttechnologybd.com\"]', 0, ''),
(3, 1, '{\"paxzone_client_master\":[\"id\",\"CompanyName\",\"CompanyAddress\",\"ContactPerson\",\"Designation\",\"MobileNo\",\"EmailAddress\",\"ITManager\",\"ContactNo\",\"EmailAddress_IT\",\"Valid\",\"Zone\",\"Remarks\",\"Status\"],\"paxzone_email_data\":[\"id\",\"EmailAddress\",\"Valid\",\"Remarks\",\"Status\"],\"ecofarms_wholesale\":[\"id\",\"CompanyName\",\"CompanyAddress\",\"ContactPerson\",\"MobileNo\",\"EmailAddress\",\"Zone\",\"Remarks\",\"Status\"]}', '[\"sales@paxzonebd.com\"]', 0, ''),
(4, 1, '{\"paxzone_client_master\":[\"id\",\"CompanyName\",\"CompanyAddress\",\"ContactPerson\",\"Designation\",\"MobileNo\",\"EmailAddress\",\"ITManager\",\"ContactNo\",\"EmailAddress_IT\",\"Valid\",\"Zone\",\"Remarks\",\"Status\"]}', '[\"sales@paxzonebd.com\"]', 0, ''),
(5, 4, '{\"paxzone_client_master\":[\"id\",\"CompanyName\",\"CompanyAddress\",\"ContactPerson\",\"Designation\",\"MobileNo\",\"EmailAddress\",\"ITManager\",\"ContactNo\",\"EmailAddress_IT\",\"Valid\",\"Zone\",\"Remarks\",\"Status\"],\"ecofarms_wholesale\":[\"id\",\"CompanyName\",\"CompanyAddress\",\"ContactPerson\",\"MobileNo\",\"EmailAddress\",\"Zone\",\"Remarks\",\"Status\"]}', '[\"sales@paxzonebd.com\"]', 0, ''),
(6, 7, '{\"ecofarms_wholesale\":[\"id\",\"CompanyName\",\"CompanyAddress\",\"ContactPerson\",\"MobileNo\",\"EmailAddress\",\"Zone\",\"Remarks\",\"Status\"]}', '[\"\"]', 0, ''),
(8, 1, '{\"ecofarms_wholesale\":[\"id\",\"CompanyName\",\"CompanyAddress\",\"ContactPerson\",\"MobileNo\",\"EmailAddress\",\"Zone\",\"Remarks\",\"Status\"]}', '[\"\"]', 0, '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_accounts`
--
ALTER TABLE `admin_accounts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_name` (`user_name`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `email_details`
--
ALTER TABLE `email_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `file_list`
--
ALTER TABLE `file_list`
  ADD PRIMARY KEY (`No`);

--
-- Indexes for table `mailcounter`
--
ALTER TABLE `mailcounter`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `otp_expiry`
--
ALTER TABLE `otp_expiry`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `paxzone_client_master`
--
ALTER TABLE `paxzone_client_master`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `paxzone_email_data`
--
ALTER TABLE `paxzone_email_data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment_details`
--
ALTER TABLE `payment_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `proposals`
--
ALTER TABLE `proposals`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `reference` (`reference`);

--
-- Indexes for table `table_details`
--
ALTER TABLE `table_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `user_details`
--
ALTER TABLE `user_details`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `admin_accounts`
--
ALTER TABLE `admin_accounts`
  MODIFY `id` int(25) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `email_details`
--
ALTER TABLE `email_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `file_list`
--
ALTER TABLE `file_list`
  MODIFY `No` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `mailcounter`
--
ALTER TABLE `mailcounter`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=105;

--
-- AUTO_INCREMENT for table `paxzone_client_master`
--
ALTER TABLE `paxzone_client_master`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `paxzone_email_data`
--
ALTER TABLE `paxzone_email_data`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payment_details`
--
ALTER TABLE `payment_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `proposals`
--
ALTER TABLE `proposals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `table_details`
--
ALTER TABLE `table_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
