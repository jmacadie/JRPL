-- phpMyAdmin SQL Dump
-- version 4.2.12deb2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 11, 2015 at 05:10 PM
-- Server version: 5.5.44-0+deb8u1
-- PHP Version: 5.6.9-0+deb8u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `jrpl_prod`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `ViewPredictions`()
    NO SQL
SELECT
	CONCAT(u.`FirstName`, ' ', u.`LastName`) AS Name
    ,COUNT(*) AS Predictions
FROM `Prediction` as p
	INNER JOIN `User` as u ON
    	u.`UserID` = p.`UserID`
GROUP BY u.`UserID`
ORDER BY COUNT(*) DESC$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `Broadcaster`
--

CREATE TABLE IF NOT EXISTS `Broadcaster` (
`BroadcasterID` int(11) NOT NULL,
  `Name` varchar(10) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Broadcaster`
--

INSERT INTO `Broadcaster` (`BroadcasterID`, `Name`) VALUES
(1, 'BBC'),
(2, 'ITV'),
(3, 'ITV4');

-- --------------------------------------------------------

--
-- Table structure for table `Emails`
--

CREATE TABLE IF NOT EXISTS `Emails` (
`EmailsID` int(11) NOT NULL,
  `MatchID` int(11) NOT NULL,
  `PredictionsSent` tinyint(1) NOT NULL,
  `ResultsSent` tinyint(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=latin1;

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
(48, 48, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `Group`
--

CREATE TABLE IF NOT EXISTS `Group` (
`GroupID` int(11) NOT NULL,
  `Name` varchar(10) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Group`
--

INSERT INTO `Group` (`GroupID`, `Name`) VALUES
(1, 'A'),
(2, 'B'),
(3, 'C'),
(4, 'D');

-- --------------------------------------------------------

--
-- Table structure for table `Match`
--

CREATE TABLE IF NOT EXISTS `Match` (
`MatchID` int(11) NOT NULL,
  `Date` date NOT NULL,
  `KickOff` time NOT NULL,
  `VenueID` int(11) NOT NULL,
  `HomeTeamID` int(11) NOT NULL,
  `AwayTeamID` int(11) NOT NULL,
  `HomeTeamPoints` int(11) DEFAULT NULL,
  `AwayTeamPoints` int(11) DEFAULT NULL,
  `ResultPostedBy` int(11) DEFAULT NULL,
  `ResultPostedOn` datetime DEFAULT NULL,
  `StageID` int(11) NOT NULL DEFAULT '1',
  `BroadcasterID` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Match`
--

INSERT INTO `Match` (`MatchID`, `Date`, `KickOff`, `VenueID`, `HomeTeamID`, `AwayTeamID`, `HomeTeamPoints`, `AwayTeamPoints`, `ResultPostedBy`, `ResultPostedOn`, `StageID`, `BroadcasterID`) VALUES
(1, '2015-09-18', '20:00:00', 11, 2, 4, NULL, NULL, NULL, NULL, 1, 2),
(2, '2015-09-19', '12:00:00', 3, 13, 14, NULL, NULL, NULL, NULL, 1, 2),
(3, '2015-09-19', '14:30:00', 6, 17, 19, NULL, NULL, NULL, NULL, 1, 2),
(4, '2015-09-19', '16:45:00', 1, 6, 8, NULL, NULL, NULL, NULL, 1, 2),
(5, '2015-09-19', '20:00:00', 11, 16, 18, NULL, NULL, NULL, NULL, 1, 3),
(6, '2015-09-20', '12:00:00', 1, 7, 10, NULL, NULL, NULL, NULL, 1, 2),
(7, '2015-09-20', '14:30:00', 6, 3, 5, NULL, NULL, NULL, NULL, 1, 2),
(8, '2015-09-20', '16:45:00', 13, 11, 12, NULL, NULL, NULL, NULL, 1, 2),
(9, '2015-09-23', '14:30:00', 3, 9, 8, NULL, NULL, NULL, NULL, 1, 2),
(10, '2015-09-23', '16:45:00', 6, 1, 4, NULL, NULL, NULL, NULL, 1, 2),
(11, '2015-09-23', '20:00:00', 7, 16, 20, NULL, NULL, NULL, NULL, 1, 3),
(12, '2015-09-24', '20:00:00', 7, 11, 15, NULL, NULL, NULL, NULL, 1, 2),
(13, '2015-09-25', '16:45:00', 3, 12, 14, NULL, NULL, NULL, NULL, 1, 3),
(14, '2015-09-26', '14:30:00', 2, 18, 19, NULL, NULL, NULL, NULL, 1, 2),
(15, '2015-09-26', '16:45:00', 12, 6, 7, NULL, NULL, NULL, NULL, 1, 2),
(16, '2015-09-26', '20:00:00', 11, 2, 3, NULL, NULL, NULL, NULL, 1, 2),
(17, '2015-09-27', '12:00:00', 12, 1, 5, NULL, NULL, NULL, NULL, 1, 2),
(18, '2015-09-27', '14:30:00', 2, 9, 10, NULL, NULL, NULL, NULL, 1, 2),
(19, '2015-09-27', '16:45:00', 13, 17, 20, NULL, NULL, NULL, NULL, 1, 2),
(20, '2015-09-29', '16:45:00', 8, 13, 15, NULL, NULL, NULL, NULL, 1, 3),
(21, '2015-10-01', '16:45:00', 6, 3, 4, NULL, NULL, NULL, NULL, 1, 2),
(22, '2015-10-01', '20:00:00', 10, 16, 19, NULL, NULL, NULL, NULL, 1, 3),
(23, '2015-10-02', '20:00:00', 6, 11, 14, NULL, NULL, NULL, NULL, 1, 2),
(24, '2015-10-03', '14:30:00', 10, 7, 8, NULL, NULL, NULL, NULL, 1, 2),
(25, '2015-10-03', '16:45:00', 9, 6, 9, NULL, NULL, NULL, NULL, 1, 2),
(26, '2015-10-03', '20:00:00', 11, 2, 1, NULL, NULL, NULL, NULL, 1, 2),
(27, '2015-10-04', '14:30:00', 4, 12, 13, NULL, NULL, NULL, NULL, 1, 2),
(28, '2015-10-04', '16:45:00', 7, 17, 18, NULL, NULL, NULL, NULL, 1, 2),
(29, '2015-10-06', '16:45:00', 4, 19, 20, NULL, NULL, NULL, NULL, 1, 3),
(30, '2015-10-06', '20:00:00', 10, 4, 5, NULL, NULL, NULL, NULL, 1, 3),
(31, '2015-10-07', '16:45:00', 7, 6, 10, NULL, NULL, NULL, NULL, 1, 2),
(32, '2015-10-07', '20:00:00', 8, 15, 14, NULL, NULL, NULL, NULL, 1, 3),
(33, '2015-10-09', '20:00:00', 9, 11, 13, NULL, NULL, NULL, NULL, 1, 3),
(34, '2015-10-10', '14:30:00', 9, 7, 9, NULL, NULL, NULL, NULL, 1, 2),
(35, '2015-10-10', '16:45:00', 11, 1, 3, NULL, NULL, NULL, NULL, 1, 2),
(36, '2015-10-10', '20:00:00', 5, 2, 5, NULL, NULL, NULL, NULL, 1, 2),
(37, '2015-10-11', '12:00:00', 4, 12, 15, NULL, NULL, NULL, NULL, 1, 2),
(38, '2015-10-11', '14:30:00', 8, 18, 20, NULL, NULL, NULL, NULL, 1, 2),
(39, '2015-10-11', '16:45:00', 6, 16, 17, NULL, NULL, NULL, NULL, 1, 2),
(40, '2015-10-11', '20:00:00', 3, 10, 8, NULL, NULL, NULL, NULL, 1, 3),
(41, '2015-10-17', '16:00:00', 11, 23, 22, NULL, NULL, NULL, NULL, 2, 2),
(42, '2015-10-17', '20:00:00', 6, 25, 28, NULL, NULL, NULL, NULL, 2, 2),
(43, '2015-10-18', '13:00:00', 6, 27, 26, NULL, NULL, NULL, NULL, 2, 2),
(44, '2015-10-18', '16:00:00', 11, 21, 24, NULL, NULL, NULL, NULL, 2, 2),
(45, '2015-10-24', '16:00:00', 11, 29, 30, NULL, NULL, NULL, NULL, 3, 2),
(46, '2015-10-25', '16:00:00', 11, 31, 32, NULL, NULL, NULL, NULL, 3, 2),
(47, '2015-10-30', '20:00:00', 7, 33, 34, NULL, NULL, NULL, NULL, 4, 2),
(48, '2015-10-31', '16:00:00', 11, 35, 36, NULL, NULL, NULL, NULL, 5, 2);

-- --------------------------------------------------------

--
-- Table structure for table `Points`
--

CREATE TABLE IF NOT EXISTS `Points` (
`PointsID` int(11) NOT NULL,
  `ScoringSystemID` int(11) NOT NULL DEFAULT '1',
  `UserID` int(11) NOT NULL,
  `MatchID` int(11) NOT NULL,
  `ResultPoints` decimal(6,2) NOT NULL,
  `ScorePoints` decimal(6,2) NOT NULL,
  `MarginPoints` decimal(6,2) NOT NULL,
  `TotalPoints` decimal(6,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB AUTO_INCREMENT=297 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Prediction`
--

INSERT INTO `Prediction` (`PredictionID`, `UserID`, `MatchID`, `HomeTeamPoints`, `AwayTeamPoints`, `DateAdded`) VALUES
(1, 4, 1, 40, 13, '2015-08-17 17:42:37'),
(2, 4, 2, 22, 11, '2015-08-17 17:43:15'),
(3, 4, 3, 42, 6, '2015-08-17 17:43:50'),
(4, 4, 4, 51, 5, '2015-08-17 17:46:30'),
(5, 4, 5, 26, 13, '2015-08-17 17:44:41'),
(6, 4, 6, 20, 5, '2015-08-17 17:44:59'),
(7, 4, 7, 80, 8, '2015-08-17 17:45:17'),
(8, 4, 8, 28, 8, '2015-08-17 17:45:41'),
(9, 25, 1, 18, 8, '2015-08-18 03:05:12'),
(10, 25, 2, 21, 9, '2015-08-18 03:05:51'),
(11, 25, 3, 27, 6, '2015-08-18 03:06:20'),
(12, 25, 4, 47, 3, '2015-08-18 03:06:49'),
(13, 25, 5, 23, 15, '2015-08-18 03:07:24'),
(14, 25, 6, 15, 12, '2015-08-18 03:10:37'),
(15, 25, 7, 19, 10, '2015-08-18 03:10:58'),
(16, 25, 8, 26, 6, '2015-08-18 03:11:29'),
(17, 25, 9, 15, 9, '2015-08-18 03:11:49'),
(18, 25, 10, 27, 12, '2015-08-18 03:12:17'),
(19, 25, 11, 20, 3, '2015-08-18 03:12:52'),
(20, 25, 12, 71, 3, '2015-08-18 03:13:15'),
(21, 25, 13, 18, 6, '2015-08-18 03:13:50'),
(22, 25, 14, 18, 15, '2015-08-18 03:14:17'),
(23, 25, 15, 34, 18, '2015-08-18 03:14:37'),
(24, 25, 16, 24, 21, '2015-08-18 03:14:54'),
(25, 25, 17, 46, 3, '2015-08-18 03:15:09'),
(26, 25, 19, 30, 6, '2015-08-18 03:15:55'),
(27, 25, 20, 24, 11, '2015-08-18 03:16:19'),
(28, 25, 21, 30, 22, '2015-08-18 03:16:49'),
(29, 25, 22, 39, 6, '2015-08-18 03:17:42'),
(30, 25, 23, 59, 3, '2015-08-18 03:17:59'),
(31, 25, 24, 18, 15, '2015-08-18 03:18:17'),
(32, 25, 25, 28, 19, '2015-08-18 03:18:36'),
(33, 25, 26, 18, 26, '2015-08-18 03:18:58'),
(34, 25, 27, 27, 20, '2015-08-18 03:19:19'),
(35, 25, 28, 31, 15, '2015-08-18 03:19:57'),
(36, 25, 29, 22, 15, '2015-08-18 03:20:16'),
(37, 25, 30, 33, 18, '2015-08-18 03:20:39'),
(38, 25, 31, 58, 3, '2015-08-18 03:21:07'),
(39, 25, 32, 25, 21, '2015-08-18 03:21:25'),
(40, 25, 33, 59, 12, '2015-08-18 03:21:43'),
(41, 25, 34, 12, 29, '2015-08-18 03:22:14'),
(42, 25, 35, 29, 18, '2015-08-18 03:22:59'),
(43, 25, 36, 45, 6, '2015-08-18 03:24:41'),
(44, 25, 37, 31, 9, '2015-08-18 03:24:56'),
(45, 25, 38, 19, 12, '2015-08-18 03:25:10'),
(46, 25, 39, 19, 24, '2015-08-18 03:25:36'),
(47, 25, 40, 19, 15, '2015-08-18 03:26:08'),
(48, 25, 18, 20, 15, '2015-08-18 03:27:31'),
(49, 25, 41, 27, 23, '2015-08-18 03:28:32'),
(50, 25, 42, 30, 19, '2015-08-18 03:28:46'),
(51, 25, 43, 19, 18, '2015-08-18 03:29:08'),
(52, 25, 44, 26, 20, '2015-08-18 03:29:24'),
(53, 25, 45, 32, 21, '2015-08-18 03:29:36'),
(54, 25, 46, 26, 18, '2015-08-18 03:30:08'),
(55, 25, 47, 43, 32, '2015-08-18 03:30:21'),
(56, 25, 48, 22, 18, '2015-08-18 03:30:37'),
(57, 27, 1, 30, 9, '2015-08-19 13:26:13'),
(58, 27, 2, 21, 12, '2015-08-19 13:26:35'),
(59, 27, 3, 24, 6, '2015-08-19 13:26:46'),
(60, 27, 4, 45, 12, '2015-08-19 13:27:14'),
(61, 27, 5, 25, 9, '2015-08-19 13:27:32'),
(62, 27, 6, 24, 15, '2015-08-19 13:28:09'),
(63, 27, 7, 24, 15, '2015-08-19 13:28:37'),
(64, 27, 8, 36, 24, '2015-08-19 13:28:48'),
(65, 27, 9, 24, 12, '2015-08-19 13:29:02'),
(66, 27, 10, 45, 18, '2015-08-19 13:29:12'),
(67, 27, 11, 12, 15, '2015-08-19 13:29:31'),
(68, 27, 12, 80, 10, '2015-08-19 13:29:40'),
(69, 27, 13, 12, 9, '2015-08-19 13:30:06'),
(70, 27, 14, 9, 3, '2015-08-19 13:30:18'),
(71, 27, 15, 36, 6, '2015-08-19 13:30:33'),
(72, 27, 16, 25, 22, '2015-08-19 13:31:04'),
(73, 27, 17, 36, 20, '2015-08-19 13:31:16'),
(74, 27, 18, 36, 12, '2015-08-19 13:31:22'),
(75, 27, 19, 35, 9, '2015-08-19 13:31:37'),
(76, 27, 20, 22, 15, '2015-08-19 13:31:53'),
(77, 27, 21, 24, 16, '2015-08-19 13:34:05'),
(78, 27, 22, 24, 6, '2015-08-19 13:34:15'),
(79, 27, 23, 45, 6, '2015-08-19 13:34:30'),
(80, 27, 24, 15, 12, '2015-08-19 13:34:37'),
(81, 27, 25, 36, 9, '2015-08-19 13:34:58'),
(82, 27, 26, 18, 12, '2015-08-19 13:35:07'),
(83, 27, 27, 18, 9, '2015-08-19 13:35:22'),
(84, 27, 28, 18, 12, '2015-08-19 13:35:41'),
(85, 27, 29, 9, 12, '2015-08-19 13:35:52'),
(86, 27, 30, 6, 18, '2015-08-19 13:36:07'),
(87, 27, 31, 24, 8, '2015-08-19 13:36:24'),
(88, 27, 32, 25, 18, '2015-08-19 13:36:42'),
(89, 27, 33, 36, 3, '2015-08-19 13:37:01'),
(90, 27, 34, 9, 18, '2015-08-19 13:37:08'),
(91, 27, 35, 18, 9, '2015-08-19 13:37:20'),
(92, 27, 36, 24, 9, '2015-08-19 13:37:38'),
(93, 27, 37, 18, 6, '2015-08-19 13:37:51'),
(94, 27, 38, 18, 12, '2015-08-19 13:38:24'),
(95, 27, 39, 9, 15, '2015-08-19 13:38:37'),
(96, 27, 40, 24, 16, '2015-08-19 13:38:50'),
(97, 27, 41, 24, 20, '2015-08-19 13:39:04'),
(98, 27, 43, 24, 20, '2015-08-19 13:39:16'),
(99, 27, 44, 24, 20, '2015-08-19 13:39:20'),
(100, 27, 45, 24, 20, '2015-08-19 13:39:25'),
(101, 27, 46, 24, 20, '2015-08-19 13:39:30'),
(102, 27, 47, 24, 20, '2015-08-19 13:39:35'),
(103, 27, 48, 24, 20, '2015-08-19 13:39:40'),
(104, 27, 42, 24, 20, '2015-08-19 13:40:01'),
(105, 7, 1, 45, 12, '2015-08-27 10:41:33'),
(106, 7, 2, 29, 8, '2015-08-27 10:42:17'),
(107, 7, 3, 49, 6, '2015-08-27 10:42:36'),
(108, 7, 4, 62, 0, '2015-08-27 10:42:48'),
(109, 7, 5, 21, 15, '2015-08-27 10:42:56'),
(110, 7, 6, 23, 22, '2015-08-27 10:43:04'),
(111, 7, 7, 65, 5, '2015-08-27 10:43:18'),
(112, 7, 8, 39, 6, '2015-08-27 10:43:30'),
(113, 7, 9, 15, 6, '2015-08-27 10:43:42'),
(114, 7, 10, 38, 3, '2015-08-27 10:43:52'),
(115, 7, 11, 24, 9, '2015-08-27 10:44:00'),
(116, 7, 12, 65, 0, '2015-08-27 10:44:08'),
(117, 7, 13, 23, 6, '2015-08-27 10:44:26'),
(118, 7, 14, 14, 13, '2015-08-27 10:44:36'),
(119, 7, 15, 23, 11, '2015-08-27 10:44:44'),
(120, 7, 16, 18, 21, '2015-08-27 10:44:51'),
(121, 7, 17, 43, 0, '2015-08-27 10:45:01'),
(122, 7, 18, 12, 18, '2015-08-27 10:45:07'),
(123, 7, 19, 27, 14, '2015-08-27 10:45:18'),
(124, 7, 20, 21, 19, '2015-08-27 10:45:24'),
(125, 7, 21, 19, 12, '2015-08-27 10:45:34'),
(126, 7, 22, 23, 10, '2015-08-27 10:45:47'),
(127, 7, 23, 38, 3, '2015-08-27 10:45:54'),
(128, 7, 24, 25, 10, '2015-08-27 10:46:03'),
(129, 7, 25, 27, 10, '2015-08-27 10:46:10'),
(130, 7, 26, 18, 21, '2015-08-27 10:46:18'),
(131, 7, 27, 21, 13, '2015-08-27 10:46:26'),
(132, 7, 28, 25, 17, '2015-08-27 10:46:36'),
(133, 7, 29, 26, 21, '2015-08-27 10:46:44'),
(134, 7, 30, 27, 19, '2015-08-27 10:46:54'),
(135, 7, 31, 42, 13, '2015-08-27 10:47:04'),
(136, 7, 32, 17, 14, '2015-08-27 10:47:21'),
(137, 7, 33, 34, 8, '2015-08-27 10:47:29'),
(138, 7, 34, 16, 25, '2015-08-27 10:47:36'),
(139, 7, 35, 23, 16, '2015-08-27 10:47:45'),
(140, 7, 36, 48, 3, '2015-08-27 10:47:52'),
(141, 7, 37, 29, 12, '2015-08-27 10:48:19'),
(142, 7, 38, 17, 14, '2015-08-27 10:48:40'),
(143, 7, 39, 19, 18, '2015-08-27 10:48:49'),
(144, 7, 40, 18, 16, '2015-08-27 10:48:56'),
(145, 7, 41, 21, 18, '2015-08-27 10:49:01'),
(146, 7, 42, 32, 14, '2015-08-27 10:49:07'),
(147, 7, 43, 10, 6, '2015-08-27 10:49:15'),
(148, 7, 44, 25, 19, '2015-08-27 10:49:22'),
(149, 7, 45, 28, 21, '2015-08-27 10:49:29'),
(150, 7, 46, 28, 21, '2015-08-27 10:49:35'),
(151, 7, 47, 36, 20, '2015-08-27 10:49:44'),
(152, 7, 48, 21, 15, '2015-08-27 10:49:50'),
(153, 13, 1, 32, 12, '2015-08-27 12:20:20'),
(154, 13, 2, 22, 15, '2015-08-27 12:21:11'),
(155, 23, 1, 18, 3, '2015-08-27 12:21:29'),
(156, 13, 3, 43, 8, '2015-08-27 12:21:45'),
(157, 23, 2, 7, 3, '2015-08-27 12:22:03'),
(158, 13, 4, 47, 6, '2015-08-27 12:22:10'),
(159, 23, 3, 28, 14, '2015-08-27 12:22:25'),
(160, 13, 5, 23, 18, '2015-08-27 12:22:35'),
(161, 23, 4, 21, 8, '2015-08-27 12:22:46'),
(162, 23, 5, 14, 7, '2015-08-27 12:23:00'),
(163, 23, 6, 7, 8, '2015-08-27 12:23:15'),
(164, 23, 7, 28, 8, '2015-08-27 12:23:31'),
(165, 23, 8, 24, 14, '2015-08-27 12:23:52'),
(166, 5, 1, 37, 10, '2015-08-28 04:37:20'),
(167, 5, 2, 22, 8, '2015-08-28 04:39:26'),
(168, 5, 3, 46, 6, '2015-08-28 04:40:14'),
(169, 5, 4, 56, 3, '2015-08-28 04:41:24'),
(170, 5, 5, 20, 6, '2015-08-28 04:42:05'),
(171, 5, 6, 28, 10, '2015-08-28 04:43:14'),
(172, 5, 7, 71, 6, '2015-08-28 04:44:20'),
(173, 5, 8, 32, 12, '2015-08-28 04:44:56'),
(174, 5, 9, 35, 6, '2015-08-28 04:49:23'),
(175, 5, 10, 45, 11, '2015-08-28 04:49:46'),
(176, 5, 11, 48, 10, '2015-08-28 04:52:46'),
(177, 5, 12, 94, 0, '2015-08-28 04:53:19'),
(178, 5, 13, 28, 6, '2015-08-28 04:53:42'),
(179, 5, 14, 37, 10, '2015-08-28 04:54:14'),
(180, 5, 15, 22, 7, '2015-08-28 04:54:35'),
(181, 5, 16, 20, 15, '2015-08-28 04:58:36'),
(182, 5, 17, 113, 3, '2015-08-28 04:59:22'),
(183, 5, 18, 35, 10, '2015-08-28 04:59:42'),
(184, 5, 19, 75, 10, '2015-08-28 05:00:09'),
(185, 5, 20, 48, 15, '2015-08-28 05:00:44'),
(186, 5, 21, 45, 12, '2015-08-28 05:01:05'),
(187, 5, 22, 43, 12, '2015-08-28 05:01:29'),
(188, 5, 23, 61, 10, '2015-08-28 05:01:49'),
(189, 5, 24, 34, 16, '2015-08-28 05:02:05'),
(190, 5, 25, 21, 12, '2015-08-28 05:02:26'),
(191, 5, 26, 13, 10, '2015-08-28 05:02:49'),
(192, 5, 27, 25, 13, '2015-08-28 05:03:19'),
(193, 5, 28, 31, 6, '2015-08-28 05:03:42'),
(194, 5, 29, 26, 15, '2015-08-28 05:04:21'),
(195, 5, 30, 44, 23, '2015-08-28 05:04:46'),
(196, 5, 31, 56, 6, '2015-08-28 05:05:06'),
(197, 5, 32, 9, 28, '2015-08-28 05:05:38'),
(198, 5, 33, 54, 10, '2015-08-28 05:06:03'),
(199, 5, 34, 12, 15, '2015-08-28 05:06:21'),
(200, 5, 35, 21, 23, '2015-08-28 05:06:33'),
(201, 5, 36, 37, 12, '2015-08-28 05:06:45'),
(202, 5, 37, 46, 6, '2015-08-28 05:07:02'),
(203, 5, 38, 28, 15, '2015-08-28 05:07:23'),
(204, 5, 39, 14, 18, '2015-08-28 05:08:01'),
(205, 5, 40, 23, 6, '2015-08-28 05:08:18'),
(206, 5, 41, 20, 15, '2015-08-28 05:08:29'),
(207, 5, 42, 18, 13, '2015-08-28 05:08:36'),
(208, 5, 43, 15, 7, '2015-08-28 05:08:42'),
(209, 5, 44, 32, 21, '2015-08-28 05:08:49'),
(210, 5, 45, 13, 10, '2015-08-28 05:08:59'),
(211, 5, 46, 17, 13, '2015-08-28 05:09:06'),
(212, 5, 47, 43, 27, '2015-08-28 05:09:14'),
(213, 5, 48, 15, 12, '2015-08-28 05:09:21'),
(214, 10, 1, 23, 15, '2015-08-28 15:40:32'),
(215, 10, 2, 25, 17, '2015-08-28 15:40:59'),
(216, 10, 3, 30, 10, '2015-08-28 15:41:32'),
(217, 10, 4, 35, 6, '2015-08-28 15:42:07'),
(218, 10, 5, 17, 12, '2015-08-28 15:43:17'),
(219, 10, 6, 23, 14, '2015-08-28 15:43:32'),
(220, 10, 7, 26, 15, '2015-08-28 15:43:47'),
(221, 10, 8, 35, 12, '2015-08-28 15:44:06'),
(222, 10, 9, 20, 13, '2015-08-28 15:44:24'),
(223, 15, 1, 35, 0, '2015-08-31 06:04:13'),
(224, 15, 2, 25, 10, '2015-08-31 02:55:05'),
(225, 15, 3, 35, 0, '2015-08-31 02:55:26'),
(226, 15, 4, 28, 3, '2015-08-31 02:55:47'),
(227, 15, 6, 28, 17, '2015-08-31 02:56:34'),
(228, 15, 7, 45, 3, '2015-08-31 02:56:59'),
(229, 15, 8, 28, 6, '2015-08-31 02:57:12'),
(230, 15, 9, 17, 10, '2015-08-31 02:57:24'),
(231, 15, 10, 35, 3, '2015-08-31 02:57:37'),
(232, 15, 11, 28, 6, '2015-08-31 02:57:47'),
(233, 15, 12, 45, 3, '2015-08-31 02:58:04'),
(234, 15, 5, 28, 10, '2015-08-31 02:58:50'),
(235, 14, 1, 24, 8, '2015-09-01 04:40:37'),
(236, 14, 2, 34, 6, '2015-09-01 04:41:16'),
(237, 14, 3, 48, 6, '2015-09-01 04:41:38'),
(238, 14, 4, 22, 2, '2015-09-01 04:41:47'),
(239, 14, 5, 24, 18, '2015-09-01 04:42:47'),
(240, 14, 6, 18, 14, '2015-09-01 04:43:06'),
(241, 14, 7, 48, 6, '2015-09-01 04:43:25'),
(242, 14, 8, 18, 2, '2015-09-01 04:43:40'),
(243, 8, 1, 40, 18, '2015-09-11 09:50:50'),
(244, 8, 2, 30, 9, '2015-09-11 09:51:04'),
(245, 8, 3, 55, 6, '2015-09-11 09:51:19'),
(246, 8, 4, 44, 12, '2015-09-11 09:51:35'),
(247, 8, 5, 26, 18, '2015-09-11 09:51:55'),
(248, 8, 6, 22, 20, '2015-09-11 09:52:11'),
(249, 8, 7, 28, 15, '2015-09-11 09:52:26'),
(250, 8, 8, 70, 12, '2015-09-11 09:52:40'),
(251, 8, 9, 16, 14, '2015-09-11 09:53:01'),
(252, 8, 10, 52, 20, '2015-09-11 09:53:22'),
(253, 8, 11, 36, 6, '2015-09-11 09:53:43'),
(254, 8, 12, 55, 12, '2015-09-11 09:54:01'),
(255, 8, 13, 26, 10, '2015-09-11 09:54:10'),
(256, 8, 14, 18, 16, '2015-09-11 09:54:19'),
(257, 8, 15, 21, 20, '2015-09-11 09:54:34'),
(258, 8, 16, 25, 20, '2015-09-11 09:54:44'),
(259, 8, 17, 52, 18, '2015-09-11 09:54:59'),
(260, 8, 18, 20, 18, '2015-09-11 09:55:17'),
(261, 8, 19, 60, 9, '2015-09-11 09:55:35'),
(262, 8, 20, 32, 23, '2015-09-11 09:56:29'),
(263, 8, 21, 21, 20, '2015-09-11 09:56:40'),
(264, 8, 22, 42, 12, '2015-09-11 09:57:16'),
(265, 8, 23, 65, 5, '2015-09-11 09:57:35'),
(266, 8, 24, 23, 16, '2015-09-11 09:57:45'),
(267, 8, 25, 36, 12, '2015-09-11 09:57:53'),
(268, 8, 26, 28, 32, '2015-09-11 09:58:06'),
(269, 8, 27, 20, 30, '2015-09-11 09:58:30'),
(270, 8, 28, 30, 15, '2015-09-11 09:58:45'),
(271, 8, 29, 26, 18, '2015-09-11 09:59:07'),
(272, 8, 30, 32, 20, '2015-09-11 09:59:35'),
(273, 8, 31, 25, 11, '2015-09-11 09:59:46'),
(274, 8, 32, 35, 10, '2015-09-11 09:59:54'),
(275, 8, 33, 40, 20, '2015-09-11 10:00:17'),
(276, 8, 34, 26, 16, '2015-09-11 10:00:32'),
(277, 8, 35, 26, 25, '2015-09-11 10:01:03'),
(278, 8, 36, 25, 10, '2015-09-11 10:01:17'),
(279, 8, 37, 22, 12, '2015-09-11 10:01:28'),
(280, 8, 38, 35, 16, '2015-09-11 10:02:12'),
(281, 8, 39, 20, 35, '2015-09-11 10:02:23'),
(282, 8, 40, 10, 22, '2015-09-11 10:02:34'),
(283, 8, 41, 22, 10, '2015-09-11 10:02:51'),
(284, 8, 42, 22, 10, '2015-09-11 10:02:58'),
(285, 8, 43, 22, 10, '2015-09-11 10:03:04'),
(286, 8, 44, 22, 10, '2015-09-11 10:03:10'),
(287, 8, 45, 14, 20, '2015-09-11 10:03:38'),
(288, 8, 46, 26, 20, '2015-09-11 10:03:48'),
(289, 8, 47, 35, 20, '2015-09-11 10:04:01'),
(290, 8, 48, 18, 28, '2015-09-11 10:04:13'),
(291, 21, 1, 37, 14, '2015-09-11 10:44:33'),
(292, 11, 1, 31, 12, '2015-09-11 11:46:48'),
(293, 11, 2, 15, 8, '2015-09-11 11:47:18'),
(294, 11, 3, 47, 3, '2015-09-11 11:47:41'),
(295, 11, 4, 26, 7, '2015-09-11 11:49:38'),
(296, 11, 5, 16, 16, '2015-09-11 11:50:48');

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
-- Dumping data for table `RememberMe`
--

INSERT INTO `RememberMe` (`UserID`, `SeriesID`, `Token`, `DateAdded`) VALUES
(27, 392788410, 'a314de22103fdfa3fe6d5cd47209a242', '2015-08-19 13:24:53'),
(27, 612395660, 'bc48c9604a2ffe1f77abc530dfb6e46c', '2015-08-19 13:24:53'),
(7, 911106566, '9a38dd8223fa34f0cd01cdd51b039398', '2015-08-27 10:41:04'),
(7, 787752433, '47ddc92947edbd0798ab274b9fd5c2b4', '2015-08-27 10:41:04'),
(5, 240094781, '2754de38630987e28b55127c00539f66', '2015-08-28 04:33:38'),
(5, 316424390, '6080f9a4d9b6394bdfac1488e3910f62', '2015-08-28 04:33:38'),
(10, 962265525, 'cf2e7d8d1f5110df6135c8a94fcd8571', '2015-08-28 15:38:59'),
(10, 797445172, 'c2ac122083b8b94cd253681c66f5f4c0', '2015-08-30 22:04:13'),
(15, 691560004, '6a165bc525005dcdb6adec2a60ac3c46', '2015-08-31 02:54:11'),
(15, 217223737, '56bbc89d2110ff9997ddddec01a2933b', '2015-08-31 06:03:25'),
(14, 964875320, '1dfa3cacb0af13486ae9aada4edb04aa', '2015-09-01 04:37:33'),
(14, 466706437, '2bb13f4c7b0c14738f197137f250af34', '2015-09-01 04:37:33'),
(11, 605075904, '0e5b49a6b24301aed5f2f0eb0dbef1c2', '2015-09-11 11:30:21'),
(11, 821894518, '9f26e5d37cbdcffaf139aec7719bf3a2', '2015-09-11 11:30:21');

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
-- Table structure for table `ScoringSystem`
--

CREATE TABLE IF NOT EXISTS `ScoringSystem` (
  `ScoringSystemID` int(11) NOT NULL,
  `Name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ScoringSystem`
--

INSERT INTO `ScoringSystem` (`ScoringSystemID`, `Name`) VALUES
(1, 'Official'),
(2, 'AutoQuiz');

-- --------------------------------------------------------

--
-- Table structure for table `Stage`
--

CREATE TABLE IF NOT EXISTS `Stage` (
`StageID` int(11) NOT NULL,
  `Name` varchar(50) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Stage`
--

INSERT INTO `Stage` (`StageID`, `Name`) VALUES
(1, 'Group Stages'),
(2, 'Quarter Finals'),
(3, 'Semi Finals'),
(4, '3rd 4th Place Play-off'),
(5, 'Final');

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
(1, 'Australia', 'AUS'),
(2, 'England', 'ENG'),
(3, 'Wales', 'WAL'),
(4, 'Fiji', 'FIJ'),
(5, 'Uruguay', 'URU'),
(6, 'South Africa', 'RSA'),
(7, 'Samoa', 'SAM'),
(8, 'Japan', 'JPN'),
(9, 'Scotland', 'SCO'),
(10, 'United States', 'USA'),
(11, 'New Zealand', 'NZL'),
(12, 'Argentina', 'ARG'),
(13, 'Tonga', 'TGA'),
(14, 'Georgia', 'GEO'),
(15, 'Namibia', 'NAM'),
(16, 'France', 'FRA'),
(17, 'Ireland', 'IRL'),
(18, 'Italy', 'ITA'),
(19, 'Canada', 'CAN'),
(20, 'Romania', 'ROU');

-- --------------------------------------------------------

--
-- Table structure for table `TournamentRole`
--

CREATE TABLE IF NOT EXISTS `TournamentRole` (
`TournamentRoleID` int(11) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `TeamID` int(11) DEFAULT NULL,
  `FromMatchID` int(11) DEFAULT NULL,
  `FromGroupID` int(11) DEFAULT NULL,
  `StageID` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `TournamentRole`
--

INSERT INTO `TournamentRole` (`TournamentRoleID`, `Name`, `TeamID`, `FromMatchID`, `FromGroupID`, `StageID`) VALUES
(1, 'Group A Team 1', 1, NULL, 1, 1),
(2, 'Group A Team 2', 2, NULL, 1, 1),
(3, 'Group A Team 3', 3, NULL, 1, 1),
(4, 'Group A Team 4', 4, NULL, 1, 1),
(5, 'Group A Team 5', 5, NULL, 1, 1),
(6, 'Group B Team 1', 6, NULL, 2, 1),
(7, 'Group B Team 2', 7, NULL, 2, 1),
(8, 'Group B Team 3', 8, NULL, 2, 1),
(9, 'Group B Team 4', 9, NULL, 2, 1),
(10, 'Group B Team 5', 10, NULL, 2, 1),
(11, 'Group C Team 1', 11, NULL, 3, 1),
(12, 'Group C Team 2', 12, NULL, 3, 1),
(13, 'Group C Team 3', 13, NULL, 3, 1),
(14, 'Group C Team 4', 14, NULL, 3, 1),
(15, 'Group C Team 5', 15, NULL, 3, 1),
(16, 'Group D Team 1', 16, NULL, 4, 1),
(17, 'Group D Team 2', 17, NULL, 4, 1),
(18, 'Group D Team 3', 18, NULL, 4, 1),
(19, 'Group D Team 4', 19, NULL, 4, 1),
(20, 'Group D Team 5', 20, NULL, 4, 1),
(21, 'Winner Group A', NULL, NULL, 1, 2),
(22, 'Runner Up Group A', NULL, NULL, 1, 2),
(23, 'Winner Group B', NULL, NULL, 2, 2),
(24, 'Runner Up Group B', NULL, NULL, 2, 2),
(25, 'Winner Group C', NULL, NULL, 3, 2),
(26, 'Runner Up Group C', NULL, NULL, 3, 2),
(27, 'Winner Group D', NULL, NULL, 4, 2),
(28, 'Runner Up Group D', NULL, NULL, 4, 2),
(29, 'Winner Quarter-Final 1', NULL, 41, NULL, 3),
(30, 'Winner Quarter-Final 2', NULL, 42, NULL, 3),
(31, 'Winner Quarter-Final 3', NULL, 43, NULL, 3),
(32, 'Winner Quarter-Final 4', NULL, 44, NULL, 3),
(33, 'Loser Semi-Final 1', NULL, 45, NULL, 4),
(34, 'Loser Semi-Final 2', NULL, 46, NULL, 4),
(35, 'Winner Semi-Final 1', NULL, 45, NULL, 5),
(36, 'Winner Semi-Final 2', NULL, 46, NULL, 5);

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
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `User`
--

INSERT INTO `User` (`UserID`, `FirstName`, `LastName`, `DisplayName`, `Email`, `Password`) VALUES
(1, 'James', 'MacAdie', 'Maccas', 'james.macadie@telerealtrillium.com', 'e30a23724ec797c00135c9a6eccda61c'),
(2, 'Mr.', 'Mean', 'Mr. Mean', 'mrmean@julianrimet.com', 'f0c9a442ef67e81b3a1340ae95700eb3'),
(3, 'Mr.', 'Median', 'Mr. Median', 'mrmedian@julianrimet.com', 'f0c9a442ef67e81b3a1340ae95700eb3'),
(4, 'Richard', 'Morrison', 'Binary Boy', 'richard.morrison3@googlemail.com', '4039d3083f93bb8623b58b626b50d7b0'),
(5, 'Dan', 'Smith', 'DTM', 'dan.smith@citi.com', '9cf2146a2ebedb2e23af62c4e0d41f98'),
(6, 'William', 'MacAdie', 'Will Mac', 'will.macadie@gmail.com', '74c46d2453cc27f2911432363c986746'),
(7, 'Richard', 'Kowenicki', 'Kov', 'doctorkov@googlemail.com', '4011bbf0faf06684cc7eba99d2d016dd'),
(8, 'Sarah', 'Kowenicki', 'Sammie', 'sarahkowenicki@hotmail.com', 'eeaae7a93367d447ef056708acbc6116'),
(9, 'Mark', 'Rusling', 'The Councillor', 'markrusling@hotmail.com', '6d73f43911551b5ed98b7d6d712bf591'),
(10, 'Clare', 'MacAdie', 'Clare Mac', 'clare@macadie.co.uk', 'e706adb60ed514bd612e49c915425ed1'),
(11, 'Tom', 'MacAdie', 'Tom Mac', 'thomasmacadie@eversheds.com', '45a79221ef9f6bc2dfb4e21ad6c6f9d9'),
(12, 'Fiona', 'MacAdie', 'Fi Mac', 'fknox1@hotmail.com', 'f0c9a442ef67e81b3a1340ae95700eb3'),
(13, 'Matt', 'Margrett', 'Matt', 'mattmargrett@gmail.com', '2d0fb7f2e960f8c47ce514ce8a863c69'),
(14, 'Graham', 'Morrison', 'G.Mozz', 'gmorrison@cantab.net', 'baaf4a1cc7c187378e67535a2fb148a6'),
(15, 'James', 'Hall', 'Haller', 'james.russell.hall@gmail.com', '6e20c6b09ad5c38d6da40696f6713c8f'),
(16, 'Martin', 'Ayers', 'Diego', 'martinjohnayers@gmail.com', 'e1108aabb94c6045cadc95e8acf91ef0'),
(17, 'Benjamin ', 'Hart', 'Ben', 'ben@benhart.co.uk', '2566ce3b7e59f9f23baeb77e7d4fe044'),
(18, 'Oliver', 'Peck', 'Ollie', 'oliver.peck@rocketmail.com', 'f8b4ad619a9b4f9f50451943b0b268ba'),
(19, 'Mr.', 'Mode', 'Mr. Mode', 'mrmode@julianrimet.com', 'f0c9a442ef67e81b3a1340ae95700eb3'),
(20, 'David', 'Hart', 'David', 'david@davidhart.co.uk', '52ce8dcc2d13295f76dcba6025b0f8ef'),
(21, 'Paul', 'Coupar', 'Coups', 'pcoupar@hotmail.com', '96ed9a860e90485c20c1030095b3b16c'),
(22, 'Tom', 'Peck', 'Zebedee Peck', 'tompeck1000@gmail.com', '9d37874755d2f8f9cd2779996048f97f'),
(23, 'Genevieve', 'Smith', 'Gen', 'gen.smith@gmail.com', 'c4683de7ded706807b711abf5b37f79b'),
(24, 'Suzie', 'Harrison', 'Suzie', 'suzanna.harrison@gmail.com', '35dbb40b2e863c639bca6303eb0f957b'),
(25, 'Ross', 'Allen', 'Ross', 'rceallen@gmail.com', '410e30c15c7c9f7b5dde86ee9227c458'),
(26, 'Mark', 'Spinks', 'Mark S', 'maspinks@hotmail.com', '00a51fd1eea9f936d90f4809e62bc423'),
(27, 'Des', 'McEwan', 'Mond', 'desmcewan@hotmail.com', 'dcfab7445dd7fb9779750c56ce581e54'),
(28, 'Charlotte', 'Peck', 'Lottie', 'happylottie@hotmail.com', 'efbed475f64469145e9b8d19f838b588'),
(29, 'Archie', 'Bland', 'Archie', 'archie.bland@theguardian.com', 'f0c9a442ef67e81b3a1340ae95700eb3');

-- --------------------------------------------------------

--
-- Table structure for table `UserRole`
--

CREATE TABLE IF NOT EXISTS `UserRole` (
`UserRoleID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `RoleID` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `UserRole`
--

INSERT INTO `UserRole` (`UserRoleID`, `UserID`, `RoleID`) VALUES
(1, 1, 1),
(2, 2, 2),
(3, 3, 3),
(4, 19, 4);

-- --------------------------------------------------------

--
-- Table structure for table `Venue`
--

CREATE TABLE IF NOT EXISTS `Venue` (
`VenueID` int(11) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `City` varchar(50) NOT NULL,
  `Capacity` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Venue`
--

INSERT INTO `Venue` (`VenueID`, `Name`, `City`, `Capacity`) VALUES
(1, 'Brighton Community Stadium', 'Brighton', 30750),
(2, 'Elland Road', 'Leeds', 37914),
(3, 'Kingsholm Stadium', 'Gloucester', 16500),
(4, 'Leicester City Stadium', 'Leicester', 32312),
(5, 'Manchester City Stadium', 'Manchester', 47800),
(6, 'Millennium Stadium', 'Cardiff', 74154),
(7, 'Queen Elizabeth Olympic Park', 'London', 54000),
(8, 'Sandy Park', 'Exeter', 12300),
(9, 'St James’ Park', 'Newcastle', 52409),
(10, 'Stadium MK', ' Milton Keynes', 30717),
(11, 'Twickenham Stadium', 'London', 81605),
(12, 'Villa Park', 'Birmingham', 42785),
(13, 'Wembley Stadium', 'London', 90000);

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
-- Indexes for table `Group`
--
ALTER TABLE `Group`
 ADD PRIMARY KEY (`GroupID`);

--
-- Indexes for table `Match`
--
ALTER TABLE `Match`
 ADD PRIMARY KEY (`MatchID`), ADD KEY `FK_Match_Venue` (`VenueID`), ADD KEY `FK_Match_Home_Team` (`HomeTeamID`), ADD KEY `FK_Match_Away_team` (`AwayTeamID`), ADD KEY `FK_Match_Broadcaster` (`BroadcasterID`), ADD KEY `FK_Match_Stage` (`StageID`), ADD KEY `FK_Match_User` (`ResultPostedBy`);

--
-- Indexes for table `Points`
--
ALTER TABLE `Points`
 ADD PRIMARY KEY (`PointsID`), ADD KEY `FK_Points_Match` (`MatchID`), ADD KEY `FK_Points_User` (`UserID`), ADD KEY `FK_Points_ScoringSystem` (`ScoringSystemID`);

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
-- Indexes for table `ScoringSystem`
--
ALTER TABLE `ScoringSystem`
 ADD PRIMARY KEY (`ScoringSystemID`);

--
-- Indexes for table `Stage`
--
ALTER TABLE `Stage`
 ADD PRIMARY KEY (`StageID`);

--
-- Indexes for table `Team`
--
ALTER TABLE `Team`
 ADD PRIMARY KEY (`TeamID`);

--
-- Indexes for table `TournamentRole`
--
ALTER TABLE `TournamentRole`
 ADD PRIMARY KEY (`TournamentRoleID`), ADD KEY `FK_TournamentRole_Team` (`TeamID`), ADD KEY `FK_TournamentRole_Match` (`FromMatchID`), ADD KEY `FK_TournamentRole_Group` (`FromGroupID`), ADD KEY `FK_TournamentRole_Stage` (`StageID`);

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
MODIFY `BroadcasterID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `Emails`
--
ALTER TABLE `Emails`
MODIFY `EmailsID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=49;
--
-- AUTO_INCREMENT for table `Group`
--
ALTER TABLE `Group`
MODIFY `GroupID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `Match`
--
ALTER TABLE `Match`
MODIFY `MatchID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=49;
--
-- AUTO_INCREMENT for table `Points`
--
ALTER TABLE `Points`
MODIFY `PointsID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `Prediction`
--
ALTER TABLE `Prediction`
MODIFY `PredictionID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=297;
--
-- AUTO_INCREMENT for table `Role`
--
ALTER TABLE `Role`
MODIFY `RoleID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `Stage`
--
ALTER TABLE `Stage`
MODIFY `StageID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `Team`
--
ALTER TABLE `Team`
MODIFY `TeamID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT for table `TournamentRole`
--
ALTER TABLE `TournamentRole`
MODIFY `TournamentRoleID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=37;
--
-- AUTO_INCREMENT for table `User`
--
ALTER TABLE `User`
MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=30;
--
-- AUTO_INCREMENT for table `UserRole`
--
ALTER TABLE `UserRole`
MODIFY `UserRoleID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `Venue`
--
ALTER TABLE `Venue`
MODIFY `VenueID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=14;
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
ADD CONSTRAINT `FK_Match_Away_Team` FOREIGN KEY (`AwayTeamID`) REFERENCES `TournamentRole` (`TournamentRoleID`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `FK_Match_Broadcaster` FOREIGN KEY (`BroadcasterID`) REFERENCES `Broadcaster` (`BroadcasterID`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `FK_Match_Home_team` FOREIGN KEY (`HomeTeamID`) REFERENCES `TournamentRole` (`TournamentRoleID`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `FK_Match_Stage` FOREIGN KEY (`StageID`) REFERENCES `Stage` (`StageID`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `FK_Match_User` FOREIGN KEY (`ResultPostedBy`) REFERENCES `User` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `FK_Match_Venue` FOREIGN KEY (`VenueID`) REFERENCES `Venue` (`VenueID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Points`
--
ALTER TABLE `Points`
ADD CONSTRAINT `FK_Points_Match` FOREIGN KEY (`MatchID`) REFERENCES `Match` (`MatchID`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `FK_Points_ScoringSystem` FOREIGN KEY (`ScoringSystemID`) REFERENCES `ScoringSystem` (`ScoringSystemID`) ON DELETE CASCADE ON UPDATE CASCADE,
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
-- Constraints for table `TournamentRole`
--
ALTER TABLE `TournamentRole`
ADD CONSTRAINT `FK_TournamentRole_Group` FOREIGN KEY (`FromGroupID`) REFERENCES `Group` (`GroupID`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `FK_TournamentRole_Match` FOREIGN KEY (`FromMatchID`) REFERENCES `Match` (`MatchID`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `FK_TournamentRole_Stage` FOREIGN KEY (`StageID`) REFERENCES `Stage` (`StageID`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `FK_TournamentRole_Team` FOREIGN KEY (`TeamID`) REFERENCES `Team` (`TeamID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `UserRole`
--
ALTER TABLE `UserRole`
ADD CONSTRAINT `FK_UserRole_Role` FOREIGN KEY (`RoleID`) REFERENCES `Role` (`RoleID`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `FK_UserRole_User` FOREIGN KEY (`UserID`) REFERENCES `User` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
