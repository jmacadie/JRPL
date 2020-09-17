<?php

// Helper function to escape any HTML special characters in a string
function html($text) {
  return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
}

// Wrapper to echo text whilst escaping any HTML special characters
function htmlout($text) {
  echo html($text);
}

// Function to test if variable passed === integer
function int($int) {

    // First check if it's a numeric value as either a string or number
    if(is_numeric($int) === TRUE)
    {

        // It's a number, but it has to be an integer
        if((int)$int == $int){

            return TRUE;

        // It's a number, but not an integer, so we fail
        }else{

            return FALSE;

        }

        // Not a number
    }else{

        return FALSE;

    }
}

// Implementation of the Quick Sort algorithm
function quickSort($arr, $left = 0, $right = NULL) {
  // when the call is recursive we need to change
  //the array passed to the function earlier
  static $array = array();
  if( $right == NULL ) $array = $arr;
  if( $right == NULL ) $right = count($array)-1; //last element of the array

  $i = $left;
  $j = $right;

  $tmp = $array[(int)( ($left+$right)/2 )];

  // partion the array in two parts.
  // left from $tmp are with smaller values,
  // right from $tmp are with bigger ones
  do
  {
    while( $array[$i] < $tmp ) $i++;
    while( $tmp < $array[$j] ) $j--;

    // swap elements from the two sides
    if( $i <= $j )
    {
      $w = $array[$i];
      $array[$i] = $array[$j];
      $array[$j] = $w;

      $i++;
      $j--;
    }
  } while( $i <= $j );

  // devide left side if it is longer the 1 element
  if( $left < $j ) quickSort(NULL, $left, $j);

  // the same with the right side
  if( $i < $right ) quickSort(NULL, $i, $right);

  // when all partitions have one element
  // the array is sorted
  return $array;
}

// Convert hex ring to binary string equivalent
function ring_base_convert ($ring) {
  $out = '';
  for ($i = 0; $i < strlen($ring); $i++) {
    $tmp = base_convert($ring[$i], 16, 2);
    $out .= str_pad($tmp, 4, "0", STR_PAD_LEFT);
  }
  return $out;
}

