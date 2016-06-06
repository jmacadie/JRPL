<?php

// Calculate the all the points systems for a given match
function calculatePoints($matchID) {
  calculateFootballStandardPoints($matchID);
  //calculateAutoQuizPoints($matchID);

}

// Calculate the standard points for a given match
function calculateFootballStandardPoints($matchID) {

  // Get DB connection
  include $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';
  if (!isset($link)) {
    $error = 'Error getting DB connection';

    header('Content-type: application/json');
    $arr = array('result' => 'No', 'message' => $error);
    echo json_encode($arr);
    die();
  }

  // Delete existing prediction first
  // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

  // Build SQL
  $sql = "
    DELETE FROM `Points`
    WHERE
      `MatchID` = " . $matchID . "
      AND `ScoringSystemID` = 1;";

  // Run SQL and trap any errors
  $result = mysqli_query($link, $sql);
  if (!$result) {
    $error = "Error deleting previous standard points for match: <br />" . mysqli_error($link) . '<br /><br />' . $sql;

    header('Content-type: application/json');
    $arr = array('result' => 'No', 'message' => $error);
    echo json_encode($arr);
    die();
  }

  // Grab match result
  // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

  // Build SQL
  $sql = "
    SELECT
       m.`HomeTeamPoints`
      ,m.`AwayTeamPoints`
    FROM `Match` m
    WHERE m.`MatchID` = " . $matchID . ";";

  // Run SQL and trap any errors
  $resultM = mysqli_query($link, $sql);
  if (!$resultM) {
    $error = "Error getting result for match: <br />" . mysqli_error($link) . '<br /><br />' . $sql;

    header('Content-type: application/json');
    $arr = array('result' => 'No', 'message' => $error);
    echo json_encode($arr);
    die();
  }

  // Grab results
  $rowM = mysqli_fetch_array($resultM);
  $ht = $rowM['HomeTeamPoints'];
  $at = $rowM['AwayTeamPoints'];

  // Grab predictions
  // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

  // Build SQL
  $sql = "
    SELECT
       u.`UserID`
      ,p.`HomeTeamPoints`
      ,p.`AwayTeamPoints`

    FROM `User` AS u

      LEFT JOIN
        (SELECT
           `UserID`
          ,`HomeTeamPoints`
          ,`AwayTeamPoints`
        FROM `Prediction`
        WHERE `MatchID` = " . $matchID . ") AS p ON
        p.`UserID` = u.`UserID`;";

  // Run SQL and trap any errors
  $resultP = mysqli_query($link, $sql);
  if (!$resultP) {
    $error = "Error getting predictions for match: <br />" . mysqli_error($link) . '<br /><br />' . $sql;

    header('Content-type: application/json');
    $arr = array('result' => 'No', 'message' => $error);
    echo json_encode($arr);
    die();
  }

  // Calculate points and INSERT them back into the DB
  // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

  // Now loop through all the submitted predictions, scoring each
  while ($rowP = mysqli_fetch_array($resultP)) {

    // Grab the prediction
    $htp = ($rowP['HomeTeamPoints'] === NULL) ? 0 : $rowP['HomeTeamPoints'];
    $atp = ($rowP['AwayTeamPoints'] === NULL) ? 0 : $rowP['AwayTeamPoints'];
    $missed = ($rowP['AwayTeamPoints'] === NULL);
    
    // Check for right result
    if (!$missed &&
        ((($ht > $at) && ($htp > $atp)) ||
        (($ht < $at) && ($htp < $atp)) ||
        (($ht == $at) && ($htp == $atp)))) {
      $resultPoints = 1;
    } else {
      $resultPoints = 0;
    }
    
    // Check for exact score
    if (!$missed &&
        ($ht == $htp) &&
        ($at == $atp)) {
      $scorePoints = 2;
    } else {
      $scorePoints = 0;
    }

    // Calculate the total points
    $totalPoints = $resultPoints +
                   $scorePoints;

    // Build SQL
    $sql = "
      INSERT INTO `Points`
        (`ScoringSystemID`,
         `UserID`,
         `MatchID`,
         `ResultPoints`,
         `ScorePoints`,
         `TotalPoints`)
      VALUES
        (1,
         " . $rowP['UserID'] . ",
         " . $matchID . ",
         " . $resultPoints . ",
         " . $scorePoints . ",
         " . $totalPoints . ");";

    // Run SQL and trap any errors
    $result = mysqli_query($link, $sql);
    if (!$result) {
      $error = "Error inserting standard points for match: <br />" . mysqli_error($link) . '<br /><br />' . $sql;

      header('Content-type: application/json');
      $arr = array('result' => 'No', 'message' => $error);
      echo json_encode($arr);
      die();
    }

  }
}

