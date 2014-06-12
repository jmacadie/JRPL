<?php
// Make sure all relevant includes are loaded
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/includesfile.inc.php';

// Get DB connection
include $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';
	
// Load the various league tables
$resultLeague = getLeagueTable($link);
$resultGSLeague = getLeagueTable($link,array(true,false,false,false,false));
$resultL16League = getLeagueTable($link,array(false,true,false,false,false));
$resultRLeague = getLeagueTable($link,array(false,false,true,true,true));

// Set tab variable to indicate point to results tab
$tab = 'results';

// Set Content pointer
$content = $_SERVER['DOCUMENT_ROOT'] . '/results/results.html.php';
$contentjs = $_SERVER['DOCUMENT_ROOT'] . '/results/results.js.php';

// Call main HTML page
include $_SERVER['DOCUMENT_ROOT'] . '/includes/template.html.php';
?>