<?php

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
// Set-up
// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

// Make sure all relevant includes are loaded
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/includesfile.inc.php';

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
// Load the graph data
// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

// Generate data for graphs
function getGraphData ($scoringSystem = 1) {

  // Get DB connection
  include $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';
  if (!isset($link)) {
    $error = 'Error getting DB connection';

    header('Content-type: application/json');
    $arr = array('result' => 'No', 'message' => $error);
    echo json_encode($arr);
    die();
  }

  // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
  // Get data, only grab matches with submitted results
  // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

  // Create temporary table to hold cumulative points by match & user
  $sql = "
    CREATE TEMPORARY TABLE `CumulativePointsByMatchUser` (
      `MatchID` INT NOT NULL
      ,`UserID` INT NOT NULL
      ,`Points` DECIMAL(6,2) NOT NULL) ; ";

  $result = mysqli_query($link, $sql);
  if (!$result) {
    $error = 'Error creating cumulative points by match & user temporary table: <br />' . mysqli_error($link) . '<br /><br />' . $sql;

    header('Content-type: application/json');
    $arr = array('result' => 'No', 'message' => $error);
    echo json_encode($arr);
    die();
  }

  // Add cumulative points by match & user data to temporary table
  $sql = "
    INSERT INTO `CumulativePointsByMatchUser`

      SELECT
         m.`MatchID`
        ,tmp.`UserID`
        ,SUM(tmp.`Points`) AS `Points`

      FROM
        (SELECT
            mu.`MatchID`
            ,mu.`UserID`
            ,IFNULL(po.`TotalPoints`,0) AS `Points`

        FROM
          (SELECT m.`MatchID`, u.`UserID`
          FROM `Match` m, `User` u
          WHERE m.`ResultPostedBy` IS NOT NULL) mu

          LEFT JOIN `Points` po ON
            po.`UserID` = mu.`UserID`
            AND po.`MatchID` = mu.`MatchID`) tmp

      INNER JOIN `Match` m ON
        m.`MatchID` >= tmp.`MatchID`
        AND m.`ResultPostedBy` IS NOT NULL

      GROUP BY
        m.`MatchID`
        ,tmp.`UserID`;";

  $result = mysqli_query($link, $sql);
  if (!$result) {
    $error = 'Error adding cumulative points by match & user data to temporary table: <br />' . mysqli_error($link) . '<br /><br />' . $sql;

    header('Content-type: application/json');
    $arr = array('result' => 'No', 'message' => $error);
    echo json_encode($arr);
    die();
  }

  // Create 2nd temporary table to hold points by user
  $sql = "
    CREATE TEMPORARY TABLE `CumulativePointsByMatchUser2`
    SELECT * FROM `CumulativePointsByMatchUser`; ";

  $result = mysqli_query($link, $sql);
  if (!$result) {
    $error = 'Error creating 2nd points by user temporary table: <br />' . mysqli_error($link) . '<br /><br />' . $sql;

    header('Content-type: application/json');
    $arr = array('result' => 'No', 'message' => $error);
    echo json_encode($arr);
    die();
  }

  // Final query
  $sql = "
    SELECT
      (SELECT COUNT(*) + 1
      FROM `CumulativePointsByMatchUser2` cpmu2
      WHERE cpmu2.`Points` > cpmu.`Points`
        AND cpmu2.`MatchID` = cpmu.`MatchID`) AS `Rank`
      ,IFNULL(u.`DisplayName`,CONCAT(u.`FirstName`,' ',u.`LastName`)) AS `DisplayName`
      ,CONCAT(ht.`Name`,' vs. ',at.`Name`) AS `Match`
      ,cpmu.*

    FROM `CumulativePointsByMatchUser` cpmu
      INNER JOIN `Match` m ON m.`MatchID` = cpmu.`MatchID`
      INNER JOIN `User` u ON u.`UserID` = cpmu.`UserID`
      INNER JOIN `Team` ht ON ht.`TeamID` = m.`HomeTeamID`
      INNER JOIN `Team` at ON at.`TeamID` = m.`AwayTeamID`

    ORDER BY cpmu.`MatchID` ASC, cpmu.`UserID` ASC";

  $result = mysqli_query($link, $sql);
  if (!$result) {
    $error = 'Error fetching match details: <br />' . mysqli_error($link) . '<br /><br />' . $sql;

    header('Content-type: application/json');
    $arr = array('result' => 'No', 'message' => $error);
    echo json_encode($arr);
    die();
  }

  $out = array();
  while ($row = mysqli_fetch_array($result)) {
    $out[] = array(
      'matchID' => $row['MatchID'],
      'match' => $row['Match'],
      'rank' => $row['Rank'],
      'userID' => $row['UserID'],
      'name' => $row['DisplayName'],
      'points' => $row['Points']);
  }

  // If there's not data yet (i.e. before Tournament start) then need to set up
  // an epmty return
  if (count($out) == 0) {
    $out[] = array(
      'matchID' => "1",
      'match' => "None",
      'rank' => "1",
      'userID' => "1",
      'name' => "None",
      'points' => "0");
  }

  return $out;
}

// Grab raw data
$data = getGraphData($_SESSION['scoringSystem']);

// Get the number of users
$numUsers = 0;
$firstMatchID = $data[$numUsers]['matchID'];
if (!isset($data[1])) {
  $numUsers = 1;
} else {
  while ($data[$numUsers]['matchID'] == $firstMatchID) {
    $numUsers++;
  }
}

// Get the number of matches
$numMatches = round(count($data)/$numUsers);

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
// Core page load
// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

// Set tab variable to indicate point to graphs tab
$tab = 'graphs';

// Set content pointers
$content = $_SERVER['DOCUMENT_ROOT'] . '/' . $tab . '/' . $tab . '.html.php';
$contentjs = $_SERVER['DOCUMENT_ROOT'] . '/' . $tab . '/' . $tab . '.js.php';

// Call main HTML page
include $_SERVER['DOCUMENT_ROOT'] . '/includes/template.html.php';
