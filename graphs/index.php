<?php
// Make sure all relevant includes are loaded
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/includesfile.inc.php';

// Set tab variable to indicate point to graphs tab
$tab = 'graphs';

// Set Content pointer
$content = $_SERVER['DOCUMENT_ROOT'] . '/graphs/graphs.html.php';
$contentjs = $_SERVER['DOCUMENT_ROOT'] . '/graphs/graphs.js.php';

// Call main HTML page
include $_SERVER['DOCUMENT_ROOT'] . '/includes/template.html.php';
?>