-- phpMyAdmin SQL Dump
-- version 4.2.12deb2+deb8u1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 28, 2016 at 04:42 PM
-- Server version: 5.5.49-0+deb8u1
-- PHP Version: 5.6.20-0+deb8u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `jrpl_dev`
--
CREATE DATABASE IF NOT EXISTS `jrpl_dev` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `jrpl_dev`;

DELIMITER $$
--
-- Procedures
--
DROP PROCEDURE IF EXISTS `ViewPredictions`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `ViewPredictions`()
    NO SQL
SELECT
	IFNULL(u.`DisplayName`,CONCAT(u.`FirstName`, ' ', u.`LastName`)) AS Name
    ,COUNT(p.`PredictionID`) AS Predictions
FROM `Prediction` AS p
	RIGHT JOIN `User` AS u ON
    	u.`UserID` = p.`UserID`
    LEFT JOIN `UserRole` AS ur ON
    	ur.`UserID` = u.`UserID`
    LEFT JOIN `Role` AS r ON
    	r.`RoleID` = ur.`RoleID`
WHERE
	r.`Role` IS NULL OR
    r.`Role` NOT IN ('Mr Mean', 'Mr Median', 'Mr Mode')
GROUP BY u.`UserID`
ORDER BY COUNT(p.`PredictionID`) DESC$$

DELIMITER ;

DROP TABLE IF EXISTS `Points`;
DROP TABLE IF EXISTS `Prediction`;

DROP TABLE IF EXISTS `Emails`;
DROP TABLE IF EXISTS `Match`;
DROP TABLE IF EXISTS `Team`;
DROP TABLE IF EXISTS `Venue`;
DROP TABLE IF EXISTS `Broadcaster`;
DROP TABLE IF EXISTS `GameWeek`;

DROP TABLE IF EXISTS `RememberMe`;
DROP TABLE IF EXISTS `UserRole`;
DROP TABLE IF EXISTS `User`;
DROP TABLE IF EXISTS `Role`;

-- --------------------------------------------------------

--
-- Table structure for table `Broadcaster`
--

