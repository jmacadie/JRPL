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
	$mailHeader = "From: jules@julianrimet.com\r\n";
	$mailHeader .= "Reply-To: jules@julianrimet.com\r\n";
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
	$MESSAGE_BODY .= 'to: ' .$to . '<br /><br />' . chr(13);
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
	mail('james.macadie@telerealtrillium.com', $subject, $MESSAGE_BODY, $mailHeader) or die ("Failure");
	//mail($to, $subject, $MESSAGE_BODY, $mailHeader) or die ("Failure");

}

?>