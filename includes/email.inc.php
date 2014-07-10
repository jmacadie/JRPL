<?php

// Standard CSS for JRPL e-mails
function emailCSS () {

	$css = '/* Client-specific Styles */' . chr(13);
    $css .= '#outlook a {padding:0;} /* Force Outlook to provide a "view in browser" menu link. */' . chr(13);
	$css .= 'body{width:100% !important; -webkit-text-size-adjust:100%; -ms-text-size-adjust:100%; margin:0; padding:0;}' . chr(13);
	$css .= '/* Prevent Webkit and Windows Mobile platforms from changing default font sizes, while not breaking desktop design. */' . chr(13);
	$css .= '.ExternalClass {width:100%;} /* Force Hotmail to display emails at full width */' . chr(13);
	$css .= '.ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div {line-height: 100%;} /* Force Hotmail to display normal line spacing.*/' . chr(13);
	$css .= '#backgroundTable {margin:0; padding:0; width:100% !important; line-height: 100% !important;}' . chr(13);
	$css .= 'img {outline:none; text-decoration:none;border:none; -ms-interpolation-mode: bicubic;}' . chr(13);
	$css .= 'a img {border:none;}' . chr(13);
	$css .= '.image_fix {display:block;}' . chr(13);
	$css .= 'p {margin: 0px 0px !important;}' . chr(13);
	$css .= 'table td {border-collapse: collapse;}' . chr(13);
	$css .= 'table { border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt; }' . chr(13);
	$css .= 'a {color: #0a8cce;text-decoration: none;text-decoration:none!important;}' . chr(13);
	$css .= '/*STYLES*/' . chr(13);
	$css .= 'table[class=full] { width: 100%; clear: both; }' . chr(13);
	$css .= '/*IPAD STYLES*/' . chr(13);
	$css .= '@media only screen and (max-width: 640px) {' . chr(13);
	$css .= 'a[href^="tel"], a[href^="sms"] {' . chr(13);
	$css .= 'text-decoration: none;' . chr(13);
	$css .= 'color: #0a8cce; /* or whatever your want */' . chr(13);
	$css .= 'pointer-events: none;' . chr(13);
	$css .= 'cursor: default;' . chr(13);
	$css .= '}' . chr(13);
	$css .= '.mobile_link a[href^="tel"], .mobile_link a[href^="sms"] {' . chr(13);
	$css .= 'text-decoration: default;' . chr(13);
	$css .= 'color: #0a8cce !important;' . chr(13);
	$css .= 'pointer-events: auto;' . chr(13);
	$css .= 'cursor: default;' . chr(13);
	$css .= '}' . chr(13);
	$css .= 'table[class=devicewidth] {width: 440px!important;text-align:center!important;}' . chr(13);
	$css .= 'table[class=devicewidthinner] {width: 420px!important;text-align:center!important;}' . chr(13);
	$css .= 'img[class=banner] {width: 440px!important;height:220px!important;}' . chr(13);
	$css .= 'img[class=colimg2] {width: 440px!important;height:220px!important;}' . chr(13);
	$css .= '}' . chr(13);
	$css .= '/*IPHONE STYLES*/' . chr(13);
	$css .= '@media only screen and (max-width: 480px) {' . chr(13);
	$css .= 'a[href^="tel"], a[href^="sms"] {' . chr(13);
	$css .= 'text-decoration: none;' . chr(13);
	$css .= 'color: #0a8cce; /* or whatever your want */' . chr(13);
	$css .= 'pointer-events: none;' . chr(13);
	$css .= 'cursor: default;' . chr(13);
	$css .= '}' . chr(13);
	$css .= '.mobile_link a[href^="tel"], .mobile_link a[href^="sms"] {' . chr(13);
	$css .= 'text-decoration: default;' . chr(13);
	$css .= 'color: #0a8cce !important;' . chr(13);
	$css .= 'pointer-events: auto;' . chr(13);
	$css .= 'cursor: default;' . chr(13);
	$css .= '}' . chr(13);
	$css .= 'table[class=devicewidth] {width: 280px!important;text-align:center!important;}' . chr(13);
	$css .= 'table[class=devicewidthinner] {width: 260px!important;text-align:center!important;}' . chr(13);
	$css .= 'img[class=banner] {width: 280px!important;height:140px!important;}' . chr(13);
	$css .= 'img[class=colimg2] {width: 280px!important;height:140px!important;}' . chr(13);
	$css .= 'td[class=mobile-hide]{display:none!important;}' . chr(13);
	$css .= 'td[class="padding-bottom25"]{padding-bottom:25px!important;}' . chr(13);
	$css .= '}' . chr(13);
	
	return $css;
	
}

