<?php

// Start the session if needed
if (!isset($_SESSION)) session_start();

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
// Includes
// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/includesfile.inc.php';

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
// Check to see if user is logged in
// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

if (!userIsLoggedIn() || !isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] == FALSE) {
	// build results into output JSON file
	header('Content-type: application/json');
	$arr = array(
		'result' => 'No'
		,'message' => 'You are not logged in. Please log in first');
	echo json_encode($arr);
	die();
}

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
// Check to see if user is an admin
// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

if (!isset($_SESSION['isAdmin']) || $_SESSION['isAdmin'] == FALSE) {
	// build results into output JSON file
	header('Content-type: application/json');
	$arr = array(
		'result' => 'No'
		,'message' => 'You are not an Admin. Only Admins can submit match results');
	echo json_encode($arr);
	die();
}

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
// Check to see if we've got the right action posted
// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
if (isset($_POST['action']) && $_POST['action'] == 'submitResult')
{
		
	// Assign values
	$userID = $_SESSION['userID'];
	$matchID = (isset($_POST['matchID'])) ? $_POST['matchID'] : 'null';
	$homeTeamScore = (isset($_POST['homeTeamScore'])) ? $_POST['homeTeamScore'] : 'null';
	$awayTeamScore = (isset($_POST['awayTeamScore'])) ? $_POST['awayTeamScore'] : 'null';
	
	// Get DB connection
	include $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';
	
	// Make sure submitted data is clean
	$userID = mysqli_real_escape_string($link, $userID);
	$matchID = mysqli_real_escape_string($link, $matchID);
	$homeTeamScore = mysqli_real_escape_string($link, $homeTeamScore);
	$awayTeamScore = mysqli_real_escape_string($link, $awayTeamScore);
	
	if (!int($matchID) || ($matchID < 1)) {
		// build results into output JSON file
		header('Content-type: application/json');
		$arr = array(
			'result' => 'No'
			,'message' => 'Submitted match number "' . $matchID . '" is not correctly formatted. It should be an integer greater than 1');
		echo json_encode($arr);
		die();
	}
	
	if (!int($homeTeamScore) || !int($awayTeamScore)) {
		// build results into output JSON file
		header('Content-type: application/json');
		$arr = array(
			'result' => 'No'
			,'message' => 'Submitted results are not integers');
		echo json_encode($arr);
		die();
	}
	
	if (($homeTeamScore < 0) || ($awayTeamScore < 0)) {
		// build results into output JSON file
		header('Content-type: application/json');
		$arr = array(
			'result' => 'No'
			,'message' => 'Submitted results are negative');
		echo json_encode($arr);
		die();
	} 
	
	// Query to see if a result for this match already exists
	$sql = "SELECT COUNT(*) AS `Count`
			FROM `Match` m
			WHERE
				m.`MatchID` = " . $matchID . "
				AND m.`HomeTeamGoals` IS NOT NULL
				AND m.`AwayTeamGoals` IS NOT NULL;";
	
	// Run query and handle any failure
	$result = mysqli_query($link, $sql);
	if (!$result)
	{
		$error = 'Error counting existing predictions: <br />' . mysqli_error($link) . '<br /><br />' . $sql;
		
		header('Content-type: application/json');
		$arr = array('result' => 'No', 'message' => $error);
		echo json_encode($arr);
		die();
	} 
	
	// Check result
	$row = mysqli_fetch_assoc($result);
    $updateResult = ($row['Count'] == 1);
	//TODO: use this result to update the text of the e-mail sent
	
	// UPDATE the match table with the posted data
	$sql = "UPDATE `Match`
			SET `HomeTeamGoals` = " . $homeTeamScore . ",
				`AwayTeamGoals` = " . $awayTeamScore . ",
				`ResultPostedBy` = " . $userID . ",
				`ResultPostedOn` = NOW()
			WHERE
				`MatchID` = " . $matchID . ";";
	
	// Run query and handle any failure
	$result = mysqli_query($link, $sql);
	if (!$result)
	{
		$error = 'Error adding result: <br />' . mysqli_error($link) . '<br /><br />' . $sql;
		
		header('Content-type: application/json');
		$arr = array('result' => 'No', 'message' => $error);
		echo json_encode($arr);
		die();
	}
	
	// Calculate everyone's points
	calculatePoints ($matchID,$link);
	
	// Send e-mail
	sendResultsEmail($matchID,$link);
	
	// Test Code
	/*header('Content-type: application/json');
	$arr = array('result' => 'No', 'message' => $sql);
	echo json_encode($arr)*/;

	// build results into output JSON file
	header('Content-type: application/json');
	$arr = array(
		'result' => 'Yes'
		,'message' => '');
	echo json_encode($arr);

}

