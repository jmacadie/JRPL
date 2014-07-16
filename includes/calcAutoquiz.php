<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/includesfile.inc.php';

for ($i=1; $i<=64; $i++) {
	calculateAutoQuizPoints($i);
	echo($i . ' done<br />');
}

?>