<?php

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
// Set-up
// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

// Make sure all relevant includes are loaded
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/includesfile.inc.php';

// Run scoring system checks and set-up
include $_SERVER['DOCUMENT_ROOT'] . '/includes/processScoringSystem.inc.php';

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
// Load the table data
// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

// Load the various league tables
$resultLeague = getLeagueTable($_SESSION['scoringSystem']);
$resultGSLeague = getLeagueTable($_SESSION['scoringSystem'],
                                 array(true,false,false,false,false));
$resultRLeague = getLeagueTable($_SESSION['scoringSystem'],
                                array(false,true,true,true,true));

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
// Core page load
// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

// Set tab variable to indicate point to tables tab
$tab = 'tables';

// Set content pointers
$content = $_SERVER['DOCUMENT_ROOT'] . '/' . $tab . '/' . $tab . '.html.php';
$contentjs = $_SERVER['DOCUMENT_ROOT'] . '/' . $tab . '/' . $tab . '.js.php';

// Call main HTML page
include $_SERVER['DOCUMENT_ROOT'] . '/includes/template.html.php';
