<?php

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
// Includes
// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/includesfile.inc.php';

// Send e-mail of the results from the posted match
function sendResultsEmail ($matchID) {

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
  // Get match details
  // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
  $sql = "
    SELECT
      ht.`Name` AS `HomeTeam`
      ,at.`Name` AS `AwayTeam`
      ,ht.`ShortName` AS `HomeTeamS`
      ,at.`ShortName` AS `AwayTeamS`
      ,m.`HomeTeamPoints`
      ,m.`AwayTeamPoints`
      ,m.`GameWeekID`

    FROM `Match` m
      INNER JOIN `Team` ht ON
        ht.`TeamID` = m.`HomeTeamID`
      INNER JOIN `Team` at ON
        at.`TeamID` = m.`AwayTeamID`

    WHERE m.`MatchID` = " . $matchID . ";";

  $result = mysqli_query($link, $sql);
  if (!$result) {
    $error = 'Error getting match details: <br />' . mysqli_error($link) . '<br /><br />' . $sql;

    header('Content-type: application/json');
    $arr = array('result' => 'No', 'message' => $error);
    echo json_encode($arr);
    die();
  }

  // Get the data
  $row = mysqli_fetch_assoc($result);

  // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
  // Get played matches this week
  // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
  $sql = "
    SELECT COUNT(*) AS `Played`

    FROM `Match` m

    WHERE m.`GameWeekID` = " . $row['GameWeekID'] . "
      AND m.`ResultPostedBy` IS NOT NULL;";

  $result = mysqli_query($link, $sql);
  if (!$result) {
    $error = 'Error getting count of posted matches: <br />' . mysqli_error($link) . '<br /><br />' . $sql;

    header('Content-type: application/json');
    $arr = array('result' => 'No', 'message' => $error);
    echo json_encode($arr);
    die();
  }

  // Get the data
  $gwPlayed = mysqli_fetch_assoc($result)['Played'];

  // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
  // Get league table details
  // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
  $resultLeague = getLeagueTable();
  $resultGWLeague = getLeagueTable($row['GameWeekID']);

  // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
  // Get match result details
  // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
  $sql = "
    SELECT
      mu.`DisplayName`
      ,IFNULL(p.`HomeTeamPoints`,'No prediction') AS `HomeTeamPoints`
      ,IFNULL(p.`AwayTeamPoints`,'No prediction') AS `AwayTeamPoints`
      ,po.`ResultPoints`
      ,po.`ScorePoints`
      ,po.`TotalPoints`
      ,po2.`TotalPoints` AS `DistancePoints`

    FROM
      (SELECT `MatchID`, `UserID`, `DisplayName`
      FROM `Match`, `User`
      WHERE `MatchID` = " . $matchID . ") mu

      LEFT JOIN `Prediction` p ON
        p.`UserID` = mu.`UserID`
        AND p.`MatchID` = mu.`MatchID`

      INNER JOIN `Points` po ON
        po.`MatchID` = mu.`MatchID`
        AND po.`UserID` = mu.`UserID`
        AND po.`ScoringSystemID` = 1

      INNER JOIN `Points` po2 ON
        po2.`MatchID` = mu.`MatchID`
        AND po2.`UserID` = mu.`UserID`
        AND po2.`ScoringSystemID` = 2

    ORDER BY
       po.`TotalPoints` DESC
      ,po2.`TotalPoints` DESC
      ,(p.`HomeTeamPoints` - p.`AwayTeamPoints`) DESC
      ,p.`HomeTeamPoints` DESC;";

  $resultMatch = mysqli_query($link, $sql);
  if (!$resultMatch) {
    $error = 'Error getting match result details: <br />' . mysqli_error($link) . '<br /><br />' . $sql;

    header('Content-type: application/json');
    $arr = array('result' => 'No', 'message' => $error);
    echo json_encode($arr);
    die();
  }

  // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
  // Email To Addresses
  // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
  $toEmail='jrpl@googlegroups.com';

  // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
  // Email Subject
  // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
  $emailSubject = 'Match results for ' . $row['HomeTeam'] . ' vs. '. $row['AwayTeam'];

  // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
  // CSS formatting
  // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
  $css = 'standard';

  // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
  // Body - write heading table
  // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
  $heading = '<!-- Title -->' . chr(13);
  $heading .= '<tr>' . chr(13);
  $heading .= '<td colspan="5"
                   style="font-family: Helvetica, arial, sans-serif;
                          font-size: 30px;
                          color: #333333;
                          text-align:center;
                          line-height: 30px;"
                   st-title="fulltext-heading">' . chr(13);
  $heading .= 'New result posted' . chr(13);
  $heading .= '</td>' . chr(13);
  $heading .= '</tr>' . chr(13);
  $heading .= '<!-- End of Title -->' . chr(13);
  $heading .= '<!-- spacing -->' . chr(13);
  $heading .= '<tr>' . chr(13);
  $heading .= '<td colspan="5" width="100%" height="20"
                   style="font-size:1px;
                          line-height:1px;
                          mso-line-height-rule: exactly;">&nbsp;</td>' . chr(13);
  $heading .= '</tr>' . chr(13);
  $heading .= '<!-- End of spacing -->' . chr(13);
  $heading .= '<!-- content -->' . chr(13);
  $heading .= '<tr>' . chr(13);
  $heading .= '<td>' . chr(13);
  $heading .= '<img border="0"
                    style="vertical-align: middle;"
                    src="http://';
  if (getenv('ENVIR') == 'Production') {
    $heading .= 'www';
  } else if (getenv('ENVIR') == 'Test') {
    $heading .= 'test';
  } else if (getenv('ENVIR') == 'Development') {
    $heading .= 'dev';
  } else {
    $heading .= 'www';
  }
  $heading .= '.julianrimet.com/assets/img/flags/';
  $heading .= strtolower($row['HomeTeamS']) . '.png" />' . chr(13);
  $heading .= '</td>' . chr(13);
  $heading .= '<td width="48%"
                   style="white-space: nowrap;
                          font-family: Helvetica, arial, sans-serif;
                          font-size: 25px;
                          color: #333333;
                          text-align:right;
                          line-height: 30px;"
                   st-content="fulltext-content">' . chr(13);
  $heading .= $row['HomeTeam'] . chr(13);
  $heading .= '</td>' . chr(13);
  $heading .= '<td style="white-space: nowrap;
                          font-family: Helvetica, arial, sans-serif;
                          font-size: 25px;
                          color: #333333;
                          text-align:center;
                          line-height: 30px;"
                   st-content="fulltext-content">' . chr(13);
  $heading .= $row['HomeTeamPoints'];
  $heading .= '&nbsp;-&nbsp;';
  $heading .= $row['AwayTeamPoints'] . chr(13);
  $heading .= '</td>' . chr(13);
  $heading .= '<td width="48%"
                   style="white-space: nowrap;
                          font-family: Helvetica, arial, sans-serif;
                          font-size: 25px;
                          color: #333333;
                          text-align:left;
                          line-height: 30px;"
                   st-content="fulltext-content">' . chr(13);
  $heading .= $row['AwayTeam'] . chr(13);
  $heading .= '</td>' . chr(13);
  $heading .= '<td>' . chr(13);
  $heading .= '<img border="0"
                    style="vertical-align: middle;"
                    src="http://';
  if (getenv('ENVIR') == 'Production') {
    $heading .= 'www';
  } else if (getenv('ENVIR') == 'Test') {
    $heading .= 'test';
  } else if (getenv('ENVIR') == 'Development') {
    $heading .= 'dev';
  } else {
    $heading .= 'www';
  }
  $heading .= '.julianrimet.com/assets/img/flags/';
  $heading .= strtolower($row['AwayTeamS']) . '.png" />' . chr(13);
  $heading .= '</td>' . chr(13);
  $heading .= '</tr>' . chr(13);
  $heading .= '<!-- End of content -->' . chr(13);

  // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
  // Body - write match details table
  // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
  $match = '<!-- Title -->' . chr(13);
  $match .= '<tr>' . chr(13);
  $match .= '<td colspan="6"
                 style="font-family: Helvetica, arial, sans-serif;
                        font-size: 18px;
                        color: #333333;
                        text-align:center;
                        line-height: 30px;"
                 st-title="fulltext-heading">' . chr(13);
  $match .= 'Details for match' . chr(13);
  $match .= '</td>' . chr(13);
  $match .= '</tr>' . chr(13);
  $match .= '<!-- End of Title -->' . chr(13);
  $match .= '<!-- spacing -->' . chr(13);
  $match .= '<tr>' . chr(13);
  $match .= '<td colspan="6" width="100%" height="20"
                 style="font-size:1px; line-height:1px;
                        mso-line-height-rule: exactly;">&nbsp;</td>' . chr(13);
  $match .= '</tr>' . chr(13);
  $match .= '<!-- End of spacing -->' . chr(13);
  $match .= '<!-- content -->' . chr(13);
  $match .= '<tr>' . chr(13);
  $match .= '<td st-content="fulltext-content">' . chr(13);
  $match .= '<table border="0" width="100%" cellpadding="4" cellspacing="0"
                    border="0" align="left" class="devicewidth">' . chr(13);
  $match .= '<tr style="background-color: #d3d3d3;">' . chr(13);
  $match .= '<th style="font-family: Helvetica, arial, sans-serif;
                        font-size: 14px;
                        color: #333333;
                        text-align:left;
                        line-height: 16px;
                        border-collapse: collapse;
                        border-bottom: 1px solid #a0a0a0;
                        border-top: 1px solid #a0a0a0;"
                  align="left">Player</th>' . chr(13);
  $match .= '<th style="font-family: Helvetica, arial, sans-serif;
                        font-size: 14px;
                        color: #333333;
                        text-align:left;
                        line-height: 16px;
                        border-collapse: collapse;
                        border-bottom: 1px solid #a0a0a0;
                        border-top: 1px solid #a0a0a0;"
                  align="left">Prediction</th>' . chr(13);
  $match .= '<th style="font-family: Helvetica, arial, sans-serif;
                        font-size: 14px;
                        color: #333333;
                        text-align:left;
                        line-height: 16px;
                        border-collapse: collapse;
                        border-bottom: 1px solid #a0a0a0;
                        border-top: 1px solid #a0a0a0;"
                  align="left">&nbsp;</th>' . chr(13);
  $match .= '<th style="font-family: Helvetica, arial, sans-serif;
                        font-size: 14px;
                        color: #333333;
                        text-align: center;
                        line-height: 16px;
                        border-collapse: collapse;
                        border-bottom: 1px solid #a0a0a0;
                        border-top: 1px solid #a0a0a0;"
                  align="left">Result Points</th>' . chr(13);
  $match .= '<th style="font-family: Helvetica, arial, sans-serif;
                        font-size: 14px;
                        color: #333333;
                        text-align: center;
                        line-height: 16px;
                        border-collapse: collapse;
                        border-bottom: 1px solid #a0a0a0;
                        border-top: 1px solid #a0a0a0;"
                  align="left">Score Points</th>' . chr(13);
  $match .= '<th style="font-family: Helvetica, arial, sans-serif;
                        font-size: 14px;
                        color: #333333;
                        text-align: center;
                        line-height: 16px;
                        border-collapse: collapse;
                        border-bottom: 1px solid #a0a0a0;
                        border-top: 1px solid #a0a0a0;"
                  align="left">Total Points</th>' . chr(13);
  $match .= '<th style="font-family: Helvetica, arial, sans-serif;
                        font-size: 14px;
                        color: #333333;
                        text-align: center;
                        line-height: 16px;
                        border-collapse: collapse;
                        border-bottom: 1px solid #a0a0a0;
                        border-top: 1px solid #a0a0a0;"
                  align="left">Distance</th>' . chr(13);
  $match .= '</tr>' . chr(13);

  // Counter for striped rows
  $i = 0;

  while ($rowMatch = mysqli_fetch_array($resultMatch)) {

    if($i == 1) {
      $match .= '<tr style="background-color: #f4ecdc;">' . chr(13);
      $i = 2;
    } else{
      $match .= '<tr>' . chr(13);
      $i = 1;
    }
    $match .= '<td style="font-family: Helvetica, arial, sans-serif;
                          font-size: 14px;
                          color: #666666;
                          text-align:left;
                          line-height: 16px;
                          white-space: nowrap;
                          vertical-align: top;
                          border-collapse: collapse;
                          border-bottom: 1px solid #b7a075;"
                   align="left">' . $rowMatch['DisplayName'] . '</td>' . chr(13);
    $match .= '<td style="font-family: Helvetica, arial, sans-serif;
                          font-size: 14px;
                          color: #666666;
                          text-align:left;
                          line-height: 16px;
                          white-space: nowrap;
                          vertical-align: top;
                          border-collapse: collapse;
                          border-bottom: 1px solid #b7a075;"
                   align="left">';
    if ($rowMatch['HomeTeamPoints'] == 'No prediction') {
      $match .= 'No prediction<br/>' . chr(13);
    } else {
      if ($rowMatch['HomeTeamPoints'] > $rowMatch['AwayTeamPoints']) {
        $match .= $row['HomeTeam'] . ' to win<br/>' . chr(13);
        $match .= $rowMatch['HomeTeamPoints'];
        $match .= '&nbsp;-&nbsp;';
        $match .= $rowMatch['AwayTeamPoints'];
      } elseif ($rowMatch['AwayTeamPoints'] > $rowMatch['HomeTeamPoints']) {
        $match .= $row['AwayTeam'] . ' to win<br/>' . chr(13);
        $match .= $rowMatch['AwayTeamPoints'];
        $match .= '&nbsp;-&nbsp;';
        $match .= $rowMatch['HomeTeamPoints'];
      } else {
        $match .= 'Draw<br/>' . chr(13);
        $match .= $rowMatch['HomeTeamPoints'];
        $match .= '&nbsp;-&nbsp;';
        $match .= $rowMatch['AwayTeamPoints'];
      }
    }
    $match .= '</td>' . chr(13);
    $match .= '<td style="font-family: Helvetica, arial, sans-serif;
                          font-size: 14px;
                          color: #666666;
                          text-align:left;
                          line-height: 16px;
                          white-space: nowrap;
                          vertical-align: top;
                          border-collapse: collapse;
                          border-bottom: 1px solid #b7a075;"
                   align="left">&nbsp;</td>' . chr(13);
    if ($rowMatch['ResultPoints'] == 0) {
      $match .= '<td style="font-family: Helvetica, arial, sans-serif;
                            font-size: 14px;
                            color: #666666;
                            text-align:center;
                            line-height: 16px;
                            white-space: nowrap;
                            vertical-align: top;
                            border-collapse: collapse;
                            border-bottom: 1px solid #b7a075;"
                     align="center">-</td>' . chr(13);
    } else {
      $match .= '<td style="font-family: Helvetica, arial, sans-serif;
                            font-size: 14px;
                            color: #666666;
                            text-align:center;
                            line-height: 16px;
                            white-space: nowrap;
                            vertical-align: top;
                            border-collapse: collapse;
                            border-bottom: 1px solid #b7a075;"
                     align="center">' . (int)$rowMatch['ResultPoints'] . '</td>' . chr(13);
    }
    if ($rowMatch['ScorePoints'] == 0) {
      $match .= '<td style="font-family: Helvetica, arial, sans-serif;
                            font-size: 14px;
                            color: #666666;
                            text-align:center;
                            line-height: 16px;
                            white-space: nowrap;
                            vertical-align: top;
                            border-collapse: collapse;
                            border-bottom: 1px solid #b7a075;"
                     align="center">-</td>' . chr(13);
    } else {
      $match .= '<td style="font-family: Helvetica, arial, sans-serif;
                            font-size: 14px;
                            color: #666666;
                            text-align:center;
                            line-height: 16px;
                            white-space: nowrap;
                            vertical-align: top;
                            border-collapse: collapse;
                            border-bottom: 1px solid #b7a075;"
                     align="center">' . (int)$rowMatch['ScorePoints'] . '</td>' . chr(13);
    }
    if ($rowMatch['TotalPoints'] == 0) {
      $match .= '<td style="font-family: Helvetica, arial, sans-serif;
                            font-size: 14px;
                            color: #666666;
                            text-align:center;
                            line-height: 16px;
                            white-space: nowrap;
                            vertical-align: top;
                            border-collapse: collapse;
                            border-bottom: 1px solid #b7a075;"
                     align="center">-</td>' . chr(13);
    } else {
      $match .= '<td style="font-family: Helvetica, arial, sans-serif;
                            font-size: 14px;
                            color: #666666;
                            text-align:center;
                            line-height: 16px;
                            white-space: nowrap;
                            vertical-align: top;
                            border-collapse: collapse;
                            border-bottom: 1px solid #b7a075;"
                     align="center">' . (int)$rowMatch['TotalPoints'] . '</td>' . chr(13);
    }
    if ($rowMatch['DistancePoints'] == 0) {
      $match .= '<td style="font-family: Helvetica, arial, sans-serif;
                            font-size: 14px;
                            color: #666666;
                            text-align:center;
                            line-height: 16px;
                            white-space: nowrap;
                            vertical-align: top;
                            border-collapse: collapse;
                            border-bottom: 1px solid #b7a075;"
                     align="center">-</td>' . chr(13);
    } else {
      $match .= '<td style="font-family: Helvetica, arial, sans-serif;
                            font-size: 14px;
                            color: #666666;
                            text-align:center;
                            line-height: 16px;
                            white-space: nowrap;
                            vertical-align: top;
                            border-collapse: collapse;
                            border-bottom: 1px solid #b7a075;"
                     align="center">' . $rowMatch['DistancePoints'] . '</td>' . chr(13);
    }

    $match .= '</tr>' . chr(13);

  }

  $match .= '</table>' . chr(13);
  $match .= '</td>' . chr(13);
  $match .= '</tr>' . chr(13);
  $match .= '<!-- End of content -->' . chr(13);

  // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
  // Body - write standard league table
  // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
  $league = '<!-- Title -->' . chr(13);
  $league .= '<tr>' . chr(13);
  $league .= '<td colspan="6"
                  style="font-family: Helvetica, arial, sans-serif;
                         font-size: 18px;
                         color: #333333;
                         text-align:center;
                         line-height: 30px;"
                  st-title="fulltext-heading">' . chr(13);
  $league .= 'Current League Table' . chr(13);
  $league .= '</td>' . chr(13);
  $league .= '</tr>' . chr(13);
  $league .= '<!-- End of Title -->' . chr(13);
  $league .= '<!-- spacing -->' . chr(13);
  $league .= '<tr>' . chr(13);
  $league .= '<td colspan="6" width="100%" height="20"
                  style="font-size:1px;
                         line-height:1px;
                         mso-line-height-rule: exactly;">&nbsp;</td>' . chr(13);
  $league .= '</tr>' . chr(13);
  $league .= '<!-- End of spacing -->' . chr(13);
  $league .= '<!-- content -->' . chr(13);
  $league .= '<tr>' . chr(13);
  $league .= '<td st-content="fulltext-content">' . chr(13);
  $league .= '<table border="0" width="100%" cellpadding="4" cellspacing="0"
                     border="0" align="left" class="devicewidth">' . chr(13);
  $league .= '<tr style="background-color: #d3d3d3;">' . chr(13);
  $league .= '<th style="font-family: Helvetica, arial, sans-serif;
                         font-size: 14px;
                         color: #333333;
                         text-align:left;
                         line-height: 16px;
                         border-collapse: collapse;
                         border-bottom: 1px solid #a0a0a0;
                         border-top: 1px solid #a0a0a0;"
                  align="left">&nbsp;</th>' . chr(13);
  $league .= '<th style="font-family: Helvetica, arial, sans-serif;
                         font-size: 14px;
                         color: #333333;
                         text-align:left;
                         line-height: 16px;
                         border-collapse: collapse;
                         border-bottom: 1px solid #a0a0a0;
                         border-top: 1px solid #a0a0a0;"
                  align="left">Player</th>' . chr(13);
  $league .= '<th style="font-family: Helvetica, arial, sans-serif;
                         font-size: 14px;
                         color: #333333;
                         text-align: center;
                         line-height: 16px;
                         border-collapse: collapse;
                         border-bottom: 1px solid #a0a0a0;
                         border-top: 1px solid #a0a0a0;"
                  align="left">Result Points</th>' . chr(13);
  $league .= '<th style="font-family: Helvetica, arial, sans-serif;
                         font-size: 14px;
                         color: #333333;
                         text-align: center;
                         line-height: 16px;
                         border-collapse: collapse;
                         border-bottom: 1px solid #a0a0a0;
                         border-top: 1px solid #a0a0a0;"
                  align="left">Score Points</th>' . chr(13);
  $league .= '<th style="font-family: Helvetica, arial, sans-serif;
                         font-size: 14px;
                         color: #333333;
                         text-align: center;
                         line-height: 16px;
                         border-collapse: collapse;
                         border-bottom: 1px solid #a0a0a0;
                         border-top: 1px solid #a0a0a0;"
                  align="left">Overall Points</th>' . chr(13);
  $league .= '<th style="font-family: Helvetica, arial, sans-serif;
                         font-size: 14px;
                         color: #333333;
                         text-align: center;
                         line-height: 16px;
                         border-collapse: collapse;
                         border-bottom: 1px solid #a0a0a0;
                         border-top: 1px solid #a0a0a0;"
                  align="left">Distance</th>' . chr(13);
  $league .= '</tr>' . chr(13);

  // Counter for striped rows
  $i = 0;

  foreach ($resultLeague as $rowLeague) {

    if($i == 1) {
      $league .= '<tr style="background-color: #f4ecdc;">' . chr(13);
      $i = 2;
    } else{
      $league .= '<tr>' . chr(13);
      $i = 1;
    }

    $league .= '<td style="font-family: Helvetica, arial, sans-serif;
                           font-size: 14px;
                           color: #666666;
                           text-align:left;
                           line-height: 16px;
                           white-space: nowrap;
                           vertical-align: top;
                           border-collapse: collapse;
                           border-bottom: 1px solid #b7a075;"
                    align="left">';
    if ($rowLeague['rankCount'] > 1) {
      $league .= $rowLeague['rank'] . '=</td>' . chr(13);
    } else {
      $league .= $rowLeague['rank'] . '</td>' . chr(13);
    }
    $league .= '<td style="font-family: Helvetica, arial, sans-serif;
                           font-size: 14px;
                           color: #666666;
                           text-align:left;
                           line-height: 16px;
                           white-space: nowrap;
                           vertical-align: top;
                           border-collapse: collapse;
                           border-bottom: 1px solid #b7a075;"
                    align="left">' . $rowLeague['name'] . '</td>' . chr(13);
    if ($rowLeague['results'] == 0) {
      $league .= '<td style="font-family: Helvetica, arial, sans-serif;
                             font-size: 14px;
                             color: #666666;
                             text-align:center;
                             line-height: 16px;
                             white-space: nowrap;
                             vertical-align: top;
                             border-collapse: collapse;
                             border-bottom: 1px solid #b7a075;"
                      align="center">-</td>' . chr(13);
    } else {
      $league .= '<td style="font-family: Helvetica, arial, sans-serif;
                             font-size: 14px;
                             color: #666666;
                             text-align:center;
                             line-height: 16px;
                             white-space: nowrap;
                             vertical-align: top;
                             border-collapse: collapse;
                             border-bottom: 1px solid #b7a075;"
                      align="center">' . (int)$rowLeague['results'] . '</td>' . chr(13);
    }
    if ($rowLeague['scores'] == 0) {
      $league .= '<td style="font-family: Helvetica, arial, sans-serif;
                             font-size: 14px;
                             color: #666666;
                             text-align:center;
                             line-height: 16px;
                             white-space: nowrap;
                             vertical-align: top;
                             border-collapse: collapse;
                             border-bottom: 1px solid #b7a075;"
                      align="center">-</td>' . chr(13);
    } else {
      $league .= '<td style="font-family: Helvetica, arial, sans-serif;
                             font-size: 14px;
                             color: #666666;
                             text-align: center;
                             line-height: 16px;
                             white-space: nowrap;
                             vertical-align: top;
                             border-collapse: collapse;
                             border-bottom: 1px solid #b7a075;"
                      align="center">' . (int)$rowLeague['scores'] . '</td>' . chr(13);
    }
    if ($rowLeague['totalPoints'] == 0) {
      $league .= '<td style="font-family: Helvetica, arial, sans-serif;
                             font-size: 14px;
                             color: #666666;
                             text-align:center;
                             line-height: 16px;
                             white-space: nowrap;
                             vertical-align: top;
                             border-collapse: collapse;
                             border-bottom: 1px solid #b7a075;"
                      align="center">-</td>' . chr(13);
    } else {
      $league .= '<td style="font-family: Helvetica, arial, sans-serif;
                             font-size: 14px;
                             color: #666666;
                             text-align:center;
                             line-height: 16px;
                             white-space: nowrap;
                             vertical-align: top;
                             border-collapse: collapse;
                             border-bottom: 1px solid #b7a075;"
                      align="center">' . (int)$rowLeague['totalPoints'] . '</td>' . chr(13);
    }
    if ($rowLeague['distancePoints'] == 0) {
      $league .= '<td style="font-family: Helvetica, arial, sans-serif;
                             font-size: 14px;
                             color: #666666;
                             text-align:center;
                             line-height: 16px;
                             white-space: nowrap;
                             vertical-align: top;
                             border-collapse: collapse;
                             border-bottom: 1px solid #b7a075;"
                      align="center">-</td>' . chr(13);
    } else {
      $league .= '<td style="font-family: Helvetica, arial, sans-serif;
                             font-size: 14px;
                             color: #666666;
                             text-align:center;
                             line-height: 16px;
                             white-space: nowrap;
                             vertical-align: top;
                             border-collapse: collapse;
                             border-bottom: 1px solid #b7a075;"
                      align="center">' . $rowLeague['distancePoints'] . '</td>' . chr(13);
    }
    $league .= '</tr>' . chr(13);

  }

  $league .= '</table>' . chr(13);
  $league .= '</td>' . chr(13);
  $league .= '</tr>' . chr(13);
  $league .= '<!-- End of content -->' . chr(13);

  // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
  // Body - write game week league table
  // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
  $leagueGW = '<!-- Title -->' . chr(13);
  $leagueGW .= '<tr>' . chr(13);
  $leagueGW .= '<td colspan="6"
                  style="font-family: Helvetica, arial, sans-serif;
                         font-size: 18px;
                         color: #333333;
                         text-align:center;
                         line-height: 30px;"
                  st-title="fulltext-heading">' . chr(13);
  $leagueGW .= 'Current Game Week League Table' . chr(13);
  $leagueGW .= '</td>' . chr(13);
  $leagueGW .= '</tr>' . chr(13);
  $leagueGW .= '<tr>' . chr(13);
  $leagueGW .= '<td colspan="6"
                  style="font-family: Helvetica, arial, sans-serif;
                         font-size: 14px;
                         color: #333333;
                         text-align:center;
                         line-height: 20px;"
                  st-title="fulltext-heading">' . chr(13);
  $leagueGW .= 'Match ' . $gwPlayed . '  of 10' . chr(13);
  $leagueGW .= '</td>' . chr(13);
  $leagueGW .= '</tr>' . chr(13);
  $leagueGW .= '<!-- End of Title -->' . chr(13);
  $leagueGW .= '<!-- spacing -->' . chr(13);
  $leagueGW .= '<tr>' . chr(13);
  $leagueGW .= '<td colspan="6" width="100%" height="20"
                  style="font-size:1px;
                         line-height:1px;
                         mso-line-height-rule: exactly;">&nbsp;</td>' . chr(13);
  $leagueGW .= '</tr>' . chr(13);
  $leagueGW .= '<!-- End of spacing -->' . chr(13);
  $leagueGW .= '<!-- content -->' . chr(13);
  $leagueGW .= '<tr>' . chr(13);
  $leagueGW .= '<td st-content="fulltext-content">' . chr(13);
  $leagueGW .= '<table border="0" width="100%" cellpadding="4" cellspacing="0"
                     border="0" align="left" class="devicewidth">' . chr(13);
  $leagueGW .= '<tr style="background-color: #d3d3d3;">' . chr(13);
  $leagueGW .= '<th style="font-family: Helvetica, arial, sans-serif;
                         font-size: 14px;
                         color: #333333;
                         text-align:left;
                         line-height: 16px;
                         border-collapse: collapse;
                         border-bottom: 1px solid #a0a0a0;
                         border-top: 1px solid #a0a0a0;"
                  align="left">&nbsp;</th>' . chr(13);
  $leagueGW .= '<th style="font-family: Helvetica, arial, sans-serif;
                         font-size: 14px;
                         color: #333333;
                         text-align:left;
                         line-height: 16px;
                         border-collapse: collapse;
                         border-bottom: 1px solid #a0a0a0;
                         border-top: 1px solid #a0a0a0;"
                  align="left">Player</th>' . chr(13);
  $leagueGW .= '<th style="font-family: Helvetica, arial, sans-serif;
                         font-size: 14px;
                         color: #333333;
                         text-align: center;
                         line-height: 16px;
                         border-collapse: collapse;
                         border-bottom: 1px solid #a0a0a0;
                         border-top: 1px solid #a0a0a0;"
                  align="left">Result Points</th>' . chr(13);
  $leagueGW .= '<th style="font-family: Helvetica, arial, sans-serif;
                         font-size: 14px;
                         color: #333333;
                         text-align: center;
                         line-height: 16px;
                         border-collapse: collapse;
                         border-bottom: 1px solid #a0a0a0;
                         border-top: 1px solid #a0a0a0;"
                  align="left">Score Points</th>' . chr(13);
  $leagueGW .= '<th style="font-family: Helvetica, arial, sans-serif;
                         font-size: 14px;
                         color: #333333;
                         text-align: center;
                         line-height: 16px;
                         border-collapse: collapse;
                         border-bottom: 1px solid #a0a0a0;
                         border-top: 1px solid #a0a0a0;"
                  align="left">Overall Points</th>' . chr(13);
  $leagueGW .= '<th style="font-family: Helvetica, arial, sans-serif;
                         font-size: 14px;
                         color: #333333;
                         text-align: center;
                         line-height: 16px;
                         border-collapse: collapse;
                         border-bottom: 1px solid #a0a0a0;
                         border-top: 1px solid #a0a0a0;"
                  align="left">Distance</th>' . chr(13);
  $leagueGW .= '</tr>' . chr(13);

  // Counter for striped rows
  $i = 0;

  foreach ($resultGWLeague as $rowGWLeague) {

    if($i == 1) {
      $leagueGW .= '<tr style="background-color: #f4ecdc;">' . chr(13);
      $i = 2;
    } else{
      $leagueGW .= '<tr>' . chr(13);
      $i = 1;
    }

    $leagueGW .= '<td style="font-family: Helvetica, arial, sans-serif;
                           font-size: 14px;
                           color: #666666;
                           text-align:left;
                           line-height: 16px;
                           white-space: nowrap;
                           vertical-align: top;
                           border-collapse: collapse;
                           border-bottom: 1px solid #b7a075;"
                    align="left">';
    if ($rowGWLeague['rankCount'] > 1) {
      $leagueGW .= $rowGWLeague['rank'] . '=</td>' . chr(13);
    } else {
      $leagueGW .= $rowGWLeague['rank'] . '</td>' . chr(13);
    }
    $leagueGW .= '<td style="font-family: Helvetica, arial, sans-serif;
                           font-size: 14px;
                           color: #666666;
                           text-align:left;
                           line-height: 16px;
                           white-space: nowrap;
                           vertical-align: top;
                           border-collapse: collapse;
                           border-bottom: 1px solid #b7a075;"
                    align="left">' . $rowGWLeague['name'] . '</td>' . chr(13);
    if ($rowGWLeague['results'] == 0) {
      $leagueGW .= '<td style="font-family: Helvetica, arial, sans-serif;
                             font-size: 14px;
                             color: #666666;
                             text-align:center;
                             line-height: 16px;
                             white-space: nowrap;
                             vertical-align: top;
                             border-collapse: collapse;
                             border-bottom: 1px solid #b7a075;"
                      align="center">-</td>' . chr(13);
    } else {
      $leagueGW .= '<td style="font-family: Helvetica, arial, sans-serif;
                             font-size: 14px;
                             color: #666666;
                             text-align:center;
                             line-height: 16px;
                             white-space: nowrap;
                             vertical-align: top;
                             border-collapse: collapse;
                             border-bottom: 1px solid #b7a075;"
                      align="center">' . (int)$rowGWLeague['results'] . '</td>' . chr(13);
    }
    if ($rowGWLeague['scores'] == 0) {
      $leagueGW .= '<td style="font-family: Helvetica, arial, sans-serif;
                             font-size: 14px;
                             color: #666666;
                             text-align:center;
                             line-height: 16px;
                             white-space: nowrap;
                             vertical-align: top;
                             border-collapse: collapse;
                             border-bottom: 1px solid #b7a075;"
                      align="center">-</td>' . chr(13);
    } else {
      $leagueGW .= '<td style="font-family: Helvetica, arial, sans-serif;
                             font-size: 14px;
                             color: #666666;
                             text-align: center;
                             line-height: 16px;
                             white-space: nowrap;
                             vertical-align: top;
                             border-collapse: collapse;
                             border-bottom: 1px solid #b7a075;"
                      align="center">' . (int)$rowGWLeague['scores'] . '</td>' . chr(13);
    }
    if ($rowGWLeague['totalPoints'] == 0) {
      $leagueGW .= '<td style="font-family: Helvetica, arial, sans-serif;
                             font-size: 14px;
                             color: #666666;
                             text-align:center;
                             line-height: 16px;
                             white-space: nowrap;
                             vertical-align: top;
                             border-collapse: collapse;
                             border-bottom: 1px solid #b7a075;"
                      align="center">-</td>' . chr(13);
    } else {
      $leagueGW .= '<td style="font-family: Helvetica, arial, sans-serif;
                             font-size: 14px;
                             color: #666666;
                             text-align:center;
                             line-height: 16px;
                             white-space: nowrap;
                             vertical-align: top;
                             border-collapse: collapse;
                             border-bottom: 1px solid #b7a075;"
                      align="center">' . (int)$rowGWLeague['totalPoints'] . '</td>' . chr(13);
    }
    if ($rowGWLeague['distancePoints'] == 0) {
      $leagueGW .= '<td style="font-family: Helvetica, arial, sans-serif;
                             font-size: 14px;
                             color: #666666;
                             text-align:center;
                             line-height: 16px;
                             white-space: nowrap;
                             vertical-align: top;
                             border-collapse: collapse;
                             border-bottom: 1px solid #b7a075;"
                      align="center">-</td>' . chr(13);
    } else {
      $leagueGW .= '<td style="font-family: Helvetica, arial, sans-serif;
                             font-size: 14px;
                             color: #666666;
                             text-align:center;
                             line-height: 16px;
                             white-space: nowrap;
                             vertical-align: top;
                             border-collapse: collapse;
                             border-bottom: 1px solid #b7a075;"
                      align="center">' . $rowGWLeague['distancePoints'] . '</td>' . chr(13);
    }
    $leagueGW .= '</tr>' . chr(13);

  }

  $leagueGW .= '</table>' . chr(13);
  $leagueGW .= '</td>' . chr(13);
  $leagueGW .= '</tr>' . chr(13);
  $leagueGW .= '<!-- End of content -->' . chr(13);

  // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
  // Body - build body array for sendEmail routine
  // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
  $body = array(array('separator','Separator'),
                array('table','Heading',$heading),
                array('separatorHR','Separator'),
                array('table','Current League table',$match),
                array('separatorHR','Separator'),
                array('table','Match details table',$league),
                array('separatorHR','Separator'),
                array('table','Match details table',$leagueGW),
                array('separatorHR','Separator'));

  // Send e-mail
  sendEmail($toEmail,$emailSubject,$css,$body);

  // Update DB to log e-mail being sent
  $sql = "
    UPDATE `Emails`
    SET `ResultsSent` = 1
    WHERE `MatchID` = " . $matchID;

  $resultBody = mysqli_query($link, $sql);
  if (!$resultBody) {
    $error = 'Error updating email sent table: <br />' . mysqli_error($link) . '<br /><br />' . $sql;

    header('Content-type: application/json');
    $arr = array('result' => 'No', 'message' => $error);
    echo json_encode($arr);
    die();
  }

}
