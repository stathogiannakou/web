-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2.1
-- http://www.phpmyadmin.net
--
-- Φιλοξενητής: localhost
-- Χρόνος δημιουργίας: 01 Οκτ 2018 στις 15:29:27
-- Έκδοση διακομιστή: 5.7.23-0ubuntu0.16.04.1
-- Έκδοση PHP: 7.0.32-0ubuntu0.16.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Βάση δεδομένων: `web`
--
CREATE DATABASE IF NOT EXISTS `web` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `web`;

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `dianomeas`
--

CREATE TABLE `dianomeas` (
  `id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL,
  `onoma` varchar(20) DEFAULT NULL,
  `epwnumo` varchar(20) DEFAULT NULL,
  `afm` varchar(10) DEFAULT NULL,
  `amka` varchar(11) DEFAULT NULL,
  `iban` varchar(27) DEFAULT NULL,
  `energos` enum('0','1') DEFAULT '0' COMMENT '0: oxi , 1: nai',
  `diathesimos` enum('0','1') DEFAULT '0' COMMENT '0: oxi , 1: nai',
  `lat` double DEFAULT NULL,
  `lon` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Άδειασμα δεδομένων του πίνακα `dianomeas`
--

INSERT INTO `dianomeas` (`id`, `username`, `password`, `onoma`, `epwnumo`, `afm`, `amka`, `iban`, `energos`, `diathesimos`, `lat`, `lon`) VALUES
(1, 'dianomeas1', '123456', 'Stamatis', 'Stathogiannakos', '11111111', '1111111111', 'GR12345678990', '0', '0', 38.2392459, 21.7289628),
(2, 'dianomeas2', '123456', 'Antonis', 'Barkas', '1234567890', '12345678890', 'GR123456778901235678', '0', '0', NULL, NULL),
(3, 'dianomeas3', '123456', 'Kiriakos', 'Pantazaras', '1234567890', '1234567890', 'GR12345678909865322', '0', '0', NULL, NULL);

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `katastima`
--

CREATE TABLE `katastima` (
  `id` int(11) NOT NULL,
  `onoma` varchar(20) NOT NULL,
  `dieuthunsi` varchar(50) NOT NULL,
  `tilefwno` varchar(10) NOT NULL,
  `lat` double DEFAULT NULL,
  `lon` double DEFAULT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL,
  `onoma_upeuthunou` varchar(20) NOT NULL,
  `epwnumo_upeuthunou` varchar(20) NOT NULL,
  `afm` varchar(10) NOT NULL,
  `amka` varchar(11) NOT NULL,
  `iban` varchar(27) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Άδειασμα δεδομένων του πίνακα `katastima`
--

INSERT INTO `katastima` (`id`, `onoma`, `dieuthunsi`, `tilefwno`, `lat`, `lon`, `username`, `password`, `onoma_upeuthunou`, `epwnumo_upeuthunou`, `afm`, `amka`, `iban`) VALUES
(1, 'katastima1', 'Βιτσέντζου Κορνάρου 46, Πάτρα 264 42', '2610082848', NULL, NULL, 'root_kat1', '123456', 'Matina', 'Stathogiannakou', '11111111', '1111111111', 'GR12345678990'),
(2, 'katastima2', 'Τσαμαδού 83, Πάτρα 262 22', '2610828481', NULL, NULL, 'root_kat2', '123456', 'Antonia', 'Barka', '123456789', '1234567890', 'GR123456789012344'),
(3, 'katastima3', 'Ναυαρίνου 76-78, Πάτρα 262 22', '2610444444', NULL, NULL, 'root_kat3', '123456', 'Kiki', 'Pantazara', '1234567890', '1234567890', 'GR12345678909865322');

--
-- Δείκτες `katastima`
--
DELIMITER $$
CREATE TRIGGER `snack` AFTER INSERT ON `katastima` FOR EACH ROW INSERT INTO snak (id_proiontos, id_katastimatos, posotita) VALUES (6, NEW.id, 0 ), (7, NEW.id, 0 ), (8, NEW.id, 0 ), (9, NEW.id, 0 ), (10, NEW.id, 0 )
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `paragelia`
--

CREATE TABLE `paragelia` (
  `id` int(11) NOT NULL,
  `onoma` varchar(20) NOT NULL,
  `epwnumo` varchar(20) NOT NULL,
  `odos` varchar(40) NOT NULL,
  `orofos` varchar(4) NOT NULL,
  `tilefwno` varchar(10) NOT NULL,
  `sunoliko_poso` double NOT NULL,
  `mera` int(2) DEFAULT NULL,
  `minas` int(2) DEFAULT NULL,
  `etos` int(2) DEFAULT NULL,
  `katastasi` enum('0','1') DEFAULT '0' COMMENT '0: ekremei  , 1: paradothike',
  `id_dianomea` int(11) NOT NULL,
  `xiliometra` double DEFAULT NULL,
  `id_pelati` int(11) NOT NULL,
  `id_katastimatos` int(11) NOT NULL,
  `DateTime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Άδειασμα δεδομένων του πίνακα `paragelia`
--

INSERT INTO `paragelia` (`id`, `onoma`, `epwnumo`, `odos`, `orofos`, `tilefwno`, `sunoliko_poso`, `mera`, `minas`, `etos`, `katastasi`, `id_dianomea`, `xiliometra`, `id_pelati`, `id_katastimatos`, `DateTime`) VALUES
(1, 'Antonia', 'Mparka', 'Θεμιστοκλέους 32, Πάτρα 262 22, Ελλάδα', '6', '6987980888', 24, 1, 10, 2018, '1', 1, 1.138, 1, 1, '2018-10-01 15:22:30');

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `pelatis`
--

CREATE TABLE `pelatis` (
  `id` int(100) NOT NULL,
  `email` varchar(45) NOT NULL,
  `password` text NOT NULL,
  `tilefwno` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Άδειασμα δεδομένων του πίνακα `pelatis`
--

INSERT INTO `pelatis` (`id`, `email`, `password`, `tilefwno`) VALUES
(1, 'niabarka@yahoo.com', '$2y$10$AY03fl1BiWp4yS/dQ0Lquu9u6hrBX/J8Cq2LM6KR8GI7dHDPVhaq6', '6987980888');

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `perilambanei`
--

CREATE TABLE `perilambanei` (
  `id_paragelias` int(11) NOT NULL,
  `id_proiontos` int(11) NOT NULL,
  `posotita` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Άδειασμα δεδομένων του πίνακα `perilambanei`
--

INSERT INTO `perilambanei` (`id_paragelias`, `id_proiontos`, `posotita`) VALUES
(1, 4, 5),
(1, 7, 1),
(1, 8, 1),
(1, 9, 1),
(1, 10, 1);

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `proion`
--

CREATE TABLE `proion` (
  `id` int(11) NOT NULL,
  `perigrafi` text NOT NULL,
  `timi` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Άδειασμα δεδομένων του πίνακα `proion`
--

INSERT INTO `proion` (`id`, `perigrafi`, `timi`) VALUES
(1, 'Ελληνικός', 1),
(2, 'Φραπές', 2),
(3, 'Εσπρέσο', 3),
(4, 'Καπουτσίνο', 3.5),
(5, 'Φίλτρου', 2.5),
(6, 'Τυρόπιτα', 1.2),
(7, 'Χορτόπιτα', 1.5),
(8, 'Κουλούρι', 0.5),
(9, 'Τοστ', 2),
(10, 'Κέικ', 2.5);

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `snak`
--

CREATE TABLE `snak` (
  `id_proiontos` int(11) NOT NULL,
  `id_katastimatos` int(11) NOT NULL,
  `posotita` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Άδειασμα δεδομένων του πίνακα `snak`
--

INSERT INTO `snak` (`id_proiontos`, `id_katastimatos`, `posotita`) VALUES
(6, 1, 20),
(7, 1, 19),
(8, 1, 19),
(9, 1, 19),
(10, 1, 19),
(6, 2, 15),
(7, 2, 15),
(8, 2, 15),
(9, 2, 15),
(10, 2, 15),
(6, 3, 0),
(7, 3, 0),
(8, 3, 0),
(9, 3, 0),
(10, 3, 0);

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `wrario`
--

CREATE TABLE `wrario` (
  `id` int(11) NOT NULL,
  `mera` varchar(2) DEFAULT NULL,
  `minas` varchar(2) DEFAULT NULL,
  `etos` varchar(4) DEFAULT NULL,
  `wra_enarksis` time DEFAULT NULL,
  `liksi` datetime DEFAULT NULL,
  `id_dianomea` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Άδειασμα δεδομένων του πίνακα `wrario`
--

INSERT INTO `wrario` (`id`, `mera`, `minas`, `etos`, `wra_enarksis`, `liksi`, `id_dianomea`) VALUES
(1, '1', '10', '2018', '15:05:45', '2018-10-01 15:24:37', 1);

--
-- Ευρετήρια για άχρηστους πίνακες
--

--
-- Ευρετήρια για πίνακα `dianomeas`
--
ALTER TABLE `dianomeas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Ευρετήρια για πίνακα `katastima`
--
ALTER TABLE `katastima`
  ADD PRIMARY KEY (`id`);

--
-- Ευρετήρια για πίνακα `paragelia`
--
ALTER TABLE `paragelia`
  ADD PRIMARY KEY (`id`);

--
-- Ευρετήρια για πίνακα `pelatis`
--
ALTER TABLE `pelatis`
  ADD PRIMARY KEY (`id`);

--
-- Ευρετήρια για πίνακα `proion`
--
ALTER TABLE `proion`
  ADD PRIMARY KEY (`id`);

--
-- Ευρετήρια για πίνακα `wrario`
--
ALTER TABLE `wrario`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT για άχρηστους πίνακες
--

--
-- AUTO_INCREMENT για πίνακα `dianomeas`
--
ALTER TABLE `dianomeas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT για πίνακα `katastima`
--
ALTER TABLE `katastima`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT για πίνακα `paragelia`
--
ALTER TABLE `paragelia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT για πίνακα `pelatis`
--
ALTER TABLE `pelatis`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT για πίνακα `proion`
--
ALTER TABLE `proion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT για πίνακα `wrario`
--
ALTER TABLE `wrario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
