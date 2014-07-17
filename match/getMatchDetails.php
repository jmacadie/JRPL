<?php

// Start the session if needed
// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
if (!isset($_SESSION)) session_start();

// Set scoring system
// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
if (!isset($_SESSION['scoringSystem']) || !int($_SESSION['scoringSystem']) || ($_SESSION['scoringSystem'] < 1)) $_SESSION['scoringSystem'] = 1;

// Check that ID parameter has been properly formed
// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
if (!isset($gMatchID) || !int($gMatchID) || ($gMatchID < 1)) {
	// TODO: This doesn't work as we're not running an AJAX request here
	$error = 'Match ID not properly formed';
	
	header('Content-type: application/json');
	$arr = array('result' => 'No', 'message' => $error);
	echo json_encode($arr);
	die();
}

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
// Get data for match page
// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
	
// Assign values
$userID = (isset($_SESSION['userID'])) ? $_SESSION['userID'] : 0;
$matchID = $gMatchID + 0;

// Get DB connection
include $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';

// Make sure submitted data is clean
$userID = mysqli_real_escape_string($link, $userID);
$matchID = mysqli_real_escape_string($link, $matchID);

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
// Get base match data
// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

// Query to pull match data from DB
$sql = "SELECT
			m.`MatchID`,
			DATE_FORMAT(m.`Date`, '%W, %D %M %Y') AS `Date`,
			m.`KickOff`,
			IFNULL(ht.`Name`,trht.`Name`) AS `HomeTeam`,
			IFNULL(at.`Name`,trat.`Name`) AS `AwayTeam`,
			IFNULL(ht.`ShortName`,'') AS `HomeTeamS`,
			IFNULL(at.`ShortName`,'') AS `AwayTeamS`,
			m.`HomeTeamGoals`,
			m.`AwayTeamGoals`,
			s.`Name` AS `Stage`,
			CONCAT(v.`Name`, ', ', v.`City`) AS `Venue`,
			b.`Name` AS `Broadcaster`,
			p.`HomeTeamGoals` AS `HomeTeamPrediction`,
			p.`AwayTeamGoals` AS `AwayTeamPrediction`,
			CASE
				WHEN DATE_ADD(NOW(), INTERVAL 30 MINUTE) > TIMESTAMP(m.`Date`, m.`KickOff`) THEN 1
				ELSE 0
			END AS `LockedDown`

		FROM `Match` m
			INNER JOIN `TournamentRole` trht ON
				trht.`TournamentRoleID` = m.`HomeTeamID`
			LEFT JOIN `Team` ht ON
				ht.`TeamID` = trht.`TeamID`
			INNER JOIN `TournamentRole` trat ON
				trat.`TournamentRoleID` = m.`AwayTeamID`
			LEFT JOIN `Team` at ON
				at.`TeamID` = trat.`TeamID`
			INNER JOIN `Stage` s ON
				s.`StageID` = m.`StageID`
			INNER JOIN `Venue` v ON
				v.`VenueID` = m.`VenueID`
			INNER JOIN `Broadcaster` b ON
				b.`BroadcasterID` = m.`BroadcasterID`
			LEFT JOIN `Prediction` p ON
				p.`MatchID` = m.`MatchID`
				AND p.`UserID` =  " . $userID . "
			
		WHERE m.`MatchID` = " . $matchID . ";";

// Run query and handle any failure
$result = mysqli_query($link, $sql);
// TODO: This doesn't work as we're not running an AJAX request here
if (!$result) {
	$error = 'Error fetching matches: <br />' . mysqli_error($link) . '<br /><br />' . $sql;
	
	header('Content-type: application/json');
	$arr = array('result' => 'No', 'message' => $error, 'loggedIn' => max($UserID, 1));
	echo json_encode($arr);
	die();
} 

