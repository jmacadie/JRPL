<?php
// Make sure all relevant includes are loaded
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/includesfile.inc.php';

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
// Main page set-up
// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

// Set tab variable to indicate point to predictions tab
$tab = 'predictions';

// Set Content pointer
$content = $_SERVER['DOCUMENT_ROOT'] . '/predictions/predictions.html.php';
$contentjs = $_SERVER['DOCUMENT_ROOT'] . '/predictions/predictions.js.php';

// Call main HTML page
include $_SERVER['DOCUMENT_ROOT'] . '/includes/template.html.php';
?>