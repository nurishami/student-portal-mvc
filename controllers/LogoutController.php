<?php

session_start();

// Remove all session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Redirect to login page
header("Location: ../views/login.php");
exit();

?>