CREATE TABLE IF NOT EXISTS `Broadcaster` (
`BroadcasterID` int(11) NOT NULL,
  `Name` varchar(20) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Broadcaster`
--

INSERT INTO `Broadcaster` (`BroadcasterID`, `Name`) VALUES
(1, 'Sky Sports'),
(2, 'BT Sport'),
(3, 'BBC Sport'),
(4, 'Prime Video'),
(5, 'TBC');

-- --------------------------------------------------------

--
-- Table structure for table `Emails`
--

CREATE TABLE IF NOT EXISTS `Emails` (
`EmailsID` int(11) NOT NULL,
  `MatchID` int(11) NOT NULL,
  `PredictionsSent` tinyint(1) NOT NULL,
  `ResultsSent` tinyint(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

--
-- RELATIONS FOR TABLE `Emails`:
--   `MatchID`
--       `Match` -> `MatchID`
--

--
-- Dumping data for table `Emails`
--

INSERT INTO `Emails` (`EmailsID`, `MatchID`, `PredictionsSent`, `ResultsSent`) VALUES
(1, 1, 0, 0),
(2, 2, 0, 0),
(3, 3, 0, 0),
(4, 4, 0, 0),
(5, 5, 0, 0),
(6, 6, 0, 0),
(7, 7, 0, 0),
(8, 8, 0, 0),
(9, 9, 0, 0),
(10, 10, 0, 0),
(11, 11, 0, 0),
(12, 12, 0, 0),
(13, 13, 0, 0),
(14, 14, 0, 0),
(15, 15, 0, 0),
(16, 16, 0, 0),
(17, 17, 0, 0),
(18, 18, 0, 0),
(19, 19, 0, 0),
(20, 20, 0, 0),
(21, 21, 0, 0),
(22, 22, 0, 0),
(23, 23, 0, 0),
(24, 24, 0, 0),
(25, 25, 0, 0),
(26, 26, 0, 0),
(27, 27, 0, 0),
(28, 28, 0, 0),
(29, 29, 0, 0),
(30, 30, 0, 0),
(31, 31, 0, 0),
(32, 32, 0, 0),
(33, 33, 0, 0),
(34, 34, 0, 0),
(35, 35, 0, 0),
(36, 36, 0, 0),
(37, 37, 0, 0),
(38, 38, 0, 0),
(39, 39, 0, 0),
(40, 40, 0, 0),
(41, 41, 0, 0),
(42, 42, 0, 0),
(43, 43, 0, 0),
(44, 44, 0, 0),
(45, 45, 0, 0),
(46, 46, 0, 0),
(47, 47, 0, 0),
(48, 48, 0, 0),
(49, 49, 0, 0),
(50, 50, 0, 0),
(51, 51, 0, 0),
(52, 52, 0, 0),
(53, 53, 0, 0),
(54, 54, 0, 0),
(55, 55, 0, 0),
(56, 56, 0, 0),
(57, 57, 0, 0),
(58, 58, 0, 0),
(59, 59, 0, 0),
(60, 60, 0, 0),
(61, 61, 0, 0),
(62, 62, 0, 0),
(63, 63, 0, 0),
(64, 64, 0, 0),
(65, 65, 0, 0),
(66, 66, 0, 0),
(67, 67, 0, 0),
(68, 68, 0, 0),
(69, 69, 0, 0),
(70, 70, 0, 0),
(71, 71, 0, 0),
(72, 72, 0, 0),
(73, 73, 0, 0),
(74, 74, 0, 0),
(75, 75, 0, 0),
(76, 76, 0, 0),
(77, 77, 0, 0),
(78, 78, 0, 0),
(79, 79, 0, 0),
(80, 80, 0, 0),
(81, 81, 0, 0),
(82, 82, 0, 0),
(83, 83, 0, 0),
(84, 84, 0, 0),
(85, 85, 0, 0),
(86, 86, 0, 0),
(87, 87, 0, 0),
(88, 88, 0, 0),
(89, 89, 0, 0),
(90, 90, 0, 0),
(91, 91, 0, 0),
(92, 92, 0, 0),
(93, 93, 0, 0),
(94, 94, 0, 0),
(95, 95, 0, 0),
(96, 96, 0, 0),
(97, 97, 0, 0),
(98, 98, 0, 0),
(99, 99, 0, 0),
(100, 100, 0, 0),
(101, 101, 0, 0),
(102, 102, 0, 0),
(103, 103, 0, 0),
(104, 104, 0, 0),
(105, 105, 0, 0),
(106, 106, 0, 0),
(107, 107, 0, 0),
(108, 108, 0, 0),
(109, 109, 0, 0),
(110, 110, 0, 0),
(111, 111, 0, 0),
(112, 112, 0, 0),
(113, 113, 0, 0),
(114, 114, 0, 0),
(115, 115, 0, 0),
(116, 116, 0, 0),
(117, 117, 0, 0),
(118, 118, 0, 0),
(119, 119, 0, 0),
(120, 120, 0, 0),
(121, 121, 0, 0),
(122, 122, 0, 0),
(123, 123, 0, 0),
(124, 124, 0, 0),
(125, 125, 0, 0),
(126, 126, 0, 0),
(127, 127, 0, 0),
(128, 128, 0, 0),
(129, 129, 0, 0),
(130, 130, 0, 0),
(131, 131, 0, 0),
(132, 132, 0, 0),
(133, 133, 0, 0),
(134, 134, 0, 0),
(135, 135, 0, 0),
(136, 136, 0, 0),
(137, 137, 0, 0),
(138, 138, 0, 0),
(139, 139, 0, 0),
(140, 140, 0, 0),
(141, 141, 0, 0),
(142, 142, 0, 0),
(143, 143, 0, 0),
(144, 144, 0, 0),
(145, 145, 0, 0),
(146, 146, 0, 0),
(147, 147, 0, 0),
(148, 148, 0, 0),
(149, 149, 0, 0),
(150, 150, 0, 0),
(151, 151, 0, 0),
(152, 152, 0, 0),
(153, 153, 0, 0),
(154, 154, 0, 0),
(155, 155, 0, 0),
(156, 156, 0, 0),
(157, 157, 0, 0),
(158, 158, 0, 0),
(159, 159, 0, 0),
(160, 160, 0, 0),
(161, 161, 0, 0),
(162, 162, 0, 0),
(163, 163, 0, 0),
(164, 164, 0, 0),
(165, 165, 0, 0),
(166, 166, 0, 0),
(167, 167, 0, 0),
(168, 168, 0, 0),
(169, 169, 0, 0),
(170, 170, 0, 0),
(171, 171, 0, 0),
(172, 172, 0, 0),
(173, 173, 0, 0),
(174, 174, 0, 0),
(175, 175, 0, 0),
(176, 176, 0, 0),
(177, 177, 0, 0),
(178, 178, 0, 0),
(179, 179, 0, 0),
(180, 180, 0, 0),
(181, 181, 0, 0),
(182, 182, 0, 0),
(183, 183, 0, 0),
(184, 184, 0, 0),
(185, 185, 0, 0),
(186, 186, 0, 0),
(187, 187, 0, 0),
(188, 188, 0, 0),
(189, 189, 0, 0),
(190, 190, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `GameWeek`
--

CREATE TABLE IF NOT EXISTS `GameWeek` (
  `GameWeekID` int(11) NOT NULL,
  `Name` varchar(20) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=latin1;


--
-- Dumping data for table `GameWeek`
--

INSERT INTO `GameWeek` (`GameWeekID`, `Name`) VALUES
(1, 'Game Week 1'),
(2, 'Game Week 2'),
(3, 'Game Week 3'),
(4, 'Game Week 4'),
(5, 'Game Week 5'),
(6, 'Game Week 6'),
(7, 'Game Week 7'),
(8, 'Game Week 8'),
(9, 'Game Week 9'),
(10, 'Game Week 10'),
(11, 'Game Week 11'),
(12, 'Game Week 12'),
(13, 'Game Week 13'),
(14, 'Game Week 14'),
(15, 'Game Week 15'),
(16, 'Game Week 16'),
(17, 'Game Week 17'),
(18, 'Game Week 18'),
(19, 'Game Week 19'),
(20, 'Game Week 20'),
(21, 'Game Week 21'),
(22, 'Game Week 22'),
(23, 'Game Week 23'),
(24, 'Game Week 24'),
(25, 'Game Week 25'),
(26, 'Game Week 26'),
(27, 'Game Week 27'),
(28, 'Game Week 28'),
(29, 'Game Week 29'),
(30, 'Game Week 30'),
(31, 'Game Week 31'),
(32, 'Game Week 32'),
(33, 'Game Week 33'),
(34, 'Game Week 34'),
(35, 'Game Week 35'),
(36, 'Game Week 36'),
(37, 'Game Week 37'),
(38, 'Game Week 38');

-- --------------------------------------------------------

--
-- Table structure for table `Match`
--

CREATE TABLE IF NOT EXISTS `Match` (
  `MatchID` int(11) NOT NULL,
  `Date` date NOT NULL,
  `KickOff` time NOT NULL,
  `GameWeekID` int(11) NOT NULL,
  `VenueID` int(11) NOT NULL,
  `HomeTeamID` int(11) NOT NULL,
  `AwayTeamID` int(11) NOT NULL,
  `HomeTeamPoints` int(11) DEFAULT NULL,
  `AwayTeamPoints` int(11) DEFAULT NULL,
  `ResultPostedBy` int(11) DEFAULT NULL,
  `ResultPostedOn` datetime DEFAULT NULL,
  `BroadcasterID` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

--
-- RELATIONS FOR TABLE `Match`:
--   `AwayTeamID`
--       `Team` -> `TeamID`
--   `BroadcasterID`
--       `Broadcaster` -> `BroadcasterID`
--   `GameWeekID`
--       `GameWeek` -> `GameWeekID`
--   `HomeTeamID`
--       `Team` -> `TeamID`
--   `ResultPostedBy`
--       `User` -> `UserID`
--   `VenueID`
--       `Venue` -> `VenueID`
--

--
-- Dumping data for table `Match`
--

INSERT INTO `Match` (`MatchID`, `Date`, `KickOff`, `GameWeekID`, `VenueID`, `HomeTeamID`, `AwayTeamID`, `HomeTeamPoints`, `AwayTeamPoints`, `ResultPostedBy`, `ResultPostedOn`, `BroadcasterID`) VALUES
(1, '2020-09-12', '12:30:00', 1, 8, 8, 1, NULL, NULL, NULL, NULL, 2),
(2, '2020-09-12', '15:00:00', 1, 6, 6, 16, NULL, NULL, NULL, NULL, 2),
(3, '2020-09-12', '17:30:00', 1, 11, 11, 9, NULL, NULL, NULL, NULL, 1),
(4, '2020-09-12', '20:00:00', 1, 19, 19, 14, NULL, NULL, NULL, NULL, 1),
(5, '2020-09-13', '14:00:00', 1, 18, 18, 10, NULL, NULL, NULL, NULL, 1),
(6, '2020-09-13', '16:30:00', 1, 17, 17, 7, NULL, NULL, NULL, NULL, 1),
(7, '2020-09-14', '18:00:00', 1, 15, 15, 20, NULL, NULL, NULL, NULL, 1),
(8, '2020-09-14', '20:15:00', 1, 3, 3, 5, NULL, NULL, NULL, NULL, 1),
(9, '2021-06-01', '00:00:00', 1, 4, 4, 13, NULL, NULL, NULL, NULL, 5),
(10, '2021-06-01', '00:00:00', 1, 12, 12, 2, NULL, NULL, NULL, NULL, 5),
(11, '2020-09-19', '12:30:00', 2, 7, 7, 18, NULL, NULL, NULL, NULL, 2),
(12, '2020-09-19', '15:00:00', 2, 9, 9, 8, NULL, NULL, NULL, NULL, 2),
(13, '2020-09-19', '17:30:00', 2, 13, 13, 6, NULL, NULL, NULL, NULL, 1),
(14, '2020-09-19', '20:00:00', 2, 1, 1, 19, NULL, NULL, NULL, NULL, 1),
(15, '2020-09-20', '12:00:00', 2, 16, 16, 17, NULL, NULL, NULL, NULL, 2),
(16, '2020-09-20', '14:00:00', 2, 14, 14, 3, NULL, NULL, NULL, NULL, 1),
(17, '2020-09-20', '16:30:00', 2, 5, 5, 11, NULL, NULL, NULL, NULL, 1),
(18, '2020-09-20', '19:00:00', 2, 10, 10, 4, NULL, NULL, NULL, NULL, 3),
(19, '2020-09-21', '18:00:00', 2, 2, 2, 15, NULL, NULL, NULL, NULL, 1),
(20, '2020-09-21', '20:15:00', 2, 20, 20, 12, NULL, NULL, NULL, NULL, 1),
(21, '2020-09-26', '12:30:00', 3, 3, 3, 13, NULL, NULL, NULL, NULL, 2),
(22, '2020-09-26', '15:00:00', 3, 6, 6, 7, NULL, NULL, NULL, NULL, 4),
(23, '2020-09-26', '17:30:00', 3, 18, 18, 5, NULL, NULL, NULL, NULL, 1),
(24, '2020-09-26', '20:00:00', 3, 4, 4, 16, NULL, NULL, NULL, NULL, 1),
(25, '2020-09-27', '12:00:00', 3, 15, 15, 9, NULL, NULL, NULL, NULL, 2),
(26, '2020-09-27', '14:00:00', 3, 17, 17, 14, NULL, NULL, NULL, NULL, 1),
(27, '2020-09-27', '16:30:00', 3, 12, 12, 10, NULL, NULL, NULL, NULL, 1),
(28, '2020-09-27', '19:00:00', 3, 19, 19, 20, NULL, NULL, NULL, NULL, 2),
(29, '2020-09-26', '18:00:00', 3, 8, 8, 2, NULL, NULL, NULL, NULL, 1),
(30, '2020-09-26', '20:15:00', 3, 11, 11, 1, NULL, NULL, NULL, NULL, 1),
(31, '2020-10-03', '15:00:00', 4, 7, 7, 3, NULL, NULL, NULL, NULL, 5),
(32, '2020-10-03', '15:00:00', 4, 9, 9, 12, NULL, NULL, NULL, NULL, 5),
(33, '2020-10-03', '15:00:00', 4, 13, 13, 17, NULL, NULL, NULL, NULL, 5),
(34, '2020-10-03', '15:00:00', 4, 10, 10, 19, NULL, NULL, NULL, NULL, 5),
(35, '2020-10-03', '15:00:00', 4, 20, 20, 8, NULL, NULL, NULL, NULL, 5),
(36, '2020-10-03', '15:00:00', 4, 1, 1, 15, NULL, NULL, NULL, NULL, 5),
(37, '2020-10-03', '15:00:00', 4, 16, 16, 18, NULL, NULL, NULL, NULL, 5),
(38, '2020-10-03', '15:00:00', 4, 14, 14, 4, NULL, NULL, NULL, NULL, 5),
(39, '2020-10-03', '15:00:00', 4, 5, 5, 6, NULL, NULL, NULL, NULL, 5),
(40, '2020-10-03', '15:00:00', 4, 2, 2, 11, NULL, NULL, NULL, NULL, 5),
(41, '2020-10-17', '15:00:00', 5, 9, 9, 20, NULL, NULL, NULL, NULL, 5),
(42, '2020-10-17', '15:00:00', 5, 12, 12, 1, NULL, NULL, NULL, NULL, 5),
(43, '2020-10-17', '15:00:00', 5, 7, 7, 11, NULL, NULL, NULL, NULL, 5),
(44, '2020-10-17', '15:00:00', 5, 18, 18, 4, NULL, NULL, NULL, NULL, 5),
(45, '2020-10-17', '15:00:00', 5, 5, 5, 16, NULL, NULL, NULL, NULL, 5),
(46, '2020-10-17', '15:00:00', 5, 17, 17, 19, NULL, NULL, NULL, NULL, 5),
(47, '2020-10-17', '15:00:00', 5, 14, 14, 13, NULL, NULL, NULL, NULL, 5),
(48, '2020-10-17', '15:00:00', 5, 10, 10, 2, NULL, NULL, NULL, NULL, 5),
(49, '2020-10-17', '15:00:00', 5, 15, 15, 8, NULL, NULL, NULL, NULL, 5),
(50, '2020-10-17', '15:00:00', 5, 6, 6, 3, NULL, NULL, NULL, NULL, 5),
(51, '2021-06-01', '00:00:00', 6, 1, 1, 10, NULL, NULL, NULL, NULL, 5),
(52, '2020-10-24', '15:00:00', 6, 8, 8, 6, NULL, NULL, NULL, NULL, 5),
(53, '2020-10-24', '15:00:00', 6, 16, 16, 7, NULL, NULL, NULL, NULL, 5),
(54, '2020-10-24', '15:00:00', 6, 2, 2, 9, NULL, NULL, NULL, NULL, 5),
(55, '2020-10-24', '15:00:00', 6, 19, 19, 12, NULL, NULL, NULL, NULL, 5),
(56, '2020-10-24', '15:00:00', 6, 20, 20, 14, NULL, NULL, NULL, NULL, 5),
(57, '2020-10-24', '15:00:00', 6, 4, 4, 17, NULL, NULL, NULL, NULL, 5),
(58, '2020-10-24', '15:00:00', 6, 13, 13, 5, NULL, NULL, NULL, NULL, 5),
(59, '2020-10-24', '15:00:00', 6, 3, 3, 18, NULL, NULL, NULL, NULL, 5),
(60, '2020-10-24', '15:00:00', 6, 11, 11, 15, NULL, NULL, NULL, NULL, 5),
(61, '2021-06-01', '00:00:00', 7, 13, 13, 1, NULL, NULL, NULL, NULL, 5),
(62, '2021-06-01', '00:00:00', 7, 9, 9, 10, NULL, NULL, NULL, NULL, 5),
(63, '2020-10-31', '15:00:00', 7, 14, 14, 7, NULL, NULL, NULL, NULL, 5),
(64, '2020-10-31', '15:00:00', 7, 4, 4, 5, NULL, NULL, NULL, NULL, 5),
(65, '2020-10-31', '15:00:00', 7, 2, 2, 16, NULL, NULL, NULL, NULL, 5),
(66, '2020-10-31', '15:00:00', 7, 17, 17, 3, NULL, NULL, NULL, NULL, 5),
(67, '2020-10-31', '15:00:00', 7, 15, 15, 12, NULL, NULL, NULL, NULL, 5),
(68, '2020-10-31', '15:00:00', 7, 11, 11, 19, NULL, NULL, NULL, NULL, 5),
(69, '2020-10-31', '15:00:00', 7, 20, 20, 6, NULL, NULL, NULL, NULL, 5),
(70, '2020-10-31', '15:00:00', 7, 8, 8, 18, NULL, NULL, NULL, NULL, 5),
(71, '2021-06-01', '00:00:00', 8, 10, 10, 20, NULL, NULL, NULL, NULL, 5),
(72, '2021-06-01', '00:00:00', 8, 1, 1, 2, NULL, NULL, NULL, NULL, 5),
(73, '2020-11-07', '15:00:00', 8, 3, 3, 4, NULL, NULL, NULL, NULL, 5),
(74, '2020-11-07', '15:00:00', 8, 7, 7, 13, NULL, NULL, NULL, NULL, 5),
(75, '2020-11-07', '15:00:00', 8, 16, 16, 14, NULL, NULL, NULL, NULL, 5),
(76, '2020-11-07', '15:00:00', 8, 6, 6, 9, NULL, NULL, NULL, NULL, 5),
(77, '2020-11-07', '15:00:00', 8, 12, 12, 11, NULL, NULL, NULL, NULL, 5),
(78, '2020-11-07', '15:00:00', 8, 17, 17, 18, NULL, NULL, NULL, NULL, 5),
(79, '2020-11-07', '15:00:00', 8, 19, 19, 8, NULL, NULL, NULL, NULL, 5),
(80, '2020-11-07', '15:00:00', 8, 5, 5, 15, NULL, NULL, NULL, NULL, 5),
(81, '2020-11-21', '15:00:00', 9, 14, 14, 5, NULL, NULL, NULL, NULL, 5),
(82, '2020-11-21', '15:00:00', 9, 8, 8, 7, NULL, NULL, NULL, NULL, 5),
(83, '2020-11-21', '15:00:00', 9, 17, 17, 12, NULL, NULL, NULL, NULL, 5),
(84, '2020-11-21', '15:00:00', 9, 20, 20, 16, NULL, NULL, NULL, NULL, 5),
(85, '2020-11-21', '15:00:00', 9, 13, 13, 18, NULL, NULL, NULL, NULL, 5),
(86, '2020-11-21', '15:00:00', 9, 9, 9, 1, NULL, NULL, NULL, NULL, 5),
(87, '2020-11-21', '15:00:00', 9, 11, 11, 10, NULL, NULL, NULL, NULL, 5),
(88, '2020-11-21', '15:00:00', 9, 2, 2, 3, NULL, NULL, NULL, NULL, 5),
(89, '2020-11-21', '15:00:00', 9, 4, 4, 6, NULL, NULL, NULL, NULL, 5),
(90, '2020-11-21', '15:00:00', 9, 15, 15, 19, NULL, NULL, NULL, NULL, 5),
(91, '2021-06-01', '00:00:00', 10, 10, 10, 8, NULL, NULL, NULL, NULL, 5),
(92, '2021-06-01', '00:00:00', 10, 1, 1, 20, NULL, NULL, NULL, NULL, 5),
(93, '2020-11-28', '15:00:00', 10, 5, 5, 17, NULL, NULL, NULL, NULL, 5),
(94, '2020-11-28', '15:00:00', 10, 7, 7, 9, NULL, NULL, NULL, NULL, 5),
(95, '2020-11-28', '15:00:00', 10, 12, 12, 4, NULL, NULL, NULL, NULL, 5),
(96, '2020-11-28', '15:00:00', 10, 6, 6, 14, NULL, NULL, NULL, NULL, 5),
(97, '2020-11-28', '15:00:00', 10, 3, 3, 11, NULL, NULL, NULL, NULL, 5),
(98, '2020-11-28', '15:00:00', 10, 18, 18, 15, NULL, NULL, NULL, NULL, 5),
(99, '2020-11-28', '15:00:00', 10, 16, 16, 13, NULL, NULL, NULL, NULL, 5),
(100, '2020-11-28', '15:00:00', 10, 19, 19, 2, NULL, NULL, NULL, NULL, 5),
(101, '2021-06-01', '00:00:00', 11, 15, 15, 10, NULL, NULL, NULL, NULL, 5),
(102, '2021-06-01', '00:00:00', 11, 17, 17, 1, NULL, NULL, NULL, NULL, 5),
(103, '2020-12-05', '15:00:00', 11, 11, 11, 20, NULL, NULL, NULL, NULL, 5),
(104, '2020-12-05', '15:00:00', 11, 4, 4, 7, NULL, NULL, NULL, NULL, 5),
(105, '2020-12-05', '15:00:00', 11, 5, 5, 9, NULL, NULL, NULL, NULL, 5),
(106, '2020-12-05', '15:00:00', 11, 18, 18, 6, NULL, NULL, NULL, NULL, 5),
(107, '2020-12-05', '15:00:00', 11, 19, 19, 13, NULL, NULL, NULL, NULL, 5),
(108, '2020-12-05', '15:00:00', 11, 2, 2, 14, NULL, NULL, NULL, NULL, 5),
(109, '2020-12-05', '15:00:00', 11, 3, 3, 16, NULL, NULL, NULL, NULL, 5),
(110, '2020-12-05', '15:00:00', 11, 12, 12, 8, NULL, NULL, NULL, NULL, 5),
(111, '2020-12-12', '15:00:00', 12, 7, 7, 5, NULL, NULL, NULL, NULL, 5),
(112, '2020-12-12', '15:00:00', 12, 13, 13, 12, NULL, NULL, NULL, NULL, 5),
(113, '2020-12-12', '15:00:00', 12, 20, 20, 2, NULL, NULL, NULL, NULL, 5),
(114, '2020-12-12', '15:00:00', 12, 8, 8, 11, NULL, NULL, NULL, NULL, 5),
(115, '2020-12-12', '15:00:00', 12, 14, 14, 18, NULL, NULL, NULL, NULL, 5),
(116, '2020-12-12', '15:00:00', 12, 16, 16, 15, NULL, NULL, NULL, NULL, 5),
(117, '2020-12-12', '15:00:00', 12, 6, 6, 17, NULL, NULL, NULL, NULL, 5),
(118, '2020-12-12', '15:00:00', 12, 9, 9, 19, NULL, NULL, NULL, NULL, 5),
(119, '2020-12-13', '00:00:00', 12, 10, 10, 3, NULL, NULL, NULL, NULL, 5),
(120, '2020-12-13', '00:00:00', 12, 1, 1, 4, NULL, NULL, NULL, NULL, 5),
(121, '2021-06-01', '00:00:00', 13, 8, 8, 3, NULL, NULL, NULL, NULL, 5),
(122, '2021-06-01', '00:00:00', 13, 1, 1, 16, NULL, NULL, NULL, NULL, 5),
(123, '2021-06-01', '00:00:00', 13, 10, 10, 7, NULL, NULL, NULL, NULL, 5),
(124, '2021-06-01', '00:00:00', 13, 2, 2, 4, NULL, NULL, NULL, NULL, 5),
(125, '2020-12-15', '15:00:00', 13, 15, 15, 13, NULL, NULL, NULL, NULL, 5),
(126, '2020-12-15', '15:00:00', 13, 20, 20, 5, NULL, NULL, NULL, NULL, 5),
(127, '2020-12-15', '15:00:00', 13, 19, 19, 6, NULL, NULL, NULL, NULL, 5),
(128, '2020-12-15', '15:00:00', 13, 9, 9, 14, NULL, NULL, NULL, NULL, 5),
(129, '2020-12-16', '15:00:00', 13, 12, 12, 18, NULL, NULL, NULL, NULL, 5),
(130, '2020-12-16', '15:00:00', 13, 11, 11, 17, NULL, NULL, NULL, NULL, 5),
(131, '2020-12-19', '15:00:00', 14, 6, 6, 11, NULL, NULL, NULL, NULL, 5),
(132, '2020-12-19', '15:00:00', 14, 7, 7, 1, NULL, NULL, NULL, NULL, 5),
(133, '2020-12-19', '15:00:00', 14, 13, 13, 9, NULL, NULL, NULL, NULL, 5),
(134, '2020-12-19', '15:00:00', 14, 4, 4, 20, NULL, NULL, NULL, NULL, 5),
(135, '2020-12-19', '15:00:00', 14, 16, 16, 12, NULL, NULL, NULL, NULL, 5),
(136, '2020-12-19', '15:00:00', 14, 14, 14, 8, NULL, NULL, NULL, NULL, 5),
(137, '2020-12-19', '15:00:00', 14, 5, 5, 19, NULL, NULL, NULL, NULL, 5),
(138, '2020-12-19', '15:00:00', 14, 18, 18, 2, NULL, NULL, NULL, NULL, 5),
(139, '2020-12-19', '15:00:00', 14, 17, 17, 10, NULL, NULL, NULL, NULL, 5),
(140, '2020-12-19', '15:00:00', 14, 3, 3, 15, NULL, NULL, NULL, NULL, 5),
(141, '2020-12-26', '15:00:00', 15, 8, 8, 16, NULL, NULL, NULL, NULL, 5),
(142, '2020-12-26', '15:00:00', 15, 12, 12, 14, NULL, NULL, NULL, NULL, 5),
(143, '2020-12-26', '15:00:00', 15, 19, 19, 3, NULL, NULL, NULL, NULL, 5),
(144, '2020-12-26', '15:00:00', 15, 15, 15, 7, NULL, NULL, NULL, NULL, 5),
(145, '2020-12-26', '15:00:00', 15, 20, 20, 17, NULL, NULL, NULL, NULL, 5),
(146, '2020-12-26', '15:00:00', 15, 9, 9, 4, NULL, NULL, NULL, NULL, 5),
(147, '2020-12-26', '15:00:00', 15, 1, 1, 5, NULL, NULL, NULL, NULL, 5),
(148, '2020-12-26', '15:00:00', 15, 11, 11, 18, NULL, NULL, NULL, NULL, 5),
(149, '2020-12-26', '15:00:00', 15, 10, 10, 13, NULL, NULL, NULL, NULL, 5),
(150, '2020-12-26', '15:00:00', 15, 2, 2, 6, NULL, NULL, NULL, NULL, 5),
(151, '2020-12-28', '15:00:00', 16, 3, 3, 1, NULL, NULL, NULL, NULL, 5),
(152, '2020-12-28', '15:00:00', 16, 6, 6, 10, NULL, NULL, NULL, NULL, 5),
(153, '2020-12-28', '15:00:00', 16, 13, 13, 20, NULL, NULL, NULL, NULL, 5),
(154, '2020-12-28', '15:00:00', 16, 16, 16, 19, NULL, NULL, NULL, NULL, 5),
(155, '2020-12-28', '15:00:00', 16, 7, 7, 12, NULL, NULL, NULL, NULL, 5),
(156, '2020-12-28', '15:00:00', 16, 17, 17, 8, NULL, NULL, NULL, NULL, 5),
(157, '2020-12-28', '15:00:00', 16, 14, 14, 11, NULL, NULL, NULL, NULL, 5),
(158, '2020-12-28', '15:00:00', 16, 5, 5, 2, NULL, NULL, NULL, NULL, 5),
(159, '2020-12-28', '15:00:00', 16, 18, 18, 9, NULL, NULL, NULL, NULL, 5),
(160, '2020-12-28', '15:00:00', 16, 4, 4, 15, NULL, NULL, NULL, NULL, 5),
(161, '2021-01-02', '15:00:00', 17, 13, 13, 2, NULL, NULL, NULL, NULL, 5),
(162, '2021-01-02', '15:00:00', 17, 7, 7, 19, NULL, NULL, NULL, NULL, 5),
(163, '2021-01-02', '15:00:00', 17, 3, 3, 20, NULL, NULL, NULL, NULL, 5),
(164, '2021-01-02', '15:00:00', 17, 14, 14, 10, NULL, NULL, NULL, NULL, 5),
(165, '2021-01-02', '15:00:00', 17, 4, 4, 8, NULL, NULL, NULL, NULL, 5),
(166, '2021-01-02', '15:00:00', 17, 5, 5, 12, NULL, NULL, NULL, NULL, 5),
(167, '2021-01-02', '15:00:00', 17, 17, 17, 9, NULL, NULL, NULL, NULL, 5),
(168, '2021-01-02', '15:00:00', 17, 6, 6, 15, NULL, NULL, NULL, NULL, 5),
(169, '2021-01-02', '15:00:00', 17, 16, 16, 11, NULL, NULL, NULL, NULL, 5),
(170, '2021-01-02', '15:00:00', 17, 18, 18, 1, NULL, NULL, NULL, NULL, 5),
(171, '2021-01-12', '19:45:00', 18, 19, 19, 18, NULL, NULL, NULL, NULL, 5),
(172, '2021-01-12', '19:45:00', 18, 10, 10, 5, NULL, NULL, NULL, NULL, 5),
(173, '2021-01-12', '19:45:00', 18, 8, 8, 13, NULL, NULL, NULL, NULL, 5),
(174, '2021-01-12', '19:45:00', 18, 2, 2, 17, NULL, NULL, NULL, NULL, 5),
(175, '2021-01-12', '19:45:00', 18, 9, 9, 16, NULL, NULL, NULL, NULL, 5),
(176, '2021-01-12', '19:45:00', 18, 15, 15, 14, NULL, NULL, NULL, NULL, 5),
(177, '2021-01-12', '19:45:00', 18, 20, 20, 7, NULL, NULL, NULL, NULL, 5),
(178, '2021-01-12', '19:45:00', 18, 1, 1, 6, NULL, NULL, NULL, NULL, 5),
(179, '2021-01-13', '20:00:00', 18, 11, 11, 4, NULL, NULL, NULL, NULL, 5),
(180, '2021-01-13', '20:00:00', 18, 12, 12, 3, NULL, NULL, NULL, NULL, 5),
(181, '2021-01-16', '15:00:00', 19, 15, 15, 17, NULL, NULL, NULL, NULL, 5),
(182, '2021-01-16', '15:00:00', 19, 2, 2, 7, NULL, NULL, NULL, NULL, 5),
(183, '2021-01-16', '15:00:00', 19, 20, 20, 18, NULL, NULL, NULL, NULL, 5),
(184, '2021-01-16', '15:00:00', 19, 10, 10, 16, NULL, NULL, NULL, NULL, 5),
(185, '2021-01-16', '15:00:00', 19, 19, 19, 4, NULL, NULL, NULL, NULL, 5),
(186, '2021-01-16', '15:00:00', 19, 12, 12, 6, NULL, NULL, NULL, NULL, 5),
(187, '2021-01-16', '15:00:00', 19, 8, 8, 5, NULL, NULL, NULL, NULL, 5),
(188, '2021-01-16', '15:00:00', 19, 11, 11, 13, NULL, NULL, NULL, NULL, 5),
(189, '2021-01-16', '15:00:00', 19, 1, 1, 14, NULL, NULL, NULL, NULL, 5),
(190, '2021-01-16', '15:00:00', 19, 9, 9, 3, NULL, NULL, NULL, NULL, 5);

-- --------------------------------------------------------

--
-- Table structure for table `Points`
--

CREATE TABLE IF NOT EXISTS `Points` (
  `PointsID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `MatchID` int(11) NOT NULL,
  `ResultPoints` decimal(6,2) NOT NULL,
  `ScorePoints` decimal(6,2) NOT NULL,
  `TotalPoints` decimal(6,2) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

--
-- RELATIONS FOR TABLE `Points`:
--   `MatchID`
--       `Match` -> `MatchID`
--   `UserID`
--       `User` -> `UserID`
--

-- --------------------------------------------------------

--
-- Table structure for table `Prediction`
--

CREATE TABLE IF NOT EXISTS `Prediction` (
  `PredictionID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `MatchID` int(11) NOT NULL,
  `HomeTeamPoints` int(11) DEFAULT NULL,
  `AwayTeamPoints` int(11) DEFAULT NULL,
  `DateAdded` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

--
-- RELATIONS FOR TABLE `Prediction`:
--   `MatchID`
--       `Match` -> `MatchID`
--   `UserID`
--       `User` -> `UserID`
--

-- --------------------------------------------------------

--
-- Table structure for table `RememberMe`
--

CREATE TABLE IF NOT EXISTS `RememberMe` (
  `UserID` int(11) NOT NULL,
  `SeriesID` int(11) NOT NULL,
  `Token` varchar(50) NOT NULL,
  `DateAdded` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONS FOR TABLE `RememberMe`:
--   `UserID`
--       `User` -> `UserID`
--

-- --------------------------------------------------------

--
-- Table structure for table `Role`
--

CREATE TABLE IF NOT EXISTS `Role` (
`RoleID` int(11) NOT NULL,
  `Role` varchar(50) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Role`
--

INSERT INTO `Role` (`RoleID`, `Role`) VALUES
(1, 'Admin'),
(2, 'Mr Mean'),
(3, 'Mr Median'),
(4, 'Mr Mode');

-- --------------------------------------------------------

--
-- Table structure for table `Team`
--

CREATE TABLE IF NOT EXISTS `Team` (
  `TeamID` int(11) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `ShortName` varchar(10) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Team`
--

INSERT INTO `Team` (`TeamID`, `Name`, `ShortName`) VALUES
(1, 'Arsenal', 'ARS'),
(2, 'Aston Villa', 'AVA'),
(3, 'Brighton & Hove Albion', 'BRH'),
(4, 'Burnley', 'BUR'),
(5, 'Chelsea', 'CHE'),
(6, 'Crystal Palace', 'CRY'),
(7, 'Everton', 'EVE'),
(8, 'Fulham', 'FUL'),
(9, 'Leeds United', 'LEE'),
(10, 'Leicester City', 'LEI'),
(11, 'Liverpool', 'LIV'),
(12, 'Manchester City', 'MCI'),
(13, 'Manchester United', 'MUN'),
(14, 'Newcastle United', 'NEW'),
(15, 'Sheffield United', 'SHU'),
(16, 'Southampton', 'SOU'),
(17, 'Tottenham Hotspur', 'TOT'),
(18, 'West Bromwich Albion', 'WBA'),
(19, 'West Ham United', 'WHU'),
(20, 'Wolverhampton Wanderers', 'WLV');

-- --------------------------------------------------------

--
-- Table structure for table `User`
--

CREATE TABLE IF NOT EXISTS `User` (
`UserID` int(11) NOT NULL,
  `FirstName` varchar(50) NOT NULL,
  `LastName` varchar(50) NOT NULL,
  `DisplayName` varchar(50) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Password` varchar(50) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `User`
--

INSERT INTO `User` (`UserID`, `FirstName`, `LastName`, `DisplayName`, `Email`, `Password`) VALUES
(1, 'James', 'MacAdie', 'Maccas', 'james.macadie@telerealtrillium.com', 'e30a23724ec797c00135c9a6eccda61c'),
(2, 'Mr.', 'Mean', 'Mr. Mean', 'mrmean@julianrimet.com', 'f0c9a442ef67e81b3a1340ae95700eb3'),
(3, 'Mr.', 'Median', 'Mr. Median', 'mrmedian@julianrimet.com', 'f0c9a442ef67e81b3a1340ae95700eb3'),
(4, 'Richard', 'Morrison', 'Binary Boy', 'richard@rmorrison.net', '4039d3083f93bb8623b58b626b50d7b0'),
(6, 'William', 'MacAdie', 'Will Mac', 'will.macadie@gmail.com', '74c46d2453cc27f2911432363c986746'),
(7, 'Richard', 'Kowenicki', 'Kov', 'doctorkov@googlemail.com', '4011bbf0faf06684cc7eba99d2d016dd'),
(10, 'Clare', 'MacAdie', 'Clare Mac', 'clare@macadie.co.uk', 'e706adb60ed514bd612e49c915425ed1'),
(11, 'Tom', 'MacAdie', 'Tom Mac', 'tom_macadie@hotmail.com', 'a3dae570bfb4c86a215db4a3380e06ef'),
(12, 'Fiona', 'MacAdie', 'Fi Mac', 'fknox1@hotmail.com', 'dfd473dbd297a47ccdab27002b24d574'),
(14, 'Graham', 'Morrison', 'G.Mozz', 'gmorrison100@gmail.com', '4880b960dcfea3b414224dc91d371111'),
(18, 'Oliver', 'Peck', 'Ollie', 'oliver.peck@rocketmail.com', 'f8b4ad619a9b4f9f50451943b0b268ba'),
(19, 'Mr.', 'Mode', 'Mr. Mode', 'mrmode@julianrimet.com', 'f0c9a442ef67e81b3a1340ae95700eb3'),
(20, 'David', 'Hart', 'David', 'david@davidhart.co.uk', '43105489c411c29223fbd12f86c72bed'),
(22, 'Tom', 'Peck', 'Peck', 'tompeck1000@gmail.com', '9d37874755d2f8f9cd2779996048f97f'),
(25, 'Ross', 'Allen', 'Ross', 'rceallen@gmail.com', '410e30c15c7c9f7b5dde86ee9227c458'),
(28, 'Charlotte', 'Peck', 'Lottie', 'happylottie@hotmail.com', 'efbed475f64469145e9b8d19f838b588'),
(37, 'Ashley', 'Timmons', 'Dr T', 'ashley.timmons123@gmail.com', 'c201c2764326c3f372f4f42ea1ea9213'),
(38, 'Mark', 'Lawrenson', 'Lawro', 'l', 'f0c9a442ef67e81b3a1340ae95700eb3');

-- --------------------------------------------------------

--
-- Table structure for table `UserRole`
--

CREATE TABLE IF NOT EXISTS `UserRole` (
`UserRoleID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `RoleID` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- RELATIONS FOR TABLE `UserRole`:
--   `RoleID`
--       `Role` -> `RoleID`
--   `UserID`
--       `User` -> `UserID`
--

--
-- Dumping data for table `UserRole`
--

INSERT INTO `UserRole` (`UserRoleID`, `UserID`, `RoleID`) VALUES
(1, 1, 1),
(2, 22, 1),
(3, 2, 2),
(4, 3, 3),
(5, 19, 4);

-- --------------------------------------------------------

--
-- Table structure for table `Venue`
--

CREATE TABLE IF NOT EXISTS `Venue` (
`VenueID` int(11) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `City` varchar(50) NOT NULL,
  `Capacity` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Venue`
--

INSERT INTO `Venue` (`VenueID`, `Name`, `City`, `Capacity`) VALUES
(1, 'Emirates Stadium', 'London', 60260),
(2, 'Villa Park', 'Birmingham', 42682),
(3, 'Amex Stadium', 'Falmer', 30666),
(4, 'Turf Moor', 'Burnley', 21944),
(5, 'Stamford Bridge', 'London', 40853),
(6, 'Selhurt Park', 'London', 25486),
(7, 'Goodison Park', 'Liverpool', 39221),
(8, 'Craven Cottage', 'London', 19000),
(9, 'Elland Road', 'Leeds', 37890),
(10, 'King Power Stadium', 'Leicester', 32273),
(11, 'Anfield', 'Liverpool', 53394),
(12, 'Etihad Stadium', 'Manchester', 55017),
(13, 'Old Trafford', 'Manchester', 74879),
(14, 'St. James'' Park', 'Newcastle', 52305),
(15, 'Bramall Lane', 'Sheffield', 32050),
(16, 'St. Mary''s Stadium', 'Southampton', 32384),
(17, 'Tottenham Hotspur Stadium', 'London', 62062),
(18, 'The Hawthorns', 'West Bromwich', 26688),
(19, 'London Stadium', 'London', 60000),
(20, 'Molineux Stadium', 'Wolverhampton', 32050);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Broadcaster`
--
ALTER TABLE `Broadcaster`
 ADD PRIMARY KEY (`BroadcasterID`);

--
-- Indexes for table `Emails`
--
ALTER TABLE `Emails`
 ADD PRIMARY KEY (`EmailsID`), ADD KEY `FK_Email_Match` (`MatchID`);

--
-- Indexes for table `GameWeek`
--
ALTER TABLE `GameWeek`
 ADD PRIMARY KEY (`GameWeekID`);

--
-- Indexes for table `Match`
--
ALTER TABLE `Match`
 ADD PRIMARY KEY (`MatchID`), ADD KEY `FK_Match_GameWeek` (`GameWeekID`), ADD KEY `FK_Match_Venue` (`VenueID`), ADD KEY `FK_Match_Home_Team` (`HomeTeamID`), ADD KEY `FK_Match_Away_team` (`AwayTeamID`), ADD KEY `FK_Match_Broadcaster` (`BroadcasterID`), ADD KEY `FK_Match_User` (`ResultPostedBy`);
 
--
-- Indexes for table `Points`
--
ALTER TABLE `Points`
 ADD PRIMARY KEY (`PointsID`), ADD KEY `FK_Points_Match` (`MatchID`), ADD KEY `FK_Points_User` (`UserID`);

--
-- Indexes for table `Prediction`
--
ALTER TABLE `Prediction`
 ADD PRIMARY KEY (`PredictionID`), ADD KEY `FK_Prediction_User` (`UserID`), ADD KEY `FK_Prediction_Match` (`MatchID`);

--
-- Indexes for table `RememberMe`
--
ALTER TABLE `RememberMe`
 ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `Role`
--
ALTER TABLE `Role`
 ADD PRIMARY KEY (`RoleID`);

--
-- Indexes for table `Team`
--
ALTER TABLE `Team`
 ADD PRIMARY KEY (`TeamID`);

--
-- Indexes for table `User`
--
ALTER TABLE `User`
 ADD PRIMARY KEY (`UserID`);

--
-- Indexes for table `UserRole`
--
ALTER TABLE `UserRole`
 ADD PRIMARY KEY (`UserRoleID`), ADD KEY `FK_UserRole_User` (`UserID`), ADD KEY `FK_UserRole_Role` (`RoleID`);

--
-- Indexes for table `Venue`
--
ALTER TABLE `Venue`
 ADD PRIMARY KEY (`VenueID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Broadcaster`
--
ALTER TABLE `Broadcaster`
MODIFY `BroadcasterID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `Emails`
--
ALTER TABLE `Emails`
MODIFY `EmailsID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=191;
--
-- AUTO_INCREMENT for table `Match`
--
ALTER TABLE `Match`
MODIFY `MatchID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=191;
--
-- AUTO_INCREMENT for table `Points`
--
ALTER TABLE `Points`
MODIFY `PointsID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT for table `Prediction`
--
ALTER TABLE `Prediction`
MODIFY `PredictionID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT for table `Role`
--
ALTER TABLE `Role`
MODIFY `RoleID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `Team`
--
ALTER TABLE `Team`
MODIFY `TeamID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT for table `User`
--
ALTER TABLE `User`
MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=39;
--
-- AUTO_INCREMENT for table `UserRole`
--
ALTER TABLE `UserRole`
MODIFY `UserRoleID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `Venue`
--
ALTER TABLE `Venue`
MODIFY `VenueID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=21;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `Emails`
--
ALTER TABLE `Emails`
ADD CONSTRAINT `FK_Email_Match` FOREIGN KEY (`MatchID`) REFERENCES `Match` (`MatchID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Match`
--
ALTER TABLE `Match`
ADD CONSTRAINT `FK_Match_Away_Team` FOREIGN KEY (`AwayTeamID`) REFERENCES `Team` (`TeamID`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `FK_Match_Broadcaster` FOREIGN KEY (`BroadcasterID`) REFERENCES `Broadcaster` (`BroadcasterID`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `FK_Match_Home_team` FOREIGN KEY (`HomeTeamID`) REFERENCES `Team` (`TeamID`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `FK_Match_User` FOREIGN KEY (`ResultPostedBy`) REFERENCES `User` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `FK_Match_Venue` FOREIGN KEY (`VenueID`) REFERENCES `Venue` (`VenueID`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `FK_Match_GameWeek` FOREIGN KEY (`GameWeekID`) REFERENCES `GameWeek` (`GameWeekID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Points`
--
ALTER TABLE `Points`
ADD CONSTRAINT `FK_Points_Match` FOREIGN KEY (`MatchID`) REFERENCES `Match` (`MatchID`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `FK_Points_User` FOREIGN KEY (`UserID`) REFERENCES `User` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Prediction`
--
ALTER TABLE `Prediction`
ADD CONSTRAINT `FK_Prediction_Match` FOREIGN KEY (`MatchID`) REFERENCES `Match` (`MatchID`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `FK_Prediction_User` FOREIGN KEY (`UserID`) REFERENCES `User` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `RememberMe`
--
ALTER TABLE `RememberMe`
ADD CONSTRAINT `FK_RememberMe_User` FOREIGN KEY (`UserID`) REFERENCES `User` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `UserRole`
--
ALTER TABLE `UserRole`
ADD CONSTRAINT `FK_UserRole_Role` FOREIGN KEY (`RoleID`) REFERENCES `Role` (`RoleID`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `FK_UserRole_User` FOREIGN KEY (`UserID`) REFERENCES `User` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;