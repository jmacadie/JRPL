<?php

// Start the session if needed
if (!isset($_SESSION)) session_start();

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
// Includes
// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/includesfile.inc.php';

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
// Get data for Event Session table
// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

if (isset($_POST['action']) && $_POST['action'] == 'updateMatches')
{
		
	// Assign values
	$userID = (isset($_SESSION['userID'])) ? $_SESSION['userID'] : 0;
	$excLocked = (isset($_POST['excLocked'])) ? ($_POST['excLocked'] === 'true') : true;
	$excPredicted = (isset($_POST['excPredicted'])) ? ($_POST['excPredicted'] === 'true') : true;
	$groupA = (isset($_POST['groupA'])) ? ($_POST['groupA'] === 'true') : true;
	$groupB = (isset($_POST['groupB'])) ? ($_POST['groupB'] === 'true') : true;
	$groupC = (isset($_POST['groupC'])) ? ($_POST['groupC'] === 'true') : true;
	$groupD = (isset($_POST['groupD'])) ? ($_POST['groupD'] === 'true') : true;
	$groupE = (isset($_POST['groupE'])) ? ($_POST['groupE'] === 'true') : true;
	$groupF = (isset($_POST['groupF'])) ? ($_POST['groupF'] === 'true') : true;
	$groupG = (isset($_POST['groupG'])) ? ($_POST['groupG'] === 'true') : true;
	$groupH = (isset($_POST['groupH'])) ? ($_POST['groupH'] === 'true') : true;
	$last16 = (isset($_POST['last16'])) ? ($_POST['last16'] === 'true') : true;
	$quarterFinals = (isset($_POST['quarterFinals'])) ? ($_POST['quarterFinals'] === 'true') : true;
	$semiFinals = (isset($_POST['semiFinals'])) ? ($_POST['semiFinals'] === 'true') : true;
	$final = (isset($_POST['final'])) ? ($_POST['final'] === 'true') : true;
	
	// Get DB connection
	include $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';
	
	// Make sure submitted data is clean
	$userID = mysqli_real_escape_string($link, $userID);
	$excLocked = mysqli_real_escape_string($link, $excLocked);
	$excPredicted = mysqli_real_escape_string($link, $excPredicted);
	$groupA = mysqli_real_escape_string($link, $groupA);
	$groupB = mysqli_real_escape_string($link, $groupB);
	$groupC = mysqli_real_escape_string($link, $groupC);
	$groupD = mysqli_real_escape_string($link, $groupD);
	$groupE = mysqli_real_escape_string($link, $groupE);
	$groupF = mysqli_real_escape_string($link, $groupF);
	$groupG = mysqli_real_escape_string($link, $groupG);
	$groupH = mysqli_real_escape_string($link, $groupH);
	$last16 = mysqli_real_escape_string($link, $last16);
	$quarterFinals = mysqli_real_escape_string($link, $quarterFinals);
	$semiFinals = mysqli_real_escape_string($link, $semiFinals);
	$final = mysqli_real_escape_string($link, $final);
	
	// Query to pull match data from DB
	// TODO: Change column names in predictions table to reference goals not points
	$sql = "SELECT
				m.`MatchID`,
				m.`Date`,
				m.`KickOff`,
				ht.`Name` AS `HomeTeam`,
				at.`Name` AS `AwayTeam`,
				ht.`ShortName` AS `HomeTeamS`,
				at.`ShortName` AS `AwayTeamS`,
				m.`HomeTeamGoals`,
				m.`AwayTeamGoals`,
				p.`HomeTeamPoints`,
				p.`AwayTeamPoints`,
				CASE
					WHEN DATE_ADD(NOW(), INTERVAL 30 MINUTE) > TIMESTAMP(m.`Date`, m.`KickOff`) THEN 1
					ELSE 0
				END AS `LockedDown`

			FROM `Match` m
				INNER JOIN `Team` ht ON
					ht.`TeamID` = m.`HomeTeamID`
				INNER JOIN `Team` at ON
					at.`TeamID` = m.`AwayTeamID`
				LEFT JOIN `Prediction` p ON
					p.`MatchID` = m.`MatchID`
					AND p.`UserID` =  " . $userID . "
				
			WHERE
				m.`MatchID` > 0";
	if ($excLocked) $sql .= " AND DATE_ADD(NOW(), INTERVAL 30 MINUTE) > TIMESTAMP(m.`Date`, m.`KickOff`)";
	if ($excPredicted) $sql .= " AND p.`PredictionID` IS NULL";
	$sql .= ";";
	
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
	$arrMatches = array();
	while($row = mysqli_fetch_assoc($result))
	{
		$arrMatches[] = $row; 
	}
	
	/*// Test Code
	header('Content-type: application/json');
	$arr = array('result' => 'No', 'message' => $sql);
	echo json_encode($arr);*/

	// build results into output JSON file
	header('Content-type: application/json');
	$arr = array(
		'result' => 'Yes'
		,'message' => ''
		,'data' => $arrMatches
		,'loggedIn' => max($UserID, 1));
	echo json_encode($arr);

}

?>