// Calculate the points for a given match
function calculatePoints ($matchID,$link) {

	// Delete existing prediction first
	// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
	
	// Build SQL
    $sql = "DELETE FROM `Points`
			WHERE `MatchID` = " . $matchID . ";";
	
	// Run SQL and trap any errors
    $result = mysqli_query($link, $sql);
    if (!$result)
    {
        $error = "Error deleting previous points for match: <br />" . mysqli_error($link) . '<br /><br />' . $sql;
        
		header('Content-type: application/json');
		$arr = array('result' => 'No', 'message' => $error);
		echo json_encode($arr);
		die();
    }
	
	// Grab match result
	// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
	
	// Build SQL
    $sql = "SELECT
				`HomeTeamGoals`,
				`AwayTeamGoals`
			FROM `Match`
			WHERE `MatchID` = " . $matchID . ";";
	
	// Run SQL and trap any errors
    $resultM = mysqli_query($link, $sql);
    if (!$resultM)
    {
        $error = "Error getting result for match: <br />" . mysqli_error($link) . '<br /><br />' . $sql;
        
		header('Content-type: application/json');
		$arr = array('result' => 'No', 'message' => $error);
		echo json_encode($arr);
		die();
    }
	
	// Grab results
	$rowM = mysqli_fetch_array($resultM);
	$ht = $rowM['HomeTeamGoals'];
	$at = $rowM['AwayTeamGoals'];
	
	// Grab predictions
	// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
	
	// Build SQL
    $sql = "SELECT
				`UserID`,
				`HomeTeamGoals`,
				`AwayTeamGoals`
			FROM `Prediction`
			WHERE `MatchID` = " . $matchID . ";";
	
	// Run SQL and trap any errors
    $resultP = mysqli_query($link, $sql);
    if (!$resultP)
    {
        $error = "Error getting predictions for match: <br />" . mysqli_error($link) . '<br /><br />' . $sql;
        
		header('Content-type: application/json');
		$arr = array('result' => 'No', 'message' => $error);
		echo json_encode($arr);
		die();
    }
	
	$out = '';
	
	// Calculate points and INSERT them back into the DB
	// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
	while ($rowP = mysqli_fetch_array($resultP)) {
		
		// First check right result
		if ((($ht > $at) && ($rowP['HomeTeamGoals'] > $rowP['AwayTeamGoals'])) ||
			(($ht < $at) && ($rowP['HomeTeamGoals'] < $rowP['AwayTeamGoals'])) ||
			(($ht == $at) && ($rowP['HomeTeamGoals'] == $rowP['AwayTeamGoals']))) {
				
				// Right result so award a result point
				$resultPoints = 1;
				
				// Then check exact score
				if (($ht == $rowP['HomeTeamGoals']) && ($at == $rowP['AwayTeamGoals'])) {
						$scorePoints = 2;
				} else {
					$scorePoints = 0;
				}
				
		} else {
			// Not the right result so no points all round
			$resultPoints = 0;
			$scorePoints = 0;
		}
		
		// Calculate the total points
		$totalPoints = $resultPoints + $scorePoints;
		
		// Build SQL
		$sql = "INSERT INTO `Points`
					(`UserID`,
					`MatchID`,
					`ResultPoints`,
					`ScorePoints`,
					`TotalPoints`)
				VALUES
					(" . $rowP['UserID'] . ",
					" . $matchID . ",
					" . $resultPoints . ",
					" . $scorePoints . ",
					" . $totalPoints . ");";
		
		// Run SQL and trap any errors
		$result = mysqli_query($link, $sql);
		if (!$result)
		{
			$error = "Error inserting points for match: <br />" . mysqli_error($link) . '<br /><br />' . $sql;
			
			header('Content-type: application/json');
			$arr = array('result' => 'No', 'message' => $error);
			echo json_encode($arr);
			die();
		}
	
	}
}