// Calculate the standard points for a given match
function calculateRugbyStandardPoints($matchID) {

  // Get DB connection
  include $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';
  if (!isset($link)) {
    $error = 'Error getting DB connection';

    header('Content-type: application/json');
    $arr = array('result' => 'No', 'message' => $error);
    echo json_encode($arr);
    die();
  }

  // Delete existing prediction first
  // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

  // Build SQL
  $sql = "
    DELETE FROM `Points`
    WHERE
      `MatchID` = " . $matchID . "
      AND `ScoringSystemID` = 1;";

  // Run SQL and trap any errors
  $result = mysqli_query($link, $sql);
  if (!$result) {
    $error = "Error deleting previous standard points for match: <br />" . mysqli_error($link) . '<br /><br />' . $sql;

    header('Content-type: application/json');
    $arr = array('result' => 'No', 'message' => $error);
    echo json_encode($arr);
    die();
  }

  // Grab match result
  // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

  // Build SQL
  $sql = "
    SELECT
      m.`HomeTeamPoints`
      ,m.`AwayTeamPoints`
      ,s.`Name` AS `Stage`
    FROM `Match` m
      INNER JOIN `Stage` s ON
        s.`StageID` = m.`StageID`
    WHERE m.`MatchID` = " . $matchID . ";";

  // Run SQL and trap any errors
  $resultM = mysqli_query($link, $sql);
  if (!$resultM) {
    $error = "Error getting result for match: <br />" . mysqli_error($link) . '<br /><br />' . $sql;

    header('Content-type: application/json');
    $arr = array('result' => 'No', 'message' => $error);
    echo json_encode($arr);
    die();
  }

  // Grab results
  $rowM = mysqli_fetch_array($resultM);
  $ht = $rowM['HomeTeamPoints'];
  $at = $rowM['AwayTeamPoints'];

  // Set multiplier
  switch($rowM['Stage']) {
    case 'Group Stage' : $multiplier = 1; break;
    case 'Quarter Finals' : $multiplier = 2; break;
    case 'Semi Finals' : $multiplier = 3; break;
    case '3rd 4th Place Play-off' : $multiplier = 1; break;
    case 'Final' : $multiplier = 4; break;
    default : $multiplier = 1;
  }

  // Grab predictions
  // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

  // Build SQL
  $sql = "
    SELECT
       u.`UserID`
      ,p.`HomeTeamPoints`
      ,p.`AwayTeamPoints`

    FROM `User` AS u

      LEFT JOIN
        (SELECT
          `UserID`
          ,`HomeTeamPoints`
          ,`AwayTeamPoints`
        FROM `Prediction`
        WHERE `MatchID` = " . $matchID . ") AS p ON
        p.`UserID` = u.`UserID`;";

  // Run SQL and trap any errors
  $resultP = mysqli_query($link, $sql);
  if (!$resultP) {
    $error = "Error getting predictions for match: <br />" . mysqli_error($link) . '<br /><br />' . $sql;

    header('Content-type: application/json');
    $arr = array('result' => 'No', 'message' => $error);
    echo json_encode($arr);
    die();
  }

  // Calculate points and INSERT them back into the DB
  // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

  // Function to convert a prediction vs. target into JRPL points by giving:
  //    an exact result 3 JRPL points
  //    within 5 rugby score points 2 JRPL score points
  //    between 6 & 10 rugby score points 1 JRPL score point
  //    between 11 & 15 rugby score points 0 JRPL score points
  //    between 16 & 20 rugby score points -1 JRPL score points
  //    ... and so on (with no negative limit!)
  function scorePoints($predict, $target, $multiplier, $missed) {
    // Exact score
    if (!$missed && $predict == $target) {
      return 3 * $multiplier;
    }
    // Not exact score so remove 1 JRPL point for every 5 points difference
    $diff = abs($predict - $target);
    $diffDamped = (int)(($diff -1) / 5);
    $points = (2 - $diffDamped) * $multiplier;
    if ($missed) {
      return min(0, $points);
    } else {
      return $points;
    }
  }

  // Now loop through all the submitted predictions, scoring each
  while ($rowP = mysqli_fetch_array($resultP)) {

    // Grab the prediction and impute missed predictions as 0-0
    $htp = ($rowP['HomeTeamPoints'] === NULL) ? 0 : $rowP['HomeTeamPoints'];
    $atp = ($rowP['AwayTeamPoints'] === NULL) ? 0 : $rowP['AwayTeamPoints'];
    $missed = ($rowP['AwayTeamPoints'] === NULL);

    // Check for right result
    if (!$missed &&
        (($ht > $at) && ($htp > $atp)) ||
        (($ht < $at) && ($htp < $atp)) ||
        (($ht == $at) && ($htp == $atp))) {
      $resultPoints = 3 * $multiplier;
    } else {
      $resultPoints = 0;
    }


    // Calculate the other points using our generic distance function
    $homeTeamScorePoints = scorePoints(
                             $htp,
                             $ht,
                             $multiplier,
                             $missed);
    $awayTeamScorePoints = scorePoints(
                             $atp,
                             $at,
                             $multiplier,
                             $missed);
    $marginPoints = scorePoints(
                      ($htp - $atp),
                      ($ht - $at),
                      $multiplier,
                      $missed);

    // Calculate the total points
    $totalPoints = $resultPoints +
                   $homeTeamScorePoints +
                   $awayTeamScorePoints +
                   $marginPoints;

    // Build SQL
    $sql = "
      INSERT INTO `Points`
        (`ScoringSystemID`,
        `UserID`,
        `MatchID`,
        `ResultPoints`,
        `ScorePoints`,
        `MarginPoints`,
        `TotalPoints`)
      VALUES
        (1,
        " . $rowP['UserID'] . ",
        " . $matchID . ",
        " . $resultPoints . ",
        " . ($homeTeamScorePoints + $awayTeamScorePoints) . ",
        " . $marginPoints . ",
        " . $totalPoints . ");";

    // Run SQL and trap any errors
    $result = mysqli_query($link, $sql);
    if (!$result) {
      $error = "Error inserting standard points for match: <br />" . mysqli_error($link) . '<br /><br />' . $sql;

      header('Content-type: application/json');
      $arr = array('result' => 'No', 'message' => $error);
      echo json_encode($arr);
      die();
    }

  }
}

