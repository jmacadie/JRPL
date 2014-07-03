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
				IFNULL(ht.`Name`,trht.`Name`) AS `HomeTeam`,
				IFNULL(at.`Name`,trat.`Name`) AS `AwayTeam`,
				IFNULL(ht.`ShortName`,'') AS `HomeTeamS`,
				IFNULL(at.`ShortName`,'') AS `AwayTeamS`,
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
				INNER JOIN `TournamentRole` trht ON
					trht.`TournamentRoleID` = m.`HomeTeamID`
				LEFT JOIN `Team` ht ON
					ht.`TeamID` = trht.`TeamID`
				INNER JOIN `TournamentRole` trat ON
					trat.`TournamentRoleID` = m.`AwayTeamID`
				LEFT JOIN `Team` at ON
					at.`TeamID` = trat.`TeamID`
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
	
	//If we're locked down then also retrieve the table of all users predictions
	if ($lockedDown == 1) {
		
		// Query to pull match data from DB
		$sql = "SELECT
					mu.`DisplayName`,
					IFNULL(ht.`Name`,trht.`Name`) AS `HomeTeam`,
					IFNULL(at.`Name`,trat.`Name`) AS `AwayTeam`,
					IFNULL(p.`HomeTeamGoals`,'No prediction') AS `HomeTeamPrediction`,
					IFNULL(p.`AwayTeamGoals`,'No prediction') AS `AwayTeamPrediction`,
					po.`TotalPoints`

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
						po.`MatchID` = p.`MatchID`
						AND po.`UserID` = p.`UserID`
				
				ORDER BY
					po.`TotalPoints` DESC,
					(p.`HomeTeamGoals` - p.`AwayTeamGoals`) DESC,
					p.`HomeTeamGoals` DESC,
					mu.`UserID` ASC;";
		
		// Run query and handle any failure
		$result = mysqli_query($link, $sql);
		// TODO: This doesn't work as we're not running an AJAX request here
		if (!$result)
		{
			$error = 'Error fetching predictions: <br />' . mysqli_error($link) . '<br /><br />' . $sql;
			
			header('Content-type: application/json');
			$arr = array('result' => 'No', 'message' => $error, 'loggedIn' => max($UserID, 1));
			echo json_encode($arr);
			die();
		}

		// Store results
		$arrPredictions = array();
		while($row = mysqli_fetch_assoc($result))
		{
			$arrPredictions[] = $row; 
		}
		
	}

}

?>