// Generate data for tables
function getLeagueTable($gw = NULL) {

  // Get DB connection
  include $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';
  if (!isset($link)) {
    $error = 'Error getting DB connection';

    header('Content-type: application/json');
    $arr = array('result' => 'No', 'message' => $error);
    echo json_encode($arr);
    die();
  }

  // Drop temporary table to hold submitted matches count
  $sql = "DROP TABLE IF EXISTS `SubmittedMatches` ; ";

  $result = mysqli_query($link, $sql);
  if (!$result) {
    $error = 'Error dropping submitted matches temporary table: <br />' . mysqli_error($link) . '<br /><br />' . $sql;

    header('Content-type: application/json');
    $arr = array('result' => 'No', 'message' => $error);
    echo json_encode($arr);
    die();
  }

  // Create temporary table to hold submitted matches count
  $sql = "
    CREATE TEMPORARY TABLE `SubmittedMatches` (
      `UserID` INT NOT NULL
      ,`Submitted` INT NOT NULL
      ,`NotSubmitted` INT NOT NULL) ; ";

  $result = mysqli_query($link, $sql);
  if (!$result) {
    $error = 'Error creating submitted matches temporary table: <br />' . mysqli_error($link) . '<br /><br />' . $sql;

    header('Content-type: application/json');
    $arr = array('result' => 'No', 'message' => $error);
    echo json_encode($arr);
    die();
  }

  // Add submitted matches count data to temporary table
  $sql = "
    INSERT INTO `SubmittedMatches`

      SELECT
        u.`UserID`

        ,(SELECT COUNT(*)
        FROM `Match` m
          LEFT JOIN `Prediction` p ON p.`MatchID` = m.`MatchID`
        WHERE p.`UserID` = u.`UserID`
          ";
  if ($gw != NULL) $sql .= "AND m.`GameWeekID` = " . $gw;
  $sql .= "
          AND (p.`HomeTeamPoints` IS NOT NULL AND p.`AwayTeamPoints` IS NOT NULL)
          AND (m.`ResultPostedBy` IS NOT NULL)) AS `Submitted`

        ,(SELECT COUNT(*)
        FROM
          (SELECT `MatchID`, `UserID`
          FROM `Match`, `User`
          WHERE `ResultPostedBy` IS NOT NULL
          ";
  if ($gw != NULL) $sql .= "AND `GameWeekID` = " . $gw;
  $sql .= ") mu
          LEFT JOIN `Prediction` p ON
            p.`MatchID` = mu.`MatchID`
            AND p.`UserID` = mu.`UserID`
        WHERE mu.`UserID` = u.`UserID`
          AND p.`PredictionID` IS NULL) AS `NotSubmitted`

      FROM `User` u ; ";

  $result = mysqli_query($link, $sql);
  if (!$result) {
    $error = 'Error adding submitted matches data to temporary table: <br />' . mysqli_error($link) . '<br /><br />' . $sql;

    header('Content-type: application/json');
    $arr = array('result' => 'No', 'message' => $error);
    echo json_encode($arr);
    die();
  }

  // Drop temporary table to hold points by user
  $sql = "DROP TABLE IF EXISTS `PointsByUser` ; ";

  $result = mysqli_query($link, $sql);
  if (!$result) {
    $error = 'Error dropping points by user temporary table: <br />' . mysqli_error($link) . '<br /><br />' . $sql;

    header('Content-type: application/json');
    $arr = array('result' => 'No', 'message' => $error);
    echo json_encode($arr);
    die();
  }

  // Create temporary table to hold points by user
  $sql = "
    CREATE TEMPORARY TABLE `PointsByUser` (
       `UserID` INT NOT NULL
      ,`DisplayName` VARCHAR(100) NOT NULL
      ,`ResultPoints` DECIMAL(6,2) NOT NULL
      ,`ScorePoints` DECIMAL(6,2) NOT NULL
      ,`TotalPoints` DECIMAL(6,2) NOT NULL) ; ";

  $result = mysqli_query($link, $sql);
  if (!$result) {
    $error = 'Error creating points by user temporary table: <br />' . mysqli_error($link) . '<br /><br />' . $sql;

    header('Content-type: application/json');
    $arr = array('result' => 'No', 'message' => $error);
    echo json_encode($arr);
    die();
  }

  // Add points by user data to temporary table
  $sql = "
    INSERT INTO `PointsByUser`

      SELECT
         tmp.`UserID`
        ,tmp.`DisplayName`
        ,SUM(tmp.`ResultPoints`) AS `ResultPoints`
        ,SUM(tmp.`ScorePoints`) AS `ScorePoints`
        ,SUM(tmp.`TotalPoints`) AS `TotalPoints`

      FROM
        (SELECT
           u.`UserID`
          ,IFNULL(u.`DisplayName`,CONCAT(u.`FirstName`,' ',u.`LastName`)) AS `DisplayName`
          ,IFNULL(po.`ResultPoints`,0) AS `ResultPoints`
          ,IFNULL(po.`ScorePoints`,0) AS `ScorePoints`
          ,IFNULL(po.`TotalPoints`,0) AS `TotalPoints`

        FROM `User` u

          LEFT JOIN
            (SELECT `MatchID`, `UserID`
            FROM `Match`, `User`
            WHERE `ResultPostedBy` IS NOT NULL
          ";
  if ($gw != NULL) $sql .= "AND `GameWeekID` = " . $gw;
  $sql .= ") mu
              ON mu.`UserID` = u.`UserID`

          LEFT JOIN `Points` po ON
            po.`UserID` = mu.`UserID`
            AND po.`MatchID` = mu.`MatchID`) tmp

      GROUP BY tmp.`UserID`, tmp.`DisplayName`; ";

  $result = mysqli_query($link, $sql);
  if (!$result) {
    $error = 'Error adding points by user data to temporary table: <br />' . mysqli_error($link) . '<br /><br />' . $sql;

    header('Content-type: application/json');
    $arr = array('result' => 'No', 'message' => $error);
    echo json_encode($arr);
    die();
  }

  // Drop 2nd temporary table to hold points by user
  $sql = "DROP TABLE IF EXISTS `PointsByUser2` ; ";

  $result = mysqli_query($link, $sql);
  if (!$result) {
    $error = 'Error dropping 2nd points by user temporary table: <br />' . mysqli_error($link) . '<br /><br />' . $sql;

    header('Content-type: application/json');
    $arr = array('result' => 'No', 'message' => $error);
    echo json_encode($arr);
    die();
  }

  // Create 2nd temporary table to hold points by user
  $sql = "CREATE TEMPORARY TABLE `PointsByUser2` SELECT * FROM `PointsByUser`; ";

  $result = mysqli_query($link, $sql);
  if (!$result) {
    $error = 'Error creating 2nd points by user temporary table: <br />' . mysqli_error($link) . '<br /><br />' . $sql;

    header('Content-type: application/json');
    $arr = array('result' => 'No', 'message' => $error);
    echo json_encode($arr);
    die();
  }

  // Drop 3rd temporary table to hold points by user
  $sql = "DROP TABLE IF EXISTS `PointsByUser3` ; ";

  $result = mysqli_query($link, $sql);
  if (!$result) {
    $error = 'Error dropping 3rd points by user temporary table: <br />' . mysqli_error($link) . '<br /><br />' . $sql;

    header('Content-type: application/json');
    $arr = array('result' => 'No', 'message' => $error);
    echo json_encode($arr);
    die();
  }

  // Create 3rd temporary table to hold points by user
  $sql = "CREATE TEMPORARY TABLE `PointsByUser3` SELECT * FROM `PointsByUser`; ";

  $result = mysqli_query($link, $sql);
  if (!$result) {
    $error = 'Error creating 3rd points by user temporary table: <br />' . mysqli_error($link) . '<br /><br />' . $sql;

    header('Content-type: application/json');
    $arr = array('result' => 'No', 'message' => $error);
    echo json_encode($arr);
    die();
  }

  // Final query
  $sql = "
    SELECT
      (SELECT COUNT(*) + 1
      FROM `PointsByUser2` pbu2
      WHERE pbu2.`TotalPoints` > pbu.`TotalPoints`) AS `Rank`
      ,(SELECT COUNT(*)
      FROM `PointsByUser3` pbu3
      WHERE pbu3.`TotalPoints` = pbu.`TotalPoints`) AS `RankCount`
      ,pbu.*
      ,sm.`Submitted`
      ,sm.`NotSubmitted`

    FROM `PointsByUser` pbu
      INNER JOIN `SubmittedMatches` sm ON sm.`UserID` = pbu.`UserID`

    ORDER BY
       pbu.`TotalPoints` DESC
      ,pbu.`ScorePoints` DESC
      ,pbu.`ResultPoints` DESC
      ,pbu.`DisplayName` ASC;";

  $result = mysqli_query($link, $sql);
  if (!$result) {
    $error = 'Error fetching league table: <br />' . mysqli_error($link) . '<br /><br />' . $sql;

    header('Content-type: application/json');
    $arr = array('result' => 'No', 'message' => $error);
    echo json_encode($arr);
    die();
  }

  // Build array of outputs
  $out = array();
  while ($row = mysqli_fetch_array($result)) {
    $out[] = array(
       'rank' => $row['Rank']
      ,'rankCount' => $row['RankCount']
      ,'name' => $row['DisplayName']
      ,'submitted' => $row['Submitted']
      ,'notSubmitted' => $row['NotSubmitted']
      ,'results' => $row['ResultPoints']
      ,'scores' => $row['ScorePoints']
      ,'totalPoints' => $row['TotalPoints']);
  }

  return $out;
}
