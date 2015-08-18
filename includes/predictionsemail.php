<?php

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
// Includes
// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/includesfile.inc.php';

// Get DB connection
include 'db.inc.php';
if (!isset($link)) {
  $error = 'Error getting DB connection';

  header('Content-type: application/json');
  $arr = array('result' => 'No', 'message' => $error);
  echo json_encode($arr);
  die();
}

// Get the Mr Men calculation functions in scope
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/calcMrMen.php';

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
// Main code - always runs
// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
$sql = "
  SELECT
    m.`MatchID`
    ,IFNULL(ht.`Name`,trht.`Name`) AS `HomeTeam`
    ,IFNULL(at.`Name`,trat.`Name`) AS `AwayTeam`
    ,IFNULL(ht.`ShortName`,'') AS `HomeTeamS`
    ,IFNULL(at.`ShortName`,'') AS `AwayTeamS`

  FROM `Match` m
    INNER JOIN `Emails` e ON e.`MatchID` = m.`MatchID`
    INNER JOIN `TournamentRole` trht ON trht.`TournamentRoleID` = m.`HomeTeamID`
      LEFT JOIN `Team` ht ON ht.`TeamID` = trht.`TeamID`
    INNER JOIN `TournamentRole` trat ON trat.`TournamentRoleID` = m.`AwayTeamID`
      LEFT JOIN `Team` at ON at.`TeamID` = trat.`TeamID`

  WHERE
    e.`PredictionsSent` = 0
    AND DATE_ADD(NOW(), INTERVAL 30 MINUTE) > TIMESTAMP(m.`Date`, m.`KickOff`);";

$result = mysqli_query($link, $sql);
if (!$result) {
    $error = 'Error getting not yet predicted matches: <br />' . mysqli_error($link) . '<br /><br />' . $sql;
  echo($error);
    sendEmail('james.macadie@telerealtrillium.com','Predictions Email Error','',$error);
    exit();
}

