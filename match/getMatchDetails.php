<?php

// Start the session if needed
// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
if (!isset($_SESSION)) session_start();

// Check that ID parameter has been properly formed
// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
if (!isset($gMatchID) || !int($gMatchID) || ($gMatchID < 1)) {
  // TODO: This doesn't work as we're not running an AJAX request here
  $error = 'Match ID not properly formed';

  header('Content-type: application/json');
  $arr = array('result' => 'No', 'message' => $error);
  echo json_encode($arr);
  die();
}

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
// Get data for match page
// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

// Assign values
$userID = (isset($_SESSION['userID'])) ? $_SESSION['userID'] : 0;
$matchID = $gMatchID + 0;

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
$matchID = mysqli_real_escape_string($link, $matchID);

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
// Get base match data
// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

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
      CONCAT(v.`Name`, ', ', v.`City`) AS `Venue`,
      b.`Name` AS `Broadcaster`,
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
      INNER JOIN `Venue` v ON
        v.`VenueID` = m.`VenueID`
      INNER JOIN `Broadcaster` b ON
        b.`BroadcasterID` = m.`BroadcasterID`
      LEFT JOIN `Prediction` p ON
        p.`MatchID` = m.`MatchID`
        AND p.`UserID` =  " . $userID . "

    WHERE m.`MatchID` = " . $matchID . ";";

// Run query and handle any failure
$result = mysqli_query($link, $sql);
// TODO: This doesn't work as we're not running an AJAX request here
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
$row = mysqli_fetch_assoc($result);
$date = $row['Date'];
$kickOff = $row['KickOff'];
$venue = $row['Venue'];
$broadcaster = $row['Broadcaster'];
$homeTeam = $row['HomeTeam'];
$homeTeamS = $row['HomeTeamS'];
$homeTeamPoints = $row['HomeTeamPoints'];
$homeTeamPredPoints = $row['HomeTeamPrediction'];
$awayTeam = $row['AwayTeam'];
$awayTeamS = $row['AwayTeamS'];
$awayTeamPoints = $row['AwayTeamPoints'];
$awayTeamPredPoints = $row['AwayTeamPrediction'];
$lockedDown = $row['LockedDown'];

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
// Get predictions data
// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

// Only get if we're locked down
if ($lockedDown == 1) {

  // Query to pull match data from DB
  $sql = "SELECT
        mu.`DisplayName`,
        ht.`Name` AS `HomeTeam`,
        at.`Name` AS `AwayTeam`,
        IFNULL(p.`HomeTeamPoints`,'No prediction') AS `HomeTeamPrediction`,
        IFNULL(p.`AwayTeamPoints`,'No prediction') AS `AwayTeamPrediction`,
        ROUND(po.`TotalPoints`, 2) AS `TotalPoints`

      FROM
        (SELECT `MatchID`, `HomeTeamID`, `AwayTeamID`, `UserID`, `DisplayName`
        FROM `Match`, `User`
        WHERE `MatchID` = " . $matchID . ") mu

        LEFT JOIN `Prediction` p ON
          p.`UserID` = mu.`UserID`
          AND p.`MatchID` = mu.`MatchID`
        INNER JOIN `Team` ht ON
          ht.`TeamID` = mu.`HomeTeamID`
        INNER JOIN `Team` at ON
          at.`TeamID` = mu.`AwayTeamID`
        LEFT JOIN `Points` po ON
          po.`MatchID` = p.`MatchID`
          AND po.`UserID` = p.`UserID`

      ORDER BY
        po.`TotalPoints` DESC,
        (p.`HomeTeamPoints` - p.`AwayTeamPoints`) DESC,
        p.`HomeTeamPoints` DESC,
        mu.`UserID` ASC;";

  // Run query and handle any failure
  $result = mysqli_query($link, $sql);
  // TODO: This doesn't work as we're not running an AJAX request here
  if (!$result) {
    $error = 'Error fetching predictions: <br />' . mysqli_error($link) . '<br /><br />' . $sql;
    header('Content-type: application/json');
    $arr = array(
      'result' => 'No'
      ,'message' => $error
      ,'loggedIn' => max($userID, 1));
    echo json_encode($arr);
    die();
  }

  // Store results
  $arrPredictions = array();
  while($row = mysqli_fetch_assoc($result)) {
    $arrPredictions[] = $row;
  }

}