// Mark-up to include a table in the
// HTML of the body
function bodyTable($comment, $content) {

	$text .= '<!-- Start  of ' . $comment . ' -->' . chr(13);
	$text .= '<table width="100%" bgcolor="#ffffff" cellpadding="0" cellspacing="0" border="0" id="backgroundTable" st-sortable="full-text">' . chr(13);
	$text .= '<tbody>' . chr(13);
	$text .= '<tr>' . chr(13);
	$text .= '<td>' . chr(13);
	$text .= '<table width="600" cellpadding="0" cellspacing="0" border="0" align="center" class="devicewidth">' . chr(13);
	$text .= '<tbody>' . chr(13);
	$text .= '<tr>' . chr(13);
	$text .= '<td width="100%">' . chr(13);
	$text .= '<table width="600" cellpadding="0" cellspacing="0" border="0" align="center" class="devicewidth">' . chr(13);
	$text .= '<tbody>' . chr(13);
	$text .= '<!-- Spacing -->' . chr(13);
	$text .= '<tr>' . chr(13);
	$text .= '<td height="20" style="font-size:1px; line-height:1px; mso-line-height-rule: exactly;">&nbsp;</td>' . chr(13);
	$text .= '</tr>' . chr(13);
	$text .= '<!-- End of Spacing -->' . chr(13);
	$text .= '<tr>' . chr(13);
	$text .= '<td>' . chr(13);
	$text .= '<table width="560" align="center" cellpadding="4" cellspacing="0" border="0" class="devicewidthinner">' . chr(13);
	$text .= '<tbody>' . chr(13);
	$text .= $content;
	$text .= '</tbody>' . chr(13);
	$text .= '</table>' . chr(13);
	$text .= '</td>' . chr(13);
	$text .= '</tr>' . chr(13);
	$text .= '<!-- Spacing -->' . chr(13);
	$text .= '<tr>' . chr(13);
	$text .= '<td height="20" style="font-size:1px; line-height:1px; mso-line-height-rule: exactly;">&nbsp;</td>' . chr(13);
	$text .= '</tr>' . chr(13);
	$text .= '<!-- End of Spacing -->' . chr(13);
	$text .= '</tbody>' . chr(13);
	$text .= '</table>' . chr(13);
	$text .= '</td>' . chr(13);
	$text .= '</tr>' . chr(13);
	$text .= '</tbody>' . chr(13);
	$text .= '</table>' . chr(13);
	$text .= '</td>' . chr(13);
	$text .= '</tr>' . chr(13);
	$text .= '</tbody>' . chr(13);
	$text .= '</table>' . chr(13);
	$text .= '<!-- End of ' . $comment . ' -->' . chr(13);
	
	return $text;

}

// Mark-up for an empty separator in the 
// HTML of the body
function bodySeparator($comment) {

	$text = '<!-- Start of ' . $comment . ' -->' . chr(13);
	$text .= '<table width="100%" bgcolor="#ffffff" cellpadding="0" cellspacing="0" border="0" id="backgroundTable" st-sortable="separator">' . chr(13);
	$text .= '<tbody>' . chr(13);
	$text .= '<tr>' . chr(13);
	$text .= '<td>' . chr(13);
	$text .= '<table width="600" align="center" cellspacing="0" cellpadding="0" border="0" class="devicewidth">' . chr(13);
	$text .= '<tbody>' . chr(13);
	$text .= '<tr>' . chr(13);
	$text .= '<td align="center" height="20" style="font-size:1px; line-height:1px;">&nbsp;</td>' . chr(13);
	$text .= '</tr>' . chr(13);
	$text .= '</tbody>' . chr(13);
	$text .= '</table>' . chr(13);
	$text .= '</td>' . chr(13);
	$text .= '</tr>' . chr(13);
	$text .= '</tbody>' . chr(13);
	$text .= '</table>' . chr(13);
	$text .= '<!-- End of ' . $comment . ' -->' . chr(13);
	
	return $text;

}

