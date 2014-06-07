<?php

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
// Get data for match page
// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

if (isset($_GET['id']) && is_numeric($_GET['id']) && ($_GET['id'] > 0))
{
		
	// Assign values
	$userID = (isset($_SESSION['userID'])) ? $_SESSION['userID'] : 0;
	$matchID = $_GET['id'] + 0;
	
	// Get DB connection
	include $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';
	
	// Make sure submitted data is clean
	$userID = mysqli_real_escape_string($link, $userID);
	$matchID = mysqli_real_escape_string($link, $matchID);
	
	// Query to pull match data from DB
	$sql = "SELECT
				m.`MatchID`,
				DATE_FORMAT(m.`Date`, '%W, %D %M %Y') AS `Date`,
				m.`KickOff`,
				ht.`Name` AS `HomeTeam`,
				at.`Name` AS `AwayTeam`,
				ht.`ShortName` AS `HomeTeamS`,
				at.`ShortName` AS `AwayTeamS`,
				m.`HomeTeamGoals`,
				m.`AwayTeamGoals`,
				CONCAT(v.`Name`, ', ', v.`City`) AS `Venue`,
				b.`Name` AS `Broadcaster`,
				p.`HomeTeamGoals` AS `HomeTeamPrediction`,
				p.`AwayTeamGoals` AS `AwayTeamPrediction`,
				CASE
					WHEN DATE_ADD(NOW(), INTERVAL 30 MINUTE) > TIMESTAMP(m.`Date`, m.`KickOff`) THEN 1
					ELSE 0
				END AS `LockedDown`

			FROM `Match` m
				INNER JOIN `Team` ht ON
					ht.`TeamID` = m.`HomeTeamID`
				INNER JOIN `Team` at ON
					at.`TeamID` = m.`AwayTeamID`
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
	if (!$result)
	{
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

}

?>