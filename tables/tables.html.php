<h1>Tables</h1>
<div id="messageTables"></div>
<hr>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/scoringSystemForm.html.php'; ?>
<hr>
<h3>Overall</h3>
<?php $sID = 'OverallCont';
$rLeague = $resultLeague;
include 'table.html.php'; ?>
<hr>
<h3>Group Stages</h3>
<?php $sID = 'GSCont';
$rLeague = $resultGSLeague;
include 'table.html.php'; ?>
<hr>
<h3>Last 16</h3>
<?php $sID = 'L16Cont';
$rLeague = $resultL16League;
include 'table.html.php'; ?>
<hr>
<h3>Semi-Finals, Quarter-Finals, 3<sup>rd</sup> 4<sup>th</sup> Place Play-off & Final</h3>
<?php $sID = 'RCont';
$rLeague = $resultRLeague;
include 'table.html.php'; ?>
