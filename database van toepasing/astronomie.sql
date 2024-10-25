-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Oct 25, 2024 at 06:16 AM
-- Server version: 8.2.0
-- PHP Version: 8.2.13

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
  `name` varchar(255) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `location` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `name`, `start_date`, `end_date`, `location`) VALUES
(1, 'Sneakerness Van Nelle Fabriek', '2024-10-26', '2024-10-27', 'Van Nelle Fabriek'),
(2, 'Sneakerness Millenáris Budapest', '2024-11-02', '2024-11-03', 'Millenáris Budapest');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

DROP TABLE IF EXISTS `messages`;
CREATE TABLE IF NOT EXISTS `messages` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `messages` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `is_read` tinyint(1) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `messages`
--

-- --------------------------------------------------------

--
-- Table structure for table `plains`
--

DROP TABLE IF EXISTS `plains`;
CREATE TABLE IF NOT EXISTS `plains` (
  `id` int NOT NULL AUTO_INCREMENT,
  `event_id` int DEFAULT NULL,
  `plain_name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `event_id` (`event_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `plains`
--

INSERT INTO `plains` (`id`, `event_id`, `plain_name`) VALUES
(1, 1, 'Plein A'),
(2, 1, 'Plein B'),
(3, 1, 'Plein C'),
(4, 2, 'Plein D'),
(5, 2, 'Plein E'),
(6, 2, 'Plein F');

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

DROP TABLE IF EXISTS `reservations`;
CREATE TABLE IF NOT EXISTS `reservations` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `stand_id` int DEFAULT NULL,
  `company_name` varchar(255) DEFAULT NULL,
  `statuses` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT 'active',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `stand_id` (`stand_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `reservations`
--


-- --------------------------------------------------------

--
-- Table structure for table `stands`
--

DROP TABLE IF EXISTS `stands`;
CREATE TABLE IF NOT EXISTS `stands` (
  `id` int NOT NULL AUTO_INCREMENT,
  `plain_id` int DEFAULT NULL,
  `stand_number` varchar(50) NOT NULL,
  `is_available` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `plain_id` (`plain_id`)
) ENGINE=MyISAM AUTO_INCREMENT=61 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `stands`
--

INSERT INTO `stands` (`id`, `plain_id`, `stand_number`, `is_available`) VALUES
(1, 1, '1', 0),
(2, 1, '2', 0),
(3, 1, '3', 1),
(4, 1, '4', 1),
(5, 1, '5', 1),
(6, 1, '6', 1),
(7, 1, '7', 1),
(8, 1, '8', 1),
(9, 1, '9', 1),
(10, 1, '10', 1),
(11, 2, '1', 1),
(12, 2, '2', 1),
(13, 2, '3', 1),
(14, 2, '4', 1),
(15, 2, '5', 1),
(16, 2, '6', 1),
(17, 2, '7', 1),
(18, 2, '8', 1),
(19, 2, '9', 1),
(20, 2, '10', 1),
(21, 3, '1', 1),
(22, 3, '2', 1),
(23, 3, '3', 1),
(24, 3, '4', 1),
(25, 3, '5', 1),
(26, 3, '6', 1),
(27, 3, '7', 1),
(28, 3, '8', 1),
(29, 3, '9', 1),
(30, 3, '10', 1),
(31, 4, '1', 0),
(32, 4, '2', 1),
(33, 4, '3', 1),
(34, 4, '4', 1),
(35, 4, '5', 1),
(36, 4, '6', 1),
(37, 4, '7', 1),
(38, 4, '8', 1),
(39, 4, '9', 1),
(40, 4, '10', 1),
(41, 5, '1', 0),
(42, 5, '2', 0),
(43, 5, '3', 1),
(44, 5, '4', 1),
(45, 5, '5', 1),
(46, 5, '6', 1),
(47, 5, '7', 1),
(48, 5, '8', 1),
(49, 5, '9', 1),
(50, 5, '10', 1),
(51, 6, '1', 1),
(52, 6, '2', 1),
(53, 6, '3', 1),
(54, 6, '4', 1),
(55, 6, '5', 1),
(56, 6, '6', 1),
(57, 6, '7', 1),
(58, 6, '8', 1),
(59, 6, '9', 1),
(60, 6, '10', 1);

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
  `is_admin` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `created_at`, `is_admin`) VALUES
(1, 'John Doe', 'john@example.com', 'passwordhash1', '2024-10-24 14:04:16', 0),
(2, 'Jane Smith', 'jane@example.com', 'passwordhash2', '2024-10-24 14:04:16', 0),
(3, 'Nimród Lobozár', 'nimrod.lobozar@gmail.com', '$2y$10$ghJvhk2QKyVAoBnwJ8M.cOSfJCTnv/RKhfS4XC5Wyp87eNNSz.sNO', '2024-10-24 14:04:29', 1),
(5, 'TestUser', 'test@gmail.com', '$2y$10$TNQskGITXrJj1h8UgWSq/uXcd.cn2jjiGazOkXDO9.b1gH1vWRLaW', '2024-10-24 20:13:33', 0);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
