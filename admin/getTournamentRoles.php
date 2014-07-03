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
			tr.`TournamentRoleID`,
			s.`Name` AS `Stage`,
			tr.`Name` AS `TournamentRole`,
			t.`TeamID`,
			t.`Name` AS `Team`,
			t.`ShortName` AS `TeamS`,
			IFNULL(gt.`TeamID`, st.`TeamID`) AS `SelectTeamID`,
			IFNULL(gt.`Name`, st.`Name`) AS `SelectTeam`

		FROM `TournamentRole` tr
			
			INNER JOIN `Stage` s ON
				tr.`StageID` = s.`StageID`
			
			LEFT JOIN `Team` t ON
				t.`TeamID` = tr.`TeamID`
			
			LEFT JOIN `TournamentRole` trg ON
				trg.`FromGroupID` = tr.`FromGroupID` AND trg.`StageID` = 1
			LEFT JOIN `Team` gt ON
				gt.`TeamID` = trg.`TeamID`
				
			LEFT JOIN
				(SELECT `MatchID`,`HomeTeamID` AS `TeamID` FROM `Match` UNION ALL
				SELECT `MatchID`,`AwayTeamID` AS `TeamID` FROM `Match`) m ON
				m.`MatchID` = tr.`FromMatchID`
			LEFT JOIN `TournamentRole` trt ON
				trt.`TournamentRoleID` = m.`TeamID`
			LEFT JOIN `Team` st ON
				st.`TeamID` = trt.`TeamID`
		
		ORDER BY
			s.`StageID` ASC,
			tr.`TournamentRoleID` ASC,
			gt.`TeamID` ASC,
			st.`TeamID` ASC";

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
		$tr = $row['TournamentRole'];
		
		// Reset temp output arrays
		$arrTROut = array();
		$arrTRTOut = array();

		// Set up initial outputs for this Tournament Role
		$arrTROut['tournamentRoleID'] = $row['TournamentRoleID'];
		$arrTROut['tournamentRole'] = $tr;
		$arrTROut['stage'] = $row['Stage'];
		$arrTROut['teamID'] = $row['TeamID'];
		$arrTROut['team'] = $row['Team'];
		$arrTROut['teamS'] = $row['TeamS'];
		 
	}
	
	// Push the team onto the select team array
	$arrTRTOut[] = array('id' => $row['SelectTeamID'], 'name' => $row['SelectTeam']); 
}

// Push final TR array onto output array
$arrTROut ['selectTeam'] = $arrTRTOut;
$arrTournamentRoles[] = $arrTROut; 

?>