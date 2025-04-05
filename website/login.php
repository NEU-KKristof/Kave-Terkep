<?php 
session_start();
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kávé Világ - Bejelentkezés</title>
    <style>
        /* style.css */
body {
    font-family: 'Arial', sans-serif;
    background: linear-gradient(135deg, #f5e8d3, #ffffff);
    color: #333;
    line-height: 1.6;
    min-height: 100vh;
    display: flex;
    flex-direction: column;
}

.container, .form-container, .page-header {
    background-color: #fff;
    padding: 25px 40px;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    text-align: center;
    max-width: 400px; /* Limit width */
    width: 90%; /* Responsive width */
    margin-top: 20px; /* Add some top margin */
}

h1, h2 {
    color: #333;
    margin-bottom: 20px;
}

.form-group {
    margin-bottom: 15px;
    text-align: left;
}

.form-group label {
    display: block;
    margin-bottom: 5px;
    color: #555;
    font-weight: bold;
}

.form-group input[type="text"],
.form-group input[type="email"],
.form-group input[type="password"] {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box; /* Include padding and border in element's total width/height */
}

.btn {
    background-color: #007bff;
    color: white;
    padding: 12px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
    text-decoration: none; /* For link buttons */
    display: inline-block; /* Proper alignment and padding for links */
    margin: 5px;
    transition: background-color 0.3s ease;
}

.btn:hover {
    background-color: #0056b3;
}

.btn-danger { /* Specific style for logout button */
    background-color: #dc3545;
}
.btn-danger:hover {
    background-color: #c82333;
}

a {
    color: #007bff;
    text-decoration: none;
}

a:hover {
    text-decoration: underline;
}

p {
    line-height: 1.6;
    color: #444;
}

.error-message {
    color: #dc3545; /* Red for errors */
    background-color: #f8d7da;
    border: 1px solid #f5c6cb;
    padding: 10px;
    border-radius: 4px;
    margin-bottom: 15px;
}

.success-message {
    color: #155724; /* Dark green for success */
    background-color: #d4edda;
    border: 1px solid #c3e6cb;
    padding: 10px;
    border-radius: 4px;
    margin-bottom: 15px;
}
    </style>
</head>
<body>

<?php include_once 'navbar.php' ?>
<center>
    <div class="form-container">
        <h2>Bejelentkezés</h2>
        <?php
        // Display potential messages (errors from login_process.php or success from signup_process.php)
        if (isset($_SESSION['login_error'])) {
            echo '<p class="error-message">' . htmlspecialchars($_SESSION['login_error']) . '</p>';
            unset($_SESSION['login_error']); // Clear message
        }
        if (isset($_SESSION['signup_success'])) {
            echo '<p class="success-message">' . htmlspecialchars($_SESSION['Sikeres bejelentkezés']) . '</p>';
            unset($_SESSION['signup_success']); // Clear message
        }
         session_write_close(); // Close session writing
        ?>

        <form action="login_process.php" method="post">
            <div class="form-group">
                <label for="username">Név:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Jelszó:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="btn">Bejelentkezés</button>
        </form>
        <p>Nincsen fiókja? <a href="signup.php">Regisztráljon itt</a></p>
    </div>
</center>
</body>
</html>