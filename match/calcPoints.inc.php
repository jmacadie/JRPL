<?php

// Calculate the all the points systems for a given match
function calculatePoints($matchID) {
  calculateStandardPoints($matchID);
  calculateAutoQuizPoints($matchID);

}

// Calculate the standard points for a given match
function calculateStandardPoints($matchID) {

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

  // Calculate points and INSERT them back into the DB
  // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

  // Function to convert a prediction vs. target into JRPL points by giving:
  //    an exact result 3 JRPL points
  //    within 5 rugby score points 2 JRPL score points
  //    between 6 & 10 rugby score points 1 JRPL score point
  //    between 11 & 15 rugby score points 0 JRPL score points
  //    between 16 & 20 rugby score points -1 JRPL score points
  //    ... and so on (with no negative limit!)
  function scorePoints($predict, $target, $multiplier) {
    // Exact score
    if ($predict == $target) {
      return 3 * $multiplier;
    }
    // Not exact score so remove 1 JRPL point for every 5 points difference
    $diff = abs($predict - $target);
    $diffDamped = (int)(($diff -1) / 5);
    return (2 - $diffDamped) * $multiplier;
  }

  // Now loop through all the submitted predictions, scoring each
  while ($rowP = mysqli_fetch_array($resultP)) {

    // Check for right result
    if ((($ht > $at) && ($rowP['HomeTeamPoints'] > $rowP['AwayTeamPoints'])) ||
        (($ht < $at) && ($rowP['HomeTeamPoints'] < $rowP['AwayTeamPoints'])) ||
        (($ht == $at) && ($rowP['HomeTeamPoints'] == $rowP['AwayTeamPoints']))) {
      $resultPoints = 3 * $multiplier;
    } else {
      $resultPoints = 0;
    }


    // Calculate the other points using our generic distance function
    $homeTeamScorePoints = scorePoints(
                             $rowP['HomeTeamPoints'],
                             $ht,
                             $multiplier);
    $awayTeamScorePoints = scorePoints(
                             $rowP['AwayTeamPoints'],
                             $at,
                             $multiplier);
    $marginPoints = scorePoints(
                      ($rowP['HomeTeamPoints'] - $rowP['AwayTeamPoints']),
                      ($ht - $at),
                      $multiplier);

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

  // Loop through predictions and do initial result processing
  // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

  // Set variables
  $numUsers = 0;
  $numResultUsers = 0;
  $numScoreUsers = 0;
  $arrPoints = array();

  // Loop through all predictions made
  while ($rowP = mysqli_fetch_array($resultP)) {

    // Increment the number of users counter
    $numUsers++;

    // Reset single user output array
    $out = array();
    $out['userID'] = $rowP['UserID'];

    // First check right result
    if ((($ht > $at) && ($rowP['HomeTeamPoints'] > $rowP['AwayTeamPoints'])) ||
      (($ht < $at) && ($rowP['HomeTeamPoints'] < $rowP['AwayTeamPoints'])) ||
      (($ht == $at) && ($rowP['HomeTeamPoints'] == $rowP['AwayTeamPoints']))) {

        // Increment the number of correct users counter
        $numResultUsers++;

        // Right result so award a result point
        $out['result'] = 1;

        // Then check exact score
        if (($ht == $rowP['HomeTeamPoints']) && ($at == $rowP['AwayTeamPoints'])) {
          // Increment the number of correct users counter
          $numScoreUsers++;
          // Right exact score so award a score point
          $out['score'] = 2;
        } else {
          // Wrong exact score so no score points
          $out['score'] = 0;
        }

    } else {
      // Not the right result so no points all round
      $out['result'] = 0;
      $out['score'] = 0;
    }

    // Add single user output array
    $arrPoints[] = $out;
  }

  // Calculate points and INSERT them back into the DB
  // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
  foreach ($arrPoints as $user) {

    // Calculate the actual points
    $resultPoints = ($numResultUsers == 0) ? 0 : ($user['result'] * $numUsers / $numResultUsers);
    $scorePoints = ($numScoreUsers == 0) ? 0 : ($user['score'] * $numUsers / $numScoreUsers);
    $totalPoints = $resultPoints + $scorePoints;

    // Build SQL
    $sql = "INSERT INTO `Points`
          (`ScoringSystemID`,
          `UserID`,
          `MatchID`,
          `ResultPoints`,
          `ScorePoints`,
          `TotalPoints`)
        VALUES
          (2,
          " . $user['userID'] . ",
          " . $matchID . ",
          " . $resultPoints . ",
          " . $scorePoints . ",
          " . $totalPoints . ");";

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
