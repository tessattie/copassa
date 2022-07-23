-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jul 23, 2022 at 05:56 PM
-- Server version: 5.7.36
-- PHP Version: 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ar`
--

-- --------------------------------------------------------

--
-- Table structure for table `authorizations`
--

DROP TABLE IF EXISTS `authorizations`;
CREATE TABLE IF NOT EXISTS `authorizations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `type` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=63 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `authorizations`
--

INSERT INTO `authorizations` (`id`, `name`, `type`) VALUES
(1, 'Access Dashboard', 1),
(2, 'Access Policies Report', 2),
(3, 'Export Policies Report', 2),
(4, 'Access Payments Report', 2),
(5, 'Export Payments Report', 2),
(6, 'Access Renewals Report', 2),
(7, 'Export Renewals Report', 2),
(8, 'Access Coorporate Groups Report', 2),
(9, 'Export Coorporate Groups Report', 2),
(10, 'Access Insurance Companies Page', 3),
(12, 'Add / Edit Insurance Companies', 3),
(16, 'View Countries', 4),
(17, 'Add / Edit Countries', 4),
(23, 'View Policies', 5),
(24, 'Add / Edit Policies', 5),
(27, 'View Pending New Business', 6),
(28, 'Add / Edit Pending New Business', 6),
(30, 'View Maternity Reminders', 7),
(31, 'Add / Edit Maternity Reminders', 7),
(33, 'View Policy Renewals', 8),
(35, 'Edit Policy Renewals', 8),
(36, 'View Corporate Groups', 9),
(37, 'View Premium Values for Corporate Groups', 9),
(38, 'Add / Edit Corporate Groups', 9),
(40, 'View Renewals for Corporate Groups', 9),
(42, 'Add / Edit Renewals for Corporate Groups', 9),
(43, 'Access Agency Ressources', 10),
(44, 'Add / Edit Resources for Agency', 10),
(49, 'View Riders', 12),
(50, 'Add / Edit Riders', 12),
(52, 'View Claims', 13),
(53, 'Add / Edit Claims', 13),
(55, 'Export Claims', 13),
(56, 'View Settings', 13),
(57, 'Add / Edit Claim Settings', 13),
(59, 'View Agents ', 4),
(60, 'Add / Edit Agents', 4),
(62, 'Do associations between Agents and Countries', 4);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
