-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Oct 24, 2024 at 04:24 PM
-- Server version: 9.0.1
-- PHP Version: 8.3.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `astronomie`
--

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

DROP TABLE IF EXISTS `contact`;
CREATE TABLE IF NOT EXISTS `contact` (
  `id` tinyint NOT NULL AUTO_INCREMENT,
  `Firstname` varchar(100) NOT NULL,
  `Lastname` varchar(100) NOT NULL,
  `PhoneNumber` int NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Question` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `contact`
--

INSERT INTO `contact` (`id`, `Firstname`, `Lastname`, `PhoneNumber`, `Email`, `Question`) VALUES
(38, 'Marvin', 'Akpabot', 684266564, 'marvinakpabot@gmail.com', 'test'),
(39, 'Marvin', 'is', 656432167, 'jhjf@gmail.com', 'kjk'),
(40, 'F. Nimr&oacute;d', 'Loboz&aacute;r', 682297430, 'nimrod.lobozar@gmail.com', 'drgfghijouygf'),
(41, 'F. Nimr&amp;oacute;d', 'Loboz&amp;aacute;r', 682297430, 'nimrod.lobozar@gmail.com', 'aerstyu'),
(42, '-1', '-1', 682297430, 'nimrod.lobozar@gmail.com', 'uouoipo');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

DROP TABLE IF EXISTS `events`;
CREATE TABLE IF NOT EXISTS `events` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `date` date NOT NULL,
  `location` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `name`, `date`, `location`, `created_at`) VALUES
(1, 'Sneakerness Amsterdam', '2024-11-12', 'RAI Amsterdam', '2024-10-24 14:04:16'),
(2, 'Sneakerness Rotterdam', '2024-12-05', 'Ahoy Rotterdam', '2024-10-24 14:04:16');

-- --------------------------------------------------------

--
-- Table structure for table `plains`
--

DROP TABLE IF EXISTS `plains`;
CREATE TABLE IF NOT EXISTS `plains` (
  `id` int NOT NULL AUTO_INCREMENT,
  `event_id` int NOT NULL,
  `plain_name` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `event_id` (`event_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `plains`
--

INSERT INTO `plains` (`id`, `event_id`, `plain_name`, `created_at`) VALUES
(1, 1, 'Main Hall', '2024-10-24 14:04:16'),
(2, 1, 'Outdoor Area', '2024-10-24 14:04:16'),
(3, 2, 'Expo Hall', '2024-10-24 14:04:16');

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

DROP TABLE IF EXISTS `reservations`;
CREATE TABLE IF NOT EXISTS `reservations` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `stand_id` int NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `reserved_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `stand_id` (`stand_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`id`, `user_id`, `stand_id`, `company_name`, `reserved_at`) VALUES
(1, 1, 1, 'John’s Sneakers', '2024-10-24 14:04:16'),
(2, 2, 3, 'Jane’s Shoes', '2024-10-24 14:04:16'),
(3, 3, 1, 'kutklotenaam', '2024-10-24 14:35:34');

-- --------------------------------------------------------

--
-- Table structure for table `stands`
--

DROP TABLE IF EXISTS `stands`;
CREATE TABLE IF NOT EXISTS `stands` (
  `id` int NOT NULL AUTO_INCREMENT,
  `plain_id` int NOT NULL,
  `stand_number` int NOT NULL,
  `is_available` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `plain_id` (`plain_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `stands`
--

INSERT INTO `stands` (`id`, `plain_id`, `stand_number`, `is_available`, `created_at`) VALUES
(1, 1, 1, 0, '2024-10-24 14:04:16'),
(2, 1, 2, 1, '2024-10-24 14:04:16'),
(3, 2, 1, 1, '2024-10-24 14:04:16'),
(4, 2, 2, 0, '2024-10-24 14:04:16'),
(5, 3, 1, 1, '2024-10-24 14:04:16');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` tinyint UNSIGNED NOT NULL AUTO_INCREMENT,
  `Username` varchar(20) NOT NULL,
  `Email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `Password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `PreOrder` bit(1) NOT NULL DEFAULT b'0',
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=67 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `Username`, `Email`, `Password`, `PreOrder`, `date`) VALUES
(46, 'john_doe', 'john@example.com', 'hashed_password_1', b'0', '2024-10-01 08:15:00'),
(47, 'jane_smith', 'jane@example.com', 'hashed_password_2', b'1', '2024-10-01 09:30:00'),
(48, 'alex_jones', 'alex@example.com', 'hashed_password_3', b'0', '2024-09-30 12:45:00'),
(49, 'emily_brown', 'emily@example.com', 'hashed_password_4', b'1', '2024-09-29 11:05:00'),
(50, 'michael_white', 'michael@example.com', 'hashed_password_5', b'0', '2024-10-02 14:20:00'),
(51, 'sarah_green', 'sarah@example.com', 'hashed_password_6', b'0', '2024-09-28 10:10:00'),
(52, 'david_clark', 'david@example.com', 'hashed_password_7', b'1', '2024-09-27 13:50:00'),
(53, 'laura_wright', 'laura@example.com', 'hashed_password_8', b'0', '2024-09-26 16:35:00'),
(54, 'chris_martin', 'chris@example.com', 'hashed_password_9', b'0', '2024-10-03 07:25:00'),
(55, 'lisa_brown', 'lisa@example.com', 'hashed_password_10', b'1', '2024-09-25 17:10:00'),
(56, 'jason_taylor', 'jason@example.com', 'hashed_password_11', b'0', '2024-09-24 18:50:00'),
(57, 'anna_anderson', 'anna@example.com', 'hashed_password_12', b'1', '2024-09-23 20:30:00'),
(58, 'peter_lee', 'peter@example.com', 'hashed_password_13', b'0', '2024-10-01 06:15:00'),
(59, 'nancy_scott', 'nancy@example.com', 'hashed_password_14', b'0', '2024-09-22 21:25:00'),
(60, 'kevin_turner', 'kevin@example.com', 'hashed_password_15', b'1', '2024-10-02 22:40:00'),
(61, 'emma_hill', 'emma@example.com', 'hashed_password_16', b'0', '2024-09-21 08:35:00'),
(62, 'daniel_miller', 'daniel@example.com', 'hashed_password_17', b'1', '2024-09-20 09:20:00'),
(63, 'olivia_adams', 'olivia@example.com', 'hashed_password_18', b'0', '2024-09-19 10:50:00'),
(64, 'ethan_thompson', 'ethan@example.com', 'hashed_password_19', b'1', '2024-09-18 11:15:00'),
(65, 'katie_hughes', 'katie@example.com', 'hashed_password_20', b'0', '2024-09-17 12:05:00'),
(66, 'Nimród Lobozár', 'nimrod.lobozar@gmail.com', '$2y$10$1gdPABEtrRhY/t5dEU3l3ep7loWQiooMRMw/WDhxhy06B08caR3qK', b'1', '2006-02-11 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `created_at`) VALUES
(1, 'John Doe', 'john@example.com', 'passwordhash1', '2024-10-24 14:04:16'),
(2, 'Jane Smith', 'jane@example.com', 'passwordhash2', '2024-10-24 14:04:16'),
(3, 'Nimród Lobozár', 'nimrod.lobozar@gmail.com', '$2y$10$ghJvhk2QKyVAoBnwJ8M.cOSfJCTnv/RKhfS4XC5Wyp87eNNSz.sNO', '2024-10-24 14:04:29');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
