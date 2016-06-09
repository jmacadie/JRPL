<?php
// Start the session if needed
if (!isset($_SESSION)) session_start();
// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
// Includes
// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/includesfile.inc.php';
// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
// Get data for Users
// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
// Get DB connection
include $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';
if (!isset($link)) {
  $error = 'Error getting DB connection';
  header('Content-type: application/json');
  $arr = array('result' => 'No', 'message' => $error);
  echo json_encode($arr);
  die();
}
// Query to pull tournament role data from DB
$sql =
"SELECT
  u.`UserID`
  ,IFNULL(u.`DisplayName`,CONCAT(u.`FirstName`,' ',u.`LastName`)) AS `DisplayName`
FROM `User` u;";
// Run query and handle any failure
$result = mysqli_query($link, $sql);
if (!$result) {
  $error =
    'Error fetching users: <br />' .
    mysqli_error($link) .
    '<br /><br />' .
    $sql;
  header('Content-type: application/json');
  $arr = array('result' => 'No', 'message' => $error);
  echo json_encode($arr);
  die();
}
// Build array of outputs
$users = array();
while ($row = mysqli_fetch_array($result)) {
  $users[] = array(
    'userID' => $row['UserID']
    ,'name' => $row['DisplayName']);
}
