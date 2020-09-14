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
if (!userIsLoggedIn() || !isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] == FALSE) {
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
if (!isset($_SESSION['isAdmin']) || $_SESSION['isAdmin'] == FALSE) {
  // build results into output JSON file
  header('Content-type: application/json');
  $arr = array(
    'result' => 'No'
    ,'message' => 'You are not an Admin. Only Admins can change match dates & times');
  echo json_encode($arr);
  die();
}

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
// Check to see if we've got the right action posted
// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
if (isset($_POST['action']) && $_POST['action'] == 'submitDT')
{

  // Assign values
  $matchID = (isset($_POST['matchID'])) ? $_POST['matchID'] : 'null';
  $date = (isset($_POST['date'])) ? $_POST['date'] : 'null';
  $time = (isset($_POST['time'])) ? $_POST['time'] : 'null';

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
  $matchID = mysqli_real_escape_string($link, $matchID);
  $date = mysqli_real_escape_string($link, $date);
  $time = mysqli_real_escape_string($link, $time);

  if (!int($matchID) || ($matchID < 1)) {
    // build results into output JSON file
    header('Content-type: application/json');
    $arr = array(
      'result' => 'No'
      ,'message' => 'Submitted match number "' . $matchID . '" is not correctly formatted. It should be an integer greater than 1');
    echo json_encode($arr);
    die();
  }

  //TODO: validate date and time
  //For now, just going to assume the js on client side will always submit good stuff

  // UPDATE the match table with the posted data
  $sql = "UPDATE `Match`
      SET `Date` = '" . $date . "',
        `KickOff` = '" . $time . "'
      WHERE
        `MatchID` = " . $matchID . ";";

  // Run query and handle any failure
  $result = mysqli_query($link, $sql);
  if (!$result)
  {
    $error = 'Error adding result: <br />' . mysqli_error($link) . '<br /><br />' . $sql;

    header('Content-type: application/json');
    $arr = array('result' => 'No', 'message' => $error);
    echo json_encode($arr);
    die();
  }

  // Test Code
  /*header('Content-type: application/json');
  $arr = array('result' => 'No', 'message' => $sql);
  echo json_encode($arr)*/;

  // build results into output JSON file
  header('Content-type: application/json');
  $arr = array(
    'result' => 'Yes'
    ,'date' => $date
    ,'time' => $time
    ,'message' => '');
  echo json_encode($arr);

}
