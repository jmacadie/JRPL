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

// Calculate the all the points systems for a given match
function calculatePoints($matchID) {
  
  calculateStandardPoints($matchID);
  calculateAutoQuizPoints($matchID);
  
}

// Calculate the standard points for a given match
function calculateStandardPoints($matchID) {
  
  // Get DB connection
  include $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';

  // Delete existing prediction first
  // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
  
  // Build SQL
    $sql = "DELETE FROM `Points`
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
    $sql = "SELECT
        `HomeTeamGoals`,
        `AwayTeamGoals`
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
  $ht = $rowM['HomeTeamGoals'];
  $at = $rowM['AwayTeamGoals'];
  
  // Grab predictions
  // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
  
  // Build SQL
    $sql = "SELECT
        `UserID`,
        `HomeTeamGoals`,
        `AwayTeamGoals`
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
  while ($rowP = mysqli_fetch_array($resultP)) {
    
    // First check right result
    if ((($ht > $at) && ($rowP['HomeTeamGoals'] > $rowP['AwayTeamGoals'])) ||
      (($ht < $at) && ($rowP['HomeTeamGoals'] < $rowP['AwayTeamGoals'])) ||
      (($ht == $at) && ($rowP['HomeTeamGoals'] == $rowP['AwayTeamGoals']))) {
        
        // Right result so award a result point
        $resultPoints = 1;
        
        // Then check exact score
        if (($ht == $rowP['HomeTeamGoals']) && ($at == $rowP['AwayTeamGoals'])) {
            $scorePoints = 2;
        } else {
          $scorePoints = 0;
        }
        
    } else {
      // Not the right result so no points all round
      $resultPoints = 0;
      $scorePoints = 0;
    }
    
    // Calculate the total points
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

// Calculate the AutoQuiz points for a given match
function calculateAutoQuizPoints($matchID) {
  
  // Get DB connection
  include $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';

  // Delete existing prediction first
  // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
  
  // Build SQL
    $sql = "DELETE FROM `Points`
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
    $sql = "SELECT
        `HomeTeamGoals`,
        `AwayTeamGoals`
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
  $ht = $rowM['HomeTeamGoals'];
  $at = $rowM['AwayTeamGoals'];
  
  // Grab predictions
  // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
  
  // Build SQL
    $sql = "SELECT
        `UserID`,
        `HomeTeamGoals`,
        `AwayTeamGoals`
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
    if ((($ht > $at) && ($rowP['HomeTeamGoals'] > $rowP['AwayTeamGoals'])) ||
      (($ht < $at) && ($rowP['HomeTeamGoals'] < $rowP['AwayTeamGoals'])) ||
      (($ht == $at) && ($rowP['HomeTeamGoals'] == $rowP['AwayTeamGoals']))) {
        
        // Increment the number of correct users counter
        $numResultUsers++;
        
        // Right result so award a result point
        $out['result'] = 1;
        
        // Then check exact score
        if (($ht == $rowP['HomeTeamGoals']) && ($at == $rowP['AwayTeamGoals'])) {
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

// Generate data for tables
function getLeagueTable($scoringSystem = 1, $stage = '') {
  
  // Get DB connection
  include $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';
  
  // Sort out selected stages
  if (($stage == '') || (!is_array($stage))) {
    $stageStr = '1,2,3,4,5';
  } else {
    $stageStr = '';
    if ($stage[0]) { $stageStr .= '1,'; }
    if ($stage[1]) { $stageStr .= '2,'; }
    if ($stage[2]) { $stageStr .= '3,'; }
    if ($stage[3]) { $stageStr .= '4,'; }
    if ($stage[4]) { $stageStr .= '5,'; }
    $stageStr .= '0';
  }
  
  // Drop temporary table to hold submitted matches count
  $sql = "DROP TABLE IF EXISTS `SubmittedMatches` ; ";

  $result = mysqli_query($link, $sql);
  if (!$result)
  {
    $error = 'Error dropping submitted matches temporary table: <br />' . mysqli_error($link) . '<br /><br />' . $sql;
    
    header('Content-type: application/json');
    $arr = array('result' => 'No', 'message' => $error);
    echo json_encode($arr);
    die();
  }
  
  // Create temporary table to hold submitted matches count
  $sql = "CREATE TEMPORARY TABLE `SubmittedMatches` (
          `UserID` INT NOT NULL,
          `Submitted` INT NOT NULL,
          `NotSubmitted` INT NOT NULL) ; ";

  $result = mysqli_query($link, $sql);
  if (!$result)
  {
    $error = 'Error creating submitted matches temporary table: <br />' . mysqli_error($link) . '<br /><br />' . $sql;
    
    header('Content-type: application/json');
    $arr = array('result' => 'No', 'message' => $error);
    echo json_encode($arr);
    die();
  }
  
  // Add submitted matches count data to temporary table
  $sql = "INSERT INTO `SubmittedMatches`
          SELECT
            u.`UserID`,
            
            (SELECT COUNT(*)
            FROM `Match` m
              LEFT JOIN `Prediction` p ON p.`MatchID` = m.`MatchID`
            WHERE p.`UserID` = u.`UserID`
              AND m.`StageID` IN (" . $stageStr . ")
              AND (p.`HomeTeamGoals` IS NOT NULL AND p.`AwayTeamGoals` IS NOT NULL)
              AND (m.`ResultPostedBy` IS NOT NULL)) AS `Submitted`,
              
            (SELECT COUNT(*)
            FROM
              (SELECT `MatchID`, `UserID`
              FROM `Match`, `User`
              WHERE `ResultPostedBy` IS NOT NULL AND `StageID` IN (" . $stageStr . ")) mu
              LEFT JOIN `Prediction` p ON
                p.`MatchID` = mu.`MatchID`
                AND p.`UserID` = mu.`UserID`
            WHERE mu.`UserID` = u.`UserID`
              AND p.`PredictionID` IS NULL) AS `NotSubmitted`
            
          FROM `User` u ; ";
  
  $result = mysqli_query($link, $sql);
  if (!$result)
  {
    $error = 'Error adding submitted matches data to temporary table: <br />' . mysqli_error($link) . '<br /><br />' . $sql;
    
    header('Content-type: application/json');
    $arr = array('result' => 'No', 'message' => $error);
    echo json_encode($arr);
    die();
  }
  
  // Drop temporary table to hold points by user
  $sql = "DROP TABLE IF EXISTS `PointsByUser` ; ";

  $result = mysqli_query($link, $sql);
  if (!$result)
  {
    $error = 'Error dropping points by user temporary table: <br />' . mysqli_error($link) . '<br /><br />' . $sql;
    
    header('Content-type: application/json');
    $arr = array('result' => 'No', 'message' => $error);
    echo json_encode($arr);
    die();
  }
  
  // Create temporary table to hold points by user
  $sql = "CREATE TEMPORARY TABLE `PointsByUser` (
          `UserID` INT NOT NULL,
          `DisplayName` VARCHAR(100) NOT NULL,
          `ResultPoints` DECIMAL(6,2) NOT NULL,
          `ScorePoints` DECIMAL(6,2) NOT NULL,
          `TotalPoints` DECIMAL(6,2) NOT NULL) ; ";

  $result = mysqli_query($link, $sql);
  if (!$result)
  {
    $error = 'Error creating points by user temporary table: <br />' . mysqli_error($link) . '<br /><br />' . $sql;
    
    header('Content-type: application/json');
    $arr = array('result' => 'No', 'message' => $error);
    echo json_encode($arr);
    die();
  }
  
  // Add points by user data to temporary table
  $sql = "INSERT INTO `PointsByUser`
          SELECT
            tmp.`UserID`,
            tmp.`DisplayName`,
            SUM(tmp.`ResultPoints`) AS `ResultPoints`,
            SUM(tmp.`ScorePoints`) AS `ScorePoints`,
            SUM(tmp.`TotalPoints`) AS `TotalPoints`
            
          FROM
            (SELECT
              u.`UserID`,
              IFNULL(u.`DisplayName`,CONCAT(u.`FirstName`,' ',u.`LastName`)) AS `DisplayName`,
              IFNULL(po.`ResultPoints`,0) AS `ResultPoints`,
              IFNULL(po.`ScorePoints`,0) AS `ScorePoints`,
              IFNULL(po.`TotalPoints`,0) AS `TotalPoints`

            FROM `User` u
              
              LEFT JOIN
                (SELECT `MatchID`, `UserID`
                FROM `Match`, `User`
                WHERE `ResultPostedBy` IS NOT NULL AND `StageID` IN (" . $stageStr . ")) mu
                  ON mu.`UserID` = u.`UserID`
            
              LEFT JOIN `Points` po ON
                po.`ScoringSystemID` = " . $scoringSystem . "
                AND po.`UserID` = mu.`UserID`
                AND po.`MatchID` = mu.`MatchID`) tmp

          GROUP BY tmp.`DisplayName`; ";
  
  $result = mysqli_query($link, $sql);
  if (!$result)
  {
    $error = 'Error adding points by user data to temporary table: <br />' . mysqli_error($link) . '<br /><br />' . $sql;
    
    header('Content-type: application/json');
    $arr = array('result' => 'No', 'message' => $error);
    echo json_encode($arr);
    die();
  }
  
  // Drop 2nd temporary table to hold points by user
  $sql = "DROP TABLE IF EXISTS `PointsByUser2` ; ";

  $result = mysqli_query($link, $sql);
  if (!$result)
  {
    $error = 'Error dropping 2nd points by user temporary table: <br />' . mysqli_error($link) . '<br /><br />' . $sql;
    
    header('Content-type: application/json');
    $arr = array('result' => 'No', 'message' => $error);
    echo json_encode($arr);
    die();
  }
  
  // Create 2nd temporary table to hold points by user
  $sql = "CREATE TEMPORARY TABLE `PointsByUser2` SELECT * FROM `PointsByUser`; ";
  
  $result = mysqli_query($link, $sql);
  if (!$result)
  {
    $error = 'Error creating 2nd points by user temporary table: <br />' . mysqli_error($link) . '<br /><br />' . $sql;
    
    header('Content-type: application/json');
    $arr = array('result' => 'No', 'message' => $error);
    echo json_encode($arr);
    die();
  }
  
  // Drop 3rd temporary table to hold points by user
  $sql = "DROP TABLE IF EXISTS `PointsByUser3` ; ";

  $result = mysqli_query($link, $sql);
  if (!$result)
  {
    $error = 'Error dropping 3rd points by user temporary table: <br />' . mysqli_error($link) . '<br /><br />' . $sql;
    
    header('Content-type: application/json');
    $arr = array('result' => 'No', 'message' => $error);
    echo json_encode($arr);
    die();
  }
  
  // Create 3rd temporary table to hold points by user
  $sql = "CREATE TEMPORARY TABLE `PointsByUser3` SELECT * FROM `PointsByUser`; ";
  
  $result = mysqli_query($link, $sql);
  if (!$result)
  {
    $error = 'Error creating 3rd points by user temporary table: <br />' . mysqli_error($link) . '<br /><br />' . $sql;
    
    header('Content-type: application/json');
    $arr = array('result' => 'No', 'message' => $error);
    echo json_encode($arr);
    die();
  }
  
  // Final query
  $sql = "SELECT
          (SELECT COUNT(*) + 1
          FROM `PointsByUser2` pbu2
          WHERE pbu2.`TotalPoints` > pbu.`TotalPoints`) AS `Rank`,
          (SELECT COUNT(*)
          FROM `PointsByUser3` pbu3
          WHERE pbu3.`TotalPoints` = pbu.`TotalPoints`) AS `RankCount`,
          pbu.*,
          sm.`Submitted`,
          sm.`NotSubmitted`
          
        FROM `PointsByUser` pbu
          INNER JOIN `SubmittedMatches` sm ON sm.`UserID` = pbu.`UserID`

        ORDER BY
          pbu.`TotalPoints` DESC,
          pbu.`ScorePoints` DESC,
          pbu.`ResultPoints` DESC,
          pbu.`DisplayName` ASC;";

  $result = mysqli_query($link, $sql);
  if (!$result)
  {
    $error = 'Error fetching league table: <br />' . mysqli_error($link) . '<br /><br />' . $sql;
    
    header('Content-type: application/json');
    $arr = array('result' => 'No', 'message' => $error);
    echo json_encode($arr);
    die();
  }
  
  // Build array of outputs 
  while ($row = mysqli_fetch_array($result))
  {
    $out[] = array(
      'rank' => $row['Rank'],
      'rankCount' => $row['RankCount'],
      'name' => $row['DisplayName'],
      'submitted' => $row['Submitted'],
      'notSubmitted' => $row['NotSubmitted'],
      'results' => $row['ResultPoints'],
      'scores' => ($row['ScorePoints'] / 2),
      'totalPoints' => $row['TotalPoints']);
  }
  
  return $out;
}

// Generate data for graphs
function getGraphData ($scoringSystem = 1) {
  
  // Get DB connection
  include $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';
  
  // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
  // Get data, only grab matches with submitted results
  // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
  
  // Create temporary table to hold cumulative points by match & user 
  $sql = "CREATE TEMPORARY TABLE `CumulativePointsByMatchUser` (
          `MatchID` INT NOT NULL,
          `UserID` INT NOT NULL,
          `Points` DECIMAL(6,2) NOT NULL) ; ";

  $result = mysqli_query($link, $sql);
  if (!$result) {
    $error = 'Error creating cumulative points by match & user temporary table: <br />' . mysqli_error($link) . '<br /><br />' . $sql;
    
    header('Content-type: application/json');
    $arr = array('result' => 'No', 'message' => $error);
    echo json_encode($arr);
    die();
  }
  
  // Add cumulative points by match & user data to temporary table
  $sql = "INSERT INTO `CumulativePointsByMatchUser`
          SELECT
            m.`MatchID`,
            tmp.`UserID`,
            SUM(tmp.`Points`) AS `Points`
          
          FROM
            (SELECT
                mu.`MatchID`,
                mu.`UserID`,
                IFNULL(po.`TotalPoints`,0) AS `Points`

            FROM
              (SELECT m.`MatchID`, u.`UserID`
              FROM `Match` m, `User` u
              WHERE m.`ResultPostedBy` IS NOT NULL) mu
              
              LEFT JOIN `Points` po ON
                po.`ScoringSystemID` = " . $scoringSystem . "
                AND po.`UserID` = mu.`UserID`
                AND po.`MatchID` = mu.`MatchID`) tmp
          
          INNER JOIN `Match` m ON
            m.`MatchID` >= tmp.`MatchID`
            AND m.`ResultPostedBy` IS NOT NULL
          
          GROUP BY
            m.`MatchID`,
            tmp.`UserID`;";

  $result = mysqli_query($link, $sql);
  if (!$result) {
    $error = 'Error adding cumulative points by match & user data to temporary table: <br />' . mysqli_error($link) . '<br /><br />' . $sql;
    
    header('Content-type: application/json');
    $arr = array('result' => 'No', 'message' => $error);
    echo json_encode($arr);
    die();
  }
  
  // Create 2nd temporary table to hold points by user
  $sql = "CREATE TEMPORARY TABLE `CumulativePointsByMatchUser2` SELECT * FROM `CumulativePointsByMatchUser`; ";
  
  $result = mysqli_query($link, $sql);
  if (!$result) {
    $error = 'Error creating 2nd points by user temporary table: <br />' . mysqli_error($link) . '<br /><br />' . $sql;
    
    header('Content-type: application/json');
    $arr = array('result' => 'No', 'message' => $error);
    echo json_encode($arr);
    die();
  }
  
  // Final query
  $sql = "SELECT
        (SELECT COUNT(*) + 1
        FROM `CumulativePointsByMatchUser2` cpmu2
        WHERE cpmu2.`Points` > cpmu.`Points`
          AND cpmu2.`MatchID` = cpmu.`MatchID`) AS `Rank`,
        IFNULL(u.`DisplayName`,CONCAT(u.`FirstName`,' ',u.`LastName`)) AS `DisplayName`,
        CONCAT(IFNULL(ht.`Name`,trht.`Name`),' vs. ',IFNULL(at.`Name`,trat.`Name`)) AS `Match`,
        cpmu.*
      
      FROM `CumulativePointsByMatchUser` cpmu
        INNER JOIN `Match` m ON m.`MatchID` = cpmu.`MatchID`
        INNER JOIN `User` u ON u.`UserID` = cpmu.`UserID`
        INNER JOIN `TournamentRole` trht ON trht.`TournamentRoleID` = m.`HomeTeamID`
        LEFT JOIN `Team` ht ON ht.`TeamID` = trht.`TeamID`
        INNER JOIN `TournamentRole` trat ON trat.`TournamentRoleID` = m.`AwayTeamID`
        LEFT JOIN `Team` at ON at.`TeamID` = trat.`TeamID`
      
      ORDER BY cpmu.`MatchID` ASC, cpmu.`UserID` ASC";

  $result = mysqli_query($link, $sql);
  if (!$result) {
    $error = 'Error fetching match details: <br />' . mysqli_error($link) . '<br /><br />' . $sql;
    
    header('Content-type: application/json');
    $arr = array('result' => 'No', 'message' => $error);
    echo json_encode($arr);
    die();
  }

  while ($row = mysqli_fetch_array($result)) {
    $out[] = array(
      'matchID' => $row['MatchID'],
      'match' => $row['Match'],
      'rank' => $row['Rank'],
      'userID' => $row['UserID'],
      'name' => $row['DisplayName'],
      'points' => $row['Points']);
  }
  
  return $out;
}

?>