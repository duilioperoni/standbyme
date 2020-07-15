-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Lug 15, 2020 alle 08:09
-- Versione del server: 10.4.11-MariaDB
-- Versione PHP: 7.4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `standbyme`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `device`
--

CREATE TABLE `device` (
  `id` int(11) NOT NULL,
  `btmac` varchar(12) NOT NULL,
  `wifimac` varchar(12) NOT NULL,
  `status` int(11) NOT NULL,
  `timestamp` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `device`
--

INSERT INTO `device` (`id`, `btmac`, `wifimac`, `status`, `timestamp`) VALUES
(1, '240ac4623d6a', 'ffffffffff01', 0, 1594792090),
(2, '240ac462411a', 'ffffffffff02', 0, 1594792090),
(3, 'fcf5c42e1cca', 'ffffffffff03', 0, 1594792090),
(4, 'fcf5c42f303e', 'ffffffffff04', 0, 1594792090);

-- --------------------------------------------------------

--
-- Struttura della tabella `proxy`
--

CREATE TABLE `proxy` (
  `mybtmac` varchar(12) NOT NULL,
  `otherbtmac` varchar(12) NOT NULL,
  `timestamp` bigint(20) NOT NULL,
  `status` int(11) NOT NULL,
  `duration` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `proxy`
--

INSERT INTO `proxy` (`mybtmac`, `otherbtmac`, `timestamp`, `status`, `duration`) VALUES
('240ac4623d6a', '240ac462411a', 1594792981, 1, 0),
('240ac4623d6a', '240ac462411a', 1594792992, 0, 11),
('240ac4623d6a', '240ac462411a', 1594793017, 1, 0),
('240ac4623d6a', '240ac462411a', 1594793026, 0, 9),
('240ac462411a', '240ac4623d6a', 1594792981, 1, 0),
('240ac462411a', '240ac4623d6a', 1594792992, 0, 11);

-- --------------------------------------------------------

--
-- Struttura della tabella `thing`
--

CREATE TABLE `thing` (
  `id` int(11) NOT NULL,
  `btmac` varchar(12) NOT NULL,
  `wifimac` varchar(12) NOT NULL,
  `status` int(11) NOT NULL,
  `timestamp` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `thing`
--

INSERT INTO `thing` (`id`, `btmac`, `wifimac`, `status`, `timestamp`) VALUES
(1, '240ac4623d6a', 'ffffffffff01', 0, 1594792992),
(2, '240ac462411a', 'ffffffffff02', 0, 1594792992),
(3, 'fcf5c42e1cca', 'ffffffffff03', 0, 1594792992),
(4, 'fcf5c42f303e', 'ffffffffff04', 0, 1594792992);

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `device`
--
ALTER TABLE `device`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD UNIQUE KEY `wifimacindex` (`wifimac`),
  ADD UNIQUE KEY `btmacindez` (`btmac`);

--
-- Indici per le tabelle `proxy`
--
ALTER TABLE `proxy`
  ADD PRIMARY KEY (`mybtmac`,`otherbtmac`,`timestamp`);

--
-- Indici per le tabelle `thing`
--
ALTER TABLE `thing`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD UNIQUE KEY `wifimacindex` (`wifimac`),
  ADD UNIQUE KEY `btmacindez` (`btmac`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
