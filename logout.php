<?php
// Start the session
session_start();

// Destroy the session
session_destroy();

// Redirect to home page
header("Location: index.html");
exit();
?>
