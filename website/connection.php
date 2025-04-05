<?php
// connection.php

// --- Database Credentials ---
// !! Important: Replace with your actual database details !!
define('DB_SERVER', 'localhost');      // Your database server (often 'localhost')
define('DB_USERNAME', 'root');         // Your database username
define('DB_PASSWORD', '');             // Your database password
define('DB_NAME', 'user_auth_db'); // The name of the database created in database.sql

// --- Attempt to connect to MySQL database ---
$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check connection
if ($conn->connect_error) {
    // Using die() stops script execution and prints a message.
    // In a production environment, you might want more sophisticated error handling/logging.
    die("ERROR: Could not connect. " . $conn->connect_error);
}

// Optional: Set character set (recommended)
if (!$conn->set_charset("utf8mb4")) {
    // Handle error if charset setting fails (optional)
    // printf("Error loading character set utf8mb4: %s\n", $conn->error);
}

// The $conn variable now holds the database connection and can be used by including this file.
?>