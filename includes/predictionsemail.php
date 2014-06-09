<?php

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
// Includes
// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/includesfile.inc.php';

// Get DB connection
include 'db.inc.php';

function calcMrMean($matchID,$link) {
	
	// Delete existing prediction first
	// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
	
	// Build SQL
    $sql = "DELETE FROM `Prediction`
			   WHERE
					`UserID` =
						(SELECT ur.`UserID`
						FROM `UserRole` ur
							INNER JOIN `Role` r ON
								r.`RoleID` = ur.`UserID`
						WHERE r`LastName` = 'Mr Mean')
					AND `MatchID` = " . $matchID . ";";
	
	// Run SQL and trap any errors
    $result = mysqli_query($link, $sql);
    if (!$result)
    {
        $error = "Error deleting mr mean's previous predictions: <br />" . mysqli_error($link) . '<br /><br />' . $sql;
        sendEmail('james.macadie@telerealtrillium.com','Predictions Email Error','',$error);
        exit();
    }
	
	// Get mean predictions
	// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
	
    // Build SQL - exclude special roles
	$sql = "SELECT
				SUM(p.`HomeTeamGoals`)/COUNT(p.`PredictionID`) AS `HomeTeamGoals`,
				SUM(p.`AwayTeamGoals`)/COUNT(p.`PredictionID`) AS `AwayTeamGoals`
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
        $error = 'Error calculating mean scores: <br />' . mysqli_error($link) . '<br /><br />' . $sql;
        sendEmail('james.macadie@telerealtrillium.com','Predictions Email Error','',$error);
        exit();
    }
	
    while ($row = mysqli_fetch_array($result)) {

        $sqlAdd = "INSERT INTO `Prediction` (
                    `UserID`,
                    `MatchID`,
                    `HomeTeamGoals`,
                    `AwayTeamGoals`,
                    `DateAdded`)
                 VALUES (
					(SELECT ur.`UserID`
					FROM `UserRole` ur
						INNER JOIN `Role` r ON
							r.`RoleID` = ur.`UserID`
					WHERE r`LastName` = 'Mr Mean'
					LIMIT 1),
					" . $matchID . ",
                    " . (($row['HomeTeamGoals'] == null) ? 'NULL' : $row['HomeTeamGoals'])  . ",
                    " . (($row['AwayTeamGoals'] == null) ? 'NULL' : $row['AwayTeamGoals']) . ",
                    NOW()
				)";

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
    $sql = "DELETE FROM `Prediction`
			   WHERE
					`UserID` =
						(SELECT ur.`UserID`
						FROM `UserRole` ur
							INNER JOIN `Role` r ON
								r.`RoleID` = ur.`UserID`
						WHERE r`LastName` = 'Mr Mode')
					AND `MatchID` = " . $matchID . ";";
	
	// Run SQL and trap any errors
    $result = mysqli_query($link, $sql);
    if (!$result)
    {
        $error = "Error deleting mr mode's previous predictions: <br />" . mysqli_error($link) . '<br /><br />' . $sql;
        sendEmail('james.macadie@telerealtrillium.com','Predictions Email Error','',$error);
        exit();
    }
	
	// Get the predicted scores
	// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
	
    // Build SQL - exclude special roles
	$sql = "SELECT
				p.`HomeTeamGoals`,
				p.`AwayTeamGoals`
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
        $error = 'Error get predictions to calculate mode: <br />' . mysqli_error($link) . '<br /><br />' . $sql;
        sendEmail('james.macadie@telerealtrillium.com','Predictions Email Error','',$error);
        exit();
    }
	
    // Calculate the Mode scores
    // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
	
	// Set the counters to zero to start with
    $numMatches = 0;
	
	// Loop through all users and add scores if submitted
    while ($row = mysqli_fetch_array($result))
    {
        if ($row['HomeTeamGoals'] <> 'NULL' && $row['AwayTeamGoals'] <> 'NULL')
		{
			$numMatches++;
			$homeScores[] = $row['HomeTeamGoals'];
			$awayScores[] = $row['AwayTeamGoals'];
		}
    }
	
	// Only do anything else if we have some predictions to work with
	if ($numMatches > 0)
	{
		
		$values = array_count_values($homeScores); 
		$homeScoreM = array_search(max($values), $values);
		
		$values = array_count_values($awayScores); 
		$awayScoreM = array_search(max($values), $values);
		
		$sqlAdd = "INSERT INTO `Prediction` (
					`UserID`,
					`MatchID`,
					`HomeTeamGoals`,
					`AwayTeamGoals`,
					`DateAdded`)
				 VALUES (
					(SELECT ur.`UserID`
					FROM `UserRole` ur
						INNER JOIN `Role` r ON
							r.`RoleID` = ur.`UserID`
					WHERE r`LastName` = 'Mr Mode'
					LIMIT 1),
					" . $matchID . ",
					" . $homeScoreM  . ",
					" . $awayScoreM . ",
					NOW()
				)";

		$resultAdd = mysqli_query($link, $sqlAdd);
		if (!$resultAdd)
		{
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
    $sql = "DELETE FROM `Prediction`
			   WHERE
					`UserID` =
						(SELECT ur.`UserID`
						FROM `UserRole` ur
							INNER JOIN `Role` r ON
								r.`RoleID` = ur.`UserID`
						WHERE r`LastName` = 'Mr Median')
					AND `MatchID` = " . $matchID . ";";
	
	// Run SQL and trap any errors
    $result = mysqli_query($link, $sql);
    if (!$result)
    {
        $error = "Error deleting mr median's previous predictions: <br />" . mysqli_error($link) . '<br /><br />' . $sql;
        sendEmail('james.macadie@telerealtrillium.com','Predictions Email Error','',$error);
        exit();
    }
	
	// Get the predicted scores
	// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
	
    // Build SQL - exclude special roles
	$sql = "SELECT
				p.`HomeTeamGoals`,
				p.`AwayTeamGoals`
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
        $error = 'Error get predictions to calculate median: <br />' . mysqli_error($link) . '<br /><br />' . $sql;
        sendEmail('james.macadie@telerealtrillium.com','Predictions Email Error','',$error);
        exit();
    }
	
    // Calculate the Median scores
    // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
	
	// Set the counters to zero to start with
    $numMatches = 0;
	
	// Loop through all users and add scores if submitted
    while ($row = mysqli_fetch_array($result))
    {
        if ($row['HomeTeamGoals'] <> 'NULL' && $row['AwayTeamGoals'] <> 'NULL')
		{
			$numMatches++;
			$homeScores[] = $row['HomeTeamGoals'];
			$awayScores[] = $row['AwayTeamGoals'];
		}
    }
	
	// Only do anything else if we have some predictions to work with
	if ($numMatches > 0)
	{
		
		// Sort arrays
		$homeScores = quickSort($homeScores);
		$awayScores = quickSort($awayScores);
		
		if ($numMatches % 2) // $numMatches is odd can just take middle array value
		{
			$homeScoreM = $homeScores[(($numMatches+1)/2)];
			$awayScoreM = $awayScores[(($numMatches+1)/2)];
		}
		else // $numMatches is even must take average of middle two values
		{
			$homeScoreM = round(($homeScores[($numMatches/2)]+$homeScores[(($numMatches/2)+1)])/2);
			$awayScoreM = round(($awayScores[($numMatches/2)]+$awayScores[(($numMatches/2)+1)])/2);
		}
		
		$sqlAdd = "INSERT INTO `Prediction` (
					`UserID`,
					`MatchID`,
					`HomeTeamGoals`,
					`AwayTeamGoals`,
					`DateAdded`)
				 VALUES (
					(SELECT ur.`UserID`
					FROM `UserRole` ur
						INNER JOIN `Role` r ON
							r.`RoleID` = ur.`UserID`
					WHERE r`LastName` = 'Mr Median'
					LIMIT 1),
					" . $matchID . ",
					" . $homeScoreM  . ",
					" . $awayScoreM . ",
					NOW()
				)";

		$resultAdd = mysqli_query($link, $sqlAdd);
		if (!$resultAdd)
		{
			$error = "Error adding mr median's predictions: <br />" . mysqli_error($link) . '<br /><br />' . $sqlAdd;
			sendEmail('james.macadie@telerealtrillium.com','Predictions Email Error','',$error);
			exit();
		}
		
	}

}

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
// Main code - always runs
// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
$sql = "SELECT
			m.`MatchID`,
			ht.`Name` AS `HomeTeam`,
			at.`Name` AS `AwayTeam`
        FROM `Match` m
			INNER JOIN `Email` e ON e.`MatchID` = m.`MatchID`
			INNER JOIN `Team` ht ON ht.`TeamID` = m.`HomeTeamID`
			INNER JOIN `Team` at ON at.`TeamID` = m.`HomeTeamID`
		WHERE
			e.`PredictionsSent` = 0
			AND DATE_ADD(NOW(), INTERVAL 30 MINUTE) > TIMESTAMP(m.`Date`, m.`KickOff`);";

