<?php
// Make sure all relevant includes are loaded

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
// Set-up
// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

// Make sure all relevant includes are loaded
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/includesfile.inc.php';

// Run scoring system checks and set-up
include $_SERVER['DOCUMENT_ROOT'] . '/includes/processScoringSystem.inc.php';

// Check $_GET and $_SESSION variables for Match ID
if (isset($_GET['id'])) {
  $gMatchID = $_GET['id'];
  $_SESSION['matchID'] = $gMatchID;
} elseif (isset($_SESSION['matchID'])) {
  $gMatchID = $_SESSION['matchID'];
}

// Check $_GET and $_SESSION variables for Ring
if (isset($_GET['ring'])) {
  $gRing = $_GET['ring'];
  $_SESSION['ring'] = $gRing;
} elseif (isset($_SESSION['ring'])) {
  $gRing = $_SESSION['ring'];
}

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
// Process Match ID and ring variables
// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

//Check if matchID has been posted
if (isset($gMatchID) && int($gMatchID) && ($gMatchID > 0)) {
  // MatchID has been properly posted so proceed

  // Call the getMatchDetails script to load all the variables for the match page
  include 'getMatchDetails.php';

  // Sort out flag links
  $homeFlag = ($homeTeamS == '') ? 'tmp' : strtolower($homeTeamS);
  $awayFlag = ($awayTeamS == '') ? 'tmp' : strtolower($awayTeamS);
  $homeHomeFlag = ($homeTeamHomeTeamS == '') ? 'tmp' : strtolower($homeTeamHomeTeamS);
  $homeAwayFlag = ($homeTeamAwayTeamS == '') ? 'tmp' : strtolower($homeTeamAwayTeamS);
  $awayHomeFlag = ($awayTeamHomeTeamS == '') ? 'tmp' : strtolower($awayTeamHomeTeamS);
  $awayAwayFlag = ($awayTeamAwayTeamS == '') ? 'tmp' : strtolower($awayTeamAwayTeamS);

  // Sort out the previous and next links based on the ring variable
  if (isset($gRing) || ($gRing == 0)) {

    //Convert hex string back into binary
    $tmp = ring_base_convert($gRing);

    // Set previous match link by looping back until we hit a match
    // which is set in the ring variable, with a 1
    $i = $gMatchID + 0;
    do {
      if ($i == 1) {
        $i = 64;
      } else {
        $i -= 1;
      }
      $j = substr($tmp, $i - 1, 1);
    } while ($j == 0);
    $prevID = max($i, 1);
    $prev = '../match?id=' . $prevID .'&ring='. $gRing;

    // Set next match link by looping forward until we hit a match
    // which is set in the ring variable, with a 1
    $i = $gMatchID + 0;
    do {
      if ($i == 64) {
        $i = 1;
      } else {
        $i += 1;
      }
      $j = substr($tmp, $i - 1, 1);
    } while ($j == 0);
    $nextID = min($i, 64);
    $next = '../match?id=' . $nextID .'&ring='. $gRing;

  } else {

    // Absent the ring variable just increment the Match ID
    $prevID = $gMatchID - 1;
    if ($prevID == 0) $prevID == 64;
    $prev = '../match?id=' . $prevID;

    $nextID = $gMatchID + 1;
    if ($nextID == 65) $nextID == 1;
    $next = '../match?id=' . $nextID;

  }

  // Set tab variable to indicate point to match page
  $tab = 'match';

  // Set content pointers
  $content = $_SERVER['DOCUMENT_ROOT'] . '/match/match.html.php';

} else {
  // MatchID has not been properly posted so return error

  $content = '<h2>No Match chosen, please go back to <a href="../fixtures">fixtures page</a></h2>';
  // Set content pointers
  $content = $_SERVER['DOCUMENT_ROOT'] . '/match/badMatch.html.php';

}

// Call main HTML page
$contentjs = $_SERVER['DOCUMENT_ROOT'] . '/match/match.js.php';
include $_SERVER['DOCUMENT_ROOT'] . '/includes/template.html.php';

?>