<h1>Tables</h1>
<div id="messageTables"></div>
<hr>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/scoringSystemForm.html.php'; ?>
<hr>
<h3>Overall</h3>
<?php
  $sID = 'OverallCont';
  if (isset($resultLeague))
    $rLeague = $resultLeague;
  include 'table.html.php';
?>
<hr>
<h3>Group Stages</h3>
<?php
  $sID = 'GSCont';
  if (isset($resultGSLeague))
    $rLeague = $resultGSLeague;
  include 'table.html.php';
?>
<hr>
<h3>Round of 16, Semi-Finals, Quarter-Finals & Final</h3>
<?php
  $sID = 'RCont';
  if (isset($resultRLeague))
    $rLeague = $resultRLeague;
  include 'table.html.php';
?>
