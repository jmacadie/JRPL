<?php

// Set scoring system
if (!isset($_SESSION['scoringSystem']) || !int($_SESSION['scoringSystem']) || ($_SESSION['scoringSystem'] < 1)) $_SESSION['scoringSystem'] = 1;

// Check if form has been posted back
if (array_key_exists('_submit_check',$_POST)) {

  // Check scoring system has been correctly posted
  if(isset($_POST['scoringSystem']) && int($_POST['scoringSystem']) && ($_POST['scoringSystem'] > 0)) {
    // Update session variable
    $_SESSION['scoringSystem'] = $_POST['scoringSystem'];
  }
}

// Get DB connection
include $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
// Grab scoring systems
// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

// Build SQL
$sql = "SELECT `ScoringSystemID`, `Name`
    FROM `ScoringSystem`
    ORDER BY `ScoringSystemID` ASC;";

// Run query and process any error
$result = mysqli_query($link, $sql);
if (!$result) {
  $error = 'Error fetching scoring systems: <br />' . mysqli_error($link) . '<br /><br />' . $sql;

  header('Content-type: application/json');
  $arr = array('result' => 'No', 'message' => $error);
  echo json_encode($arr);
  die();
}

// Store results
$arrSS = array();
while($row = mysqli_fetch_assoc($result)) {
  $arrSS[] = $row;
}


?>