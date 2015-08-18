<?php
// Make sure all relevant includes are loaded
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/includesfile.inc.php';

// Set tab variable to indicate point to rules tab
$tab = 'rules';

// Set Content pointer
$content = $_SERVER['DOCUMENT_ROOT'] . '/rules/rules.html.php';
$contentjs = $_SERVER['DOCUMENT_ROOT'] . '/rules/rules.js.php';

// Call main HTML page
include $_SERVER['DOCUMENT_ROOT'] . '/includes/template.html.php';
