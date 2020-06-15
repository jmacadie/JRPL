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
(92, 92, 0, 0);

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
  `BroadcasterID` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=latin1;

--
-- RELATIONS FOR TABLE `Match`:
--   `AwayTeamID`
--       `Team` -> `TeamID`
--   `BroadcasterID`
--       `Broadcaster` -> `BroadcasterID`
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

INSERT INTO `Match` (`MatchID`, `Date`, `KickOff`, `VenueID`, `HomeTeamID`, `AwayTeamID`, `HomeTeamPoints`, `AwayTeamPoints`, `ResultPostedBy`, `ResultPostedOn`, `BroadcasterID`) VALUES
(1, '2020-06-17', '18:00:00', 1, 3, 15, NULL, NULL, NULL, NULL, 1),
(2, '2020-06-17', '20:15:00', 1, 11, 2, NULL, NULL, NULL, NULL, 1),
(3, '2020-06-19', '18:00:00', 1, 14, 16, NULL, NULL, NULL, NULL, 1),
(4, '2020-06-19', '20:15:00', 1, 17, 12, NULL, NULL, NULL, NULL, 1),
(5, '2020-06-20', '12:30:00', 1, 18, 9, NULL, NULL, NULL, NULL, 1),
(6, '2020-06-20', '15:00:00', 1, 4, 2, NULL, NULL, NULL, NULL, 1),
(7, '2020-06-20', '17:30:00', 1, 19, 20, NULL, NULL, NULL, NULL, 1),
(8, '2020-06-20', '19:45:00', 1, 1, 7, NULL, NULL, NULL, NULL, 1),
(9, '2020-06-21', '14:00:00', 1, 13, 15, NULL, NULL, NULL, NULL, 1),
(10, '2020-06-21', '16:15:00', 1, 3, 6, NULL, NULL, NULL, NULL, 1),
(11, '2020-06-21', '19:00:00', 1, 8, 10, NULL, NULL, NULL, NULL, 1),
(12, '2020-06-22', '20:00:00', 1, 11, 5, NULL, NULL, NULL, NULL, 1),
(13, '2020-06-23', '18:00:00', 1, 9, 4, NULL, NULL, NULL, NULL, 1),
(14, '2020-06-23', '20:15:00', 1, 17, 19, NULL, NULL, NULL, NULL, 1),
(15, '2020-06-24', '18:00:00', 1, 12, 15, NULL, NULL, NULL, NULL, 1),
(16, '2020-06-24', '18:00:00', 1, 13, 3, NULL, NULL, NULL, NULL, 1),
(17, '2020-06-24', '18:00:00', 1, 14, 8, NULL, NULL, NULL, NULL, 1),
(18, '2020-06-24', '18:00:00', 1, 20, 1, NULL, NULL, NULL, NULL, 1),
(19, '2020-06-24', '20:15:00', 1, 10, 7, NULL, NULL, NULL, NULL, 1),
(20, '2020-06-25', '18:00:00', 1, 5, 18, NULL, NULL, NULL, NULL, 1),
(21, '2020-06-25', '18:00:00', 1, 16, 2, NULL, NULL, NULL, NULL, 1),
(22, '2020-06-25', '20:15:00', 1, 6, 11, NULL, NULL, NULL, NULL, 1),
(23, '2020-06-27', '12:30:00', 1, 3, 20, NULL, NULL, NULL, NULL, 1),
(24, '2020-06-28', '16:30:00', 1, 18, 16, NULL, NULL, NULL, NULL, 1),
(25, '2020-06-29', '20:00:00', 1, 7, 5, NULL, NULL, NULL, NULL, 1),
(26, '2020-06-30', '20:15:00', 1, 4, 12, NULL, NULL, NULL, NULL, 1),
(27, '2020-07-01', '18:00:00', 1, 2, 14, NULL, NULL, NULL, NULL, 1),
(28, '2020-07-01', '18:00:00', 1, 1, 13, NULL, NULL, NULL, NULL, 1),
(29, '2020-07-01', '18:00:00', 1, 8, 9, NULL, NULL, NULL, NULL, 1),
(30, '2020-07-01', '20:15:00', 1, 19, 6, NULL, NULL, NULL, NULL, 1),
(31, '2020-07-02', '18:00:00', 1, 15, 17, NULL, NULL, NULL, NULL, 1),
(32, '2020-07-02', '20:15:00', 1, 11, 10, NULL, NULL, NULL, NULL, 1),
(33, '2020-07-04', '15:00:00', 1, 5, 15, NULL, NULL, NULL, NULL, 1),
(34, '2020-07-04', '15:00:00', 1, 6, 18, NULL, NULL, NULL, NULL, 1),
(35, '2020-07-04', '15:00:00', 1, 9, 7, NULL, NULL, NULL, NULL, 1),
(36, '2020-07-04', '15:00:00', 1, 10, 3, NULL, NULL, NULL, NULL, 1),
(37, '2020-07-04', '15:00:00', 1, 12, 1, NULL, NULL, NULL, NULL, 1),
(38, '2020-07-04', '15:00:00', 1, 13, 19, NULL, NULL, NULL, NULL, 1),
(39, '2020-07-04', '15:00:00', 1, 14, 4, NULL, NULL, NULL, NULL, 1),
(40, '2020-07-04', '15:00:00', 1, 16, 11, NULL, NULL, NULL, NULL, 1),
(41, '2020-07-04', '15:00:00', 1, 17, 8, NULL, NULL, NULL, NULL, 1),
(42, '2020-07-04', '15:00:00', 1, 20, 2, NULL, NULL, NULL, NULL, 1),
(43, '2020-07-08', '20:00:00', 1, 2, 9, NULL, NULL, NULL, NULL, 1),
(44, '2020-07-08', '20:00:00', 1, 3, 12, NULL, NULL, NULL, NULL, 1),
(45, '2020-07-08', '20:00:00', 1, 1, 17, NULL, NULL, NULL, NULL, 1),
(46, '2020-07-08', '20:00:00', 1, 4, 10, NULL, NULL, NULL, NULL, 1),
(47, '2020-07-08', '20:00:00', 1, 7, 6, NULL, NULL, NULL, NULL, 1),
(48, '2020-07-08', '20:00:00', 1, 8, 16, NULL, NULL, NULL, NULL, 1),
(49, '2020-07-08', '20:00:00', 1, 11, 13, NULL, NULL, NULL, NULL, 1),
(50, '2020-07-08', '20:00:00', 1, 15, 20, NULL, NULL, NULL, NULL, 1),
(51, '2020-07-08', '20:00:00', 1, 18, 14, NULL, NULL, NULL, NULL, 1),
(52, '2020-07-08', '20:00:00', 1, 19, 5, NULL, NULL, NULL, NULL, 1),
(53, '2020-07-11', '15:00:00', 1, 3, 7, NULL, NULL, NULL, NULL, 1),
(54, '2020-07-11', '15:00:00', 1, 1, 9, NULL, NULL, NULL, NULL, 1),
(55, '2020-07-11', '15:00:00', 1, 4, 11, NULL, NULL, NULL, NULL, 1),
(56, '2020-07-11', '15:00:00', 1, 10, 5, NULL, NULL, NULL, NULL, 1),
(57, '2020-07-11', '15:00:00', 1, 12, 16, NULL, NULL, NULL, NULL, 1),
(58, '2020-07-11', '15:00:00', 1, 14, 19, NULL, NULL, NULL, NULL, 1),
(59, '2020-07-11', '15:00:00', 1, 15, 6, NULL, NULL, NULL, NULL, 1),
(60, '2020-07-11', '15:00:00', 1, 17, 2, NULL, NULL, NULL, NULL, 1),
(61, '2020-07-11', '15:00:00', 1, 18, 13, NULL, NULL, NULL, NULL, 1),
(62, '2020-07-11', '15:00:00', 1, 20, 8, NULL, NULL, NULL, NULL, 1),
(63, '2020-07-15', '20:00:00', 1, 2, 10, NULL, NULL, NULL, NULL, 1),
(64, '2020-07-15', '20:00:00', 1, 5, 20, NULL, NULL, NULL, NULL, 1),
(65, '2020-07-15', '20:00:00', 1, 6, 14, NULL, NULL, NULL, NULL, 1),
(66, '2020-07-15', '20:00:00', 1, 7, 12, NULL, NULL, NULL, NULL, 1),
(67, '2020-07-15', '20:00:00', 1, 8, 3, NULL, NULL, NULL, NULL, 1),
(68, '2020-07-15', '20:00:00', 1, 9, 15, NULL, NULL, NULL, NULL, 1),
(69, '2020-07-15', '20:00:00', 1, 11, 1, NULL, NULL, NULL, NULL, 1),
(70, '2020-07-15', '20:00:00', 1, 13, 17, NULL, NULL, NULL, NULL, 1),
(71, '2020-07-15', '20:00:00', 1, 16, 4, NULL, NULL, NULL, NULL, 1),
(72, '2020-07-15', '20:00:00', 1, 19, 18, NULL, NULL, NULL, NULL, 1),
(73, '2020-07-18', '15:00:00', 1, 3, 2, NULL, NULL, NULL, NULL, 1),
(74, '2020-07-18', '15:00:00', 1, 1, 16, NULL, NULL, NULL, NULL, 1),
(75, '2020-07-18', '15:00:00', 1, 4, 13, NULL, NULL, NULL, NULL, 1),
(76, '2020-07-18', '15:00:00', 1, 10, 6, NULL, NULL, NULL, NULL, 1),
(77, '2020-07-18', '15:00:00', 1, 12, 19, NULL, NULL, NULL, NULL, 1),
(78, '2020-07-18', '15:00:00', 1, 14, 5, NULL, NULL, NULL, NULL, 1),
(79, '2020-07-18', '15:00:00', 1, 15, 8, NULL, NULL, NULL, NULL, 1),
(80, '2020-07-18', '15:00:00', 1, 17, 9, NULL, NULL, NULL, NULL, 1),
(81, '2020-07-18', '15:00:00', 1, 18, 11, NULL, NULL, NULL, NULL, 1),
(82, '2020-07-18', '15:00:00', 1, 20, 7, NULL, NULL, NULL, NULL, 1),
(83, '2020-07-26', '15:00:00', 1, 2, 18, NULL, NULL, NULL, NULL, 1),
(84, '2020-07-26', '15:00:00', 1, 5, 4, NULL, NULL, NULL, NULL, 1),
(85, '2020-07-26', '15:00:00', 1, 6, 20, NULL, NULL, NULL, NULL, 1),
(86, '2020-07-26', '15:00:00', 1, 7, 17, NULL, NULL, NULL, NULL, 1),
(87, '2020-07-26', '15:00:00', 1, 8, 1, NULL, NULL, NULL, NULL, 1),
(88, '2020-07-26', '15:00:00', 1, 9, 12, NULL, NULL, NULL, NULL, 1),
(89, '2020-07-26', '15:00:00', 1, 11, 14, NULL, NULL, NULL, NULL, 1),
(90, '2020-07-26', '15:00:00', 1, 13, 10, NULL, NULL, NULL, NULL, 1),
(91, '2020-07-26', '15:00:00', 1, 16, 15, NULL, NULL, NULL, NULL, 1),
(92, '2020-07-26', '15:00:00', 1, 19, 3, NULL, NULL, NULL, NULL, 1);

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
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Team`
--

INSERT INTO `Team` (`TeamID`, `Name`, `ShortName`) VALUES
(1, 'AFC Bournemouth', 'BOU'),
(2, 'Arsenal', 'ARS'),
(3, 'Aston Villa', 'AVA'),
(4, 'Brighton & Hove Albion', 'BRH'),
(5, 'Burnley', 'BUR'),
(6, 'Chelsea', 'CHE'),
(7, 'Crystal Palace', 'CRY'),
(8, 'Everton', 'EVE'),
(9, 'Leicester City', 'LEI'),
(10, 'Liverpool', 'LIV'),
(11, 'Manchester City', 'MCI'),
(12, 'Manchester United', 'MUN'),
(13, 'Newcastle United', 'NEW'),
(14, 'Norwich City', 'NOR'),
(15, 'Sheffield United', 'SHU'),
(16, 'Southampton', 'SOU'),
(17, 'Tottenham Hotspur', 'TOT'),
(18, 'Watford', 'WAT'),
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
(1, 'Parc des Princes', 'Paris', 45000),
(2, 'Stade de France', 'Saint Denis', 80000),
(3, 'Stade de Bordeaux', 'Bordeaux', 42000),
(4, 'Stade Bollaert-Delelis', 'Lens', 35000),
(5, 'Stade Pierre Mauroy', 'Lille', 50000),
(6, 'Stade de Lyon', 'Lyon', 59000),
(7, 'Stade Vélodrome', 'Marseille', 67000),
(8, 'Stade de Nice', 'Nice', 35000),
(9, 'Stade Geoffroy Guichard', 'Saint-Etienne', 42000),
(10, 'Stadium de Toulouse', 'Toulouse', 33000);

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
-- Indexes for table `Match`
--
ALTER TABLE `Match`
 ADD PRIMARY KEY (`MatchID`), ADD KEY `FK_Match_Venue` (`VenueID`), ADD KEY `FK_Match_Home_Team` (`HomeTeamID`), ADD KEY `FK_Match_Away_team` (`AwayTeamID`), ADD KEY `FK_Match_Broadcaster` (`BroadcasterID`), ADD KEY `FK_Match_User` (`ResultPostedBy`);
 
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
MODIFY `BroadcasterID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `Emails`
--
ALTER TABLE `Emails`
MODIFY `EmailsID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=93;
--
-- AUTO_INCREMENT for table `Match`
--
ALTER TABLE `Match`
MODIFY `MatchID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=93;
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
MODIFY `TeamID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=25;
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
ADD CONSTRAINT `FK_Match_Away_Team` FOREIGN KEY (`AwayTeamID`) REFERENCES `Team` (`TeamID`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `FK_Match_Broadcaster` FOREIGN KEY (`BroadcasterID`) REFERENCES `Broadcaster` (`BroadcasterID`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `FK_Match_Home_team` FOREIGN KEY (`HomeTeamID`) REFERENCES `Team` (`TeamID`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `FK_Match_User` FOREIGN KEY (`ResultPostedBy`) REFERENCES `User` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `FK_Match_Venue` FOREIGN KEY (`VenueID`) REFERENCES `Venue` (`VenueID`) ON DELETE CASCADE ON UPDATE CASCADE;

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