while ($row = mysqli_fetch_array($result)) {

  // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
  // Calculate Mr Men
  // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

  calcMrMean($row['MatchID'], $link);
  calcMrMedian($row['MatchID'], $link);
  calcMrMode($row['MatchID'], $link);

  // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
  // Email To Addresses
  // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
  $toEmail = 'jrpl@googlegroups.com';

  // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
  // Email Subject
  // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
  $emailSubject = 'Match Predictions for ' . $row['HomeTeam'] . ' vs. '. $row['AwayTeam'];

  // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
  // CSS formatting
  // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

  $css = 'standard';

  // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
  // Body - Get details
  // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
  $sql = "
    SELECT
      u.`DisplayName`
      ,IFNULL(p.`HomeTeamPoints`,'No prediction') AS `HomeTeamPoints`
      ,IFNULL(p.`AwayTeamPoints`,'No prediction') AS `AwayTeamPoints`

    FROM `User` u

      LEFT JOIN `Prediction` p ON
        p.`MatchID` = " . $row['MatchID'] . "
        AND p.`UserID` = u.`UserID`

    ORDER BY
      (p.`HomeTeamPoints` - p.`AwayTeamPoints`) DESC
      ,p.`HomeTeamPoints` DESC;";

  $resultBody = mysqli_query($link, $sql);
  if (!$resultBody) {
    $error = 'Error getting predictions for match: <br />' . mysqli_error($link) . '<br /><br />' . $sql;
    sendEmail('james.macadie@telerealtrillium.com','Predictions Email Error','',$error);
    exit();
  }

  // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
  // Body - write heading table
  // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
  $heading = '<!-- Title -->' . chr(13);
  $heading .= '<tr>' . chr(13);
  $heading .= '<td colspan="5" style="font-family: Helvetica, arial, sans-serif; font-size: 30px; color: #333333; text-align:center; line-height: 30px;" st-title="fulltext-heading">' . chr(13);
  $heading .= 'Next match locked down' . chr(13);
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
  $heading .= '<td style="white-space: nowrap; font-family: Helvetica, arial, sans-serif; font-size: 16px; color: #333333; text-align:center; line-height: 30px;" st-content="fulltext-content">' . chr(13);
  $heading .= 'vs.' . chr(13);
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
  // Body - write predictions table
  // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
  $predictions = '<!-- content -->' . chr(13);
  $predictions .= '<tr>' . chr(13);
  $predictions .= '<td st-content="fulltext-content">' . chr(13);
  $predictions .= '<table border="0" width="100%" cellpadding="4" cellspacing="0" border="0" align="left" class="devicewidth">' . chr(13);
  $predictions .= '<tr>' . chr(13);
  $predictions .= '<th style="font-family: Helvetica, arial, sans-serif; font-size: 14px; color: #333333; text-align:left; line-height: 16px;" align="left">Player</th>' . chr(13);
  $predictions .= '<th style="font-family: Helvetica, arial, sans-serif; font-size: 14px; color: #333333; text-align:left; line-height: 16px;" align="left">Prediction</th>' . chr(13);
  $predictions .= '</tr>' . chr(13);

  // Counter for striped rows
  $i = 0;

  while ($rowBody = mysqli_fetch_array($resultBody)) {

    if($i == 1) {
      $predictions .= '<tr style="background-color: #f0f0ff;">' . chr(13);
      $i = 2;
    } else{
      $predictions .= '<tr>' . chr(13);
      $i = 1;
    }
    if ($rowBody['HomeTeamPoints'] == 'No prediction') {
      $predictions .= '<td style="font-family: Helvetica, arial, sans-serif; font-size: 14px; color: #666666; text-align:left; line-height: 16px; white-space: nowrap; vertical-align: top;" align="left"><i>' . $rowBody['DisplayName'] . '</i></td>' . chr(13);
    } else {
      $predictions .= '<td style="font-family: Helvetica, arial, sans-serif; font-size: 14px; color: #666666; text-align:left; line-height: 16px; white-space: nowrap; vertical-align: top;" align="left">' . $rowBody['DisplayName'] . '</td>' . chr(13);
    }

    $predictions .= '<td style="font-family: Helvetica, arial, sans-serif; font-size: 14px; color: #666666; text-align:left; line-height: 16px; white-space: nowrap;">' . chr(13);

    if ($rowBody['HomeTeamPoints'] == 'No prediction') {
      $predictions .= '<i>No prediction</i>' . chr(13);
    } else {
      if ($rowBody['HomeTeamPoints'] > $rowBody['AwayTeamPoints']) {
        $predictions .= $row['HomeTeam'] . ' to win<br/>' . chr(13);
        $predictions .= $rowBody['HomeTeamPoints'] . '&nbsp;-&nbsp;' . $rowBody['AwayTeamPoints'] . chr(13);
      } elseif ($rowBody['AwayTeamPoints'] > $rowBody['HomeTeamPoints']) {
        $predictions .= $row['AwayTeam'] . ' to win<br/>' . chr(13);
        $predictions .= $rowBody['AwayTeamPoints'] . '&nbsp;-&nbsp;' . $rowBody['HomeTeamPoints'] . chr(13);
      } else {
        $predictions .= 'Draw<br/>' . chr(13);
        $predictions .= $rowBody['HomeTeamPoints'] . '&nbsp;-&nbsp;' . $rowBody['AwayTeamPoints'] . chr(13);
      }
    }
    $predictions .= '</td>' . chr(13);
    $predictions .= '</tr>' . chr(13);

  }

  $predictions .= '</table>' . chr(13);
  $predictions .= '</td>' . chr(13);
  $predictions .= '</tr>' . chr(13);
  $predictions .= '<!-- End of content -->' . chr(13);

  // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
  // Body - build body array for sendEmail routine
  // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
  $body = array(array('separator','Separator'),
          array('table','Heading',$heading),
          array('separatorHR','Separator'),
          array('table','Predictions table',$predictions),
          array('separatorHR','Separator'));

  // Send e-mail
  sendEmail($toEmail,$emailSubject,$css,$body);

  // Update DB to log e-mail being sent
  $sql = "
    UPDATE `Emails`
    SET `PredictionsSent` = 1
    WHERE `MatchID`=" . $row['MatchID'];

  $resultBody = mysqli_query($link, $sql);
  if (!$resultBody) {
    $error = 'Error updating email sent table: <br />' . mysqli_error($link) . '<br /><br />' . $sql;
    sendEmail('james.macadie@telerealtrillium.com','Predictions Email Error','',$error);
    exit();
  }

}
