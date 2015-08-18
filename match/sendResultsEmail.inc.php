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
      IFNULL(ht.`Name`,trht.`Name`) AS `HomeTeam`
      ,IFNULL(at.`Name`,trat.`Name`) AS `AwayTeam`
      ,IFNULL(ht.`ShortName`,'') AS `HomeTeamS`
      ,IFNULL(at.`ShortName`,'') AS `AwayTeamS`
      ,m.`HomeTeamPoints`
      ,m.`AwayTeamPoints`

    FROM `Match` m
      INNER JOIN `TournamentRole` trht ON
        trht.`TournamentRoleID` = m.`HomeTeamID`
      LEFT JOIN `Team` ht ON
        ht.`TeamID` = trht.`TeamID`
      INNER JOIN `TournamentRole` trat ON
        trat.`TournamentRoleID` = m.`AwayTeamID`
      LEFT JOIN `Team` at ON
        at.`TeamID` = trat.`TeamID`

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
  // Get league table details
  // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
  $resultLeague = getLeagueTable(1);

  // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
  // Get match result details
  // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
  $sql = "
    SELECT
      mu.`DisplayName`
      ,IFNULL(p.`HomeTeamPoints`,'No prediction') AS `HomeTeamPoints`
      ,IFNULL(p.`AwayTeamPoints`,'No prediction') AS `AwayTeamPoints`
      ,IFNULL(po.`TotalPoints`,0) AS `TotalPoints`

    FROM
      (SELECT `MatchID`, `UserID`, `DisplayName`
      FROM `Match`, `User`
      WHERE `MatchID` = " . $matchID . ") mu

      LEFT JOIN `Prediction` p ON
        p.`UserID` = mu.`UserID`
        AND p.`MatchID` = mu.`MatchID`

      LEFT JOIN `Points` po ON
        po.`ScoringSystemID` = 1
        AND po.`MatchID` = p.`MatchID`
        AND po.`UserID` = p.`UserID`

    ORDER BY
      po.`TotalPoints` DESC
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
  $heading .= '<td colspan="5" style="font-family: Helvetica, arial, sans-serif; font-size: 30px; color: #333333; text-align:center; line-height: 30px;" st-title="fulltext-heading">' . chr(13);
  $heading .= 'New result posted' . chr(13);
  $heading .= '</td>' . chr(13);
  $heading .= '</tr>' . chr(13);
  $heading .= '<!-- End of Title -->' . chr(13);
  $heading .= '<!-- spacing -->' . chr(13);
  $heading .= '<tr>' . chr(13);
  $heading .= '<td colspan="5" width="100%" height="20" style="font-size:1px; line-height:1px; mso-line-height-rule: exactly;">&nbsp;</td>' . chr(13);
  $heading .= '</tr>' . chr(13);
  $heading .= '<!-- End of spacing -->' . chr(13);
  $heading .= '<!-- content -->' . chr(13);
  $heading .= '<tr>' . chr(13);
  $heading .= '<td>' . chr(13);
  $heading .= tableBorder('<img border="0" style="vertical-align: middle;" src="http://www.julianrimet.com/assets/img/flags/' . strtolower($row['HomeTeamS']) . '.png" />') . chr(13);
  $heading .= '</td>' . chr(13);
  $heading .= '<td width="48%" style="white-space: nowrap; font-family: Helvetica, arial, sans-serif; font-size: 25px; color: #333333; text-align:right; line-height: 30px;" st-content="fulltext-content">' . chr(13);
  $heading .= $row['HomeTeam'] . chr(13);
  $heading .= '</td>' . chr(13);
  $heading .= '<td style="white-space: nowrap; font-family: Helvetica, arial, sans-serif; font-size: 25px; color: #333333; text-align:center; line-height: 30px;" st-content="fulltext-content">' . chr(13);
  $heading .= $row['HomeTeamPoints'] . '&nbsp;-&nbsp;' . $row['AwayTeamPoints'] . chr(13);
  $heading .= '</td>' . chr(13);
  $heading .= '<td width="48%" style="white-space: nowrap; font-family: Helvetica, arial, sans-serif; font-size: 25px; color: #333333; text-align:left; line-height: 30px;" st-content="fulltext-content">' . chr(13);
  $heading .= $row['AwayTeam'] . chr(13);
  $heading .= '</td>' . chr(13);
  $heading .= '<td>' . chr(13);
  $heading .= tableBorder('<img border="0" style="vertical-align: middle;" src="http://www.julianrimet.com/assets/img/flags/' . strtolower($row['AwayTeamS']) . '.png" />') . chr(13);
  $heading .= '</td>' . chr(13);
  $heading .= '</tr>' . chr(13);
  $heading .= '<!-- End of content -->' . chr(13);

  // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
  // Body - write league table
  // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
  $league = '<!-- Title -->' . chr(13);
  $league .= '<tr>' . chr(13);
  $league .= '<td colspan="5" style="font-family: Helvetica, arial, sans-serif; font-size: 18px; color: #333333; text-align:center; line-height: 30px;" st-title="fulltext-heading">' . chr(13);
  $league .= 'Current League Table' . chr(13);
  $league .= '</td>' . chr(13);
  $league .= '</tr>' . chr(13);
  $league .= '<!-- End of Title -->' . chr(13);
  $league .= '<!-- spacing -->' . chr(13);
  $league .= '<tr>' . chr(13);
  $league .= '<td colspan="5" width="100%" height="20" style="font-size:1px; line-height:1px; mso-line-height-rule: exactly;">&nbsp;</td>' . chr(13);
  $league .= '</tr>' . chr(13);
  $league .= '<!-- End of spacing -->' . chr(13);
  $league .= '<!-- content -->' . chr(13);
  $league .= '<tr>' . chr(13);
  $league .= '<td st-content="fulltext-content">' . chr(13);
  $league .= '<table border="0" width="100%" cellpadding="4" cellspacing="0" border="0" align="left" class="devicewidth">' . chr(13);
  $league .= '<tr>' . chr(13);
  $league .= '<th style="font-family: Helvetica, arial, sans-serif; font-size: 14px; color: #333333; text-align:left; line-height: 16px;" align="left">&nbsp;</th>' . chr(13);
  $league .= '<th style="font-family: Helvetica, arial, sans-serif; font-size: 14px; color: #333333; text-align:left; line-height: 16px;" align="left">Player</th>' . chr(13);
  $league .= '<th style="font-family: Helvetica, arial, sans-serif; font-size: 14px; color: #333333; text-align:center; line-height: 16px;" align="center">Results</th>' . chr(13);
  $league .= '<th style="font-family: Helvetica, arial, sans-serif; font-size: 14px; color: #333333; text-align:center; line-height: 16px;" align="center">Exact Scores</th>' . chr(13);
  $league .= '<th style="font-family: Helvetica, arial, sans-serif; font-size: 14px; color: #333333; text-align:center; line-height: 16px;" align="center">Points</th>' . chr(13);
  $league .= '</tr>' . chr(13);

  // Counter for striped rows
  $i = 0;

  foreach ($resultLeague as $rowLeague) {

    if($i == 1) {
      $league .= '<tr style="background-color: #f0f0ff;">' . chr(13);
      $i = 2;
    } else{
      $league .= '<tr>' . chr(13);
      $i = 1;
    }

    $league .= '<td style="font-family: Helvetica, arial, sans-serif; font-size: 14px; color: #666666; text-align:left; line-height: 16px; white-space: nowrap; vertical-align: top;" align="left">' . $rowLeague['rank'] . '</td>' . chr(13);
    $league .= '<td style="font-family: Helvetica, arial, sans-serif; font-size: 14px; color: #666666; text-align:left; line-height: 16px; white-space: nowrap; vertical-align: top;" align="left">' . $rowLeague['name'] . '</td>' . chr(13);
    if ($rowLeague['results'] == 0) {
      $league .= '<td style="font-family: Helvetica, arial, sans-serif; font-size: 14px; color: #666666; text-align:center; line-height: 16px; white-space: nowrap; vertical-align: top;" align="center">-</td>' . chr(13);
    } else {
      $league .= '<td style="font-family: Helvetica, arial, sans-serif; font-size: 14px; color: #666666; text-align:center; line-height: 16px; white-space: nowrap; vertical-align: top;" align="center">' . $rowLeague['results'] . '</td>' . chr(13);
    }
    if ($rowLeague['scores'] == 0) {
      $league .= '<td style="font-family: Helvetica, arial, sans-serif; font-size: 14px; color: #666666; text-align:center; line-height: 16px; white-space: nowrap; vertical-align: top;" align="center">-</td>' . chr(13);
    } else {
      $league .= '<td style="font-family: Helvetica, arial, sans-serif; font-size: 14px; color: #666666; text-align:center; line-height: 16px; white-space: nowrap; vertical-align: top;" align="center">' . $rowLeague['scores'] . '</td>' . chr(13);
    }
    if ($rowLeague['totalPoints'] == 0) {
      $league .= '<td style="font-family: Helvetica, arial, sans-serif; font-size: 14px; color: #666666; text-align:center; line-height: 16px; white-space: nowrap; vertical-align: top;" align="center">-</td>' . chr(13);
    } else {
      $league .= '<td style="font-family: Helvetica, arial, sans-serif; font-size: 14px; color: #666666; text-align:center; line-height: 16px; white-space: nowrap; vertical-align: top;" align="center">' . $rowLeague['totalPoints'] . '</td>' . chr(13);
    }
    $league .= '</tr>' . chr(13);

  }

  $league .= '</table>' . chr(13);
  $league .= '</td>' . chr(13);
  $league .= '</tr>' . chr(13);
  $league .= '<!-- End of content -->' . chr(13);

  // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
  // Body - write match details table
  // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
  $match = '<!-- Title -->' . chr(13);
  $match .= '<tr>' . chr(13);
  $match .= '<td colspan="3" style="font-family: Helvetica, arial, sans-serif; font-size: 18px; color: #333333; text-align:center; line-height: 30px;" st-title="fulltext-heading">' . chr(13);
  $match .= 'Details for match' . chr(13);
  $match .= '</td>' . chr(13);
  $match .= '</tr>' . chr(13);
  $match .= '<!-- End of Title -->' . chr(13);
  $match .= '<!-- spacing -->' . chr(13);
  $match .= '<tr>' . chr(13);
  $match .= '<td colspan="3" width="100%" height="20" style="font-size:1px; line-height:1px; mso-line-height-rule: exactly;">&nbsp;</td>' . chr(13);
  $match .= '</tr>' . chr(13);
  $match .= '<!-- End of spacing -->' . chr(13);
  $match .= '<!-- content -->' . chr(13);
  $match .= '<tr>' . chr(13);
  $match .= '<td st-content="fulltext-content">' . chr(13);
  $match .= '<table border="0" width="100%" cellpadding="4" cellspacing="0" border="0" align="left" class="devicewidth">' . chr(13);
  $match .= '<tr>' . chr(13);
  $match .= '<th style="font-family: Helvetica, arial, sans-serif; font-size: 14px; color: #333333; text-align:left; line-height: 16px;" align="left">Player</th>' . chr(13);
  $match .= '<th style="font-family: Helvetica, arial, sans-serif; font-size: 14px; color: #333333; text-align:left; line-height: 16px;" align="left">Prediction</th>' . chr(13);
  $match .= '<th style="font-family: Helvetica, arial, sans-serif; font-size: 14px; color: #333333; text-align:center; line-height: 16px;" align="center">Points</th>' . chr(13);
  $match .= '</tr>' . chr(13);

  // Counter for striped rows
  $i = 0;

  while ($rowMatch = mysqli_fetch_array($resultMatch)) {

    if($i == 1) {
      $match .= '<tr style="background-color: #f0f0ff;">' . chr(13);
      $i = 2;
    } else{
      $match .= '<tr>' . chr(13);
      $i = 1;
    }
    $match .= '<td style="font-family: Helvetica, arial, sans-serif; font-size: 14px; color: #666666; text-align:left; line-height: 16px; white-space: nowrap; vertical-align: top;" align="left">' . $rowMatch['DisplayName'] . '</td>' . chr(13);
    $match .= '<td style="font-family: Helvetica, arial, sans-serif; font-size: 14px; color: #666666; text-align:left; line-height: 16px; white-space: nowrap; vertical-align: top;" align="left">';
    if ($rowMatch['HomeTeamPoints'] == 'No prediction') {
      $match .= '<i>No prediction</i>' . chr(13);
    } else {
      if ($rowMatch['HomeTeamPoints'] > $rowMatch['AwayTeamPoints']) {
        $match .= $row['HomeTeam'] . ' to win<br/>' . chr(13);
        $match .= $rowMatch['HomeTeamPoints'] . '&nbsp;-&nbsp;' . $rowMatch['AwayTeamPoints'];
      } elseif ($rowMatch['AwayTeamPoints'] > $rowMatch['HomeTeamPoints']) {
        $match .= $row['AwayTeam'] . ' to win<br/>' . chr(13);
        $match .= $rowMatch['AwayTeamPoints'] . '&nbsp;-&nbsp;' . $rowMatch['HomeTeamPoints'];
      } else {
        $match .= 'Draw<br/>' . chr(13);
        $match .= $rowMatch['HomeTeamPoints'] . '&nbsp;-&nbsp;' . $rowMatch['AwayTeamPoints'];
      }
    }
    $match .= '</td>' . chr(13);
    if ($rowMatch['TotalPoints'] == 0) {
      $match .= '<td style="font-family: Helvetica, arial, sans-serif; font-size: 14px; color: #666666; text-align:center; line-height: 16px; white-space: nowrap; vertical-align: top;" align="center">-</td>' . chr(13);
    } else {
      $match .= '<td style="font-family: Helvetica, arial, sans-serif; font-size: 14px; color: #666666; text-align:center; line-height: 16px; white-space: nowrap; vertical-align: top;" align="center">' . $rowMatch['TotalPoints'] . '</td>' . chr(13);
    }

    $match .= '</tr>' . chr(13);

  }

  $match .= '</table>' . chr(13);
  $match .= '</td>' . chr(13);
  $match .= '</tr>' . chr(13);
  $match .= '<!-- End of content -->' . chr(13);

  // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
  // Body - build body array for sendEmail routine
  // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
  $body = array(array('separator','Separator'),
                array('table','Heading',$heading),
                array('separatorHR','Separator'),
                array('table','Current League table',$league),
                array('separatorHR','Separator'),
                array('table','Match details table',$match),
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
