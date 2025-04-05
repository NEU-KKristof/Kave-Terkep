<?php
// signup_process.php

session_start(); // Start session to store potential error messages

// Include database connection
require_once 'connection.php'; // Use require_once to ensure it's included only once and is essential

// Check if the form was submitted using POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // --- Input Retrieval & Basic Validation ---
    $username = trim($_POST['username'] ?? ''); // Use null coalescing operator for safety
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? ''; // Don't trim password initially

    $errors = []; // Array to hold validation errors

    if (empty($username)) {
        $errors[] = "A neve kitölteni kötelező";
    } elseif (!preg_match('/^[a-zA-Z0-9_]+$/', $username)) {
        // Basic check for allowed characters (alphanumeric and underscore)
        $errors[] = "A felhasználó név csak betűket számokat és aláhúzásokat tartalmazhat.";
    }

    if (empty($email)) {
        $errors[] = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Nem ismert email";
    }

    if (empty($password)) {
        $errors[] = "A jelszót kitölteni kötelező";
    } elseif (strlen($password) < 3) {
        $errors[] = "A jelszónak legalább 3 karakter hosszúnak kell lennie";
    }

    if (empty($errors)) {
        $sql_check = "SELECT id FROM users WHERE username = ? OR email = ?";

        if ($stmt_check = $conn->prepare($sql_check)) {
            $stmt_check->bind_param("ss", $param_username_check, $param_email_check);
            $param_username_check = $username;
            $param_email_check = $email;

            if ($stmt_check->execute()) {
                $stmt_check->store_result(); // Store result to check num_rows

                if ($stmt_check->num_rows > 0) {
                    // Determine if username or email caused the conflict (optional refinement)
                     $stmt_check->bind_result($id_check); // Bind a result variable
                     $stmt_check->fetch(); // Fetch the row to know which field matched (though we don't use id_check here)
                     // More complex logic could check which field caused the match if needed
                    $errors[] = "A név vagy az email már foglalt";
                }
            } else {
                $errors[] = "Valami hiba történt.";
            }
            $stmt_check->close();
        } else {
             $errors[] = "Valami hiba történt.";
        }
    }

    // --- If no errors, proceed with insertion ---
    if (empty($errors)) {
        // Hash the password for security
        $hashed_password = password_hash($password, PASSWORD_DEFAULT); // Use default strong hashing algorithm

        // Prepare an insert statement
        $sql_insert = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";

        if ($stmt_insert = $conn->prepare($sql_insert)) {
            // Bind variables to the prepared statement as parameters
            $stmt_insert->bind_param("sss", $param_username, $param_email, $param_password);

            // Set parameters
            $param_username = $username;
            $param_email = $email;
            $param_password = $hashed_password;

            // Attempt to execute the prepared statement
            if ($stmt_insert->execute()) {
                // Redirect to login page on successful registration
                $_SESSION['signup_success'] = "A regisztáció sikeres volt. Most már be tud jelentkezni"; // Optional success message for login page
                header("location: login.php");
                exit(); // Important to exit after redirection header
            } else {
                $_SESSION['signup_error'] = "Valami hiba történt.";
                // Log error: $stmt_insert->error;
            }

            // Close statement
            $stmt_insert->close();
        } else {
             $_SESSION['signup_error'] = "Valami hiba történt.";
             // Log error: $conn->error;
        }
    }

    // --- If there were errors, redirect back to signup page ---
    if (!empty($errors)) {
        // Store the first error message in the session to display on the signup page
        $_SESSION['signup_error'] = $errors[0]; // Store only the first error for simplicity
        // You could store all errors and display them if needed
        header("location: signup.php");
        exit();
    }

    // Close connection
    $conn->close();

} else {
    // If the script was accessed directly without POST data, redirect
    header("location: signup.php");
    exit();
}
?>