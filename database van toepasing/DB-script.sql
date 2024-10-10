-- Run dit script om de database te maken ---
-- Verander dit script als je de database aanvult --


--
-- Database: `astronomie`
--
DROP DATABASE IF EXISTS `astronomie`;
CREATE DATABASE IF NOT EXISTS `astronomie`;

USE `astronomie`;


-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `contact`
--

DROP TABLE IF EXISTS `contact`;
CREATE TABLE `contact` (
  `id` tinyint NOT NULL AUTO_INCREMENT,
  `Firstname` varchar(100) NOT NULL,
  `Lastname` varchar(100) NOT NULL,
  `PhoneNumber` int NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Question` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Gegevens worden geëxporteerd voor tabel `contact`
--

INSERT INTO `contact` (`id`, `Firstname`, `Lastname`, `PhoneNumber`, `Email`, `Question`) VALUES
(38, 'Marvin', 'Akpabot', 684266564, 'marvinakpabot@gmail.com', 'test'),
(39, 'Marvin', 'is', 656432167, 'jhjf@gmail.com', 'kjk');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` tinyint UNSIGNED NOT NULL AUTO_INCREMENT,
  `Username` varchar(20) NOT NULL,
  `Email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `Password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `PreOrder` BIT NOT NULL DEFAULT 0,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Gegevens worden geëxporteerd voor tabel `user`
--

INSERT INTO `user` (`Username`, `Email`, `Password`, `PreOrder`, `date`)
VALUES
('john', 'john@example.com', 'hashed_password_1', 0, '2024-10-01 08:15:00'),
('jane', 'jane@example.com', 'hashed_password_2', 1, '2024-10-01 09:30:00'),
('alex', 'alex@example.com', 'hashed_password_3', 0, '2024-09-30 12:45:00'),
('emily', 'emily@example.com', 'hashed_password_4', 1, '2024-09-29 11:05:00'),
('michael', 'michael@example.com', 'hashed_password_5', 0, '2024-10-02 14:20:00'),
('sarah', 'sarah@example.com', 'hashed_password_6', 0, '2024-09-28 10:10:00'),
('david', 'david@example.com', 'hashed_password_7', 1, '2024-09-27 13:50:00'),
('laura', 'laura@example.com', 'hashed_password_8', 0, '2024-09-26 16:35:00'),
('chris', 'chris@example.com', 'hashed_password_9', 0, '2024-10-03 07:25:00'),
('lisa', 'lisa@example.com', 'hashed_password_10', 1, '2024-09-25 17:10:00'),
('jason', 'jason@example.com', 'hashed_password_11', 0, '2024-09-24 18:50:00'),
('anna', 'anna@example.com', 'hashed_password_12', 1, '2024-09-23 20:30:00'),
('peter', 'peter@example.com', 'hashed_password_13', 0, '2024-10-01 06:15:00'),
('nancy', 'nancy@example.com', 'hashed_password_14', 0, '2024-09-22 21:25:00');