// Store results
$row = mysqli_fetch_assoc($result);
$date = $row['Date'];
$kickOff = $row['KickOff'];
$stage = $row['Stage'];
$venue = $row['Venue'];
$broadcaster = $row['Broadcaster'];
$homeTeam = $row['HomeTeam'];
$homeTeamS = $row['HomeTeamS'];
$homeTeamGoals = $row['HomeTeamGoals'];
$homeTeamPredGoals = $row['HomeTeamPrediction'];
$awayTeam = $row['AwayTeam'];
$awayTeamS = $row['AwayTeamS'];
$awayTeamGoals = $row['AwayTeamGoals'];
$awayTeamPredGoals = $row['AwayTeamPrediction'];
$lockedDown = $row['LockedDown'];

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
// Get predictions data
// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

// Only get if we're locked down
if ($lockedDown == 1) {
	
	// Query to pull match data from DB
	$sql = "SELECT
				mu.`DisplayName`,
				IFNULL(ht.`Name`,trht.`Name`) AS `HomeTeam`,
				IFNULL(at.`Name`,trat.`Name`) AS `AwayTeam`,
				IFNULL(p.`HomeTeamGoals`,'No prediction') AS `HomeTeamPrediction`,
				IFNULL(p.`AwayTeamGoals`,'No prediction') AS `AwayTeamPrediction`,
				ROUND(po.`TotalPoints`, 2) AS `TotalPoints`

			FROM 
				(SELECT `MatchID`, `HomeTeamID`, `AwayTeamID`, `UserID`, `DisplayName`
				FROM `Match`, `User`
				WHERE `MatchID` = " . $matchID . ") mu
				
				LEFT JOIN `Prediction` p ON
					p.`UserID` = mu.`UserID`
					AND p.`MatchID` = mu.`MatchID`
				INNER JOIN `TournamentRole` trht ON
					trht.`TournamentRoleID` = mu.`HomeTeamID`
				LEFT JOIN `Team` ht ON
					ht.`TeamID` = trht.`TeamID`
				INNER JOIN `TournamentRole` trat ON
					trat.`TournamentRoleID` = mu.`AwayTeamID`
				LEFT JOIN `Team` at ON
					at.`TeamID` = trat.`TeamID`
				LEFT JOIN `Points` po ON
					po.`ScoringSystemID` = " . $_SESSION['scoringSystem'] . "
					AND po.`MatchID` = p.`MatchID`
					AND po.`UserID` = p.`UserID`
			
			ORDER BY
				po.`TotalPoints` DESC,
				(p.`HomeTeamGoals` - p.`AwayTeamGoals`) DESC,
				p.`HomeTeamGoals` DESC,
				mu.`UserID` ASC;";
	
	// Run query and handle any failure
	$result = mysqli_query($link, $sql);
	// TODO: This doesn't work as we're not running an AJAX request here
	if (!$result) {
		$error = 'Error fetching predictions: <br />' . mysqli_error($link) . '<br /><br />' . $sql;
		header('Content-type: application/json');
		$arr = array('result' => 'No', 'message' => $error, 'loggedIn' => max($UserID, 1));
		echo json_encode($arr);
		die();
	}

	// Store results
	$arrPredictions = array();
	while($row = mysqli_fetch_assoc($result)) {
		$arrPredictions[] = $row; 
	}
	
}

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
// Get origin data
// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

