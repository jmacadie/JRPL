<?php

// Start the session if needed
if (!isset($_SESSION)) session_start();

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
// Includes
// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/includesfile.inc.php';

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
// Get data for selected fixtures
// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

if (isset($_POST['gameWeek']))
{

  // Get DB connection
  include $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';
  if (!isset($link)) {
    $error = 'Error getting DB connection';

    header('Content-type: application/json');
    $arr = array('result' => 'No', 'message' => $error);
    echo json_encode($arr);
    die();
  }

  // Assign values
  $gw = mysqli_real_escape_string($link,$_POST['gameWeek']);

  // Sanitise $gw
  if (!int($gw) || $gw < 1) $gw = 1;
  if ($gw > 38) $gw = 38;

  // Get the gameWeek league table & set session
  $_SESSION['gameWeek'] = $gw;
  $resultLeague = getLeagueTable($gw);

  // build results into output JSON file
  header('Content-type: application/json');
  $arr = array(
    'result' => 'Yes'
    ,'message' => ''
    ,'data' => $resultLeague);
  echo json_encode($arr);

}
