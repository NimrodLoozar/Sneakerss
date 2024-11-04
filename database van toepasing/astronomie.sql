-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Gép: 127.0.0.1:3306
-- Létrehozás ideje: 2024. Nov 04. 08:15
-- Kiszolgáló verziója: 9.0.1
-- PHP verzió: 8.3.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Adatbázis: `astronomie`
--
DROP DATABASE IF EXISTS `astronomie`;
CREATE DATABASE `astronomie`;
USE `astronomie`;
-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `contact`
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
-- A tábla adatainak kiíratása `contact`
--

INSERT INTO `contact` (`id`, `Firstname`, `Lastname`, `PhoneNumber`, `Email`, `Question`) VALUES
(38, 'Marvin', 'Akpabot', 684266564, 'marvinakpabot@gmail.com', 'test'),
(39, 'Marvin', 'is', 656432167, 'jhjf@gmail.com', 'kjk'),
(40, 'F. Nimr&oacute;d', 'Loboz&aacute;r', 682297430, 'nimrod.lobozar@gmail.com', 'drgfghijouygf'),
(41, 'F. Nimr&amp;oacute;d', 'Loboz&amp;aacute;r', 682297430, 'nimrod.lobozar@gmail.com', 'aerstyu'),
(42, '-1', '-1', 682297430, 'nimrod.lobozar@gmail.com', 'uouoipo');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `events`
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
-- A tábla adatainak kiíratása `events`
--

INSERT INTO `events` (`id`, `name`, `start_date`, `end_date`, `location`) VALUES
(1, 'Sneakerness Van Nelle Fabriek', '2024-10-26', '2024-10-27', 'Van Nelle Fabriek'),
(2, 'Sneakerness Millenáris Budapest', '2024-12-02', '2024-12-03', 'Millenáris Budapest');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `messages`
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
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- A tábla adatainak kiíratása `messages`
--

INSERT INTO `messages` (`id`, `user_id`, `messages`, `is_read`, `created_at`) VALUES
(12, 4, 'Je reservering is goedgekeurd.', 0, '2024-10-31 09:31:28'),
(13, 4, 'Je reservering is goedgekeurd.', 0, '2024-10-31 09:31:29'),
(14, 3, 'Je reservering is goedgekeurd.', 1, '2024-10-31 09:32:25'),
(15, 4, 'Je reservering is goedgekeurd.', 0, '2024-10-31 09:54:02');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `plains`
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
-- A tábla adatainak kiíratása `plains`
--

INSERT INTO `plains` (`id`, `event_id`, `plain_name`) VALUES
(1, 2, 'Gebouw B'),
(2, 2, 'Gebouw C'),
(3, 2, 'Gebouw D'),
(4, 2, 'Gebouw E'),
(5, 2, 'Gebouw G');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `reservations`
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
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `stand_id` (`stand_id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- A tábla adatainak kiíratása `reservations`
--

INSERT INTO `reservations` (`id`, `user_id`, `stand_id`, `company_name`, `statuses`, `days`, `total_price`) VALUES
(13, 4, 2, 'Sneaker Design505', 'approved', 2, 300.00),
(14, 4, 25, 'kutklotenaam', 'approved', 2, 400.00),
(15, 3, 31, 'Kankernaam', 'approved', 2, 200.00),
(16, 4, 45, 'liuyt', 'approved', 2, 300.00);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `sections`
--

DROP TABLE IF EXISTS `sections`;
CREATE TABLE IF NOT EXISTS `sections` (
  `id` int NOT NULL AUTO_INCREMENT,
  `section_name` varchar(255) NOT NULL,
  `is_visible` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- A tábla adatainak kiíratása `sections`
--

INSERT INTO `sections` (`id`, `section_name`, `is_visible`) VALUES
(1, 'about', 0),
(2, 'services', 1),
(3, 'gallery', 1),
(4, 'banner-content', 1),
(5, 'testimonials', 1),
(6, 'clients', 1),
(7, 'sneaker', 1),
(8, 'exclusive', 1),
(9, 'podium', 1),
(10, 'stand-map-section', 0),
(11, 'pricing', 1);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `stands`
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
-- A tábla adatainak kiíratása `stands`
--

INSERT INTO `stands` (`id`, `plain_id`, `stand_number`, `is_available`, `price_per_day`) VALUES
(1, 1, 'A', 1, 100.00),
(2, 1, 'AA', 0, 150.00),
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
(25, 2, 'AA+', 0, 200.00),
(26, 2, 'A', 1, 100.00),
(27, 2, 'A', 1, 100.00),
(28, 2, 'AA', 1, 150.00),
(29, 2, 'A', 1, 100.00),
(30, 2, 'AA+', 1, 200.00),
(31, 3, 'A', 0, 100.00),
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
(45, 4, 'AA', 0, 150.00),
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
-- Tábla szerkezet ehhez a táblához `stand_pricing`
--

DROP TABLE IF EXISTS `stand_pricing`;
CREATE TABLE IF NOT EXISTS `stand_pricing` (
  `id` int NOT NULL AUTO_INCREMENT,
  `stand_type` varchar(50) NOT NULL,
  `price_per_day` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- A tábla adatainak kiíratása `stand_pricing`
--

INSERT INTO `stand_pricing` (`id`, `stand_type`, `price_per_day`) VALUES
(1, 'A', 100.00),
(2, 'AA', 150.00),
(3, 'AA+', 200.00);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `user`
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
-- A tábla adatainak kiíratása `user`
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
-- Tábla szerkezet ehhez a táblához `users`
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
-- A tábla adatainak kiíratása `users`
--

INSERT INTO `users` (`id`, `username`, `first_name`, `last_name`, `country`, `street`, `adres`, `city`, `state_province`, `zip_postal_code`, `email`, `password`, `created_at`, `is_admin`, `about`, `profile_photo`, `cover_photo`) VALUES
(1, 'John Doe', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'john@example.com', 'passwordhash1', '2024-10-24 14:04:16', 0, NULL, NULL, NULL),
(2, 'Jane Smith', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'jane@example.com', 'passwordhash2', '2024-10-24 14:04:16', 0, NULL, NULL, NULL),
(3, 'NimrodLobozar', 'F. Nimród', '', NULL, NULL, NULL, NULL, NULL, NULL, 'nimrod.lobozar@gmail.com', '$2y$10$ghJvhk2QKyVAoBnwJ8M.cOSfJCTnv/RKhfS4XC5Wyp87eNNSz.sNO', '2024-10-24 14:04:29', 1, '', 'assets/img/uploads/profile_3_294052465_5222177057837600_119414460320895139_n.jpg', 'assets/img/default/default-cover.jpg'),
(4, 'TestUser', 'F. Nimród', 'Lobozár', 'Nederland', 'Australie', '25', 'Utrecht', 'Utrecht', '6574PL', 'test@gmail.com', '$2y$10$Mz8DQZgpGzkjx0fyCFYj2O2.vibTbhYxxvk25FhmbZQxZ2lAZS86u', '2024-10-26 22:48:05', 0, '', 'assets/img/uploads/profile_6_imageedit_2_2174348917-300x300.png', 'assets/img/uploads/cover_4_ferenc.lobozar_Hungarian_style_castle__surrounded_by_pine_tree__1b7b63a0-7855-4855-b3ba-45d1b13326c3.png');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
