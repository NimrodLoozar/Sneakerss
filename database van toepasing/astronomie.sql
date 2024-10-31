-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Oct 30, 2024 at 09:57 AM
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
DROP DATABASE IF EXISTS astronomie;
CREATE DATABASE astronomie;
USE astronomie;
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
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
(1, 2, 'Gebouw B'),
(2, 2, 'Gebouw C'),
(3, 2, 'Gebouw D'),
(4, 2, 'Gebouw E'),
(5, 2, 'Gebouw G');

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
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `reservations`
--

-- --------------------------------------------------------

--
-- Table structure for table `sections`
--

DROP TABLE IF EXISTS `sections`;
CREATE TABLE IF NOT EXISTS `sections` (
  `id` int NOT NULL AUTO_INCREMENT,
  `section_name` varchar(255) NOT NULL,
  `is_visible` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `sections`
--

INSERT INTO `sections` (`id`, `section_name`, `is_visible`) VALUES
(1, 'about', 1),
(2, 'services', 1),
(3, 'gallery', 1),
(4, 'banner-content', 1),
(5, 'testimonials', 1),
(6, 'clients', 1),
(7, 'sneaker', 1),
(8, 'exclusive', 1),
(9, 'podium', 1),
(10, 'stand-map-section', 1),
(11, 'pricing', 1);

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
(1, 1, 'A', 0),
(2, 1, 'AA', 1),
(3, 1, 'A', 1),
(4, 1, 'AA+', 1),
(5, 1, 'A', 1),
(6, 1, 'AA+', 1),
(7, 1, 'AA', 1),
(8, 1, 'A', 1),
(9, 1, 'A', 1),
(10, 1, 'AA', 1),
(11, 1, 'AA+', 1),
(12, 1, 'A', 1),
(13, 1, 'AA', 1),
(14, 1, 'A', 1),
(15, 1, 'AA+', 1),
(16, 2, 'A', 1),
(17, 2, 'AA+', 1),
(18, 2, 'AA', 1),
(19, 2, 'A', 1),
(20, 2, 'AA', 1),
(21, 2, 'AA+', 1),
(22, 2, 'A', 1),
(23, 2, 'A', 1),
(24, 2, 'AA', 1),
(25, 2, 'AA+', 1),
(26, 2, 'A', 1),
(27, 2, 'A', 1),
(28, 2, 'AA', 1),
(29, 2, 'A', 1),
(30, 2, 'AA+', 1),
(31, 3, 'A', 1),
(32, 3, 'AA+', 1),
(33, 3, 'AA', 1),
(34, 3, 'A', 1),
(35, 3, 'AA', 1),
(36, 3, 'AA+', 1),
(37, 3, 'A', 1),
(38, 3, 'AA', 1),
(39, 3, 'AA+', 1),
(40, 3, 'A', 1),
(41, 3, 'AA', 1),
(42, 3, 'A', 1),
(43, 3, 'A', 1),
(44, 3, 'AA+', 1),
(45, 4, 'AA', 1),
(46, 4, 'A', 1),
(47, 4, 'AA+', 1),
(48, 4, 'A', 1),
(49, 4, 'AA', 1),
(50, 4, 'A', 1),
(51, 4, 'AA+', 1),
(52, 4, 'A', 1),
(53, 4, 'AA', 1),
(54, 4, 'AA+', 1),
(55, 4, 'A', 1),
(56, 4, 'AA', 1),
(57, 4, 'AA+', 1),
(58, 5, 'A', 1),
(59, 5, 'AA+', 1),
(60, 5, 'AA', 1);

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
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `street` varchar(255) DEFAULT NULL,
  `adres` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `state_province` varchar(255) DEFAULT NULL,
  `zip_postal_code` varchar(20) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `is_admin` tinyint(1) DEFAULT '0',
  `about` text,
  `profile_photo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT 'assets/img/default/default-profile.png',
  `cover_photo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT 'assets/img/default/default-profile.jpg',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `first_name`, `last_name`, `country`, `street`, `adres`, `city`, `state_province`, `zip_postal_code`, `email`, `password`, `created_at`, `is_admin`, `about`, `profile_photo`, `cover_photo`) VALUES
(1, 'John Doe', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'john@example.com', 'passwordhash1', '2024-10-24 14:04:16', 0, NULL, NULL, NULL),
(2, 'Jane Smith', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'jane@example.com', 'passwordhash2', '2024-10-24 14:04:16', 0, NULL, NULL, NULL),
(3, 'NimrodLobozar', 'F. Nimród', '', NULL, NULL, NULL, NULL, NULL, NULL, 'nimrod.lobozar@gmail.com', '$2y$10$ghJvhk2QKyVAoBnwJ8M.cOSfJCTnv/RKhfS4XC5Wyp87eNNSz.sNO', '2024-10-24 14:04:29', 1, '', 'assets/img/uploads/profile_3_294052465_5222177057837600_119414460320895139_n.jpg', 'assets/img/default/default-cover.jpg'),
(4, 'TestUser', 'F. Nimród', 'Lobozár', 'Nederland', 'Australie', '25', 'Utrecht', 'Utrecht', '6574PL', 'test@gmail.com', '$2y$10$Mz8DQZgpGzkjx0fyCFYj2O2.vibTbhYxxvk25FhmbZQxZ2lAZS86u', '2024-10-26 22:48:05', 0, '', 'assets/img/uploads/profile_6_imageedit_2_2174348917-300x300.png', 'assets/img/uploads/cover_4_ferenc.lobozar_Hungarian_style_castle__surrounded_by_pine_tree__1b7b63a0-7855-4855-b3ba-45d1b13326c3.png');


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
