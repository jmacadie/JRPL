<?php
// Start the session if needed
if (!isset($_SESSION)) session_start();

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
// Includes
// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

// Web version
include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/magicquotes.inc.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/access.inc.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/email.inc.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/helpers.inc.php';

?>