// Mark-up for a horizontal row separator in the 
// HTML of the body
function bodySeparatorHR($comment) {

	$text .= '<!-- Start of ' . $comment . ' -->' . chr(13);
	$text .= '<table width="100%" bgcolor="#ffffff" cellpadding="0" cellspacing="0" border="0" id="backgroundTable" st-sortable="separator">' . chr(13);
	$text .= '<tbody>' . chr(13);
	$text .= '<tr>' . chr(13);
	$text .= '<td>' . chr(13);
	$text .= '<table width="600" align="center" cellspacing="0" cellpadding="0" border="0" class="devicewidth">' . chr(13);
	$text .= '<tbody>' . chr(13);
	$text .= '<tr>' . chr(13);
	$text .= '<td align="center" height="30" style="font-size:1px; line-height:1px;">&nbsp;</td>' . chr(13);
	$text .= '</tr>' . chr(13);
	$text .= '<tr>' . chr(13);
	$text .= '<td width="550" align="center" height="1" bgcolor="#d1d1d1" style="font-size:1px; line-height:1px;">&nbsp;</td>' . chr(13);
	$text .= '</tr>' . chr(13);
	$text .= '<tr>' . chr(13);
	$text .= '<td align="center" height="30" style="font-size:1px; line-height:1px;">&nbsp;</td>' . chr(13);
	$text .= '</tr>' . chr(13);
	$text .= '</tbody>' . chr(13);
	$text .= '</table>' . chr(13);
	$text .= '</td>' . chr(13);
	$text .= '</tr>' . chr(13);
	$text .= '</tbody>' . chr(13);
	$text .= '</table>' . chr(13);
	$text .= '<!-- End of ' . $comment . ' --> ' . chr(13);
	
	return $text;

}

// Wrap content in a html <table> with no cell padding but just a 1px grey border
// This is only necessary because of the vagaries of html email
function tableBorder($content) {
	$text  = '<table border="0" cellpadding="0" cellspacing="0" border="0"><tr><td style="border: 1px solid #ccc;">' . chr(13);
	$text .= $content . chr(13);
	$text .= '</td></tr></table>';
	return $text;
 }

// Build HTML for body based on input array
// Cuts down on repetitive tables mark-up
function emailBody ($body) {
	
	$out = '';
	
	// Loop through each element
	foreach ($body as $ele) {
		
		if ($ele[0] == 'separator') {
			$out .= bodySeparator($ele[1]);
		} elseif ($ele[0] == 'separatorHR') {
			$out .= bodySeparatorHR($ele[1]);
		} elseif ($ele[0] == 'table') {
			$out .= bodyTable($ele[1],$ele[2]);
		}
		
	}
	
	return $out;
	
}