// Query to pull match data from DB
$sql = "SELECT
			IFNULL(htht.`Name`,httrht.`Name`) AS `HomeTeamHomeTeam`,
			IFNULL(htat.`Name`,httrat.`Name`) AS `HomeTeamAwayTeam`,
			IFNULL(htht.`ShortName`,'') AS `HomeTeamHomeTeamS`,
			IFNULL(htat.`ShortName`,'') AS `HomeTeamAwayTeamS`,
			htm.`HomeTeamGoals` AS `HomeTeamHomeTeamGoals`,
			htm.`AwayTeamGoals` AS `HomeTeamAwayTeamGoals`,
			htm.`MatchID` AS `HomeTeamMatchID`,
			hts.`Name` AS `HomeTeamStage`,
			IFNULL(atht.`Name`,attrht.`Name`) AS `AwayTeamHomeTeam`,
			IFNULL(atat.`Name`,attrat.`Name`) AS `AwayTeamAwayTeam`,
			IFNULL(atht.`ShortName`,'') AS `AwayTeamHomeTeamS`,
			IFNULL(atat.`ShortName`,'') AS `AwayTeamAwayTeamS`,
			atm.`HomeTeamGoals` AS `AwayTeamHomeTeamGoals`,
			atm.`AwayTeamGoals` AS `AwayTeamAwayTeamGoals`,
			atm.`MatchID` AS `AwayTeamMatchID`,
			ats.`Name` AS `AwayTeamStage`

		FROM `Match` m
		
			INNER JOIN `TournamentRole` trht ON
				trht.`TournamentRoleID` = m.`HomeTeamID`
			LEFT JOIN `Match` htm ON
				htm.`MatchID` = trht.`FromMatchID`
			LEFT JOIN `Stage` hts ON
				hts.`StageID` = htm.`StageID`
			LEFT JOIN `TournamentRole` httrht ON
				httrht.`TournamentRoleID` = htm.`HomeTeamID`
			LEFT JOIN `Team` htht ON
				htht.`TeamID` = httrht.`TeamID`
			LEFT JOIN `TournamentRole` httrat ON
				httrat.`TournamentRoleID` = htm.`AwayTeamID`
			LEFT JOIN `Team` htat ON
				htat.`TeamID` = httrat.`TeamID`
			
			INNER JOIN `TournamentRole` trat ON
				trat.`TournamentRoleID` = m.`AwayTeamID`
			LEFT JOIN `Match` atm ON
				atm.`MatchID` = trat.`FromMatchID`
			LEFT JOIN `Stage` ats ON
				ats.`StageID` = atm.`StageID`
			LEFT JOIN `TournamentRole` attrht ON
				attrht.`TournamentRoleID` = atm.`HomeTeamID`
			LEFT JOIN `Team` atht ON
				atht.`TeamID` = attrht.`TeamID`
			LEFT JOIN `TournamentRole` attrat ON
				attrat.`TournamentRoleID` = atm.`AwayTeamID`
			LEFT JOIN `Team` atat ON
				atat.`TeamID` = attrat.`TeamID`
			
		WHERE m.`MatchID` = " . $matchID . ";";

// Run query and handle any failure
$result = mysqli_query($link, $sql);
// TODO: This doesn't work as we're not running an AJAX request here
if (!$result) {
	$error = 'Error fetching origin data: <br />' . mysqli_error($link) . '<br /><br />' . $sql;
	
	header('Content-type: application/json');
	$arr = array('result' => 'No', 'message' => $error, 'loggedIn' => max($UserID, 1));
	echo json_encode($arr);
	die();
} 

// Store results
$row = mysqli_fetch_assoc($result);
$homeTeamHomeTeam = $row['HomeTeamHomeTeam'];
$homeTeamAwayTeam = $row['HomeTeamAwayTeam'];
$homeTeamHomeTeamS = $row['HomeTeamHomeTeamS'];
$homeTeamAwayTeamS = $row['HomeTeamAwayTeamS'];
$homeTeamHomeTeamGoals = $row['HomeTeamHomeTeamGoals'];
$homeTeamAwayTeamGoals = $row['HomeTeamAwayTeamGoals'];
$homeTeamMatchID = $row['HomeTeamMatchID'];
$homeTeamStage = $row['HomeTeamStage'];
$awayTeamHomeTeam = $row['AwayTeamHomeTeam'];
$awayTeamAwayTeam = $row['AwayTeamAwayTeam'];
$awayTeamHomeTeamS = $row['AwayTeamHomeTeamS'];
$awayTeamAwayTeamS = $row['AwayTeamAwayTeamS'];
$awayTeamHomeTeamGoals = $row['AwayTeamHomeTeamGoals'];
$awayTeamAwayTeamGoals = $row['AwayTeamAwayTeamGoals'];
$awayTeamMatchID = $row['AwayTeamMatchID'];
$awayTeamStage = $row['AwayTeamStage'];

?>