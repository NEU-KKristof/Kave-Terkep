<?php
// logout.php
session_start(); // Initialize the session

// Unset all of the session variables
$_SESSION = array(); // Clears all session data

// Destroy the session.
if (session_destroy()) {
    // Redirect to login page after successful logout
    header("location: login.php");
    exit;
} else {
    // Handle potential errors during session destruction (optional)
    echo "Error destroying session.";
    // Maybe log this error
}
?>