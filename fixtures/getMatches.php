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
  $t1 = (isset($_POST['t1'])) ? ($_POST['t1'] === 'true') : true;
  $t2 = (isset($_POST['t2'])) ? ($_POST['t2'] === 'true') : true;
  $t3 = (isset($_POST['t3'])) ? ($_POST['t3'] === 'true') : true;
  $t4 = (isset($_POST['t4'])) ? ($_POST['t4'] === 'true') : true;
  $t5 = (isset($_POST['t5'])) ? ($_POST['t5'] === 'true') : true;
  $t6 = (isset($_POST['t6'])) ? ($_POST['t6'] === 'true') : true;
  $t7 = (isset($_POST['t7'])) ? ($_POST['t7'] === 'true') : true;
  $t8 = (isset($_POST['t8'])) ? ($_POST['t8'] === 'true') : true;
  $t9 = (isset($_POST['t9'])) ? ($_POST['t9'] === 'true') : true;
  $t10 = (isset($_POST['t10'])) ? ($_POST['t10'] === 'true') : true;
  $t11 = (isset($_POST['t11'])) ? ($_POST['t11'] === 'true') : true;
  $t12 = (isset($_POST['t12'])) ? ($_POST['t12'] === 'true') : true;
  $t13 = (isset($_POST['t13'])) ? ($_POST['t13'] === 'true') : true;
  $t14 = (isset($_POST['t14'])) ? ($_POST['t14'] === 'true') : true;
  $t15 = (isset($_POST['t15'])) ? ($_POST['t15'] === 'true') : true;
  $t16 = (isset($_POST['t16'])) ? ($_POST['t16'] === 'true') : true;
  $t17 = (isset($_POST['t17'])) ? ($_POST['t17'] === 'true') : true;
  $t18 = (isset($_POST['t18'])) ? ($_POST['t18'] === 'true') : true;
  $t19 = (isset($_POST['t19'])) ? ($_POST['t19'] === 'true') : true;
  $t20 = (isset($_POST['t20'])) ? ($_POST['t20'] === 'true') : true;
  $gw1 = (isset($_POST['gw1'])) ? ($_POST['gw1'] === 'true') : true;
  $gw2 = (isset($_POST['gw2'])) ? ($_POST['gw2'] === 'true') : true;
  $gw3 = (isset($_POST['gw3'])) ? ($_POST['gw3'] === 'true') : true;
  $gw4 = (isset($_POST['gw4'])) ? ($_POST['gw4'] === 'true') : true;
  $gw5 = (isset($_POST['gw5'])) ? ($_POST['gw5'] === 'true') : true;
  $gw6 = (isset($_POST['gw6'])) ? ($_POST['gw6'] === 'true') : true;
  $gw7 = (isset($_POST['gw7'])) ? ($_POST['gw7'] === 'true') : true;
  $gw8 = (isset($_POST['gw8'])) ? ($_POST['gw8'] === 'true') : true;
  $gw9 = (isset($_POST['gw9'])) ? ($_POST['gw9'] === 'true') : true;
  $gw10 = (isset($_POST['gw10'])) ? ($_POST['gw10'] === 'true') : true;
  $gw11 = (isset($_POST['gw11'])) ? ($_POST['gw11'] === 'true') : true;
  $gw12 = (isset($_POST['gw12'])) ? ($_POST['gw12'] === 'true') : true;
  $gw13 = (isset($_POST['gw13'])) ? ($_POST['gw13'] === 'true') : true;
  $gw14 = (isset($_POST['gw14'])) ? ($_POST['gw14'] === 'true') : true;
  $gw15 = (isset($_POST['gw15'])) ? ($_POST['gw15'] === 'true') : true;
  $gw16 = (isset($_POST['gw16'])) ? ($_POST['gw16'] === 'true') : true;
  $gw17 = (isset($_POST['gw17'])) ? ($_POST['gw17'] === 'true') : true;
  $gw18 = (isset($_POST['gw18'])) ? ($_POST['gw18'] === 'true') : true;
  $gw19 = (isset($_POST['gw19'])) ? ($_POST['gw19'] === 'true') : true;
  $gw20 = (isset($_POST['gw20'])) ? ($_POST['gw20'] === 'true') : true;
  $gw21 = (isset($_POST['gw21'])) ? ($_POST['gw21'] === 'true') : true;
  $gw22 = (isset($_POST['gw22'])) ? ($_POST['gw22'] === 'true') : true;
  $gw23 = (isset($_POST['gw23'])) ? ($_POST['gw23'] === 'true') : true;
  $gw24 = (isset($_POST['gw24'])) ? ($_POST['gw24'] === 'true') : true;
  $gw25 = (isset($_POST['gw25'])) ? ($_POST['gw25'] === 'true') : true;
  $gw26 = (isset($_POST['gw26'])) ? ($_POST['gw26'] === 'true') : true;
  $gw27 = (isset($_POST['gw27'])) ? ($_POST['gw27'] === 'true') : true;
  $gw28 = (isset($_POST['gw28'])) ? ($_POST['gw18'] === 'true') : true;
  $gw29 = (isset($_POST['gw29'])) ? ($_POST['gw29'] === 'true') : true;
  $gw30 = (isset($_POST['gw30'])) ? ($_POST['gw30'] === 'true') : true;
  $gw31 = (isset($_POST['gw31'])) ? ($_POST['gw31'] === 'true') : true;
  $gw32 = (isset($_POST['gw32'])) ? ($_POST['gw32'] === 'true') : true;
  $gw33 = (isset($_POST['gw33'])) ? ($_POST['gw33'] === 'true') : true;
  $gw34 = (isset($_POST['gw34'])) ? ($_POST['gw34'] === 'true') : true;
  $gw35 = (isset($_POST['gw35'])) ? ($_POST['gw35'] === 'true') : true;
  $gw36 = (isset($_POST['gw36'])) ? ($_POST['gw36'] === 'true') : true;
  $gw37 = (isset($_POST['gw37'])) ? ($_POST['gw17'] === 'true') : true;
  $gw38 = (isset($_POST['gw38'])) ? ($_POST['gw38'] === 'true') : true;

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
  $t1 = mysqli_real_escape_string($link, $t1);
  $t2 = mysqli_real_escape_string($link, $t2);
  $t3 = mysqli_real_escape_string($link, $t3);
  $t4 = mysqli_real_escape_string($link, $t4);
  $t5 = mysqli_real_escape_string($link, $t5);
  $t6 = mysqli_real_escape_string($link, $t6);
  $t7 = mysqli_real_escape_string($link, $t7);
  $t8 = mysqli_real_escape_string($link, $t8);
  $t9 = mysqli_real_escape_string($link, $t9);
  $t10 = mysqli_real_escape_string($link, $t10);
  $t11 = mysqli_real_escape_string($link, $t11);
  $t12 = mysqli_real_escape_string($link, $t12);
  $t13 = mysqli_real_escape_string($link, $t13);
  $t14 = mysqli_real_escape_string($link, $t14);
  $t15 = mysqli_real_escape_string($link, $t15);
  $t16 = mysqli_real_escape_string($link, $t16);
  $t17 = mysqli_real_escape_string($link, $t17);
  $t18 = mysqli_real_escape_string($link, $t18);
  $t19 = mysqli_real_escape_string($link, $t19);
  $t20 = mysqli_real_escape_string($link, $t20);
  $gw1 = mysqli_real_escape_string($link, $gw1);
  $gw2 = mysqli_real_escape_string($link, $gw2);
  $gw3 = mysqli_real_escape_string($link, $gw3);
  $gw4 = mysqli_real_escape_string($link, $gw4);
  $gw5 = mysqli_real_escape_string($link, $gw5);
  $gw6 = mysqli_real_escape_string($link, $gw6);
  $gw7 = mysqli_real_escape_string($link, $gw7);
  $gw8 = mysqli_real_escape_string($link, $gw8);
  $gw9 = mysqli_real_escape_string($link, $gw9);
  $gw10 = mysqli_real_escape_string($link, $gw10);
  $gw11 = mysqli_real_escape_string($link, $gw11);
  $gw12 = mysqli_real_escape_string($link, $gw12);
  $gw13 = mysqli_real_escape_string($link, $gw13);
  $gw14 = mysqli_real_escape_string($link, $gw14);
  $gw15 = mysqli_real_escape_string($link, $gw15);
  $gw16 = mysqli_real_escape_string($link, $gw16);
  $gw17 = mysqli_real_escape_string($link, $gw17);
  $gw18 = mysqli_real_escape_string($link, $gw18);
  $gw19 = mysqli_real_escape_string($link, $gw19);
  $gw20 = mysqli_real_escape_string($link, $gw20);
  $gw21 = mysqli_real_escape_string($link, $gw21);
  $gw22 = mysqli_real_escape_string($link, $gw22);
  $gw23 = mysqli_real_escape_string($link, $gw23);
  $gw24 = mysqli_real_escape_string($link, $gw24);
  $gw25 = mysqli_real_escape_string($link, $gw25);
  $gw26 = mysqli_real_escape_string($link, $gw26);
  $gw27 = mysqli_real_escape_string($link, $gw27);
  $gw28 = mysqli_real_escape_string($link, $gw28);
  $gw29 = mysqli_real_escape_string($link, $gw29);
  $gw30 = mysqli_real_escape_string($link, $gw30);
  $gw31 = mysqli_real_escape_string($link, $gw31);
  $gw32 = mysqli_real_escape_string($link, $gw32);
  $gw33 = mysqli_real_escape_string($link, $gw33);
  $gw34 = mysqli_real_escape_string($link, $gw34);
  $gw35 = mysqli_real_escape_string($link, $gw35);
  $gw36 = mysqli_real_escape_string($link, $gw36);
  $gw37 = mysqli_real_escape_string($link, $gw37);
  $gw38 = mysqli_real_escape_string($link, $gw38);

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
          AND p.`UserID` =  " . $userID . "
      WHERE
        (";
  if ($t1) $sql .= "m.`HomeTeamID` = 1 OR m.`AwayTeamID` = 1 OR ";
  if ($t2) $sql .= "m.`HomeTeamID` = 2 OR m.`AwayTeamID` = 2 OR ";
  if ($t3) $sql .= "m.`HomeTeamID` = 3 OR m.`AwayTeamID` = 3 OR ";
  if ($t4) $sql .= "m.`HomeTeamID` = 4 OR m.`AwayTeamID` = 4 OR ";
  if ($t5) $sql .= "m.`HomeTeamID` = 5 OR m.`AwayTeamID` = 5 OR ";
  if ($t6) $sql .= "m.`HomeTeamID` = 6 OR m.`AwayTeamID` = 6 OR ";
  if ($t7) $sql .= "m.`HomeTeamID` = 7 OR m.`AwayTeamID` = 7 OR ";
  if ($t8) $sql .= "m.`HomeTeamID` = 8 OR m.`AwayTeamID` = 8 OR ";
  if ($t9) $sql .= "m.`HomeTeamID` = 9 OR m.`AwayTeamID` = 9 OR ";
  if ($t10) $sql .= "m.`HomeTeamID` = 10 OR m.`AwayTeamID` = 10 OR ";
  if ($t11) $sql .= "m.`HomeTeamID` = 11 OR m.`AwayTeamID` = 11 OR ";
  if ($t12) $sql .= "m.`HomeTeamID` = 12 OR m.`AwayTeamID` = 12 OR ";
  if ($t13) $sql .= "m.`HomeTeamID` = 13 OR m.`AwayTeamID` = 13 OR ";
  if ($t14) $sql .= "m.`HomeTeamID` = 14 OR m.`AwayTeamID` = 14 OR ";
  if ($t15) $sql .= "m.`HomeTeamID` = 15 OR m.`AwayTeamID` = 15 OR ";
  if ($t16) $sql .= "m.`HomeTeamID` = 16 OR m.`AwayTeamID` = 16 OR ";
  if ($t17) $sql .= "m.`HomeTeamID` = 17 OR m.`AwayTeamID` = 17 OR ";
  if ($t18) $sql .= "m.`HomeTeamID` = 18 OR m.`AwayTeamID` = 18 OR ";
  if ($t19) $sql .= "m.`HomeTeamID` = 19 OR m.`AwayTeamID` = 19 OR ";
  if ($t20) $sql .= "m.`HomeTeamID` = 20 OR m.`AwayTeamID` = 10 OR ";
  //Remove last OR as close bracket on section
  $sql = substr($sql, 0, -4) . ")";
  $sql .= " AND (";
  if ($gw1) $sql .= "m.`GameWeekID` = 1 OR ";
  if ($gw2) $sql .= "m.`GameWeekID` = 2 OR ";
  if ($gw3) $sql .= "m.`GameWeekID` = 3 OR ";
  if ($gw4) $sql .= "m.`GameWeekID` = 4 OR ";
  if ($gw5) $sql .= "m.`GameWeekID` = 5 OR ";
  if ($gw6) $sql .= "m.`GameWeekID` = 6 OR ";
  if ($gw7) $sql .= "m.`GameWeekID` = 7 OR ";
  if ($gw8) $sql .= "m.`GameWeekID` = 8 OR ";
  if ($gw9) $sql .= "m.`GameWeekID` = 9 OR ";
  if ($gw10) $sql .= "m.`GameWeekID` = 10 OR ";
  if ($gw11) $sql .= "m.`GameWeekID` = 11 OR ";
  if ($gw12) $sql .= "m.`GameWeekID` = 12 OR ";
  if ($gw13) $sql .= "m.`GameWeekID` = 13 OR ";
  if ($gw14) $sql .= "m.`GameWeekID` = 14 OR ";
  if ($gw15) $sql .= "m.`GameWeekID` = 15 OR ";
  if ($gw16) $sql .= "m.`GameWeekID` = 16 OR ";
  if ($gw17) $sql .= "m.`GameWeekID` = 17 OR ";
  if ($gw18) $sql .= "m.`GameWeekID` = 18 OR ";
  if ($gw19) $sql .= "m.`GameWeekID` = 19 OR ";
  if ($gw20) $sql .= "m.`GameWeekID` = 20 OR ";
  if ($gw21) $sql .= "m.`GameWeekID` = 21 OR ";
  if ($gw22) $sql .= "m.`GameWeekID` = 22 OR ";
  if ($gw23) $sql .= "m.`GameWeekID` = 23 OR ";
  if ($gw24) $sql .= "m.`GameWeekID` = 24 OR ";
  if ($gw25) $sql .= "m.`GameWeekID` = 25 OR ";
  if ($gw26) $sql .= "m.`GameWeekID` = 26 OR ";
  if ($gw27) $sql .= "m.`GameWeekID` = 27 OR ";
  if ($gw28) $sql .= "m.`GameWeekID` = 28 OR ";
  if ($gw29) $sql .= "m.`GameWeekID` = 29 OR ";
  if ($gw30) $sql .= "m.`GameWeekID` = 30 OR ";
  if ($gw31) $sql .= "m.`GameWeekID` = 31 OR ";
  if ($gw32) $sql .= "m.`GameWeekID` = 32 OR ";
  if ($gw33) $sql .= "m.`GameWeekID` = 33 OR ";
  if ($gw34) $sql .= "m.`GameWeekID` = 34 OR ";
  if ($gw35) $sql .= "m.`GameWeekID` = 35 OR ";
  if ($gw36) $sql .= "m.`GameWeekID` = 36 OR ";
  if ($gw37) $sql .= "m.`GameWeekID` = 37 OR ";
  if ($gw38) $sql .= "m.`GameWeekID` = 38 OR ";
  //Remove last OR as close bracket on section
  $sql = substr($sql, 0, -4) . ")";
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
