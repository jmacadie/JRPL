<?php

function calcMrMean($matchID,$link) {

  // Delete existing prediction first
  // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

  // Build SQL
    $sql = "DELETE FROM `Prediction`
         WHERE
          `UserID` IN
            (SELECT ur.`UserID`
            FROM `UserRole` ur
              INNER JOIN `Role` r ON
                r.`RoleID` = ur.`RoleID`
            WHERE r.`Role` = 'Mr Mean')
          AND `MatchID` = " . $matchID . ";";

  // Run SQL and trap any errors
    $result = mysqli_query($link, $sql);
    if (!$result)
    {
        $error = "Error deleting mr mean's previous predictions: <br />" . mysqli_error($link) . '<br /><br />' . $sql;
        sendEmail('james.macadie@telerealtrillium.com','Predictions Email Error','',$error);
        exit();
    }

  // Get the predicted scores
  // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

    // Build SQL - exclude special roles
  $sql = "SELECT
        p.`HomeTeamPoints`,
        p.`AwayTeamPoints`
      FROM `Prediction` p
        LEFT JOIN `UserRole` ur ON
          ur.`UserID` = p.`UserID`
        LEFT JOIN `Role` r ON
          r.`RoleID` = ur.`RoleID`
      WHERE p.`MatchID` = " . $matchID . "
        AND (r.`Role` IS NULL OR r.`Role` NOT IN ('Mr Mean','Mr Median','Mr Mode'));";

  // Run SQL and trap any errors
    $result = mysqli_query($link, $sql);
    if (!$result)
    {
        $error = 'Error get predictions to calculate mean: <br />' . mysqli_error($link) . '<br /><br />' . $sql;
        sendEmail('james.macadie@telerealtrillium.com','Predictions Email Error','',$error);
        exit();
    }

    // Calculate the Mean scores
    // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

  // Set the counters to zero to start with
  $homeScoreT = 0;
  $homeScoreC = 0;
  $awayScoreT = 0;
  $awayScoreC = 0;

  // Loop through all users and add scores if submitted
    while ($row = mysqli_fetch_array($result))
    {
        if ($row['HomeTeamPoints'] <> 'NULL' && $row['AwayTeamPoints'] <> 'NULL')
    {
      $homeScoreT += $row['HomeTeamPoints'];
      $homeScoreC++;
      $awayScoreT += $row['AwayTeamPoints'];
      $awayScoreC++;
    }
    }

  // Insert the prediction
    // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

  // Only do anything else if we have some predictions to work with
  if ($homeScoreC > 0)
  {

    // Actually calculate the averages ;)
    $homeScoreM = round($homeScoreT / $homeScoreC);
    $awayScoreM = round($awayScoreT / $awayScoreC);

    // Build SQL
    $sqlAdd = "INSERT INTO `Prediction` (
          `UserID`,
          `MatchID`,
          `HomeTeamPoints`,
          `AwayTeamPoints`,
          `DateAdded`)
         VALUES (
          (SELECT ur.`UserID`
          FROM `UserRole` ur
            INNER JOIN `Role` r ON
              r.`RoleID` = ur.`RoleID`
          WHERE r.`Role` = 'Mr Mean'
          LIMIT 1),
          " . $matchID . ",
          " . $homeScoreM  . ",
          " . $awayScoreM . ",
          NOW()
        )";

    // Run SQL and trap any errors
    $resultAdd = mysqli_query($link, $sqlAdd);
    if (!$resultAdd)
    {
      $error = "Error adding mr mean's predictions: <br />" . mysqli_error($link) . '<br /><br />' . $sqlAdd;
      sendEmail('james.macadie@telerealtrillium.com','Predictions Email Error','',$error);
      exit();
    }

  }

}

