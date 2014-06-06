<?php
// Make sure all relevant includes are loaded
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/includesfile.inc.php';

//Check if matchID has been posted
if (isset($_GET['id']) && is_numeric($_GET['id']) && ($_GET['id'] > 0)) {
// MatchID has been properly posted so proceed
	
	// Call the getMatchDetails script to load all the varaibles for the match page
	include 'getMatchDetails.php';
	
	// Set tab variable to indicate point to match page
	$tab = 'match';

	// Set content pointers
	$content = $_SERVER['DOCUMENT_ROOT'] . '/match/match.html.php';
	
} else {
// MatchID has not been properly posted so return error
	
	$content = '<h2>No Match chosen, please go back to <a href="../fixtures">fixtures page</a></h2>';
	// Set content pointers
	$content = $_SERVER['DOCUMENT_ROOT'] . '/match/badMatch.html.php';

}

// Call main HTML page
$contentjs = $_SERVER['DOCUMENT_ROOT'] . '/match/match.js.php';
include $_SERVER['DOCUMENT_ROOT'] . '/includes/template.html.php';
	
?>