// Send e-mail of the results from the posted match
function sendResultsEmail ($matchID, $link) {
	
	// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    // Get match details
    // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    $sql = "SELECT
                ht.`Name` AS `HomeTeam`,
				ht.`ShortName` AS `HomeTeamS`,
				at.`Name` AS `AwayTeam`,
				at.`ShortName` AS `AwayTeamS`,
				m.`HomeTeamGoals`,
				m.`AwayTeamGoals`

            FROM `Match` m

				INNER JOIN `Team` ht ON
					ht.`TeamID` = m.`HomeTeamID`
				
				INNER JOIN `Team` at ON
					at.`TeamID` = m.`AwayTeamID`
			
			WHERE m.`MatchID` = " . $matchID . ";";

    $result = mysqli_query($link, $sql);
    if (!$result)
    {
        $error = 'Error getting match details: <br />' . mysqli_error($link) . '<br /><br />' . $sql;
        
		header('Content-type: application/json');
		$arr = array('result' => 'No', 'message' => $error);
		echo json_encode($arr);
		die();
    }
	
	// Get the data
	$row = mysqli_fetch_assoc($result);
	
	// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    // Get league table details
    // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    $resultLeague = getLeagueTable($link);
	
	// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    // Get match result details
    // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    $sql = "SELECT
                mu.`DisplayName`,
                IFNULL(p.`HomeTeamGoals`,'No prediction') AS `HomeTeamGoals`,
				IFNULL(p.`AwayTeamGoals`,'No prediction') AS `AwayTeamGoals`,
				IFNULL(po.`TotalPoints`,0) AS `TotalPoints`

            FROM
				(SELECT `MatchID`, `UserID`, `DisplayName`
				FROM `Match`, `User`
				WHERE `MatchID` = " . $matchID . ") mu

				LEFT JOIN `Prediction` p ON
					p.`UserID` = mu.`UserID`
					AND p.`MatchID` = mu.`MatchID`
				
				LEFT JOIN `Points` po ON
					po.`MatchID` = p.`MatchID`
					AND po.`UserID` = p.`UserID`
			
			ORDER BY
				po.`TotalPoints` DESC,
				(p.`HomeTeamGoals` - p.`AwayTeamGoals`) DESC,
				p.`HomeTeamGoals` DESC;";

    $resultMatch = mysqli_query($link, $sql);
    if (!$resultMatch)
    {
        $error = 'Error getting match result details: <br />' . mysqli_error($link) . '<br /><br />' . $sql;
        
		header('Content-type: application/json');
		$arr = array('result' => 'No', 'message' => $error);
		echo json_encode($arr);
		die();
    }
	
	// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    // Email To Addresses
    // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    $toEmail='jrpl@googlegroups.com';

    // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    // Email Subject
    // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    $emailSubject = 'Match results for ' . $row['HomeTeam'] . ' vs. '. $row['AwayTeam'];

    // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    // CSS formatting
    // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

    $css = 'standard';

    // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    // Body - write heading table
    // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
	$heading = '<!-- Title -->' . chr(13);
	$heading .= '<tr>' . chr(13);
	$heading .= '<td colspan="5" style="font-family: Helvetica, arial, sans-serif; font-size: 30px; color: #333333; text-align:center; line-height: 30px;" st-title="fulltext-heading">' . chr(13);
	$heading .= 'New result posted' . chr(13);
	$heading .= '</td>' . chr(13);
	$heading .= '</tr>' . chr(13);
	$heading .= '<!-- End of Title -->' . chr(13);
	$heading .= '<!-- spacing -->' . chr(13);
	$heading .= '<tr>' . chr(13);
	$heading .= '<td colspan="5" width="100%" height="20" style="font-size:1px; line-height:1px; mso-line-height-rule: exactly;">&nbsp;</td>' . chr(13);
	$heading .= '</tr>' . chr(13);
	$heading .= '<!-- End of spacing -->' . chr(13);
	$heading .= '<!-- content -->' . chr(13);
	$heading .= '<tr>' . chr(13);
	$heading .= '<td>' . chr(13);
	$heading .= tableBorder('<img border="0" style="vertical-align: middle;" src="http://www.julianrimet.com/assets/img/flags/' . strtolower($row['HomeTeamS']) . '.png" />') . chr(13);
	$heading .= '</td>' . chr(13);
	$heading .= '<td width="48%" style="white-space: nowrap; font-family: Helvetica, arial, sans-serif; font-size: 25px; color: #333333; text-align:right; line-height: 30px;" st-content="fulltext-content">' . chr(13);
	$heading .= $row['HomeTeam'] . chr(13);
	$heading .= '</td>' . chr(13);
	$heading .= '<td style="white-space: nowrap; font-family: Helvetica, arial, sans-serif; font-size: 25px; color: #333333; text-align:center; line-height: 30px;" st-content="fulltext-content">' . chr(13);
	$heading .= $row['HomeTeamGoals'] . '&nbsp;-&nbsp;' . $row['AwayTeamGoals'] . chr(13);
	$heading .= '</td>' . chr(13);
	$heading .= '<td width="48%" style="white-space: nowrap; font-family: Helvetica, arial, sans-serif; font-size: 25px; color: #333333; text-align:left; line-height: 30px;" st-content="fulltext-content">' . chr(13);
	$heading .= $row['AwayTeam'] . chr(13);
	$heading .= '</td>' . chr(13);
	$heading .= '<td>' . chr(13);
	$heading .= tableBorder('<img border="0" style="vertical-align: middle;" src="http://www.julianrimet.com/assets/img/flags/' . strtolower($row['AwayTeamS']) . '.png" />') . chr(13);
	$heading .= '</td>' . chr(13);
	$heading .= '</tr>' . chr(13);
	$heading .= '<!-- End of content -->' . chr(13);
	
	// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    // Body - write league table
    // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
	$league = '<!-- Title -->' . chr(13);
	$league .= '<tr>' . chr(13);
	$league .= '<td colspan="5" style="font-family: Helvetica, arial, sans-serif; font-size: 18px; color: #333333; text-align:center; line-height: 30px;" st-title="fulltext-heading">' . chr(13);
	$league .= 'Current League Table' . chr(13);
	$league .= '</td>' . chr(13);
	$league .= '</tr>' . chr(13);
	$league .= '<!-- End of Title -->' . chr(13);
	$league .= '<!-- spacing -->' . chr(13);
	$league .= '<tr>' . chr(13);
	$league .= '<td colspan="5" width="100%" height="20" style="font-size:1px; line-height:1px; mso-line-height-rule: exactly;">&nbsp;</td>' . chr(13);
	$league .= '</tr>' . chr(13);
	$league .= '<!-- End of spacing -->' . chr(13);
	$league .= '<!-- content -->' . chr(13);
	$league .= '<tr>' . chr(13);
	$league .= '<td st-content="fulltext-content">' . chr(13);
	$league .= '<table border="0" width="100%" cellpadding="4" cellspacing="0" border="0" align="left" class="devicewidth">' . chr(13);
	$league .= '<tr>' . chr(13);
	$league .= '<th style="font-family: Helvetica, arial, sans-serif; font-size: 14px; color: #333333; text-align:left; line-height: 16px;" align="left">&nbsp;</th>' . chr(13);
	$league .= '<th style="font-family: Helvetica, arial, sans-serif; font-size: 14px; color: #333333; text-align:left; line-height: 16px;" align="left">Player</th>' . chr(13);
	$league .= '<th style="font-family: Helvetica, arial, sans-serif; font-size: 14px; color: #333333; text-align:center; line-height: 16px;" align="center">Results</th>' . chr(13);
	$league .= '<th style="font-family: Helvetica, arial, sans-serif; font-size: 14px; color: #333333; text-align:center; line-height: 16px;" align="center">Exact Scores</th>' . chr(13);
	$league .= '<th style="font-family: Helvetica, arial, sans-serif; font-size: 14px; color: #333333; text-align:center; line-height: 16px;" align="center">Points</th>' . chr(13);
	$league .= '</tr>' . chr(13);
	
	// Counter for striped rows
	$i = 0;
	
	foreach ($resultLeague as $rowLeague) {
	
		if($i == 1) {
			$league .= '<tr style="background-color: #f0f0ff;">' . chr(13);
			$i = 2;
		} else{
			$league .= '<tr>' . chr(13);
			$i = 1;
		}
		
		$score  = $rowLeague['scorePoints'] / 2;
		$league .= '<td style="font-family: Helvetica, arial, sans-serif; font-size: 14px; color: #666666; text-align:left; line-height: 16px; white-space: nowrap; vertical-align: top;" align="left">' . $rowLeague['rank'] . '</td>' . chr(13);
		$league .= '<td style="font-family: Helvetica, arial, sans-serif; font-size: 14px; color: #666666; text-align:left; line-height: 16px; white-space: nowrap; vertical-align: top;" align="left">' . $rowLeague['name'] . '</td>' . chr(13);
		if ($rowLeague['resultPoints'] == 0) {
			$league .= '<td style="font-family: Helvetica, arial, sans-serif; font-size: 14px; color: #666666; text-align:center; line-height: 16px; white-space: nowrap; vertical-align: top;" align="center">-</td>' . chr(13);
		} else {
			$league .= '<td style="font-family: Helvetica, arial, sans-serif; font-size: 14px; color: #666666; text-align:center; line-height: 16px; white-space: nowrap; vertical-align: top;" align="center">' . $rowLeague['resultPoints'] . '</td>' . chr(13);
		}
		if ($rowLeague['scorePoints'] == 0) {
			$league .= '<td style="font-family: Helvetica, arial, sans-serif; font-size: 14px; color: #666666; text-align:center; line-height: 16px; white-space: nowrap; vertical-align: top;" align="center">-</td>' . chr(13);
		} else {
			$league .= '<td style="font-family: Helvetica, arial, sans-serif; font-size: 14px; color: #666666; text-align:center; line-height: 16px; white-space: nowrap; vertical-align: top;" align="center">' . $score . '</td>' . chr(13);
		}
		if ($rowLeague['totalPoints'] == 0) {
			$league .= '<td style="font-family: Helvetica, arial, sans-serif; font-size: 14px; color: #666666; text-align:center; line-height: 16px; white-space: nowrap; vertical-align: top;" align="center">-</td>' . chr(13);
		} else {
			$league .= '<td style="font-family: Helvetica, arial, sans-serif; font-size: 14px; color: #666666; text-align:center; line-height: 16px; white-space: nowrap; vertical-align: top;" align="center">' . $rowLeague['totalPoints'] . '</td>' . chr(13);
		}
		$league .= '</tr>' . chr(13);
	
	}
	
	$league .= '</table>' . chr(13);
	$league .= '</td>' . chr(13);
	$league .= '</tr>' . chr(13);
	$league .= '<!-- End of content -->' . chr(13);
	
	// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    // Body - write match details table
    // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
	$match = '<!-- Title -->' . chr(13);
	$match .= '<tr>' . chr(13);
	$match .= '<td colspan="3" style="font-family: Helvetica, arial, sans-serif; font-size: 18px; color: #333333; text-align:center; line-height: 30px;" st-title="fulltext-heading">' . chr(13);
	$match .= 'Details for match' . chr(13);
	$match .= '</td>' . chr(13);
	$match .= '</tr>' . chr(13);
	$match .= '<!-- End of Title -->' . chr(13);
	$match .= '<!-- spacing -->' . chr(13);
	$match .= '<tr>' . chr(13);
	$match .= '<td colspan="3" width="100%" height="20" style="font-size:1px; line-height:1px; mso-line-height-rule: exactly;">&nbsp;</td>' . chr(13);
	$match .= '</tr>' . chr(13);
	$match .= '<!-- End of spacing -->' . chr(13);
	$match .= '<!-- content -->' . chr(13);
	$match .= '<tr>' . chr(13);
	$match .= '<td st-content="fulltext-content">' . chr(13);
	$match .= '<table border="0" width="100%" cellpadding="4" cellspacing="0" border="0" align="left" class="devicewidth">' . chr(13);
	$match .= '<tr>' . chr(13);
	$match .= '<th style="font-family: Helvetica, arial, sans-serif; font-size: 14px; color: #333333; text-align:left; line-height: 16px;" align="left">Player</th>' . chr(13);
	$match .= '<th style="font-family: Helvetica, arial, sans-serif; font-size: 14px; color: #333333; text-align:left; line-height: 16px;" align="left">Prediction</th>' . chr(13);
	$match .= '<th style="font-family: Helvetica, arial, sans-serif; font-size: 14px; color: #333333; text-align:center; line-height: 16px;" align="center">Points</th>' . chr(13);
	$match .= '</tr>' . chr(13);
	
	// Counter for striped rows
	$i = 0;
	
	while ($rowMatch = mysqli_fetch_array($resultMatch)) {
	
		if($i == 1) {
			$match .= '<tr style="background-color: #f0f0ff;">' . chr(13);
			$i = 2;
		} else{
			$match .= '<tr>' . chr(13);
			$i = 1;
		}
		$match .= '<td style="font-family: Helvetica, arial, sans-serif; font-size: 14px; color: #666666; text-align:left; line-height: 16px; white-space: nowrap; vertical-align: top;" align="left">' . $rowMatch['DisplayName'] . '</td>' . chr(13);
		$match .= '<td style="font-family: Helvetica, arial, sans-serif; font-size: 14px; color: #666666; text-align:left; line-height: 16px; white-space: nowrap; vertical-align: top;" align="left">';
		if ($rowMatch['HomeTeamGoals'] == 'No prediction') {
			$match .= '<i>No prediction</i>' . chr(13);
		} else {
			if ($rowMatch['HomeTeamGoals'] > $rowMatch['AwayTeamGoals']) {
				$match .= $row['HomeTeam'] . ' to win<br/>' . chr(13);
				$match .= $rowMatch['HomeTeamGoals'] . '&nbsp;-&nbsp;' . $rowMatch['AwayTeamGoals'];
			} elseif ($rowMatch['AwayTeamGoals'] > $rowMatch['HomeTeamGoals']) {
				$match .= $row['AwayTeam'] . ' to win<br/>' . chr(13);
				$match .= $rowMatch['AwayTeamGoals'] . '&nbsp;-&nbsp;' . $rowMatch['HomeTeamGoals'];
			} else {
				$match .= 'Draw<br/>' . chr(13);
				$match .= $rowMatch['HomeTeamGoals'] . '&nbsp;-&nbsp;' . $rowMatch['AwayTeamGoals'];
			}
		}
		$match .= '</td>' . chr(13);
		if ($rowMatch['TotalPoints'] == 0) {
			$match .= '<td style="font-family: Helvetica, arial, sans-serif; font-size: 14px; color: #666666; text-align:center; line-height: 16px; white-space: nowrap; vertical-align: top;" align="center">-</td>' . chr(13);
		} else {
			$match .= '<td style="font-family: Helvetica, arial, sans-serif; font-size: 14px; color: #666666; text-align:center; line-height: 16px; white-space: nowrap; vertical-align: top;" align="center">' . $rowMatch['TotalPoints'] . '</td>' . chr(13);
		}
		
		$match .= '</tr>' . chr(13);
	
	}
	
	$match .= '</table>' . chr(13);
	$match .= '</td>' . chr(13);
	$match .= '</tr>' . chr(13);
	$match .= '<!-- End of content -->' . chr(13);
	
	// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    // Body - build body array for sendEmail routine
    // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
	$body = array(array('separator','Separator'),
					array('table','Heading',$heading),
					array('separatorHR','Separator'),
					array('table','Current League table',$league),
					array('separatorHR','Separator'),
					array('table','Match details table',$match),
					array('separatorHR','Separator'));

    // Send e-mail
    sendEmail($toEmail,$emailSubject,$css,$body);

    // Update DB to log e-mail being sent
    $sql = "UPDATE `Emails`
            SET `ResultsSent` = 1
            WHERE `MatchID` = " . $matchID;

    $resultBody = mysqli_query($link, $sql);
    if (!$resultBody)
    {
        $error = 'Error updating email sent table: <br />' . mysqli_error($link) . '<br /><br />' . $sql;
        
		header('Content-type: application/json');
		$arr = array('result' => 'No', 'message' => $error);
		echo json_encode($arr);
		die();
    }

}

?>