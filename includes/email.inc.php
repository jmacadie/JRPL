<?php

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
	
	$MESSAGE_BODY = '<html><head>';
    $MESSAGE_BODY .= '<style type="text/css">';
	$MESSAGE_BODY .= $css;
    $MESSAGE_BODY .= '</style>';
	$MESSAGE_BODY .= '</head>';
	
	// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
	// Body - Write details
	// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
	$MESSAGE_BODY .= '<body>';
	$MESSAGE_BODY .= 'to: ' .$to . '<br /><br />';
	$MESSAGE_BODY .= $body;
	$MESSAGE_BODY .= '<br /><br />Yours,<br />Jules, 3rd President of FIFA<br />';
	$MESSAGE_BODY .= '<a href="http://www.julianrimet.com">JRPL website</a></body></html>';
	
	// Send e-mail
	mail('james.macadie@telerealtrillium.com', $subject, $MESSAGE_BODY, $mailHeader) or die ("Failure");
	//mail($to, $subject, $MESSAGE_BODY, $mailHeader) or die ("Failure");

}

?>