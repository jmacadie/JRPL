SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `jrpl_dev`
--

-- --------------------------------------------------------

--
-- DROP existing tables
--

-- Break circular FK reference first
ALTER TABLE TournamentRole DROP FOREIGN KEY FK_TournamentRole_Match;

DROP TABLE `Emails`;
DROP TABLE `RememberMe`;
DROP TABLE `UserRole`;
DROP TABLE `Role`;
DROP TABLE `Points`;
DROP TABLE `ScoringSystem`;
DROP TABLE `Prediction`;
DROP TABLE `Match`;
DROP TABLE `TournamentRole`;
DROP TABLE `Group`;
DROP TABLE `Team`;
DROP TABLE `Broadcaster`;
DROP TABLE `Venue`;
DROP TABLE `User`;
DROP TABLE `Stage`;

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
(5, '2015-09-19', '20:00:00', 11, 16, 18, NULL, NULL, NULL, NULL, 1, 2),

(6, '2015-09-20', '12:00:00', 1, 7, 10, NULL, NULL, NULL, NULL, 1, 2),
(7, '2015-09-20', '14:30:00', 6, 3, 5, NULL, NULL, NULL, NULL, 1, 2),
(8, '2015-09-20', '16:45:00', 13, 11, 12, NULL, NULL, NULL, NULL, 1, 2),

(9, '2015-09-23', '14:30:00', 3, 9, 8, NULL, NULL, NULL, NULL, 1, 2),
(10, '2015-09-23', '16:45:00', 6, 1, 4, NULL, NULL, NULL, NULL, 1, 2),
(11, '2015-09-23', '20:00:00', 7, 16, 20, NULL, NULL, NULL, NULL, 1, 2),

(12, '2015-09-24', '20:00:00', 7, 11, 15, NULL, NULL, NULL, NULL, 1, 2),

(13, '2015-09-25', '16:45:00', 3, 12, 14, NULL, NULL, NULL, NULL, 1, 2),

(14, '2015-09-26', '14:30:00', 2, 18, 19, NULL, NULL, NULL, NULL, 1, 2),
(15, '2015-09-26', '16:45:00', 12, 6, 7, NULL, NULL, NULL, NULL, 1, 2),
(16, '2015-09-26', '20:00:00', 11, 2, 3, NULL, NULL, NULL, NULL, 1, 2),

(17, '2015-09-27', '12:00:00', 12, 1, 5, NULL, NULL, NULL, NULL, 1, 2),
(18, '2015-09-27', '14:30:00', 2, 9, 10, NULL, NULL, NULL, NULL, 1, 2),
(19, '2015-09-27', '16:45:00', 13, 17, 20, NULL, NULL, NULL, NULL, 1, 2),

(20, '2015-09-29', '16:45:00', 8, 13, 15, NULL, NULL, NULL, NULL, 1, 2),

(21, '2015-10-01', '16:45:00', 6, 3, 4, NULL, NULL, NULL, NULL, 1, 2),
(22, '2015-10-01', '20:00:00', 10, 16, 19, NULL, NULL, NULL, NULL, 1, 2),

(23, '2015-10-02', '20:00:00', 6, 11, 14, NULL, NULL, NULL, NULL, 1, 2),

(24, '2015-10-03', '14:30:00', 10, 7, 8, NULL, NULL, NULL, NULL, 1, 2),
(25, '2015-10-03', '16:45:00', 9, 6, 9, NULL, NULL, NULL, NULL, 1, 2),
(26, '2015-10-03', '20:00:00', 11, 2, 1, NULL, NULL, NULL, NULL, 1, 2),

(27, '2015-10-04', '14:30:00', 4, 12, 13, NULL, NULL, NULL, NULL, 1, 2),
(28, '2015-10-04', '16:45:00', 7, 17, 18, NULL, NULL, NULL, NULL, 1, 2),

(29, '2015-10-06', '16:45:00', 4, 19, 20, NULL, NULL, NULL, NULL, 1, 2),
(30, '2015-10-06', '20:00:00', 10, 4, 5, NULL, NULL, NULL, NULL, 1, 2),

(31, '2015-10-07', '16:45:00', 7, 6, 10, NULL, NULL, NULL, NULL, 1, 2),
(32, '2015-10-07', '20:00:00', 8, 15, 14, NULL, NULL, NULL, NULL, 1, 2),

(33, '2015-10-09', '20:00:00', 9, 11, 13, NULL, NULL, NULL, NULL, 1, 2),

(34, '2015-10-10', '14:30:00', 9, 7, 9, NULL, NULL, NULL, NULL, 1, 2),
(35, '2015-10-10', '16:45:00', 11, 1, 3, NULL, NULL, NULL, NULL, 1, 2),
(36, '2015-10-10', '20:00:00', 5, 2, 5, NULL, NULL, NULL, NULL, 1, 2),

(37, '2015-10-11', '12:00:00', 4, 12, 15, NULL, NULL, NULL, NULL, 1, 2),
(38, '2015-10-11', '14:30:00', 8, 18, 20, NULL, NULL, NULL, NULL, 1, 2),
(39, '2015-10-11', '16:45:00', 6, 16, 17, NULL, NULL, NULL, NULL, 1, 2),
(40, '2015-10-11', '20:00:00', 3, 10, 8, NULL, NULL, NULL, NULL, 1, 2),

(41, '2015-10-17', '16:00:00', 11, 23 ,22, NULL, NULL, NULL, NULL, 2, 2),
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
  `TotalPoints` decimal(6,2) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;


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
(10, 'Clare', 'MacAdie', 'Clare Mac', 'clare@macadie.co.uk', '37657da08a3ad8fa9745ad0cfd093193'),
(11, 'Tom', 'MacAdie', 'Tom Mac', 'tmacadie@dacbeachcroft.com', '727e03f92f38d09ae2d3aa85b250d395'),
(12, 'Fiona', 'MacAdie', 'Fi Mac', 'fknox1@hotmail.com', '1e1e7cb8fb80cb67eb7d0e5341e1d6b1'),
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
(27, 'Des', 'McEwan', 'Mond', 'desmcewan@hotmail.com', '8775f5218989f43311488bb6521520e1'),
(28, 'Charlotte', 'Peck', 'Lottie', 'happylottie@hotmail.com', 'efbed475f64469145e9b8d19f838b588'),
(29, 'Archie', 'Bland', 'Archie', 'a.bland@independent.co.uk', 'f0c9a442ef67e81b3a1340ae95700eb3');

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
