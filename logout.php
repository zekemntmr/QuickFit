<?php
session_start();

// Unset all session variables
$_SESSION = array();

// Destroy the session cookie if it exists
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time()-42000, '/');
}

// Clear the session from the server
session_destroy();

// Redirect to the landing page (index.php)
header("Location: index.php");
exit();
?>