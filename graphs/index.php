<?php

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
// Set-up
// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

// Make sure all relevant includes are loaded
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/includesfile.inc.php';

// Run scoring system checks and set-up
include $_SERVER['DOCUMENT_ROOT'] . '/includes/processScoringSystem.inc.php';

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
// Load the graph data
// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

// Grab raw data
$data = getGraphData($_SESSION['scoringSystem']);

// Get the number of users
$numUsers = 0;
$firstMatchID = $data[$numUsers]['matchID'];
while ($data[$numUsers]['matchID'] == $firstMatchID){
  $numUsers++;
}

// Get the number of matches
$numMatches = round(count($data)/$numUsers);

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
// Core page load
// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

// Set tab variable to indicate point to graphs tab
$tab = 'graphs';

// Set content pointers
$content = $_SERVER['DOCUMENT_ROOT'] . '/' . $tab . '/' . $tab . '.html.php';
$contentjs = $_SERVER['DOCUMENT_ROOT'] . '/' . $tab . '/' . $tab . '.js.php';

// Call main HTML page
include $_SERVER['DOCUMENT_ROOT'] . '/includes/template.html.php';
?>