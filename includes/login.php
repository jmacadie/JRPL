<?php
// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
// Includes
// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/includesfile.inc.php';

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
// Log in
// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
if (isset($_POST['action']) && $_POST['action'] === 'login') {

  if (userIsLoggedIn()) {
    // prepare success xml data
    header('Content-type: application/json');
    $arr = array('result' => 'Yes', 'message' => '');
    echo json_encode($arr);
  } else {
    // prepare failure xml data
    header('Content-type: application/json');
    $arr = array('result' => 'No', 'message' => $GLOBALS['loginError']);
    echo json_encode($arr);
  }

}

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
// Log Out
// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
if (isset($_POST['action']) and $_POST['action'] === 'logout') {
  unsetUserSessionInfo();
}

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
// Update Details
// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
if (isset($_POST['action']) && $_POST['action'] === 'update') {

  if (updateDetails()) {
    // prepare success xml data
    header('Content-type: application/json');
    $arr = array('result' => 'Yes', 'message' => '');
    echo json_encode($arr);
  } else {
    // prepare failure xml data
    header('Content-type: application/json');
    $arr = array('result' => 'No', 'message' => $GLOBALS['loginError']);
    echo json_encode($arr);
  }

}
