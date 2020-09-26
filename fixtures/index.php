<?php
// Make sure all relevant includes are loaded
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/includesfile.inc.php';

if (isset($_GET['calc'])) {
  include $_SERVER['DOCUMENT_ROOT'] . '/match/calcPoints.inc.php';
  calculatePoints(1);
  calculatePoints(2);
  calculatePoints(3);
  calculatePoints(4);
  calculatePoints(5);
  calculatePoints(6);
  calculatePoints(7);
  calculatePoints(8);
  calculatePoints(11);
  calculatePoints(12);
  calculatePoints(13);
  calculatePoints(14);
  calculatePoints(15);
  calculatePoints(16);
  calculatePoints(17);
  calculatePoints(18);
  calculatePoints(19);
  calculatePoints(20);
  calculatePoints(21);
}

// Set tab variable to indicate point to fixtures tab
$tab = 'fixtures';

// Set Content pointer
$content = $_SERVER['DOCUMENT_ROOT'] . '/fixtures/fixtures.html.php';
$contentjs = $_SERVER['DOCUMENT_ROOT'] . '/fixtures/fixtures.js.php';

// Call main HTML page
include $_SERVER['DOCUMENT_ROOT'] . '/includes/template.html.php';
