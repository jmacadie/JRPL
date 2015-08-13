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
    ,'message' => 'You are not an Admin. Only Admins can submit match results');
  echo json_encode($arr);
  die();
}

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
// Check correct data has been posted
// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

if (!isset($_POST['action']) || !isset($_POST['tournamentRoleID']) || !isset($_POST['teamID'])) {
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
if ($_POST['action'] == 'updateTournamentRole') {

  // Assign values
  $tournamentRoleID = $_POST['tournamentRoleID'];
  $teamID = $_POST['teamID'];

  // Get DB connection
  include $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';

  // Make sure submitted data is clean
  $tournamentRoleID = mysqli_real_escape_string($link, $tournamentRoleID);
  $teamID = mysqli_real_escape_string($link, $teamID);

  if (!int($tournamentRoleID) || ($tournamentRoleID < 1)) {
    // build results into output JSON file
    header('Content-type: application/json');
    $arr = array(
      'result' => 'No'
      ,'message' => 'Submitted tournament role number "' . $tournamentRoleID . '" is not correctly formatted. It should be an integer greater than 1');
    echo json_encode($arr);
    die();
  }

  if (!int($teamID) || ($teamID < 0)) {
    // build results into output JSON file
    header('Content-type: application/json');
    $arr = array(
      'result' => 'No'
      ,'message' => 'Submitted team number "' . $teamID . '" is not correctly formatted. It should be an integer greater than 1');
    echo json_encode($arr);
    die();
  }

  // UPDATE the match table with the posted data
  $sql = "UPDATE `TournamentRole`
      SET `TeamID` = ";
  if ($teamID == 0) { $sql .= 'NULL'; } else { $sql .= $teamID; }
  $sql .= "
      WHERE `TournamentRoleID` = " . $tournamentRoleID . ";";

  // Run query and handle any failure
  $result = mysqli_query($link, $sql);
  if (!$result) {
    $error = 'Error updating tournament role: <br />' . mysqli_error($link) . '<br /><br />' . $sql;

    header('Content-type: application/json');
    $arr = array('result' => 'No', 'message' => $error);
    echo json_encode($arr);
    die();
  }

  // Get submitted team details back
  if ($teamID != 0) {

    // Build the SQL
    $sql = "SELECT `Name`, `ShortName`
        FROM `Team`
        WHERE `TeamID` = " . $teamID . ";";

    // Run query and handle any failure
    $result = mysqli_query($link, $sql);
    if (!$result) {
      $error = 'Error getting team details back: <br />' . mysqli_error($link) . '<br /><br />' . $sql;

      header('Content-type: application/json');
      $arr = array('result' => 'No', 'message' => $error);
      echo json_encode($arr);
      die();
    }

    // Store results
    $row = mysqli_fetch_assoc($result);
    $team = $row['Name'];
    $teamS = $row['ShortName'];

  } else {
    // Team was unset, return blanks
    $team = '';
    $teamS = '';
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

?>