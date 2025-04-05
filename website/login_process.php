<?php
// login_process.php

session_start(); // Essential for login: start the session

// Include database connection
require_once 'connection.php';

// Check if the form was submitted using POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // --- Input Retrieval ---
    $username_or_email = trim($_POST['username'] ?? ''); // Can be username or email
    $password = $_POST['password'] ?? '';

    $error = ''; // Variable to hold login error message

    // Basic validation
    if (empty($username_or_email)) {
        $error = "Please enter username or email.";
    } elseif (empty($password)) {
        $error = "Please enter your password.";
    }

    // --- If no basic validation errors, proceed to check database ---
    if (empty($error)) {
        // Prepare a select statement (allow login via username OR email)
        $sql = "SELECT id, username, email, password FROM users WHERE username = ? OR email = ?";

        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("ss", $param_login_identifier, $param_login_identifier); // Bind the same variable twice

            $param_login_identifier = $username_or_email;

            if ($stmt->execute()) {
                $stmt->store_result(); // Store result to check num_rows

                // Check if account exists
                if ($stmt->num_rows == 1) {
                    // Bind result variables
                    $stmt->bind_result($id, $username, $email, $hashed_password);

                    if ($stmt->fetch()) {
                        // Verify password
                        if (password_verify($password, $hashed_password)) {
                            // Password is correct, start a new session

                            // Regenerate session ID for security (prevents session fixation)
                            session_regenerate_id(true);

                            // Store data in session variables
                            $_SESSION["loggedin"] = true; // Flag to indicate user is logged in
                            $_SESSION["user_id"] = $id;
                            $_SESSION["username"] = $username;
                            $_SESSION["email"] = $email; // Store email as well if needed

                            // Redirect back to index.php with a success flag
                            header("location: index.php?login=success");
                            exit();
                        } else {
                            // Password is not valid
                            $error = "Invalid password.";
                        }
                    }
                } else {
                    // Username/Email doesn't exist
                    $error = "No account found with that username or email.";
                }
            } else {
                $error = "Oops! Something went wrong executing the query. Please try again later.";
                // Log error: $stmt->error;
            }

            // Close statement
            $stmt->close();
        } else {
            $error = "Oops! Something went wrong preparing the query. Please try again later.";
            // Log error: $conn->error;
        }
    }

    // --- If there was an error, redirect back to login page ---
    if (!empty($error)) {
        $_SESSION['login_error'] = $error; // Store error in session
        header("location: login.php");
        exit();
    }

    // Close connection
    $conn->close();

} else {
    // If the script was accessed directly without POST data, redirect
    header("location: login.php");
    exit();
}
?>