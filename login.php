<?php
require 'config.php'; // Ensure this path is correct

// Start the session
session_start();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Use the $conn object directly from the included config.php
    if (isset($conn)) {
        // Prepare the SQL statement
        $stmt = $conn->prepare("SELECT user_id, username, password FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        // Verify the password
        if ($user && password_verify($password, $user['password'])) {
            // Set session variables
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['username'] = $user['username'];
            // Redirect to dashboard
            header("Location: dashboard.php");
            exit();
        } else {
            $error = "Invalid username or password";
        }
    } else {
        $error = "Database connection error";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #fff7db; /* Light baby yellow background */
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 500px;
            margin-top: 50px;
            background-color: #fff; /* White background */
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1); /* Light shadow */
            text-align: center;
        }
        .login-form {
            margin-bottom: 30px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            font-weight: bold;
            color: #af8b41; /* Darker yellow text */
        }
        .form-control {
            border-radius: 5px;
            padding: 12px;
            font-size: 16px;
        }
        .btn-login {
            background-color: #f0e591; /* Lighter yellow button */
            border: none;
            padding: 12px 20px;
            font-size: 18px;
            color: #664c19; /* Darker yellow text */
            border-radius: 8px;
            transition: background-color 0.3s, color 0.3s;
        }
        .btn-login:hover {
            background-color: #f5d16e; /* Lighter yellow on hover */
            color: #5a4214; /* Darker yellow text on hover */
        }
        .register-link {
            margin-top: 20px;
        }
        .register-link a {
            color: #af8b41; /* Yellow link */
            text-decoration: none;
            font-weight: bold;
        }
        .register-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="login-form">
            <h2 style="color: #f0e591;">User Login</h2>
            <form action="login.php" method="POST">
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-login">Login</button>
            </form>
        </div>
        <div class="register-link">
            <p>Don't have an account yet? <a href="register.php">Register</a></p>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>