function calcMrMode($matchID,$link) {

  // Delete existing prediction first
  // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

  // Build SQL
  $sql = "
    DELETE FROM `Prediction`
    WHERE
      `UserID` IN
        (SELECT ur.`UserID`
        FROM `UserRole` ur
          INNER JOIN `Role` r ON
            r.`RoleID` = ur.`RoleID`
        WHERE r.`Role` = 'Mr Mode')
    AND `MatchID` = " . $matchID . ";";

  // Run SQL and trap any errors
  $result = mysqli_query($link, $sql);
  if (!$result) {
    $error = "Error deleting mr mode's previous predictions: <br />" . mysqli_error($link) . '<br /><br />' . $sql;
    sendEmail('james.macadie@telerealtrillium.com','Predictions Email Error','',$error);
    exit();
  }

  // Get the predicted scores
  // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

  // Build SQL - exclude special roles
  $sql = "
    SELECT
      p.`HomeTeamPoints`,
      p.`AwayTeamPoints`
    FROM `Prediction` p
      LEFT JOIN `UserRole` ur ON
        ur.`UserID` = p.`UserID`
      LEFT JOIN `Role` r ON
        r.`RoleID` = ur.`RoleID`
    WHERE p.`MatchID` = " . $matchID . "
      AND (r.`Role` IS NULL OR r.`Role` NOT IN ('Mr Mean','Mr Median','Mr Mode'));";

  // Run SQL and trap any errors
  $result = mysqli_query($link, $sql);
  if (!$result) {
    $error = 'Error get predictions to calculate mode: <br />' . mysqli_error($link) . '<br /><br />' . $sql;
    sendEmail('james.macadie@telerealtrillium.com','Predictions Email Error','',$error);
    exit();
  }

  // Fetch the results into arrays, for calculating
  // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

  // Set the counters to zero to start with
  $numMatches = 0;

  // Loop through all users and add scores if submitted
  $homeScores = array();
  $awayScores = array();
  while ($row = mysqli_fetch_array($result)) {
    if ($row['HomeTeamPoints'] <> 'NULL' && $row['AwayTeamPoints'] <> 'NULL') {
      $numMatches++;
      $homeScores[] = $row['HomeTeamPoints'];
      $awayScores[] = $row['AwayTeamPoints'];
    }
  }

  // Calculate & insert the prediction
  // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

  // Only do anything else if we have some predictions to work with
  if ($numMatches > 0) {

    // Actually calculate the averages ;)
    $values = array_count_values($homeScores);
    $maxVals = array_keys($values, max($values));
    $homeScoreM = array_sum($maxVals) / count($maxVals);

    $values = array_count_values($awayScores);
    $maxVals = array_keys($values, max($values));
    $awayScoreM = array_sum($maxVals) / count($maxVals);

    // Build SQL
    $sqlAdd = "
      INSERT INTO `Prediction` (
        `UserID`
        ,`MatchID`
        ,`HomeTeamPoints`
        ,`AwayTeamPoints`
        ,`DateAdded`)
      VALUES (
        (SELECT ur.`UserID`
        FROM `UserRole` ur
          INNER JOIN `Role` r ON
            r.`RoleID` = ur.`RoleID`
        WHERE r.`Role` = 'Mr Mode'
        LIMIT 1)
        ," . $matchID . "
        ," . $homeScoreM  . "
        ," . $awayScoreM . "
        ,NOW());";

    // Run SQL and trap any errors
    $resultAdd = mysqli_query($link, $sqlAdd);
    if (!$resultAdd) {
      $error = "Error adding mr mode's predictions: <br />" . mysqli_error($link) . '<br /><br />' . $sqlAdd;
      sendEmail('james.macadie@telerealtrillium.com','Predictions Email Error','',$error);
      exit();
    }

  }

}

