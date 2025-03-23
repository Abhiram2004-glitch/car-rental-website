<?php
session_start();

// Destroy the session to log the user out
session_destroy();

// Redirect to the login page (change the URL to your login page)
header('Location: index.php');
exit;
?>
