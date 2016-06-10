<?php
// Start the session if needed
if (!isset($_SESSION)) session_start();
// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
// Includes
// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/includesfile.inc.php';
// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
// Check to see if user is logged in
// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
if (!userIsLoggedIn() ||
    !isset($_SESSION['loggedIn']) ||
    $_SESSION['loggedIn'] == FALSE) {
  // build results into output JSON file
  header('Content-type: application/json');
  $arr = array(
    'result' => 'No'
    ,'message' => 'You are not logged in. Please log in first');
  echo json_encode($arr);
  die();
}
// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
// Check to see if user is an admin
// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
if (!isset($_SESSION['isAdmin']) ||
    $_SESSION['isAdmin'] == FALSE) {
  // build results into output JSON file
  header('Content-type: application/json');
  $arr = array(
    'result' => 'No'
    ,'message' => 'You are not an Admin. Only Admins can reset user passwords');
  echo json_encode($arr);
  die();
}
// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
// Check correct data has been posted
// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
if (!isset($_POST['action']) ||
    !isset($_POST['userID'])) {
  // build results into output JSON file
  header('Content-type: application/json');
  $arr = array(
    'result' => 'No'
    ,'message' => 'Incorrect data posted');
  echo json_encode($arr);
  die();
}
// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
// Check to see if we've got the right action posted
// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
if ($_POST['action'] == 'resetPassword') {
  // Assign values
  $userID = $_POST['userID'];
  // Get DB connection
  include $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';
  if (!isset($link)) {
    $error = 'Error getting DB connection';
    header('Content-type: application/json');
    $arr = array('result' => 'No', 'message' => $error);
    echo json_encode($arr);
    die();
  }
  // Make sure submitted data is clean
  $userID = mysqli_real_escape_string($link, $userID);
  if (!int($userID) ||
      ($userID < 1)) {
    // build results into output JSON file
    header('Content-type: application/json');
    $arr = array(
      'result' => 'No'
      ,'message' => 'Submitted UserID "' .
                    $userID .
                    '" is not correctly formatted. ' .
                    'It should be an integer greater than 1');
    echo json_encode($arr);
    die();
  }
  // UPDATE the match table with the posted data
  $sql =
"UPDATE `User`
SET `Password` = 'f0c9a442ef67e81b3a1340ae95700eb3'
WHERE `UserID` = " . $userID . ";";
  // Run query and handle any failure
  $result = mysqli_query($link, $sql);
  if (!$result) {
    $error = 'Error resetting password: <br />' .
             mysqli_error($link) .
             '<br /><br />' .
             $sql;
    header('Content-type: application/json');
    $arr = array('result' => 'No', 'message' => $error);
    echo json_encode($arr);
    die();
  }
  // build results into output JSON file
  header('Content-type: application/json');
  $arr = array(
    'result' => 'Yes'
    ,'message' => ''
    ,'team' => $team
    ,'teamS' => $teamS);
  echo json_encode($arr);
}
