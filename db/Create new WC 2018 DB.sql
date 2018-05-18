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
DROP TABLE IF EXISTS `ScoringSystem`;
DROP TABLE IF EXISTS `Prediction`;

DROP TABLE IF EXISTS `Emails`;

ALTER TABLE `TournamentRole` DROP FOREIGN KEY `FK_TournamentRole_Match`;
ALTER TABLE `TournamentRole` DROP INDEX `FK_TournamentRole_Match`;
DROP TABLE IF EXISTS `Match`;
DROP TABLE IF EXISTS `TournamentRole`;
DROP TABLE IF EXISTS `Team`;
DROP TABLE IF EXISTS `Stage`;
DROP TABLE IF EXISTS `Venue`;
DROP TABLE IF EXISTS `Broadcaster`;

DROP TABLE IF EXISTS `MetaGroupMap`;
DROP TABLE IF EXISTS `MetaGroup`;
DROP TABLE IF EXISTS `Group`;

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
  `Name` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Broadcaster`
--

INSERT INTO `Broadcaster` (`BroadcasterID`, `Name`) VALUES
(1, 'BBC'),
(2, 'ITV'),
(3, 'ITV 4'),
(4, 'TBD');

-- --------------------------------------------------------

--
-- Table structure for table `Emails`
--

CREATE TABLE IF NOT EXISTS `Emails` (
  `EmailsID` int(11) NOT NULL,
  `MatchID` int(11) NOT NULL,
  `PredictionsSent` tinyint(1) NOT NULL,
  `ResultsSent` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
(64, 64, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `Group`
--

CREATE TABLE IF NOT EXISTS `Group` (
  `GroupID` int(11) NOT NULL,
  `Name` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Group`
--

INSERT INTO `Group` (`GroupID`, `Name`) VALUES
(1, 'A'),
(2, 'B'),
(3, 'C'),
(4, 'D'),
(5, 'E'),
(6, 'F'),
(7, 'G'),
(8, 'H');

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONS FOR TABLE `Match`:
--   `AwayTeamID`
--       `TournamentRole` -> `TournamentRoleID`
--   `BroadcasterID`
--       `Broadcaster` -> `BroadcasterID`
--   `HomeTeamID`
--       `TournamentRole` -> `TournamentRoleID`
--   `StageID`
--       `Stage` -> `StageID`
--   `ResultPostedBy`
--       `User` -> `UserID`
--   `VenueID`
--       `Venue` -> `VenueID`
--

--
-- Dumping data for table `Match`
--