// Calculate the AutoQuiz points for a given match
function calculateAutoQuizPoints($matchID) {

  // Get DB connection
  include $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';
  if (!isset($link)) {
    $error = 'Error getting DB connection';

    header('Content-type: application/json');
    $arr = array('result' => 'No', 'message' => $error);
    echo json_encode($arr);
    die();
  }

  // Delete existing prediction first
  // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

  // Build SQL
  $sql = "
    DELETE FROM `Points`
    WHERE
      `MatchID` = " . $matchID . "
      AND `ScoringSystemID` = 2;";

  // Run SQL and trap any errors
  $result = mysqli_query($link, $sql);
  if (!$result) {
    $error = "Error deleting previous AutoQuiz points for match: <br />" . mysqli_error($link) . '<br /><br />' . $sql;

    header('Content-type: application/json');
    $arr = array('result' => 'No', 'message' => $error);
    echo json_encode($arr);
    die();
  }

  // Grab match result
  // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

  // Build SQL
  $sql = "
    SELECT
      `HomeTeamPoints`
      ,`AwayTeamPoints`
    FROM `Match`
    WHERE `MatchID` = " . $matchID . ";";

  // Run SQL and trap any errors
  $resultM = mysqli_query($link, $sql);
  if (!$resultM) {
    $error = "Error getting result for match: <br />" . mysqli_error($link) . '<br /><br />' . $sql;

    header('Content-type: application/json');
    $arr = array('result' => 'No', 'message' => $error);
    echo json_encode($arr);
    die();
  }

  // Grab results
  $rowM = mysqli_fetch_array($resultM);
  $ht = $rowM['HomeTeamPoints'];
  $at = $rowM['AwayTeamPoints'];

  // Grab predictions
  // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

  // Build SQL
  $sql = "
    SELECT
      `UserID`
      ,`HomeTeamPoints`
      ,`AwayTeamPoints`
    FROM `Prediction`
    WHERE `MatchID` = " . $matchID . ";";

  // Run SQL and trap any errors
  $resultP = mysqli_query($link, $sql);
  if (!$resultP) {
    $error = "Error getting predictions for match: <br />" . mysqli_error($link) . '<br /><br />' . $sql;

    header('Content-type: application/json');
    $arr = array('result' => 'No', 'message' => $error);
    echo json_encode($arr);
    die();
  }

  // Loop through predictions and calculate Ecludian Distance
  // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

  // Set variables
  $numUsers = 0;
  $maxED = 0;
  $arrCalc = array();

  // Loop through all predictions made
  while ($rowP = mysqli_fetch_array($resultP)) {

    // Increment the number of users counter
    $numUsers++;

    // Reset single user output array
    $out = array();
    $out['userID'] = $rowP['UserID'];

    // Calculate this user's Ecludian Distance
    $ed = sqrt(pow(($rowP['HomeTeamPoints'] - $ht), 2) +
               pow(($rowP['AwayTeamPoints'] - $at), 2));
    $out['ed'] = $ed;

    // Track the maximum Ecludian Distance
    $maxED = max($ed, $maxED);

    // Add single user output array
    $arrCalc[] = $out;
  }

  // Loop through predictions and calculate Inverted Ecludian Distance
  // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

  // Set variables
  $cumIED = 0;

  // Loop through all predictions made
  for ($i = 0, $max = count($arrCalc); $i < $max; $i++) {

    // Calculate this user's Inverted Ecludian Distance
    $ied = $maxED - $arrCalc[$i]['ed'];
    $arrCalc[$i]['ied'] = $ied;

    // Track the cumulative Inverted Ecludian Distance
    $cumIED += $ied;
  }

  // Calculate points and INSERT them back into the DB
  // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

  // Set variables
  $targetPoints = 10;
  $pointsPool = $targetPoints * $numUsers;

  // Loop through all predictions made
  foreach ($arrCalc as $userPoints) {

    // Calculate the actual points
    $aqPoints = ($cumIED == 0)
                  ? $targetPoints
                  : ($pointsPool * $userPoints['ied'] / $cumIED);

    // Build SQL
    $sql = "INSERT INTO `Points`
          (`ScoringSystemID`,
          `UserID`,
          `MatchID`,
          `ResultPoints`,
          `ScorePoints`,
          `MarginPoints`,
          `TotalPoints`)
        VALUES
          (2,
          " . $userPoints['userID'] . ",
          " . $matchID . ",
          0,
          0,
          0,
          " . $aqPoints . ");";

    // Run SQL and trap any errors
    $result = mysqli_query($link, $sql);
    if (!$result) {
      $error = "Error inserting AutoQuiz points for match: <br />" . mysqli_error($link) . '<br /><br />' . $sql;

      header('Content-type: application/json');
      $arr = array('result' => 'No', 'message' => $error);
      echo json_encode($arr);
      die();
    }
  }
}
