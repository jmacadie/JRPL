<?php
// Make sure all relevant includes are loaded
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/includesfile.inc.php';

// Set tab variable to indicate point to log in tab
$tab = 'login';

// Set content pointers
$content = $_SERVER['DOCUMENT_ROOT'] . '/login/login.html.php';
$contentjs = $_SERVER['DOCUMENT_ROOT'] . '/login/login.js.php';

// Call main HTML page
include $_SERVER['DOCUMENT_ROOT'] . '/includes/template.html.php';
?>