INSERT INTO `Match` (`MatchID`, `Date`, `KickOff`, `VenueID`, `HomeTeamID`, `AwayTeamID`, `HomeTeamPoints`, `AwayTeamPoints`, `ResultPostedBy`, `ResultPostedOn`, `StageID`, `BroadcasterID`) VALUES
(1, '2018-06-14', '16:00:00', 1, 1, 4, NULL, NULL, NULL, NULL, 1, 2),
(2, '2018-06-15', '13:00:00', 2, 2, 3, NULL, NULL, NULL, NULL, 1, 1),
(3, '2018-06-15', '16:00:00', 3, 5, 7, NULL, NULL, NULL, NULL, 1, 2),
(4, '2018-06-15', '19:00:00', 4, 6, 8, NULL, NULL, NULL, NULL, 1, 1),
(5, '2018-06-16', '11:00:00', 5, 9, 12, NULL, NULL, NULL, NULL, 1, 1),
(6, '2018-06-16', '14:00:00', 6, 13, 16, NULL, NULL, NULL, NULL, 1, 2),
(7, '2018-06-16', '17:00:00', 7, 10, 11, NULL, NULL, NULL, NULL, 1, 1),
(8, '2018-06-16', '20:00:00', 8, 14, 15, NULL, NULL, NULL, NULL, 1, 2),
(9, '2018-06-17', '13:00:00', 9, 17, 19, NULL, NULL, NULL, NULL, 1, 2),
(10, '2018-06-17', '16:00:00', 1, 21, 24, NULL, NULL, NULL, NULL, 1, 1),
(11, '2018-06-17', '19:00:00', 10, 18, 20, NULL, NULL, NULL, NULL, 1, 2),
(12, '2018-06-18', '13:00:00', 11, 22, 23, NULL, NULL, NULL, NULL, 1, 2),
(13, '2018-06-18', '16:00:00', 4, 25, 28, NULL, NULL, NULL, NULL, 1, 1),
(14, '2018-06-18', '19:00:00', 12, 26, 27, NULL, NULL, NULL, NULL, 1, 1),
(15, '2018-06-19', '13:00:00', 7, 30, 31, NULL, NULL, NULL, NULL, 1, 1),
(16, '2018-06-19', '16:00:00', 6, 29, 32, NULL, NULL, NULL, NULL, 1, 2),
(17, '2018-06-19', '19:00:00', 3, 1, 2, NULL, NULL, NULL, NULL, 1, 1),
(18, '2018-06-20', '13:00:00', 1, 6, 5, NULL, NULL, NULL, NULL, 1, 1),
(19, '2018-06-20', '16:00:00', 10, 3, 4, NULL, NULL, NULL, NULL, 1, 1),
(20, '2018-06-20', '19:00:00', 5, 7, 8, NULL, NULL, NULL, NULL, 1, 2),
(21, '2018-06-21', '13:00:00', 9, 11, 12, NULL, NULL, NULL, NULL, 1, 2),
(22, '2018-06-21', '16:00:00', 2, 9, 10, NULL, NULL, NULL, NULL, 1, 2),
(23, '2018-06-21', '19:00:00', 11, 13, 14, NULL, NULL, NULL, NULL, 1, 1),
(24, '2018-06-22', '13:00:00', 3, 18, 17, NULL, NULL, NULL, NULL, 1, 2),
(25, '2018-06-22', '16:00:00', 12, 15, 16, NULL, NULL, NULL, NULL, 1, 1),
(26, '2018-06-22', '19:00:00', 8, 19, 20, NULL, NULL, NULL, NULL, 1, 1),
(27, '2018-06-23', '13:00:00', 6, 25, 26, NULL, NULL, NULL, NULL, 1, 1),
(28, '2018-06-23', '16:00:00', 10, 23, 24, NULL, NULL, NULL, NULL, 1, 2),
(29, '2018-06-23', '19:00:00', 4, 21, 22, NULL, NULL, NULL, NULL, 1, 2),
(30, '2018-06-24', '13:00:00', 11, 27, 28, NULL, NULL, NULL, NULL, 1, 1),
(31, '2018-06-24', '16:00:00', 2, 31, 32, NULL, NULL, NULL, NULL, 1, 1),
(32, '2018-06-24', '19:00:00', 5, 29, 30, NULL, NULL, NULL, NULL, 1, 2),
(33, '2018-06-25', '15:00:00', 9, 3, 1, NULL, NULL, NULL, NULL, 1, 2),
(34, '2018-06-25', '15:00:00', 12, 4, 2, NULL, NULL, NULL, NULL, 1, 3),
(35, '2018-06-25', '19:00:00', 8, 8, 5, NULL, NULL, NULL, NULL, 1, 1),
(36, '2018-06-25', '19:00:00', 7, 7, 6, NULL, NULL, NULL, NULL, 1, 1),
(37, '2018-06-26', '15:00:00', 1, 11, 9, NULL, NULL, NULL, NULL, 1, 2),
(38, '2018-06-26', '15:00:00', 4, 12, 10, NULL, NULL, NULL, NULL, 1, 3),
(39, '2018-06-26', '19:00:00', 3, 15, 13, NULL, NULL, NULL, NULL, 1, 1),
(40, '2018-06-26', '19:00:00', 10, 16, 14, NULL, NULL, NULL, NULL, 1, 1),
(41, '2018-06-27', '15:00:00', 5, 23, 21, NULL, NULL, NULL, NULL, 1, 1),
(42, '2018-06-27', '15:00:00', 2, 24, 22, NULL, NULL, NULL, NULL, 1, 1),
(43, '2018-06-27', '19:00:00', 6, 19, 18, NULL, NULL, NULL, NULL, 1, 2),
(44, '2018-06-27', '19:00:00', 11, 20, 17, NULL, NULL, NULL, NULL, 1, 3),
(45, '2018-06-28', '15:00:00', 12, 31, 29, NULL, NULL, NULL, NULL, 1, 1),
(46, '2018-06-28', '15:00:00', 9, 32, 30, NULL, NULL, NULL, NULL, 1, 1),
(47, '2018-06-28', '19:00:00', 8, 27, 25, NULL, NULL, NULL, NULL, 1, 2),
(48, '2018-06-28', '19:00:00', 7, 28, 26, NULL, NULL, NULL, NULL, 1, 3),
(49, '2018-06-30', '15:00:00', 5, 37, 40, NULL, NULL, NULL, NULL, 2, 4),
(50, '2018-06-30', '19:00:00', 4, 33, 36, NULL, NULL, NULL, NULL, 2, 4),
(51, '2018-07-01', '15:00:00', 1, 35, 34, NULL, NULL, NULL, NULL, 2, 4),
(52, '2018-07-01', '19:00:00', 11, 39, 38, NULL, NULL, NULL, NULL, 2, 4),
(53, '2018-07-02', '15:00:00', 9, 41, 44, NULL, NULL, NULL, NULL, 2, 4),
(54, '2018-07-02', '19:00:00', 10, 45, 48, NULL, NULL, NULL, NULL, 2, 4),
(55, '2018-07-03', '15:00:00', 3, 43, 42, NULL, NULL, NULL, NULL, 2, 4),
(56, '2018-07-03', '19:00:00', 6, 47, 46, NULL, NULL, NULL, NULL, 2, 4),
(57, '2018-07-06', '15:00:00', 11, 50, 49, NULL, NULL, NULL, NULL, 3, 4),
(58, '2018-07-06', '19:00:00', 5, 53, 54, NULL, NULL, NULL, NULL, 3, 4),
(59, '2018-07-07', '15:00:00', 9, 55, 56, NULL, NULL, NULL, NULL, 3, 4),
(60, '2018-07-07', '19:00:00', 4, 51, 52, NULL, NULL, NULL, NULL, 3, 4),
(61, '2018-07-10', '19:00:00', 3, 57, 58, NULL, NULL, NULL, NULL, 4, 4),
(62, '2018-07-11', '19:00:00', 1, 59, 60, NULL, NULL, NULL, NULL, 4, 4),
(63, '2018-07-14', '15:00:00', 3, 61, 62, NULL, NULL, NULL, NULL, 5, 2),
(64, '2018-07-15', '16:00:00', 1, 63, 64, NULL, NULL, NULL, NULL, 6, 1);

