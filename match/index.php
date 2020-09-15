<?php
// Make sure all relevant includes are loaded

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
// Set-up
// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

// Make sure all relevant includes are loaded
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/includesfile.inc.php';

// Check $_GET and $_SESSION variables for Match ID
if (isset($_GET['id'])) {
  $gMatchID = $_GET['id'];
  $_SESSION['matchID'] = $gMatchID;
} elseif (isset($_SESSION['matchID'])) {
  $gMatchID = $_SESSION['matchID'];
}

// Check if $_SESSION variable for the ring is set and generate if not
if (!isset($_SESSION['ring'])) {
  //TODO: Fix this section
  include $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';
  if (!isset($link)) {
    $error = 'Error getting DB connection';
    die($error);
  }

  $sql = "SELECT `MatchID` FROM `Match` ORDER BY `Date` ASC, `KickOff` ASC;";

  // Run query and handle any failure
  $result = mysqli_query($link, $sql);
  if (!$result) {
    $error = 'Error fetching matches: <br />' . mysqli_error($link) . '<br /><br />' . $sql;
    die($error);
  }

  // Store results
  $arrMatchIDs = array();
  while($row = mysqli_fetch_assoc($result)) {
    $arrMatchIDs[] = $row['MatchID'];
  }
  $_SESSION['ring'] = $arrMatchIDs;
}
// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
// Process Match ID and ring variables
// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

//Check if matchID has been posted
if (isset($gMatchID) && int($gMatchID) && ($gMatchID > 0)) {
  // MatchID has been properly posted so proceed

  // Call the getMatchDetails script to load all the variables for the match page
  include 'getMatchDetails.php';

  // Make sure we've got the variables we need
  if (!isset($homeTeamS))
    $homeTeamS = "";
  if (!isset($awayTeamS))
    $awayTeamS = "";

  // Sort out flag links
  $homeFlag = ($homeTeamS == '') ? 'tmp' : strtolower($homeTeamS);
  $awayFlag = ($awayTeamS == '') ? 'tmp' : strtolower($awayTeamS);

  // Sort out the previous and next links based on the ring variable
  $ring = $_SESSION['ring'];
  $i = 0;
  $found = false;
  $max = count($ring);
  while (!$found && ($i < $max)) {
    // Found the match in the ring
    if ($ring[$i] == $gMatchID) {
      // Find previous & next matches
      $prevID = ($i == 0) ? ($max - 1) : ($i - 1);
      $nextID = ($i == $max - 1) ? 0 : ($i + 1);
      $prev = '../match?id=' . $ring[$prevID];
      $next = '../match?id=' . $ring[$nextID];
      // Set found variable to be true
      $found = true;
    }
    // Increment the counter
    $i++;
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
