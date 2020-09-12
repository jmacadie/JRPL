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

if (isset($_POST['action']) && $_POST['action'] == 'updateMatches')
{

  // Assign values
  $userID = (isset($_SESSION['userID'])) ? $_SESSION['userID'] : 0;
  $excPlayed = (isset($_POST['excPlayed'])) ? ($_POST['excPlayed'] === 'true') : true;
  $excPredicted = (isset($_POST['excPredicted'])) ? ($_POST['excPredicted'] === 'true') : true;

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
  $excPlayed = mysqli_real_escape_string($link, $excPlayed);
  $excPredicted = mysqli_real_escape_string($link, $excPredicted);

  $firstFilter = true;

  // Query to pull match data from DB
  $sql = "SELECT
        m.`MatchID`,
        DATE_FORMAT(m.`Date`, '%W, %D %M %Y') AS `Date`,
        m.`KickOff`,
        ht.`Name` AS `HomeTeam`,
        at.`Name` AS `AwayTeam`,
        ht.`ShortName` AS `HomeTeamS`,
        at.`ShortName` AS `AwayTeamS`,
        m.`HomeTeamPoints`,
        m.`AwayTeamPoints`,
        p.`HomeTeamPoints` AS `HomeTeamPrediction`,
        p.`AwayTeamPoints` AS `AwayTeamPrediction`,
        CASE
          WHEN DATE_ADD(NOW(), INTERVAL 30 MINUTE) > TIMESTAMP(m.`Date`, m.`KickOff`) THEN 1
          ELSE 0
        END AS `LockedDown`

      FROM `Match` m
        INNER JOIN `Team` ht ON
          ht.`TeamID` = m.`HomeTeamID`
        INNER JOIN `Team` at ON
          at.`TeamID` = m.`AwayTeamID`
        LEFT JOIN `Prediction` p ON
          p.`MatchID` = m.`MatchID`
          AND p.`UserID` =  " . $userID;
  if ($excPredicted || $excPlayed) $sql .= "
      WHERE
        ";
  if ($excPlayed) {
    $sql .= "m.`ResultPostedBy` IS NULL";
    $firstFilter = false;
  }
  if ($excPredicted && $firstFilter) $sql .= "p.`PredictionID` IS NULL";
  if ($excPredicted && !$firstFilter) $sql .= " AND p.`PredictionID` IS NULL";
  $sql .= " ORDER BY m.`Date` ASC, m.`KickOff` ASC;";

  // Run query and handle any failure
  $result = mysqli_query($link, $sql);
  if (!$result) {
    $error = 'Error fetching matches: <br />' . mysqli_error($link) . '<br /><br />' . $sql;

    header('Content-type: application/json');
    $arr = array(
      'result' => 'No'
      ,'message' => $error
      ,'loggedIn' => max($userID, 1));
    echo json_encode($arr);
    die();
  }

  // Store results
  $arrMatches = array();
  $arrMatchIDs = array();
  while($row = mysqli_fetch_assoc($result)) {
    $arrMatches[] = $row;
    $arrMatchIDs[] = $row['MatchID'];
  }
  $_SESSION['ring'] = $arrMatchIDs;

  // Test Code
  /*header('Content-type: application/json');
  $arr = array('result' => 'No', 'message' => $sql);
  echo json_encode($arr)*/;

  // build results into output JSON file
  header('Content-type: application/json');
  $arr = array(
    'result' => 'Yes'
    ,'message' => ''
    ,'data' => $arrMatches
    ,'loggedIn' => min($userID, 1));
  echo json_encode($arr);

}