-- --------------------------------------------------------

--
-- Table structure for table `MetaGroup`
--

CREATE TABLE IF NOT EXISTS `MetaGroup` (
  `MetaGroupID` int(11) NOT NULL,
  `Name` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `MetaGroup`
--

INSERT INTO `MetaGroup` (`MetaGroupID`, `Name`) VALUES
(1, 'A'),
(2, 'B'),
(3, 'C'),
(4, 'D'),
(5, 'E'),
(6, 'F'),
(7, 'G'),
(8, 'H');


-- --------------------------------------------------------

--
-- Table structure for table `MetaGroupMap`
--

CREATE TABLE IF NOT EXISTS `MetaGroupMap` (
  `MetaGroupID` int(11) NOT NULL,
  `GroupID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONS FOR TABLE `MetaGroupMap`:
--   `MetaGroupID`
--       `MetaGroup` -> `MetaGroupID`
--   `GroupID`
--       `Group` -> `GroupID`

--
-- Dumping data for table `MetaGroupMap`
--

INSERT INTO `MetaGroupMap` (`MetaGroupID`, `GroupID`) VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 4),
(5, 5),
(6, 6),
(7, 7),
(8, 8);

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
  `TotalPoints` decimal(6,2) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

--
-- RELATIONS FOR TABLE `Points`:
--   `MatchID`
--       `Match` -> `MatchID`
--   `ScoringSystemID`
--       `ScoringSystem` -> `ScoringSystemID`
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Stage`
--

INSERT INTO `Stage` (`StageID`, `Name`) VALUES
(1, 'Group Stages'),
(2, 'Round of 16'),
(3, 'Quarter Finals'),
(4, 'Semi Finals'),
(5, 'Third Fourth Place Play-off'),
(6, 'Final');

-- --------------------------------------------------------

--
-- Table structure for table `Team`
--

CREATE TABLE IF NOT EXISTS `Team` (
  `TeamID` int(11) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `ShortName` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Team`
--

INSERT INTO `Team` (`TeamID`, `Name`, `ShortName`) VALUES
(1, 'Russia', 'RUS'),
(2, 'Eygpt', 'EGY'),
(3, 'Uruguay', 'URU'),
(4, 'Saudi Arabia', 'KSA'),
(5, 'Morocco', 'MAR'),
(6, 'Portugal', 'POR'),
(7, 'Iran', 'IRN'),
(8, 'Spain', 'ESP'),
(9, 'France', 'FRA'),
(10, 'Peru', 'PER'),
(11, 'Denmark', 'DEN'),
(12, 'Australia', 'AUS'),
(13, 'Argentina', 'ARG'),
(14, 'Croatia', 'CRO'),
(15, 'Nigeria', 'NGA'),
(16, 'Iceland', 'ISL'),
(17, 'Costa Rica', 'CRC'),
(18, 'Brazil', 'BRA'),
(19, 'Serbia', 'SRB'),
(20, 'Switzerland', 'SUI'),
(21, 'Germany', 'GER'),
(22, 'Sweden', 'SWE'),
(23, 'South Korea', 'KOR'),
(24, 'Mexico', 'MEX'),
(25, 'Belgium', 'BEL'),
(26, 'Tunisia', 'TUN'),
(27, 'England', 'ENG'),
(28, 'Panama', 'PAN'),
(29, 'Poland', 'POL'),
(30, 'Columbia', 'COL'),
(31, 'Japan', 'JAP'),
(32, 'Senegal', 'SEN');

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONS FOR TABLE `TournamentRole`:
--   `FromGroupID`
--       `MetaGroup` -> `MetaGroupID`
--   `FromMatchID`
--       `Match` -> `MatchID`
--   `StageID`
--       `Stage` -> `StageID`
--   `TeamID`
--       `Team` -> `TeamID`
--

--
-- Dumping data for table `TournamentRole`
--

INSERT INTO `TournamentRole` (`TournamentRoleID`, `Name`, `TeamID`, `FromMatchID`, `FromGroupID`, `StageID`) VALUES
(1, 'Group A Team 1', 1, NULL, 1, 1),
(2, 'Group A Team 2', 2, NULL, 1, 1),
(3, 'Group A Team 3', 3, NULL, 1, 1),
(4, 'Group A Team 4', 4, NULL, 1, 1),
(5, 'Group B Team 1', 5, NULL, 2, 1),
(6, 'Group B Team 2', 6, NULL, 2, 1),
(7, 'Group B Team 3', 7, NULL, 2, 1),
(8, 'Group B Team 4', 8, NULL, 2, 1),
(9, 'Group C Team 1', 9, NULL, 3, 1),
(10, 'Group C Team 2', 10, NULL, 3, 1),
(11, 'Group C Team 3', 11, NULL, 3, 1),
(12, 'Group C Team 4', 12, NULL, 3, 1),
(13, 'Group D Team 1', 13, NULL, 4, 1),
(14, 'Group D Team 2', 14, NULL, 4, 1),
(15, 'Group D Team 3', 15, NULL, 4, 1),
(16, 'Group D Team 4', 16, NULL, 4, 1),
(17, 'Group E Team 1', 17, NULL, 5, 1),
(18, 'Group E Team 2', 18, NULL, 5, 1),
(19, 'Group E Team 3', 19, NULL, 5, 1),
(20, 'Group E Team 4', 20, NULL, 5, 1),
(21, 'Group F Team 1', 21, NULL, 6, 1),
(22, 'Group F Team 2', 22, NULL, 6, 1),
(23, 'Group F Team 3', 23, NULL, 6, 1),
(24, 'Group F Team 4', 24, NULL, 6, 1),
(25, 'Group G Team 1', 25, NULL, 7, 1),
(26, 'Group G Team 2', 26, NULL, 7, 1),
(27, 'Group G Team 3', 27, NULL, 7, 1),
(28, 'Group G Team 4', 28, NULL, 7, 1),
(29, 'Group H Team 1', 29, NULL, 8, 1),
(30, 'Group H Team 2', 30, NULL, 8, 1),
(31, 'Group H Team 3', 31, NULL, 8, 1),
(32, 'Group H Team 4', 32, NULL, 8, 1),
(33, 'Winner Group A', NULL, NULL, 1, 2),
(34, 'Runner Up Group A', NULL, NULL, 1, 2),
(35, 'Winner Group B', NULL, NULL, 2, 2),
(36, 'Runner Up Group B', NULL, NULL, 2, 2),
(37, 'Winner Group C', NULL, NULL, 3, 2),
(38, 'Runner Up Group C', NULL, NULL, 3, 2),
(39, 'Winner Group D', NULL, NULL, 4, 2),
(40, 'Runner Up Group D', NULL, NULL, 4, 2),
(41, 'Winner Group E', NULL, NULL, 5, 2),
(42, 'Runner Up Group E', NULL, NULL, 5, 2),
(43, 'Winner Group F', NULL, NULL, 6, 2),
(44, 'Runner Up Group F', NULL, NULL, 6, 2),
(45, 'Winner Group G', NULL, NULL, 7, 2),
(46, 'Runner Up Group G', NULL, NULL, 7, 2),
(47, 'Winner Group H', NULL, NULL, 8, 2),
(48, 'Runner Up Group H', NULL, NULL, 8, 2),
(49, 'Winner R16 1', NULL, 49, NULL, 3),
(50, 'Winner R16 2', NULL, 50, NULL, 3),
(51, 'Winner R16 3', NULL, 51, NULL, 3),
(52, 'Winner R16 4', NULL, 52, NULL, 3),
(53, 'Winner R16 5', NULL, 53, NULL, 3),
(54, 'Winner R16 6', NULL, 54, NULL, 3),
(55, 'Winner R16 7', NULL, 55, NULL, 3),
(56, 'Winner R16 8', NULL, 56, NULL, 3),
(57, 'Winner Quarter-Final 1', NULL, 57, NULL, 4),
(58, 'Winner Quarter-Final 2', NULL, 58, NULL, 4),
(59, 'Winner Quarter-Final 3', NULL, 59, NULL, 4),
(60, 'Winner Quarter-Final 4', NULL, 60, NULL, 4),
(61, 'Loser Semi-Final 1', NULL, 61, NULL, 5),
(62, 'Loser Semi-Final 2', NULL, 62, NULL, 5),
(63, 'Winner Semi-Final 1', NULL, 61, NULL, 6),
(64, 'Winner Semi-Final 2', NULL, 62, NULL, 6);

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
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=latin1;

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
(9, 'Mark', 'Rusling', 'Uwe', 'markrusling@hotmail.com', '6d73f43911551b5ed98b7d6d712bf591'),
(10, 'Clare', 'MacAdie', 'Clare Mac', 'clare@macadie.co.uk', 'e706adb60ed514bd612e49c915425ed1'),
(11, 'Tom', 'MacAdie', 'Tom Mac', 'tom_macadie@hotmail.com', '45a79221ef9f6bc2dfb4e21ad6c6f9d9'),
(12, 'Fiona', 'MacAdie', 'Fi Mac', 'fknox1@hotmail.com', '713dc3d995d57eb25e632786983ee2f3'),
(13, 'Matt', 'Margrett', 'Matt', 'mattmargrett@gmail.com', '2d0fb7f2e960f8c47ce514ce8a863c69'),
(14, 'Graham', 'Morrison', 'G.Mozz', 'gmorrison100@gmail.com', 'baaf4a1cc7c187378e67535a2fb148a6'),
(15, 'James', 'Hall', 'Haller', 'james.russell.hall@gmail.com', '6e20c6b09ad5c38d6da40696f6713c8f'),
(16, 'Archie', 'Bland', 'Archie', 'archie.bland@theguardian.com', 'f0c9a442ef67e81b3a1340ae95700eb3'),
(17, 'Benjamin ', 'Hart', 'Ben', 'ben@benhart.co.uk', '2566ce3b7e59f9f23baeb77e7d4fe044'),
(18, 'Oliver', 'Peck', 'Ollie', 'oliver.peck@rocketmail.com', 'f8b4ad619a9b4f9f50451943b0b268ba'),
(19, 'Mr.', 'Mode', 'Mr. Mode', 'mrmode@julianrimet.com', 'f0c9a442ef67e81b3a1340ae95700eb3'),
(20, 'David', 'Hart', 'David', 'david@davidhart.co.uk', '52ce8dcc2d13295f76dcba6025b0f8ef'),
(21, 'Paul', 'Coupar', 'Coups', 'pcoupar@hotmail.com', '96ed9a860e90485c20c1030095b3b16c'),
(22, 'Tom', 'Peck', 'Peck', 'tompeck1000@gmail.com', '9d37874755d2f8f9cd2779996048f97f'),
(23, 'Genevieve', 'Smith', 'Gen', 'gen.smith@gmail.com', 'c4683de7ded706807b711abf5b37f79b'),
(24, 'Martin', 'Ayers', 'Diego', 'martin.ayers@talk21.com', 'f0c9a442ef67e81b3a1340ae95700eb3'),
(25, 'Ross', 'Allen', 'Ross', 'rceallen@gmail.com', '410e30c15c7c9f7b5dde86ee9227c458'),
(26, 'Mark', 'Spinks', 'Mark S', 'maspinks@hotmail.com', '00a51fd1eea9f936d90f4809e62bc423'),
(27, 'Des', 'McEwan', 'Mond', 'desmcewan@hotmail.com', 'dcfab7445dd7fb9779750c56ce581e54'),
(28, 'Charlotte', 'Peck', 'Lottie', 'happylottie@hotmail.com', 'efbed475f64469145e9b8d19f838b588'),
(29, 'Jari', 'Stehn', 'Sven', 'jari.stehn@gmail.com', 'f0c9a442ef67e81b3a1340ae95700eb3'),
(30, 'Alice', 'Jones', 'Lady Peck', 'alice.jones@inews.co.uk', '78c8566f78eb142414d15bd1e73bcffe'),
(31, 'Sam', 'Gallagher', 'galsnakes', 'Sam.Gallagher@progressivecontent.com', '876a9703f04b99cc019c7bc6df3c02b4'),
(32, 'Jonny', 'Pearson', 'Jonny', 'jonnyzpearson@gmail.com', '87a7c24bf14d213c9f9ddbcb2c04dddc'),
(33, 'Manon', 'Cornu', 'Manon', 'manoncornu@live.fr', 'f0c9a442ef67e81b3a1340ae95700eb3'),
(34, 'Rosa', 'Monserrat', 'Rosa', 'rosama68@hotmail.com', 'f0c9a442ef67e81b3a1340ae95700eb3');

-- --------------------------------------------------------

--
-- Table structure for table `UserRole`
--

CREATE TABLE IF NOT EXISTS `UserRole` (
  `UserRoleID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `RoleID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Venue`
--

INSERT INTO `Venue` (`VenueID`, `Name`, `City`, `Capacity`) VALUES
(1, 'Luzhniki Stadium', 'Moscow', 81000),
(2, 'Central Stadium', 'Yekaterinburg', 35696),
(3, 'Krestovsky Stadium', 'Saint-Petersburg', 64287),
(4, 'Fisht Olympic Stadium', 'Sochi', 41220),
(5, 'Kazan Arena', 'Kazan', 45379),
(6, 'Otkritie Arena', 'Moscow', 45360),
(7, 'Mordovia Arena', 'Saransk', 44442),
(8, 'Kaliningrad Stadium', 'Kaliningrad', 35212),
(9, 'Cosmos Arena', 'Samara', 44918),
(10, 'Rostov Arena', 'Rostov-on-Don', 45000),
(11, 'Nizhny Novgorod Stadium', 'Nizhny Novgorod', 44899),
(12, 'Volgograd Arena', 'Volgograd', 45568);

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
-- Indexes for table `MetaGroup`
--
ALTER TABLE `MetaGroup`
 ADD PRIMARY KEY (`MetaGroupID`);

--
-- Indexes for table `MetaGroupMap`
--
ALTER TABLE `MetaGroupMap`
 ADD KEY `FK_MetaGroupMap_MetaGroup` (`MetaGroupID`), ADD KEY `FK_MetaGroupMap_Group` (`GroupID`);
 
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
-- AUTO_INCREMENT for table `User`
--
ALTER TABLE `User`
MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=33;
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
-- Constraints for table `MetaGroupMap`
--
ALTER TABLE `MetaGroupMap`
ADD CONSTRAINT `FK_MetaGroupMap_MetaGroup` FOREIGN KEY (`MetaGroupID`) REFERENCES `MetaGroup` (`MetaGroupID`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `FK_MetaGroupMap_Group` FOREIGN KEY (`GroupID`) REFERENCES `Group` (`GroupID`) ON DELETE CASCADE ON UPDATE CASCADE;

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
ADD CONSTRAINT `FK_TournamentRole_Group` FOREIGN KEY (`FromGroupID`) REFERENCES `MetaGroup` (`MetaGroupID`) ON DELETE CASCADE ON UPDATE CASCADE,
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
