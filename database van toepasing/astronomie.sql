-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 05, 2024 at 11:24 PM
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
DROP DATABASE IF EXISTS `astronomie`;
CREATE DATABASE IF NOT EXISTS `astronomie` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `astronomie`;

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
(2, 'Sneakerness Millenáris Budapest', '2024-12-02', '2024-12-03', 'Millenáris Budapest');

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
) ENGINE=MyISAM AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `messages`
--


-- --------------------------------------------------------

--
-- Table structure for table `newsletters`
--

DROP TABLE IF EXISTS `newsletters`;
CREATE TABLE IF NOT EXISTS `newsletters` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `sent_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `event_id` int NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `event_id` (`event_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

DROP TABLE IF EXISTS `order_items`;
CREATE TABLE IF NOT EXISTS `order_items` (
  `id` int NOT NULL AUTO_INCREMENT,
  `order_id` int NOT NULL,
  `ticket_type` varchar(255) NOT NULL,
  `quantity` int NOT NULL,
  `price` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
  `days` int NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `about` text,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `stand_id` (`stand_id`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
(11, 'pricing', 1),
(12, 'pre-order-sneakers', 1);

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
  `price_per_day` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `plain_id` (`plain_id`)
) ENGINE=MyISAM AUTO_INCREMENT=61 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `stands`
--

INSERT INTO `stands` (`id`, `plain_id`, `stand_number`, `is_available`, `price_per_day`) VALUES
(1, 1, 'A', 1, 100.00),
(2, 1, 'AA', 1, 150.00),
(3, 1, 'A', 1, 100.00),
(4, 1, 'AA+', 1, 200.00),
(5, 1, 'A', 1, 100.00),
(6, 1, 'AA+', 1, 200.00),
(7, 1, 'AA', 1, 150.00),
(8, 1, 'A', 1, 100.00),
(9, 1, 'A', 1, 100.00),
(10, 1, 'AA', 1, 150.00),
(11, 1, 'AA+', 1, 200.00),
(12, 1, 'A', 1, 100.00),
(13, 1, 'AA', 1, 150.00),
(14, 1, 'A', 1, 100.00),
(15, 1, 'AA+', 1, 200.00),
(16, 2, 'A', 1, 100.00),
(17, 2, 'AA+', 1, 200.00),
(18, 2, 'AA', 1, 150.00),
(19, 2, 'A', 1, 100.00),
(20, 2, 'AA', 1, 150.00),
(21, 2, 'AA+', 1, 200.00),
(22, 2, 'A', 1, 100.00),
(23, 2, 'A', 1, 100.00),
(24, 2, 'AA', 1, 150.00),
(25, 2, 'AA+', 1, 200.00),
(26, 2, 'A', 1, 100.00),
(27, 2, 'A', 1, 100.00),
(28, 2, 'AA', 1, 150.00),
(29, 2, 'A', 1, 100.00),
(30, 2, 'AA+', 1, 200.00),
(31, 3, 'A', 1, 100.00),
(32, 3, 'AA+', 1, 200.00),
(33, 3, 'AA', 1, 150.00),
(34, 3, 'A', 1, 100.00),
(35, 3, 'AA', 1, 150.00),
(36, 3, 'AA+', 1, 200.00),
(37, 3, 'A', 1, 100.00),
(38, 3, 'AA', 1, 150.00),
(39, 3, 'AA+', 1, 200.00),
(40, 3, 'A', 1, 100.00),
(41, 3, 'AA', 1, 150.00),
(42, 3, 'A', 1, 100.00),
(43, 3, 'A', 1, 100.00),
(44, 3, 'AA+', 1, 200.00),
(45, 4, 'AA', 1, 150.00),
(46, 4, 'A', 1, 100.00),
(47, 4, 'AA+', 1, 200.00),
(48, 4, 'A', 1, 100.00),
(49, 4, 'AA', 1, 150.00),
(50, 4, 'A', 1, 100.00),
(51, 4, 'AA+', 1, 200.00),
(52, 4, 'A', 1, 100.00),
(53, 4, 'AA', 1, 150.00),
(54, 4, 'AA+', 1, 200.00),
(55, 4, 'A', 1, 100.00),
(56, 4, 'AA', 1, 150.00),
(57, 4, 'AA+', 1, 200.00),
(58, 5, 'A', 1, 100.00),
(59, 5, 'AA+', 1, 200.00),
(60, 5, 'AA', 1, 150.00);

-- --------------------------------------------------------

--
-- Table structure for table `stand_pricing`
--

DROP TABLE IF EXISTS `stand_pricing`;
CREATE TABLE IF NOT EXISTS `stand_pricing` (
  `id` int NOT NULL AUTO_INCREMENT,
  `stand_type` varchar(50) NOT NULL,
  `price_per_day` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `stand_pricing`
--

INSERT INTO `stand_pricing` (`id`, `stand_type`, `price_per_day`) VALUES
(1, 'A', 100.00),
(2, 'AA', 150.00),
(3, 'AA+', 200.00);

-- --------------------------------------------------------

--
-- Table structure for table `subscriptions`
--

DROP TABLE IF EXISTS `subscriptions`;
CREATE TABLE IF NOT EXISTS `subscriptions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(100) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `subscribed_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `is_active` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `subscriptions`
--


-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
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
  `cover_photo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT 'assets/img/default/default-cover.jpg',
  `PreOrder` tinyint(1) DEFAULT '0',
  `date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `first_name`, `last_name`, `country`, `street`, `adres`, `city`, `state_province`, `zip_postal_code`, `email`, `password`, `created_at`, `is_admin`, `about`, `profile_photo`, `cover_photo`, `PreOrder`, `date`) VALUES
(1, 'NimrodLobozar', 'F. Nimród', 'Lobozár', '', '', '', '', '', '', 'nimrod.lobozar@gmail.com', '$2y$10$ghJvhk2QKyVAoBnwJ8M.cOSfJCTnv/RKhfS4XC5Wyp87eNNSz.sNO', '2024-10-24 14:04:29', 1, '', 'assets/img/uploads/profile_3_294052465_5222177057837600_119414460320895139_n.jpg', 'assets/img/uploads/cover_1_cover_4_ferenc.lobozar_Hungarian_style_castle__surrounded_by_pine_tree__1b7b63a0-7855-4855-b3ba-45d1b13326c3.png', 0, '2024-11-04 12:05:34'),
(2, 'TestUser', 'F. Nimród', 'Lobozár', 'Nederland', 'Australie', '25', 'Utrecht', 'Utrecht', '6574PL', 'test@gmail.com', '$2y$10$Mz8DQZgpGzkjx0fyCFYj2O2.vibTbhYxxvk25FhmbZQxZ2lAZS86u', '2024-10-26 22:48:05', 0, '', 'assets/img/uploads/profile_6_imageedit_2_2174348917-300x300.png', 'assets/img/uploads/cover_4_ferenc.lobozar_Hungarian_style_castle__surrounded_by_pine_tree__1b7b63a0-7855-4855-b3ba-45d1b13326c3.png', 0, '2024-11-04 12:05:34'),
(3, 'john_doe', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'john@example.com', 'hashed_password_1', '2024-10-01 08:15:00', 0, NULL, NULL, NULL, 0, '2024-11-04 12:05:34'),
(4, 'jane_smith', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'jane@example.com', 'hashed_password_2', '2024-10-01 09:30:00', 0, NULL, NULL, NULL, 0, '2024-11-04 12:05:34'),
(5, 'alex_jones', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'alex@example.com', 'hashed_password_3', '2024-09-30 12:45:00', 0, NULL, NULL, NULL, 0, '2024-11-04 12:05:34'),
(6, 'emily_brown', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'emily@example.com', 'hashed_password_4', '2024-09-29 11:05:00', 0, NULL, NULL, NULL, 0, '2024-11-04 12:05:34'),
(7, 'michael_white', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'michael@example.com', 'hashed_password_5', '2024-10-02 14:20:00', 0, NULL, NULL, NULL, 0, '2024-11-04 12:05:34'),
(8, 'sarah_green', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'sarah@example.com', 'hashed_password_6', '2024-09-28 10:10:00', 0, NULL, NULL, NULL, 0, '2024-11-04 12:05:34'),
(9, 'david_clark', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'david@example.com', 'hashed_password_7', '2024-09-27 13:50:00', 0, NULL, NULL, NULL, 0, '2024-11-04 12:05:34'),
(10, 'laura_wright', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'laura@example.com', 'hashed_password_8', '2024-09-26 16:35:00', 0, NULL, NULL, NULL, 0, '2024-11-04 12:05:34'),
(11, 'chris_martin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'chris@example.com', 'hashed_password_9', '2024-10-03 07:25:00', 0, NULL, NULL, NULL, 0, '2024-11-04 12:05:34'),
(12, 'lisa_brown', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'lisa@example.com', 'hashed_password_10', '2024-09-25 17:10:00', 0, NULL, NULL, NULL, 0, '2024-11-04 12:05:34'),
(13, 'jason_taylor', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'jason@example.com', 'hashed_password_11', '2024-09-24 18:50:00', 0, NULL, NULL, NULL, 0, '2024-11-04 12:05:34'),
(14, 'anna_anderson', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'anna@example.com', 'hashed_password_12', '2024-09-23 20:30:00', 0, NULL, NULL, NULL, 0, '2024-11-04 12:05:34'),
(15, 'peter_lee', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'peter@example.com', 'hashed_password_13', '2024-10-01 06:15:00', 0, NULL, NULL, NULL, 0, '2024-11-04 12:05:34'),
(16, 'nancy_scott', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'nancy@example.com', 'hashed_password_14', '2024-09-22 21:25:00', 0, NULL, NULL, NULL, 0, '2024-11-04 12:05:34'),
(17, 'kevin_turner', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'kevin@example.com', 'hashed_password_15', '2024-10-02 22:40:00', 0, NULL, NULL, NULL, 0, '2024-11-04 12:05:34'),
(18, 'emma_hill', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'emma@example.com', 'hashed_password_16', '2024-09-21 08:35:00', 0, NULL, NULL, NULL, 0, '2024-11-04 12:05:34'),
(19, 'daniel_miller', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'daniel@example.com', 'hashed_password_17', '2024-09-20 09:20:00', 0, NULL, NULL, NULL, 0, '2024-11-04 12:05:34'),
(20, 'olivia_adams', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'olivia@example.com', 'hashed_password_18', '2024-09-19 10:50:00', 0, NULL, NULL, NULL, 0, '2024-11-04 12:05:34'),
(21, 'ethan_thompson', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'ethan@example.com', 'hashed_password_19', '2024-09-18 11:15:00', 0, NULL, NULL, NULL, 0, '2024-11-04 12:05:34'),
(22, 'katie_hughes', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'katie@example.com', 'hashed_password_20', '2024-09-17 12:05:00', 0, NULL, NULL, NULL, 0, '2024-11-04 12:05:34'),
(23, 'TestAdmin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'test@admin.com', '$2y$10$JdSy8RJC2hvJlg/KItZ.UuJzJ7D/5cDMGTz9xbbGQXOPCkQKNVy6G', '2024-11-04 17:27:27', 1, NULL, 'https://avatar.iran.liara.run/public/boy?username=Ash', 'assets/img/default/default-cover.jpg', 0, '2024-11-04 17:27:27');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
