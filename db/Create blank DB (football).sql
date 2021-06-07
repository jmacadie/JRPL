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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Broadcaster`
--

INSERT INTO `Broadcaster` (`BroadcasterID`, `Name`) VALUES
(1, 'BBC'),
(2, 'ITV'),
(3, 'TBC');

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
(51, 51, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `Group`
--

CREATE TABLE IF NOT EXISTS `Group` (
`GroupID` int(11) NOT NULL,
  `Name` varchar(10) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Group`
--

INSERT INTO `Group` (`GroupID`, `Name`) VALUES
(1, 'A'),
(2, 'B'),
(3, 'C'),
(4, 'D'),
(5, 'E'),
(6, 'F');

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
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=latin1;

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
(1, '2021-06-11', '20:00:00', 1, 3, 1, NULL, NULL, NULL, NULL, 1, 1),
(2, '2021-06-12', '14:00:00', 2, 4, 2, NULL, NULL, NULL, NULL, 1, 1),
(3, '2021-06-12', '17:00:00', 3, 6, 7, NULL, NULL, NULL, NULL, 1, 1),
(4, '2021-06-12', '20:00:00', 4, 5, 8, NULL, NULL, NULL, NULL, 1, 2),
(5, '2021-06-13', '14:00:00', 5, 15, 13, NULL, NULL, NULL, NULL, 1, 1),
(6, '2021-06-13', '17:00:00', 6, 9, 11, NULL, NULL, NULL, NULL, 1, 2),
(7, '2021-06-13', '20:00:00', 7, 10, 12, NULL, NULL, NULL, NULL, 1, 2),
(8, '2021-06-14', '14:00:00', 8, 16, 14, NULL, NULL, NULL, NULL, 1, 1),
(9, '2021-06-14', '17:00:00', 4, 17, 18, NULL, NULL, NULL, NULL, 1, 2),
(10, '2021-06-14', '20:00:00', 9, 19, 20, NULL, NULL, NULL, NULL, 1, 1),
(11, '2021-06-15', '17:00:00', 10, 23, 24, NULL, NULL, NULL, NULL, 1, 2),
(12, '2021-06-15', '20:00:00', 11, 21, 22, NULL, NULL, NULL, NULL, 1, 2),
(13, '2021-06-16', '14:00:00', 4, 7, 8, NULL, NULL, NULL, NULL, 1, 1),
(14, '2021-06-16', '17:00:00', 2, 3, 4, NULL, NULL, NULL, NULL, 1, 1),
(15, '2021-06-16', '20:00:00', 1, 1, 2, NULL, NULL, NULL, NULL, 1, 2),
(16, '2021-06-17', '14:00:00', 6, 12, 11, NULL, NULL, NULL, NULL, 1, 2),
(17, '2021-06-17', '17:00:00', 3, 6, 5, NULL, NULL, NULL, NULL, 1, 2),
(18, '2021-06-17', '20:00:00', 7, 10, 9, NULL, NULL, NULL, NULL, 1, 1),
(19, '2021-06-18', '14:00:00', 4, 20, 18, NULL, NULL, NULL, NULL, 1, 1),
(20, '2021-06-18', '17:00:00', 8, 13, 14, NULL, NULL, NULL, NULL, 1, 1),
(21, '2021-06-18', '20:00:00', 5, 15, 16, NULL, NULL, NULL, NULL, 1, 2),
(22, '2021-06-19', '14:00:00', 10, 23, 21, NULL, NULL, NULL, NULL, 1, 1),
(23, '2021-06-19', '17:00:00', 11, 24, 22, NULL, NULL, NULL, NULL, 1, 2),
(24, '2021-06-19', '20:00:00', 9, 19, 17, NULL, NULL, NULL, NULL, 1, 1),
(25, '2021-06-20', '17:00:00', 1, 1, 4, NULL, NULL, NULL, NULL, 1, 1),
(26, '2021-06-20', '17:00:00', 2, 2, 3, NULL, NULL, NULL, NULL, 1, 1),
(27, '2021-06-21', '17:00:00', 6, 12, 9, NULL, NULL, NULL, NULL, 1, 2),
(28, '2021-06-21', '17:00:00', 7, 11, 10, NULL, NULL, NULL, NULL, 1, 2),
(29, '2021-06-21', '20:00:00', 4, 7, 5, NULL, NULL, NULL, NULL, 1, 1),
(30, '2021-06-21', '20:00:00', 3, 8, 6, NULL, NULL, NULL, NULL, 1, 1),
(31, '2021-06-22', '20:00:00', 5, 14, 15, NULL, NULL, NULL, NULL, 1, 2),
(32, '2021-06-22', '20:00:00', 8, 13, 16, NULL, NULL, NULL, NULL, 1, 2),
(33, '2021-06-23', '17:00:00', 4, 20, 17, NULL, NULL, NULL, NULL, 1, 2),
(34, '2021-06-23', '17:00:00', 9, 18, 19, NULL, NULL, NULL, NULL, 1, 2),
(35, '2021-06-23', '20:00:00', 11, 22, 23, NULL, NULL, NULL, NULL, 1, 1),
(36, '2021-06-23', '20:00:00', 10, 24, 21, NULL, NULL, NULL, NULL, 1, 1),
(37, '2021-06-26', '17:00:00', 7, 26, 28, NULL, NULL, NULL, NULL, 2, 3),
(38, '2021-06-26', '20:00:00', 5, 25, 30, NULL, NULL, NULL, NULL, 2, 3),
(39, '2021-06-27', '17:00:00', 10, 29, 39, NULL, NULL, NULL, NULL, 2, 3),
(40, '2021-06-27', '20:00:00', 9, 27, 40, NULL, NULL, NULL, NULL, 2, 3),
(41, '2021-06-28', '17:00:00', 3, 32, 34, NULL, NULL, NULL, NULL, 2, 3),
(42, '2021-06-28', '20:00:00', 6, 35, 37, NULL, NULL, NULL, NULL, 2, 3),
(43, '2021-06-29', '17:00:00', 5, 31, 36, NULL, NULL, NULL, NULL, 2, 3),
(44, '2021-06-29', '20:00:00', 8, 33, 38, NULL, NULL, NULL, NULL, 2, 3),
(45, '2021-07-02', '17:00:00', 4, 46, 45, NULL, NULL, NULL, NULL, 3, 3),
(46, '2021-07-02', '20:00:00', 11, 44, 42, NULL, NULL, NULL, NULL, 3, 3),
(47, '2021-07-03', '17:00:00', 2, 43, 41, NULL, NULL, NULL, NULL, 3, 3),
(48, '2021-07-03', '20:00:00', 1, 48, 47, NULL, NULL, NULL, NULL, 3, 3),
(49, '2021-07-06', '20:00:00', 5, 50, 49, NULL, NULL, NULL, NULL, 4, 3),
(50, '2021-07-07', '20:00:00', 5, 52, 51, NULL, NULL, NULL, NULL, 4, 3),
(51, '2021-07-11', '20:00:00', 5, 53, 54, NULL, NULL, NULL, NULL, 5, 1);


