-- Run dit script om de database te maken ---
-- Verander dit script als je de database aanvult --


--
-- Database: `astronomie`
--

DROP DATABASE IF EXISTS `astronomie`;
CREATE DATABASE `astronomie`;

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

INSERT INTO `user` (`id`, `Username`, `Email`, `Password`, `date`, `PreOrder`) VALUES
(44, 'stmakpabot ', 'marvinakpabot@gmail.com', '$2y$10$XzVjteqbWnm32cu0yDFLCOLScGmXZC8RaCXExIQD2DQo6LGW7m5r2', '2024-06-23 22:05:35', 1),
(45, 'hoi', 'hoi@hl.nl', '$2y$10$FtMY3Xht736MgrPNSN2w8OkPWXFD2EGw7WQ/WxitHARZykL.DfP/O', '2024-06-23 23:54:55', 1);
COMMIT;
