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
  $groupA = (isset($_POST['groupA'])) ? ($_POST['groupA'] === 'true') : true;
  $groupB = (isset($_POST['groupB'])) ? ($_POST['groupB'] === 'true') : true;
  $groupC = (isset($_POST['groupC'])) ? ($_POST['groupC'] === 'true') : true;
  $groupD = (isset($_POST['groupD'])) ? ($_POST['groupD'] === 'true') : true;
  $groupE = (isset($_POST['groupE'])) ? ($_POST['groupE'] === 'true') : true;
  $groupF = (isset($_POST['groupF'])) ? ($_POST['groupF'] === 'true') : true;
  $r16 = (isset($_POST['r16'])) ? ($_POST['r16'] === 'true') : true;
  $quarterFinals = (isset($_POST['quarterFinals'])) ? ($_POST['quarterFinals'] === 'true') : true;
  $semiFinals = (isset($_POST['semiFinals'])) ? ($_POST['semiFinals'] === 'true') : true;
  $final = (isset($_POST['final'])) ? ($_POST['final'] === 'true') : true;

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
  $groupA = mysqli_real_escape_string($link, $groupA);
  $groupB = mysqli_real_escape_string($link, $groupB);
  $groupC = mysqli_real_escape_string($link, $groupC);
  $groupD = mysqli_real_escape_string($link, $groupD);
  $groupE = mysqli_real_escape_string($link, $groupE);
  $groupF = mysqli_real_escape_string($link, $groupF);
  $r16 = mysqli_real_escape_string($link, $r16);
  $quarterFinals = mysqli_real_escape_string($link, $quarterFinals);
  $semiFinals = mysqli_real_escape_string($link, $semiFinals);
  $final = mysqli_real_escape_string($link, $final);

  // Make sure at least 1 stage is selected
  $final = $final ||
            !($groupA ||
              $groupB ||
              $groupC ||
              $groupD ||
              $groupE ||
              $groupF ||
              $r16 ||
              $quarterFinals ||
              $semiFinals);

  $firstFilter = true;

  // Query to pull match data from DB
  $sql = "SELECT
        m.`MatchID`,
        DATE_FORMAT(m.`Date`, '%W, %D %M %Y') AS `Date`,
        m.`KickOff`,
        IFNULL(ht.`Name`,trht.`Name`) AS `HomeTeam`,
        IFNULL(at.`Name`,trat.`Name`) AS `AwayTeam`,
        IFNULL(ht.`ShortName`,'') AS `HomeTeamS`,
        IFNULL(at.`ShortName`,'') AS `AwayTeamS`,
        m.`HomeTeamPoints`,
        m.`AwayTeamPoints`,
        p.`HomeTeamPoints` AS `HomeTeamPrediction`,
        p.`AwayTeamPoints` AS `AwayTeamPrediction`,
        CASE
          WHEN DATE_ADD(NOW(), INTERVAL 30 MINUTE) > TIMESTAMP(m.`Date`, m.`KickOff`) THEN 1
          ELSE 0
        END AS `LockedDown`

      FROM `Match` m
        INNER JOIN `TournamentRole` trht ON
          trht.`TournamentRoleID` = m.`HomeTeamID`
        LEFT JOIN `Team` ht ON
          ht.`TeamID` = trht.`TeamID`
        INNER JOIN `TournamentRole` trat ON
          trat.`TournamentRoleID` = m.`AwayTeamID`
        LEFT JOIN `Team` at ON
          at.`TeamID` = trat.`TeamID`
        LEFT JOIN `Group` g ON
          g.`GroupID` = trht.`FromGroupID`
        INNER JOIN `Stage` s ON
          s.`StageID` = m.`StageID`
        LEFT JOIN `Prediction` p ON
          p.`MatchID` = m.`MatchID`
          AND p.`UserID` =  " . $userID . "

      WHERE
        (";
  if ($groupA) {
    if ($firstFilter) {
      $firstFilter = false;
    } else {
      $sql .= " OR ";
    }
    $sql .= "(s.`Name` = 'Group Stages' AND g.`Name` = 'A')";
  }
  if ($groupB) {
    if ($firstFilter) {
      $firstFilter = false;
    } else {
      $sql .= " OR ";
    }
    $sql .= "(s.`Name` = 'Group Stages' AND g.`Name` = 'B')";
  }
  if ($groupC) {
    if ($firstFilter) {
      $firstFilter = false;
    } else {
      $sql .= " OR ";
    }
    $sql .= "(s.`Name` = 'Group Stages' AND g.`Name` = 'C')";
  }
  if ($groupD) {
    if ($firstFilter) {
      $firstFilter = false;
    } else {
      $sql .= " OR ";
    }
    $sql .= "(s.`Name` = 'Group Stages' AND g.`Name` = 'D')";
  }
  if ($groupE) {
    if ($firstFilter) {
      $firstFilter = false;
    } else {
      $sql .= " OR ";
    }
    $sql .= "(s.`Name` = 'Group Stages' AND g.`Name` = 'E')";
  }
  if ($groupF) {
    if ($firstFilter) {
      $firstFilter = false;
    } else {
      $sql .= " OR ";
    }
    $sql .= "(s.`Name` = 'Group Stages' AND g.`Name` = 'F')";
  }
  if ($r16) {
    if ($firstFilter) {
      $firstFilter = false;
    } else {
      $sql .= " OR ";
    }
    $sql .= "(s.`Name` = 'Round of 16')";
  }
  if ($quarterFinals) {
    if ($firstFilter) {
      $firstFilter = false;
    } else {
      $sql .= " OR ";
    }
    $sql .= "(s.`Name` = 'Quarter Finals')";
  }
  if ($semiFinals) {
    if ($firstFilter) {
      $firstFilter = false;
    } else {
      $sql .= " OR ";
    }
    $sql .= "(s.`Name` = 'Semi Finals')";
  }
  if ($final) {
    if ($firstFilter) {
      $firstFilter = false;
    } else {
      $sql .= " OR ";
    }
    $sql .= "(s.`Name` = 'Final')";
  }
  $sql .= ")";
  if ($excPlayed) $sql .= " AND m.`ResultPostedBy` IS NULL";
  if ($excPredicted) $sql .= " AND p.`PredictionID` IS NULL";
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
