<?php
// Make sure all relevant includes are loaded
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/includesfile.inc.php';

// Call log in function to make sure logged in status is correctly set
userIsLoggedIn();

// Set tab variable to indicate point to admin tab
$tab = 'admin';

// Set content pointers
$content = $_SERVER['DOCUMENT_ROOT'] . '/admin/admin.html.php';
$contentjs = $_SERVER['DOCUMENT_ROOT'] . '/admin/admin.js.php';

// Call main HTML page
include $_SERVER['DOCUMENT_ROOT'] . '/includes/template.html.php';
?>