function sendEmail($to,$subject,$css,$body) {
	
	// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
	// Email header
	// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
	$mailHeader = "From: julian@julianrimet.com\r\n";
	$mailHeader .= "Reply-To: julian@julianrimet.com\r\n";
	$mailHeader .= "Content-type: text/html; charset=iso-8859-1\r\n";
	
	// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
	// Body - HTML Head section (formatting)
	// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
	
	$MESSAGE_BODY = '<html>' . chr(13);
	$MESSAGE_BODY .= '<head>' . chr(13);
    $MESSAGE_BODY .= '<style type="text/css">' . chr(13);
	if ($css == 'standard') {
		$MESSAGE_BODY .= emailCSS();
	} else {
		$MESSAGE_BODY .= $css;
	}
    $MESSAGE_BODY .= '</style>' . chr(13);
	$MESSAGE_BODY .= '</head>' . chr(13);
	
	// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
	// Body - Write details
	// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
	$MESSAGE_BODY .= '<body>' . chr(13);
	//$MESSAGE_BODY .= 'to: ' .$to . '<br /><br />' . chr(13);
	if (is_array($body)) {
		$MESSAGE_BODY .= emailBody($body);
	} else {
		$MESSAGE_BODY .= $body;
	}
	$MESSAGE_BODY .= '<br /><br />Yours,<br />Jules, 3rd President of FIFA<br />' . chr(13);
	$MESSAGE_BODY .= '<a href="http://www.julianrimet.com">JRPL website</a>' . chr(13);
	$MESSAGE_BODY .= '</body>' . chr(13);
	$MESSAGE_BODY .= '</html>' . chr(13);
	
	// Send e-mail
	//mail('james.macadie@telerealtrillium.com', $subject, $MESSAGE_BODY, $mailHeader) or die ("Failure");
	mail($to, $subject, $MESSAGE_BODY, $mailHeader) or die ("Failure");

}

// Send e-mail of the results from the posted match
function sendResultsEmail ($matchID) {
	
	// Get DB connection
	include $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';
	
	// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    // Get match details
    // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    $sql = "SELECT
                IFNULL(ht.`Name`,trht.`Name`) AS `HomeTeam`,
				IFNULL(at.`Name`,trat.`Name`) AS `AwayTeam`,
				IFNULL(ht.`ShortName`,'') AS `HomeTeamS`,
				IFNULL(at.`ShortName`,'') AS `AwayTeamS`,
				m.`HomeTeamGoals`,
				m.`AwayTeamGoals`

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
    if (!$result)
    {
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
    $sql = "SELECT
                mu.`DisplayName`,
                IFNULL(p.`HomeTeamGoals`,'No prediction') AS `HomeTeamGoals`,
				IFNULL(p.`AwayTeamGoals`,'No prediction') AS `AwayTeamGoals`,
				IFNULL(po.`TotalPoints`,0) AS `TotalPoints`

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
				po.`TotalPoints` DESC,
				(p.`HomeTeamGoals` - p.`AwayTeamGoals`) DESC,
				p.`HomeTeamGoals` DESC;";

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
	$heading .= $row['HomeTeamGoals'] . '&nbsp;-&nbsp;' . $row['AwayTeamGoals'] . chr(13);
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
		if ($rowMatch['HomeTeamGoals'] == 'No prediction') {
			$match .= '<i>No prediction</i>' . chr(13);
		} else {
			if ($rowMatch['HomeTeamGoals'] > $rowMatch['AwayTeamGoals']) {
				$match .= $row['HomeTeam'] . ' to win<br/>' . chr(13);
				$match .= $rowMatch['HomeTeamGoals'] . '&nbsp;-&nbsp;' . $rowMatch['AwayTeamGoals'];
			} elseif ($rowMatch['AwayTeamGoals'] > $rowMatch['HomeTeamGoals']) {
				$match .= $row['AwayTeam'] . ' to win<br/>' . chr(13);
				$match .= $rowMatch['AwayTeamGoals'] . '&nbsp;-&nbsp;' . $rowMatch['HomeTeamGoals'];
			} else {
				$match .= 'Draw<br/>' . chr(13);
				$match .= $rowMatch['HomeTeamGoals'] . '&nbsp;-&nbsp;' . $rowMatch['AwayTeamGoals'];
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
    $sql = "UPDATE `Emails`
            SET `ResultsSent` = 1
            WHERE `MatchID` = " . $matchID;

    $resultBody = mysqli_query($link, $sql);
    if (!$resultBody)
    {
        $error = 'Error updating email sent table: <br />' . mysqli_error($link) . '<br /><br />' . $sql;
        
		header('Content-type: application/json');
		$arr = array('result' => 'No', 'message' => $error);
		echo json_encode($arr);
		die();
    }

}

?>