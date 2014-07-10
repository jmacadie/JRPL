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
	calculatePoints($matchID);
	
	// Send e-mail
	sendResultsEmail($matchID);
	
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

?>