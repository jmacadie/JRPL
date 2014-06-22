<?php
// Make sure all relevant includes are loaded
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/includesfile.inc.php';

// Load the various league tables
$data = getGraphData();

// Get the number of users
$numUsers = 0;
$firstMatchID = $data[$numUsers]['matchID'];
while ($data[$numUsers]['matchID'] == $firstMatchID){
	$numUsers++;
}

// Get the number of matches
$numMatches = round(count($data)/$numUsers);

// Set tab variable to indicate point to graphs tab
$tab = 'graphs';

// Set Content pointer
$content = $_SERVER['DOCUMENT_ROOT'] . '/graphs/graphs.html.php';
$contentjs = $_SERVER['DOCUMENT_ROOT'] . '/graphs/graphs.js.php';

// Call main HTML page
include $_SERVER['DOCUMENT_ROOT'] . '/includes/template.html.php';
?>