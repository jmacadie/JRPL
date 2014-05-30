<?php
// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
// Includes
// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/includesfile.inc.php';

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
// Check User is logged in status
// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

if (userIsLoggedIn())
{
    if (isset($_SESSION['displayName'])) $displayName = $_SESSION['displayName'];
    if (isset($_SESSION['firstName'])) $firstName = $_SESSION['firstName'];
    if (isset($_SESSION['lastName'])) $lastName = $_SESSION['lastName'];
    if (isset($_SESSION['email'])) $email = $_SESSION['email'];
	
	// prepare success xml data
	header('Content-type: application/json');
	$arr = array('logInResult' => 'Yes', 'logInMessage' => '');
	echo json_encode($arr);
		
} else {
	// prepare failure xml data
	header('Content-type: application/json');
	$arr = array('logInResult' => 'No', 'logInMessage' => $GLOBALS['loginError']);
	echo json_encode($arr);
}

?>