function calcMrMedian($matchID,$link) {

  // Delete existing prediction first
  // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

  // Build SQL
  $sql = "
    DELETE FROM `Prediction`
    WHERE
      `UserID` =
        (SELECT ur.`UserID`
        FROM `UserRole` ur
          INNER JOIN `Role` r ON
            r.`RoleID` = ur.`RoleID`
        WHERE r.`Role` = 'Mr Median')
      AND `MatchID` = " . $matchID . ";";

  // Run SQL and trap any errors
  $result = mysqli_query($link, $sql);
  if (!$result) {
    $error = "Error deleting mr median's previous predictions: <br />" . mysqli_error($link) . '<br /><br />' . $sql;
    sendEmail('james.macadie@telerealtrillium.com','Predictions Email Error','',$error);
    exit();
  }

  // Get the predicted scores
  // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

  // Build SQL - exclude special roles
  $sql = "
    SELECT
      p.`HomeTeamPoints`
      ,p.`AwayTeamPoints`
    FROM `Prediction` p
      LEFT JOIN `UserRole` ur ON
        ur.`UserID` = p.`UserID`
      LEFT JOIN `Role` r ON
        r.`RoleID` = ur.`RoleID`
    WHERE p.`MatchID` = " . $matchID . "
      AND (r.`Role` IS NULL OR r.`Role` NOT IN ('Mr Mean','Mr Median','Mr Mode'));";

  // Run SQL and trap any errors
  $result = mysqli_query($link, $sql);
  if (!$result) {
    $error = 'Error get predictions to calculate median: <br />' . mysqli_error($link) . '<br /><br />' . $sql;
    sendEmail('james.macadie@telerealtrillium.com','Predictions Email Error','',$error);
    exit();
  }

  // Calculate the Median scores
  // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

  // Set the counters to zero to start with
  $numMatches = 0;

  // Loop through all users and add scores if submitted
  $homeScores = array();
  $awayScores = array();
  while ($row = mysqli_fetch_array($result)) {
    if ($row['HomeTeamPoints'] <> 'NULL' && $row['AwayTeamPoints'] <> 'NULL') {
      $numMatches++;
      $homeScores[] = $row['HomeTeamPoints'];
      $awayScores[] = $row['AwayTeamPoints'];
    }
  }

  // Insert the prediction
  // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

  // Only do anything else if we have some predictions to work with
  if ($numMatches > 0) {

    // Actually calculate the averages ;)
    // Sort arrays
    $homeScores = quickSort($homeScores);
    $awayScores = quickSort($awayScores);

    if ($numMatches % 2) {
      // $numMatches is odd can just take middle array value
      $homeScoreM = $homeScores[(($numMatches-1)/2)];
      $awayScoreM = $awayScores[(($numMatches-1)/2)];
    }
    else {
      // $numMatches is even must take average of middle two values
      $homeScoreM =
        round(($homeScores[($numMatches/2)]+
               $homeScores[(($numMatches/2)-1)])/2);
      $awayScoreM =
        round(($awayScores[($numMatches/2)]+
               $awayScores[(($numMatches/2)-1)])/2);
    }

    // Build SQL
    $sqlAdd = "
      INSERT INTO `Prediction` (
        `UserID`
        ,`MatchID`
        ,`HomeTeamPoints`
        ,`AwayTeamPoints`
        ,`DateAdded`)
      VALUES (
        (SELECT ur.`UserID`
        FROM `UserRole` ur
          INNER JOIN `Role` r ON
            r.`RoleID` = ur.`RoleID`
        WHERE r.`Role` = 'Mr Median'
        LIMIT 1)
        ," . $matchID . "
        ," . $homeScoreM . "
        ," . $awayScoreM . "
        ,NOW());";

    // Run SQL and trap any errors
    $resultAdd = mysqli_query($link, $sqlAdd);
    if (!$resultAdd) {
      $error = "Error adding mr median's predictions: <br />" . mysqli_error($link) . '<br /><br />' . $sqlAdd;
      sendEmail('james.macadie@telerealtrillium.com','Predictions Email Error','',$error);
      exit();
    }

  }

}
