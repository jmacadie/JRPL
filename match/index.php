<?php
// Start the session if needed
if (!isset($_SESSION)) session_start();

// Make sure all relevant includes are loaded
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/includesfile.inc.php';

//TODO:use posted match ID to grab relevent match data from DB

// Set tab variable to indicate point to match page
$tab = 'match';

// Set Content pointer
$content = $_SERVER['DOCUMENT_ROOT'] . '/match/match.html.php';
$contentjs = $_SERVER['DOCUMENT_ROOT'] . '/match/match.js.php';

// Call main HTML page
include $_SERVER['DOCUMENT_ROOT'] . '/includes/template.html.php';
?>