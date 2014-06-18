<?php
// Make sure all relevant includes are loaded
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/includesfile.inc.php';

// Call log in function to make sure logged in status is correctly set
userIsLoggedIn();

// Set tab variable to indicate point to data tab
$tab = 'details';

// Set Content pointer
$content = $_SERVER['DOCUMENT_ROOT'] . '/details/details.html.php';
$contentjs = $_SERVER['DOCUMENT_ROOT'] . '/details/details.js.php';

// Call main HTML page
include $_SERVER['DOCUMENT_ROOT'] . '/includes/template.html.php';
?>