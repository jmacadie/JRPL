<?php
// Make sure all relevant includes are loaded
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/includesfile.inc.php';

// Start the session if needed
if (!isset($_SESSION)) session_start();

// Set up the filter variables
$excPlayed = (isset($_SESSION['excPlayed'])) ? $_SESSION['excPlayed'] : true;
$excPredicted = (isset($_SESSION['excPredicted'])) ? $_SESSION['excPredicted'] : false;
$t1 = (isset($_SESSION['t1'])) ? $_SESSION['t1'] : true;
$t2 = (isset($_SESSION['t2'])) ? $_SESSION['t2'] : true;
$t3 = (isset($_SESSION['t3'])) ? $_SESSION['t3'] : true;
$t4 = (isset($_SESSION['t4'])) ? $_SESSION['t4'] : true;
$t5 = (isset($_SESSION['t5'])) ? $_SESSION['t5'] : true;
$t6 = (isset($_SESSION['t6'])) ? $_SESSION['t6'] : true;
$t7 = (isset($_SESSION['t7'])) ? $_SESSION['t7'] : true;
$t8 = (isset($_SESSION['t8'])) ? $_SESSION['t8'] : true;
$t9 = (isset($_SESSION['t9'])) ? $_SESSION['t9'] : true;
$t10 = (isset($_SESSION['t10'])) ? $_SESSION['t10'] : true;
$t11 = (isset($_SESSION['t11'])) ? $_SESSION['t11'] : true;
$t12 = (isset($_SESSION['t12'])) ? $_SESSION['t12'] : true;
$t13 = (isset($_SESSION['t13'])) ? $_SESSION['t13'] : true;
$t14 = (isset($_SESSION['t14'])) ? $_SESSION['t14'] : true;
$t15 = (isset($_SESSION['t15'])) ? $_SESSION['t15'] : true;
$t16 = (isset($_SESSION['t16'])) ? $_SESSION['t16'] : true;
$t17 = (isset($_SESSION['t17'])) ? $_SESSION['t17'] : true;
$t18 = (isset($_SESSION['t18'])) ? $_SESSION['t18'] : true;
$t19 = (isset($_SESSION['t19'])) ? $_SESSION['t19'] : true;
$t20 = (isset($_SESSION['t20'])) ? $_SESSION['t20'] : true;
$gw1 = (isset($_SESSION['gw1'])) ? $_SESSION['gw1'] : true;
$gw2 = (isset($_SESSION['gw2'])) ? $_SESSION['gw2'] : true;
$gw3 = (isset($_SESSION['gw3'])) ? $_SESSION['gw3'] : true;
$gw4 = (isset($_SESSION['gw4'])) ? $_SESSION['gw4'] : true;
$gw5 = (isset($_SESSION['gw5'])) ? $_SESSION['gw5'] : true;
$gw6 = (isset($_SESSION['gw6'])) ? $_SESSION['gw6'] : true;
$gw7 = (isset($_SESSION['gw7'])) ? $_SESSION['gw7'] : true;
$gw8 = (isset($_SESSION['gw8'])) ? $_SESSION['gw8'] : true;
$gw9 = (isset($_SESSION['gw9'])) ? $_SESSION['gw9'] : true;
$gw10 = (isset($_SESSION['gw10'])) ? $_SESSION['gw10'] : true;
$gw11 = (isset($_SESSION['gw11'])) ? $_SESSION['gw11'] : true;
$gw12 = (isset($_SESSION['gw12'])) ? $_SESSION['gw12'] : true;
$gw13 = (isset($_SESSION['gw13'])) ? $_SESSION['gw13'] : true;
$gw14 = (isset($_SESSION['gw14'])) ? $_SESSION['gw14'] : true;
$gw15 = (isset($_SESSION['gw15'])) ? $_SESSION['gw15'] : true;
$gw16 = (isset($_SESSION['gw16'])) ? $_SESSION['gw16'] : true;
$gw17 = (isset($_SESSION['gw17'])) ? $_SESSION['gw17'] : true;
$gw18 = (isset($_SESSION['gw18'])) ? $_SESSION['gw18'] : true;
$gw19 = (isset($_SESSION['gw19'])) ? $_SESSION['gw19'] : true;
$gw20 = (isset($_SESSION['gw20'])) ? $_SESSION['gw20'] : true;
$gw21 = (isset($_SESSION['gw21'])) ? $_SESSION['gw21'] : true;
$gw22 = (isset($_SESSION['gw22'])) ? $_SESSION['gw22'] : true;
$gw23 = (isset($_SESSION['gw23'])) ? $_SESSION['gw23'] : true;
$gw24 = (isset($_SESSION['gw24'])) ? $_SESSION['gw24'] : true;
$gw25 = (isset($_SESSION['gw25'])) ? $_SESSION['gw25'] : true;
$gw26 = (isset($_SESSION['gw26'])) ? $_SESSION['gw26'] : true;
$gw27 = (isset($_SESSION['gw27'])) ? $_SESSION['gw27'] : true;
$gw28 = (isset($_SESSION['gw28'])) ? $_SESSION['gw28'] : true;
$gw29 = (isset($_SESSION['gw29'])) ? $_SESSION['gw29'] : true;
$gw30 = (isset($_SESSION['gw30'])) ? $_SESSION['gw30'] : true;
$gw31 = (isset($_SESSION['gw31'])) ? $_SESSION['gw31'] : true;
$gw32 = (isset($_SESSION['gw32'])) ? $_SESSION['gw32'] : true;
$gw33 = (isset($_SESSION['gw33'])) ? $_SESSION['gw33'] : true;
$gw34 = (isset($_SESSION['gw34'])) ? $_SESSION['gw34'] : true;
$gw35 = (isset($_SESSION['gw35'])) ? $_SESSION['gw35'] : true;
$gw36 = (isset($_SESSION['gw36'])) ? $_SESSION['gw36'] : true;
$gw37 = (isset($_SESSION['gw37'])) ? $_SESSION['gw37'] : true;
$gw38 = (isset($_SESSION['gw38'])) ? $_SESSION['gw38'] : true;

// Set tab variable to indicate point to fixtures tab
$tab = 'fixtures';

// Set Content pointer
$content = $_SERVER['DOCUMENT_ROOT'] . '/fixtures/fixtures.html.php';
$contentjs = $_SERVER['DOCUMENT_ROOT'] . '/fixtures/fixtures.js.php';

// Call main HTML page
include $_SERVER['DOCUMENT_ROOT'] . '/includes/template.html.php';
