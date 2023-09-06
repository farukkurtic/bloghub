<?php

session_start();

// Clear all session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Redirect the user to the sign-in page or any other desired location
header("Location: login.php");
exit();

?>