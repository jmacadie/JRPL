<?php
// Make sure all relevant includes are loaded
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/includesfile.inc.php';

//Check if matchID has been posted
if (isset($_GET['id']) && int($_GET['id']) && ($_GET['id'] > 0)) {
// MatchID has been properly posted so proceed
	
	// Call the getMatchDetails script to load all the varaibles for the match page
	include 'getMatchDetails.php';
	
	// Sort out the previous and next links based on the ring varaible
	if (isset($_GET['ring'])) {
		
		//Convert hex string back into binary
		$tmp = base_convert($_GET['ring'], 16, 2);
		//TODO: cope with ring being all zeros
		// ought not to happen else how did we get here?
		
		// Set previous match link by looping back until we hit a match
		// which is set in the ring variable, with a 1
		$i = $_GET['id'] + 0;
		do {
			if ($i == 1) {
				$i = 64;
			} else {
				$i -= 1;
			}
			$j = substr($tmp, $i - 1, 1);
		} while ($j == 0);
		$prevID = max($i, 1);
		$prev = '../match?id=' . $prevID .'&ring='. $_GET['ring'];
		
		// Set next match link by looping forward until we hit a match
		// which is set in the ring variable, with a 1
		$i = $_GET['id'] + 0;
		do {
			if ($i == 64) {
				$i = 1;
			} else {
				$i += 1;
			}
			$j = substr($tmp, $i - 1, 1);
		} while ($j == 0);
		$nextID = min($i, 64);
		$next = '../match?id=' . $nextID .'&ring='. $_GET['ring'];
		
	} else {
		
		// Absent the ring varaiable just increment the Match ID
		$prevID = max($_GET['id'] - 1, 1);
		$prev = '../match?id=' . $prevID;
		$nextID = min($_GET['id'] + 1, 64);
		$next = '../match?id=' . $nextID;
		
	}
	
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