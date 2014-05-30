<?php
// Make sure all relevant includes are loaded
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/includesfile.inc.php';

// Set tab variable to indicate point to results tab
$tab = 'results';

// Set Content pointer
$content = $_SERVER['DOCUMENT_ROOT'] . '/results/results.html.php';
$contentjs = $_SERVER['DOCUMENT_ROOT'] . '/results/results.js.php';

// Call main HTML page
include $_SERVER['DOCUMENT_ROOT'] . '/includes/template.html.php';
?>