$result = mysqli_query($link, $sql);
if (!$result)
{
    $error = 'Error getting not yet predicted matches: <br />' . mysqli_error($link) . '<br /><br />' . $sql;
    sendEmail('james.macadie@telerealtrillium.com','Predictions Email Error','',$error);
    exit();
}

while ($row = mysqli_fetch_array($result))
{

    // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    // Calculate Mr Men
    // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

    calcMrMean($matchID,$link);
	calcMrMedian($matchID,$link);
	calcMrMode($matchID,$link);

    // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    // Email To Addresses
    // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    $toEmail='jrpl@googlegroups.com';

    // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    // Email Subject
    // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    $emailSubject = 'Match Predictions for ' . $row['HomeTeam'] . ' vs. '. $row['AwayTeam'];

    // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    // CSS formatting
    // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

    $css = '/* Client-specific Styles */' . '\r\n';
    $css .= '#outlook a {padding:0;} /* Force Outlook to provide a "view in browser" menu link. */' . '\r\n';
	$css .= 'body{width:100% !important; -webkit-text-size-adjust:100%; -ms-text-size-adjust:100%; margin:0; padding:0;}' . '\r\n';
	$css .= '/* Prevent Webkit and Windows Mobile platforms from changing default font sizes, while not breaking desktop design. */' . '\r\n';
	$css .= '.ExternalClass {width:100%;} /* Force Hotmail to display emails at full width */' . '\r\n';
	$css .= '.ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div {line-height: 100%;} /* Force Hotmail to display normal line spacing.*/' . '\r\n';
	$css .= '#backgroundTable {margin:0; padding:0; width:100% !important; line-height: 100% !important;}' . '\r\n';
	$css .= 'img {outline:none; text-decoration:none;border:none; -ms-interpolation-mode: bicubic;}' . '\r\n';
	$css .= 'a img {border:none;}' . '\r\n';
	$css .= '.image_fix {display:block;}' . '\r\n';
	$css .= 'p {margin: 0px 0px !important;}' . '\r\n';
	$css .= 'table td {border-collapse: collapse;}' . '\r\n';
	$css .= 'table { border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt; }' . '\r\n';
	$css .= 'a {color: #0a8cce;text-decoration: none;text-decoration:none!important;}' . '\r\n';
	$css .= '/*STYLES*/' . '\r\n';
	$css .= 'table[class=full] { width: 100%; clear: both; }' . '\r\n';
	$css .= '/*IPAD STYLES*/' . '\r\n';
	$css .= '@media only screen and (max-width: 640px) {' . '\r\n';
	$css .= 'a[href^="tel"], a[href^="sms"] {' . '\r\n';
	$css .= 'text-decoration: none;' . '\r\n';
	$css .= 'color: #0a8cce; /* or whatever your want */' . '\r\n';
	$css .= 'pointer-events: none;' . '\r\n';
	$css .= 'cursor: default;' . '\r\n';
	$css .= '}' . '\r\n';
	$css .= '.mobile_link a[href^="tel"], .mobile_link a[href^="sms"] {' . '\r\n';
	$css .= 'text-decoration: default;' . '\r\n';
	$css .= 'color: #0a8cce !important;' . '\r\n';
	$css .= 'pointer-events: auto;' . '\r\n';
	$css .= 'cursor: default;' . '\r\n';
	$css .= '}' . '\r\n';
	$css .= 'table[class=devicewidth] {width: 440px!important;text-align:center!important;}' . '\r\n';
	$css .= 'table[class=devicewidthinner] {width: 420px!important;text-align:center!important;}' . '\r\n';
	$css .= 'img[class=banner] {width: 440px!important;height:220px!important;}' . '\r\n';
	$css .= 'img[class=colimg2] {width: 440px!important;height:220px!important;}' . '\r\n';
	$css .= '}' . '\r\n';
	$css .= '/*IPHONE STYLES*/' . '\r\n';
	$css .= '@media only screen and (max-width: 480px) {' . '\r\n';
	$css .= 'a[href^="tel"], a[href^="sms"] {' . '\r\n';
	$css .= 'text-decoration: none;' . '\r\n';
	$css .= 'color: #0a8cce; /* or whatever your want */' . '\r\n';
	$css .= 'pointer-events: none;' . '\r\n';
	$css .= 'cursor: default;' . '\r\n';
	$css .= '}' . '\r\n';
	$css .= '.mobile_link a[href^="tel"], .mobile_link a[href^="sms"] {' . '\r\n';
	$css .= 'text-decoration: default;' . '\r\n';
	$css .= 'color: #0a8cce !important;' . '\r\n';
	$css .= 'pointer-events: auto;' . '\r\n';
	$css .= 'cursor: default;' . '\r\n';
	$css .= '}' . '\r\n';
	$css .= 'table[class=devicewidth] {width: 280px!important;text-align:center!important;}' . '\r\n';
	$css .= 'table[class=devicewidthinner] {width: 260px!important;text-align:center!important;}' . '\r\n';
	$css .= 'img[class=banner] {width: 280px!important;height:140px!important;}' . '\r\n';
	$css .= 'img[class=colimg2] {width: 280px!important;height:140px!important;}' . '\r\n';
	$css .= 'td[class=mobile-hide]{display:none!important;}' . '\r\n';
	$css .= 'td[class="padding-bottom25"]{padding-bottom:25px!important;}' . '\r\n';
	$css .= '}' . '\r\n';
	
    // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    // Body - Get details
    // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    $sql = "SELECT
                p.`DisplayName`,
                IFNULL(p.`HomeTeamGoals`,'No prediction') AS `HomeTeamGoals`,
				IFNULL(p.`AwayTeamGoals`,'No prediction') AS `AwayTeamGoals`

            FROM `User` u

				LEFT JOIN `Prediction` p ON
					p.`MatchID` = " . $row['MatchID'] . "
			
			ORDER BY
				(p.`HomeTeamGoals` - p.`AwayTeamGoals`) DESC,
				p.`HomeTeamGoals` DESC;";

    $resultBody = mysqli_query($link, $sql);
    if (!$resultBody)
    {
        $error = 'Error getting predictions for match: <br />' . mysqli_error($link) . '<br /><br />' . $sql;
        sendEmail('james.macadie@telerealtrillium.com','Predictions Email Error','',$error);
        exit();
    }

    // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    // Body - Write details
    // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    $body = '<!-- Start of separator -->' . '\r\n';
	$body .= '<table width="100%" bgcolor="#ffffff" cellpadding="0" cellspacing="0" border="0" id="backgroundTable" st-sortable="separator">' . '\r\n';
	$body .= '<tbody>' . '\r\n';
	$body .= '<tr>' . '\r\n';
	$body .= '<td>' . '\r\n';
	$body .= '<table width="600" align="center" cellspacing="0" cellpadding="0" border="0" class="devicewidth">' . '\r\n';
	$body .= '<tbody>' . '\r\n';
	$body .= '<tr>' . '\r\n';
	$body .= '<td align="center" height="20" style="font-size:1px; line-height:1px;">&nbsp;</td>' . '\r\n';
	$body .= '</tr>' . '\r\n';
	$body .= '</tbody>' . '\r\n';
	$body .= '</table>' . '\r\n';
	$body .= '</td>' . '\r\n';
	$body .= '</tr>' . '\r\n';
	$body .= '</tbody>' . '\r\n';
	$body .= '</table>' . '\r\n';
	$body .= '<!-- End of separator -->' . '\r\n';
	
	$body .= '<!-- Start Heading Text -->' . '\r\n';
	$body .= '<table width="100%" bgcolor="#ffffff" cellpadding="0" cellspacing="0" border="0" id="backgroundTable" st-sortable="full-text">' . '\r\n';
	$body .= '<tbody>' . '\r\n';
	$body .= '<tr>' . '\r\n';
	$body .= '<td>' . '\r\n';
	$body .= '<table width="600" cellpadding="0" cellspacing="0" border="0" align="center" class="devicewidth">' . '\r\n';
	$body .= '<tbody>' . '\r\n';
	$body .= '<tr>' . '\r\n';
	$body .= '<td width="100%">' . '\r\n';
	$body .= '<table width="600" cellpadding="0" cellspacing="0" border="0" align="center" class="devicewidth">' . '\r\n';
	$body .= '<tbody>' . '\r\n';
	$body .= '<!-- Spacing -->' . '\r\n';
	$body .= '<tr>' . '\r\n';
	$body .= '<td height="20" style="font-size:1px; line-height:1px; mso-line-height-rule: exactly;">&nbsp;</td>' . '\r\n';
	$body .= '</tr>' . '\r\n';
	$body .= '<!-- Spacing -->' . '\r\n';
	$body .= '<tr>' . '\r\n';
	$body .= '<td>' . '\r\n';
	$body .= '<table width="560" align="center" cellpadding="4" cellspacing="0" border="0" class="devicewidthinner">' . '\r\n';
	$body .= '<tbody>' . '\r\n';
	$body .= '<!-- Title -->' . '\r\n';
	$body .= '<tr>' . '\r\n';
	$body .= '<td colspan="5" style="font-family: Helvetica, arial, sans-serif; font-size: 30px; color: #333333; text-align:center; line-height: 30px;" st-title="fulltext-heading">' . '\r\n';
	$body .= 'Next match locked down' . '\r\n';
	$body .= '</td>' . '\r\n';
	$body .= '</tr>' . '\r\n';
	$body .= '<!-- End of Title -->' . '\r\n';
	$body .= '<!-- spacing -->' . '\r\n';
	$body .= '<tr>' . '\r\n';
	$body .= '<td colspan="5" width="100%" height="20" style="font-size:1px; line-height:1px; mso-line-height-rule: exactly;">&nbsp;</td>' . '\r\n';
	$body .= '</tr>' . '\r\n';
    $body .= '<!-- End of spacing -->' . '\r\n';
	$body .= '<!-- Sub-Title -->' . '\r\n';
	$body .= '<tr>' . '\r\n';
	$body .= '<td colspan="5" style="font-family: Helvetica, arial, sans-serif; font-size: 16px; color: #333333; text-align:center; line-height: 30px;" st-title="fulltext-content">' . '\r\n';
	$body .= 'See below for predictions for ' . $row['HomeTeam'] . ' vs. ' . $row['AwayTeam'] . '\r\n';
	$body .= '</td>' . '\r\n';
	$body .= '</tr>' . '\r\n';
	$body .= '<!-- End of Sub-Title -->' . '\r\n';
	$body .= '</tbody>' . '\r\n';
	$body .= '</table>' . '\r\n';
	$body .= '</td>' . '\r\n';
	$body .= '</tr>' . '\r\n';
	$body .= '<!-- Spacing -->' . '\r\n';
	$body .= '<tr>' . '\r\n';
	$body .= '<td height="20" style="font-size:1px; line-height:1px; mso-line-height-rule: exactly;">&nbsp;</td>' . '\r\n';
	$body .= '</tr>' . '\r\n';
	$body .= '<!-- Spacing -->' . '\r\n';
	$body .= '</tbody>' . '\r\n';
	$body .= '</table>' . '\r\n';
	$body .= '</td>' . '\r\n';
	$body .= '</tr>' . '\r\n';
	$body .= '</tbody>' . '\r\n';
	$body .= '</table>' . '\r\n';
	$body .= '</td>' . '\r\n';
	$body .= '</tr>' . '\r\n';
	$body .= '</tbody>' . '\r\n';
	$body .= '</table>' . '\r\n';
	$body .= '<!-- end of Heading text -->' . '\r\n';
	
	$body .= '<!-- Start of separator -->' . '\r\n';
	$body .= '<table width="100%" bgcolor="#ffffff" cellpadding="0" cellspacing="0" border="0" id="backgroundTable" st-sortable="separator">' . '\r\n';
	$body .= '<tbody>' . '\r\n';
	$body .= '<tr>' . '\r\n';
	$body .= '<td>' . '\r\n';
	$body .= '<table width="600" align="center" cellspacing="0" cellpadding="0" border="0" class="devicewidth">' . '\r\n';
	$body .= '<tbody>' . '\r\n';
	$body .= '<tr>' . '\r\n';
	$body .= '<td align="center" height="30" style="font-size:1px; line-height:1px;">&nbsp;</td>' . '\r\n';
	$body .= '</tr>' . '\r\n';
	$body .= '<tr>' . '\r\n';
	$body .= '<td width="550" align="center" height="1" bgcolor="#d1d1d1" style="font-size:1px; line-height:1px;">&nbsp;</td>' . '\r\n';
	$body .= '</tr>' . '\r\n';
	$body .= '<tr>' . '\r\n';
	$body .= '<td align="center" height="30" style="font-size:1px; line-height:1px;">&nbsp;</td>' . '\r\n';
	$body .= '</tr>' . '\r\n';
	$body .= '</tbody>' . '\r\n';
	$body .= '</table>' . '\r\n';
	$body .= '</td>' . '\r\n';
	$body .= '</tr>' . '\r\n';
	$body .= '</tbody>' . '\r\n';
	$body .= '</table>' . '\r\n';
	$body .= '<!-- End of separator --> ' . '\r\n';
	
	$body .= '<!-- predictions table -->' . '\r\n';
	$body .= '<table width="100%" bgcolor="#ffffff" cellpadding="0" cellspacing="0" border="0" id="backgroundTable" st-sortable="full-text">' . '\r\n';
	$body .= '<tbody>' . '\r\n';
	$body .= '<tr>' . '\r\n';
	$body .= '<td>' . '\r\n';
	$body .= '<table width="600" cellpadding="0" cellspacing="0" border="0" align="center" class="devicewidth">' . '\r\n';
	$body .= '<tbody>' . '\r\n';
	$body .= '<tr>' . '\r\n';
	$body .= '<td width="100%">' . '\r\n';
	$body .= '<table width="600" cellpadding="0" cellspacing="0" border="0" align="center" class="devicewidth">' . '\r\n';
	$body .= '<tbody>' . '\r\n';
	$body .= '<!-- Spacing -->' . '\r\n';
	$body .= '<tr>' . '\r\n';
	$body .= '<td height="20" style="font-size:1px; line-height:1px; mso-line-height-rule: exactly;">&nbsp;</td>' . '\r\n';
	$body .= '</tr>' . '\r\n';
	$body .= '<!-- Spacing -->' . '\r\n';
	$body .= '<tr>' . '\r\n';
	$body .= '<td>' . '\r\n';
	$body .= '<table width="560" align="center" cellpadding="0" cellspacing="0" border="0" class="devicewidthinner">' . '\r\n';
	$body .= '<tbody>' . '\r\n';
	$body .= '<!-- Title -->' . '\r\n';
	$body .= '<tr>' . '\r\n';
	$body .= '<td style="font-family: Helvetica, arial, sans-serif; font-size: 18px; color: #333333; line-height:24px;text-align:center;" st-title="fulltext-heading">' . '\r\n';
	$body .= 'Spain vs The Netherlands<br/>' . '\r\n';
	$body .= 'Spain won 1&nbsp;-&nbsp;0' . '\r\n';
	$body .= '</td>' . '\r\n';
	$body .= '</tr>' . '\r\n';
	$body .= '<!-- End of Title -->' . '\r\n';
	$body .= '<!-- spacing -->' . '\r\n';
	$body .= '<tr>' . '\r\n';
	$body .= '<td width="100%" height="20" style="font-size:1px; line-height:1px; mso-line-height-rule: exactly;">&nbsp;</td>' . '\r\n';
	$body .= '</tr>' . '\r\n';
	$body .= '<!-- End of spacing -->' . '\r\n';
	
	// Counter for striped rows
	$i = 0;
	
	$body .= '<!-- content -->' . '\r\n';
	$body .= '<tr>' . '\r\n';
	$body .= '<td style="font-family: Helvetica, arial, sans-serif; font-size: 14px; color: #666666; text-align:left; line-height: 16px;" st-content="fulltext-content">' . '\r\n';
	$body .= '<table border="0" width="100%" cellpadding="4" cellspacing="0" border="0" align="left" class="devicewidth">' . '\r\n';
	$body .= '<tr>' . '\r\n';
	$body .= '<th>Player</th>' . '\r\n';
	$body .= '<th>Perediction</th>' . '\r\n';
	$body .= '</tr>' . '\r\n';
	
	while ($rowBody = mysqli_fetch_array($resultBody)) {
	
		if($i == 1) {
			$body .= '<tr style="background-color: #f0f0ff;">' . '\r\n';
			$i = 2;
		} else{
			$body .= '<tr>';
			$i = 1;
		}
		$body .= '<td style="white-space: nowrap; vertical-align: top;" align="left">' . $rowBody['DisplayName'] . '</td>' . '\r\n';
		$body .= '<td style="white-space: nowrap;">' . '\r\n';
		
		if ($rowBody['HomeTeamGoals'] > $rowBody['AwayTeamGoals']) {
			$body .= $row['HomeTeam'] . ' to win<br/>' . '\r\n';
			$body .= $rowBody['HomeTeamGoals'] . '&nbsp;-&nbsp;' . $rowBody['AwayTeamGoals'] . '\r\n';
		} elseif ($rowBody['AwayTeamGoals'] > $rowBody['HomeTeamGoals']) {
			$body .= $row['AwayTeam'] . ' to win<br/>' . '\r\n';
			$body .= $rowBody['AwayTeamGoals'] . '&nbsp;-&nbsp;' . $rowBody['HomeTeamGoals'] . '\r\n';
		} else {
			$body .= 'Draw<br/>' . '\r\n';
			$body .= $rowBody['HomeTeamGoals'] . '&nbsp;-&nbsp;' . $rowBody['AwayTeamGoals'] . '\r\n';
		}
		$body .= '</td>' . '\r\n';
		$body .= '</tr>' . '\r\n';
	
	}
	
	$body .= '</table>' . '\r\n';
	$body .= '</td>' . '\r\n';
	$body .= '</tr>' . '\r\n';
	$body .= '<!-- End of content -->' . '\r\n';
	$body .= '</tbody>' . '\r\n';
	$body .= '</table>' . '\r\n';
	$body .= '</td>' . '\r\n';
	$body .= '</tr>' . '\r\n';
	$body .= '<!-- Spacing -->' . '\r\n';
	$body .= '<tr>' . '\r\n';
	$body .= '<td height="20" style="font-size:1px; line-height:1px; mso-line-height-rule: exactly;">&nbsp;</td>' . '\r\n';
	$body .= '</tr>' . '\r\n';
	$body .= '<!-- Spacing -->' . '\r\n';
	$body .= '</tbody>' . '\r\n';
	$body .= '</table>' . '\r\n';
	$body .= '</td>' . '\r\n';
	$body .= '</tr>' . '\r\n';
	$body .= '</tbody>' . '\r\n';
	$body .= '</table>' . '\r\n';
	$body .= '</td>' . '\r\n';
	$body .= '</tr>' . '\r\n';
	$body .= '</tbody>' . '\r\n';
	$body .= '</table>' . '\r\n';
	$body .= '<!-- End of predictions table -->' . '\r\n';
	
	$body .= '<!-- Start of separator -->' . '\r\n';
	$body .= '<table width="100%" bgcolor="#ffffff" cellpadding="0" cellspacing="0" border="0" id="backgroundTable" st-sortable="separator">' . '\r\n';
	$body .= '<tbody>' . '\r\n';
	$body .= '<tr>' . '\r\n';
	$body .= '<td>' . '\r\n';
	$body .= '<table width="600" align="center" cellspacing="0" cellpadding="0" border="0" class="devicewidth">' . '\r\n';
	$body .= '<tbody>' . '\r\n';
	$body .= '<tr>' . '\r\n';
	$body .= '<td align="center" height="30" style="font-size:1px; line-height:1px;">&nbsp;</td>' . '\r\n';
	$body .= '</tr>' . '\r\n';
	$body .= '<tr>' . '\r\n';
	$body .= '<td width="550" align="center" height="1" bgcolor="#d1d1d1" style="font-size:1px; line-height:1px;">&nbsp;</td>' . '\r\n';
	$body .= '</tr>' . '\r\n';
	$body .= '<tr>' . '\r\n';
	$body .= '<td align="center" height="30" style="font-size:1px; line-height:1px;">&nbsp;</td>' . '\r\n';
	$body .= '</tr>' . '\r\n';
	$body .= '</tbody>' . '\r\n';
	$body .= '</table>' . '\r\n';
	$body .= '</td>' . '\r\n';
	$body .= '</tr>' . '\r\n';
	$body .= '</tbody>' . '\r\n';
	$body .= '</table>' . '\r\n';
	$body .= '<!-- End of separator --> ' . '\r\n';
	
	$body .= '<!-- Start of Postfooter -->' . '\r\n';
	$body .= '<table width="100%" bgcolor="#ffffff" cellpadding="0" cellspacing="0" border="0" id="backgroundTable" st-sortable="postfooter" >' . '\r\n';
	$body .= '<tbody>' . '\r\n';
	$body .= '<tr>' . '\r\n';
	$body .= '<td>' . '\r\n';
	$body .= '<table width="600" cellpadding="0" cellspacing="0" border="0" align="center" class="devicewidth">' . '\r\n';
	$body .= '<tbody>' . '\r\n';
	$body .= '<tr>' . '\r\n';
	$body .= '<td width="100%">' . '\r\n';
	$body .= '<table width="600" cellpadding="0" cellspacing="0" border="0" align="center" class="devicewidth">' . '\r\n';
	$body .= '<tbody>' . '\r\n';
	$body .= '<tr>' . '\r\n';
	$body .= '<td align="center" valign="middle" style="font-family: Helvetica, arial, sans-serif; font-size: 14px;color: #666666" st-content="postfooter">' . '\r\n';
	$body .= '<a href="http://www.julianrimet.com">JRPL website</a>' . '\r\n';
	$body .= '</td>' . '\r\n';
	$body .= '</tr>' . '\r\n';
	$body .= '<!-- Spacing -->' . '\r\n';
	$body .= '<tr>' . '\r\n';
	$body .= '<td width="100%" height="20"></td>' . '\r\n';
	$body .= '</tr>' . '\r\n';
	$body .= '<!-- Spacing -->' . '\r\n';
	$body .= '</tbody>' . '\r\n';
	$body .= '</table>' . '\r\n';
	$body .= '</td>' . '\r\n';
	$body .= '</tr>' . '\r\n';
	$body .= '</tbody>' . '\r\n';
	$body .= '</table>' . '\r\n';
	$body .= '</td>' . '\r\n';
	$body .= '</tr>' . '\r\n';
	$body .= '</tbody>' . '\r\n';
	$body .= '</table>' . '\r\n';
	$body .= '<!-- End of postfooter -->' . '\r\n';

    // Send e-mail
    sendEmail($toEmail,$emailSubject,$css,$body);

    // Update DB to log e-mail being sent
    $sql = "UPDATE `Email`
            SET `PredictionsSent` = TRUE
            WHERE `MatchID`=" . $row['MatchID'];

    $resultBody = mysqli_query($link, $sql);
    if (!$resultBody)
    {
        $error = 'Error updating email sent table: <br />' . mysqli_error($link) . '<br /><br />' . $sql;
        sendEmail('james.macadie@telerealtrillium.com','Predictions Email Error','',$error);
        exit();
    }
}

?>