-- --------------------------------------------------------

--
-- Table structure for table `MetaGroup`
--

CREATE TABLE IF NOT EXISTS `MetaGroup` (
  `MetaGroupID` int(11) NOT NULL,
  `Name` varchar(10) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

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
(7, 'A/C/D'),
(8, 'B/E/F'),
(9, 'C/D/E'),
(10, 'A/B/F');


-- --------------------------------------------------------

--
-- Table structure for table `MetaGroupMap`
--

CREATE TABLE IF NOT EXISTS `MetaGroupMap` (
  `MetaGroupID` int(11) NOT NULL,
  `GroupID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
(7, 1),
(7, 3),
(7, 4),
(8, 2),
(8, 5),
(8, 6),
(9, 3),
(9, 4),
(9, 5),
(10, 1),
(10, 2),
(10, 6);

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
(2, 'Round of 16'),
(3, 'Quarter Finals'),
(4, 'Semi Finals'),
(5, 'Final');

-- --------------------------------------------------------

--
-- Table structure for table `Team`
--

CREATE TABLE IF NOT EXISTS `Team` (
`TeamID` int(11) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `ShortName` varchar(10) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Team`
--

INSERT INTO `Team` (`TeamID`, `Name`, `ShortName`) VALUES
(1,'Italy','ITA'),
(2,'Switzerland','SUI'),
(3,'Turkey','TUR'),
(4,'Wales','WAL'),
(5,'Belgium','BEL'),
(6,'Denmark','DNK'),
(7,'Finland','FIN'),
(8,'Russia','RUS'),
(9,'Austria','AUT'),
(10,'Netherlands','NLD'),
(11,'North Macedonia','MKD'),
(12,'Ukraine','UKR'),
(13,'Croatia','CRO'),
(14,'Czechia','CZE'),
(15,'England','ENG'),
(16,'Scotland','SCO'),
(17,'Poland','POL'),
(18,'Slovakia','SVK'),
(19,'Spain','ESP'),
(20,'Sweden','SWE'),
(21,'France','FRA'),
(22,'Germany','GER'),
(23,'Hungary','HUN'),
(24,'Portugal','POR');


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
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=latin1;

--
-- RELATIONS FOR TABLE `TournamentRole`:
--   `FromGroupID`
--       `Group` -> `GroupID`
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
(25, 'Winner Group A', NULL, NULL, 1, 2),
(26, 'Runner Up Group A', NULL, NULL, 1, 2),
(27, 'Winner Group B', NULL, NULL, 2, 2),
(28, 'Runner Up Group B', NULL, NULL, 2, 2),
(29, 'Winner Group C', NULL, NULL, 3, 2),
(30, 'Runner Up Group C', NULL, NULL, 3, 2),
(31, 'Winner Group D', NULL, NULL, 4, 2),
(32, 'Runner Up Group D', NULL, NULL, 4, 2),
(33, 'Winner Group E', NULL, NULL, 5, 2),
(34, 'Runner Up Group E', NULL, NULL, 5, 2),
(35, 'Winner Group F', NULL, NULL, 6, 2),
(36, 'Runner Up Group F', NULL, NULL, 6, 2),
(37, 'Third Place A/C/D', NULL, NULL, 7, 2),
(38, 'Third Place B/E/F', NULL, NULL, 8, 2),
(39, 'Third Place C/D/E', NULL, NULL, 9, 2),
(40, 'Third Place A/B/F', NULL, NULL, 10, 2),
(41, 'Winner R16 1', NULL, 37, NULL, 3),
(42, 'Winner R16 2', NULL, 38, NULL, 3),
(43, 'Winner R16 3', NULL, 39, NULL, 3),
(44, 'Winner R16 4', NULL, 40, NULL, 3),
(45, 'Winner R16 5', NULL, 41, NULL, 3),
(46, 'Winner R16 6', NULL, 42, NULL, 3),
(47, 'Winner R16 7', NULL, 43, NULL, 3),
(48, 'Winner R16 8', NULL, 44, NULL, 3),
(49, 'Winner Quarter-Final 1', NULL, 45, NULL, 4),
(50, 'Winner Quarter-Final 2', NULL, 46, NULL, 4),
(51, 'Winner Quarter-Final 3', NULL, 47, NULL, 4),
(52, 'Winner Quarter-Final 4', NULL, 48, NULL, 4),
(53, 'Winner Semi-Final 1', NULL, 49, NULL, 5),
(54, 'Winner Semi-Final 2', NULL, 50, NULL, 5);

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
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=latin1;

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
(12, 'Fiona', 'MacAdie', 'Fi Mac', 'fknox1@hotmail.com', '713dc3d995d57eb25e632786983ee2f3'),
(13, 'Matt', 'Margrett', 'Matt', 'mattmargrett@gmail.com', '2d0fb7f2e960f8c47ce514ce8a863c69'),
(14, 'Graham', 'Morrison', 'G.Mozz', 'gmorrison@cantab.net', 'baaf4a1cc7c187378e67535a2fb148a6'),
(15, 'James', 'Hall', 'Haller', 'james.russell.hall@gmail.com', '6e20c6b09ad5c38d6da40696f6713c8f'),
(17, 'Benjamin ', 'Hart', 'Ben', 'ben@benhart.co.uk', '2566ce3b7e59f9f23baeb77e7d4fe044'),
(18, 'Oliver', 'Peck', 'Ollie', 'oliver.peck@rocketmail.com', 'f8b4ad619a9b4f9f50451943b0b268ba'),
(19, 'Mr.', 'Mode', 'Mr. Mode', 'mrmode@julianrimet.com', 'f0c9a442ef67e81b3a1340ae95700eb3'),
(20, 'David', 'Hart', 'David', 'david@davidhart.co.uk', '52ce8dcc2d13295f76dcba6025b0f8ef'),
(21, 'Paul', 'Coupar', 'Coups', 'pcoupar@hotmail.com', '96ed9a860e90485c20c1030095b3b16c'),
(22, 'Tom', 'Peck', 'Peck', 'tompeck1000@gmail.com', '9d37874755d2f8f9cd2779996048f97f'),
(23, 'Genevieve', 'Smith', 'Gen', 'gen.smith@gmail.com', 'c4683de7ded706807b711abf5b37f79b'),
(25, 'Ross', 'Allen', 'Ross', 'rceallen@gmail.com', '410e30c15c7c9f7b5dde86ee9227c458'),
(26, 'Mark', 'Spinks', 'Mark S', 'maspinks@hotmail.com', '00a51fd1eea9f936d90f4809e62bc423'),
(27, 'Des', 'McEwan', 'Mond', 'desmcewan@hotmail.com', 'dcfab7445dd7fb9779750c56ce581e54'),
(28, 'Charlotte', 'Peck', 'Lottie', 'happylottie@hotmail.com', 'efbed475f64469145e9b8d19f838b588'),
(30, 'Alice', 'Jones', 'Lady Peck', 'a.jones@independent.co.uk', '78c8566f78eb142414d15bd1e73bcffe'),
(31, 'Sam', 'Gallagher', 'galsnakes', 'Sam.Gallagher@progressivecp.com', '876a9703f04b99cc019c7bc6df3c02b4'),
(32, 'Jonny', 'Pearson', 'Jonny', 'jonnyzpearson@gmail.com', '87a7c24bf14d213c9f9ddbcb2c04dddc');

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
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Venue`
--

INSERT INTO `Venue` (`VenueID`, `Name`, `City`, `Capacity`) VALUES
(1, 'Stadio Olimpico', 'Rome', 16000),
(2, 'Baki Olimpiya Stadionu', 'Baku', 31000),
(3, 'Parken', 'Copenhagen', 15900),
(4, 'Saint Petersburg Stadium', 'St Petersburg', 30500),
(5, 'Wembley Stadium', 'London', 22500),
(6, 'Arena Națională', 'Bucharest', 13000),
(7, 'Johan Cruijff ArenA', 'Amsterdam', 16000),
(8, 'Hampden Park', 'Glasgow', 12000),
(9, 'Estadio La Cartuja', 'Seville', 25000),
(10, 'Puskás Aréna', 'Budapest', 61000),
(11, 'Fußball Arena München', 'Munich', 14500);

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
-- AUTO_INCREMENT for table `Broadcaster`
--
ALTER TABLE `Broadcaster`
MODIFY `BroadcasterID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `Emails`
--
ALTER TABLE `Emails`
MODIFY `EmailsID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT for table `Group`
--
ALTER TABLE `Group`
MODIFY `GroupID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `Match`
--
ALTER TABLE `Match`
MODIFY `MatchID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=52;
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
-- AUTO_INCREMENT for table `Stage`
--
ALTER TABLE `Stage`
MODIFY `StageID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `Team`
--
ALTER TABLE `Team`
MODIFY `TeamID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT for table `TournamentRole`
--
ALTER TABLE `TournamentRole`
MODIFY `TournamentRoleID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=55;
--
-- AUTO_INCREMENT for table `User`
--
ALTER TABLE `User`
MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=33;
--
-- AUTO_INCREMENT for table `UserRole`
--
ALTER TABLE `UserRole`
MODIFY `UserRoleID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `Venue`
--
ALTER TABLE `Venue`
MODIFY `VenueID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
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
