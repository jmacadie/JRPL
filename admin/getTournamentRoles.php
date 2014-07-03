<?php

// Start the session if needed
if (!isset($_SESSION)) session_start();

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
// Includes
// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/includesfile.inc.php';

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
// Get data for Tournament Roles
// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

// Get DB connection
include $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';

// Query to pull tournament role data from DB
$sql = "SELECT
			s.`Name` AS `Stage`,
			tr.`Name` AS `TournamentRole`,
			t.`TeamID`,
			t.`Team`,
			IFNULL(gt.`TeamID`, IFNULL(ht.`TeamID`, at.`TeamID`)) AS `SelectTeamID`,
			IFNULL(gt.`Name`, IFNULL(ht.`Name`, at.`Name`)) AS `SelectTeam`

		FROM `TournamentRole` tr
			
			INNER JOIN `Stage` s ON
				tr.`StageID` = s.`StageID`
			
			LEFT JOIN `Team` t ON
				t.`TeamID` = tr.`TeamID`
			
			LEFT JOIN `Team` gt ON
				gt.`GroupID` = tr.`GroupID`
				
			LEFT JOIN (SELECT `MatchID`,`HomeTeamID` AS `TeamID` FROM `Match`) htm ON
				htm.`MatchID` = tr.`FromMatchID`
			LEFT JOIN `TournamentRole` trht ON
				trht.`TournamentRoleID` = htm.`TeamID`
			LEFT JOIN `Team` ht ON
				ht.`TeamID` = trht.`TeamID`
			
			LEFT JOIN (SELECT `MatchID`,`AwayTeamID` AS `TeamID` FROM `Match`) atm ON
				atm.`MatchID` = tr.`FromMatchID`
			LEFT JOIN `TournamentRole` trat ON
				trat.`TournamentRoleID` = atm.`TeamID`
			LEFT JOIN `Team` at ON
				at.`TeamID` = trat.`TeamID`
		
		ORDER BY
			s.`StageID` ASC,
			tr.TournamentID ASC";

// Run query and handle any failure
$result = mysqli_query($link, $sql);
if (!$result) {
	$error = 'Error fetching tournament roles: <br />' . mysqli_error($link) . '<br /><br />' . $sql;
	
	header('Content-type: application/json');
	$arr = array('result' => 'No', 'message' => $error);
	echo json_encode($arr);
	die();
} 

// Store results
$arrTournamentRoles = array();
$tr == '';

while($row = mysqli_fetch_assoc($result)) {
	
	// Check if we're onto a new Tournament Role
	if ($row['TournamentRole'] != $tr) {

		// If $tr is set then must have already done a loop so push completed TR array onto output array
		if ($tr != '') {
			$arrTROut ['selectTeam'] = $arrTRTOut;
			$arrTournamentRoles[] = $arrTROut;
		}

		// Reset tr variables
		$tr == $row['TournamentRole'];
		
		// Reset temp output arrays
		$arrTROut = array();
		$arrTRTOut = array();

		// Set up initial outputs for this Tournament Role
		$arrTROut['tournamentRole'] = $tr;
		$arrTROut['stage'] = $row['Stage'];
		$arrTROut['teamID'] = $row['TeamID'];
		$arrTROut['team'] = $row['Team'];
		 
	}
	
	// Push the team onto the select team array
	$arrTRTOut[] = array('id' => $row['SelectTeamID'], 'name' => $row['SelectTeam']); 
}

// Push final TR array onto output array
$arrTROut ['selectTeam'] = $arrTRTOut;
$arrTournamentRoles[] = $arrTROut; 

?>