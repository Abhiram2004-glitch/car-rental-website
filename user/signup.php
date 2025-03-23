<?php
include '../shared/db_config.php'; // Include your database configuration file

$message = ""; // Initialize a message variable

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validate input
    if ($password !== $confirm_password) {
        $message = "<p style='color: red;'>Passwords do not match.</p>";
    } else {
        // Check if username or email already exists
        $check_query = "SELECT * FROM users WHERE username = '$username' OR email = '$email'";
        $result = $conn->query($check_query);

        if ($result->num_rows > 0) {
            $message = "<p style='color: red;'>Username or email already exists. Please try another.</p>";
        } else {
            // Hash the password
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);

            // Insert into database
            $query = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$hashed_password')";
            if ($conn->query($query)) {
                $message = "<p style='color: green;'>Account created successfully! Redirecting to login page...</p>";
                header("refresh:3;url=login.php"); // Redirect to login after 3 seconds
            } else {
                $message = "<p style='color: red;'>Error: " . $conn->error . "</p>";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>User Signup</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            background: linear-gradient(to right, #1e3c72, #2a5298);
            color: white;
        }
        .form-container {
            max-width: 400px;
            margin: auto;
            margin-top: 100px;
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            color: black;
        }
        .form-container h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .btn-primary {
            width: 100%;
            background-color: #1e3c72;
            border: none;
        }
        .btn-primary:hover {
            background-color: #2a5298;
        }
        .text-primary {
            text-decoration: none;
        }
        .message {
            text-align: center;
            margin-top: 15px;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Sign Up</h2>
        <form method="POST">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" placeholder="Enter your username" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
            </div>
            <div class="mb-3">
                <label for="confirm_password" class="form-label">Confirm Password</label>
                <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirm your password" required>
            </div>
            <button type="submit" class="btn btn-primary">Sign Up</button>
        </form>
        <!-- Display the message -->
        <div class="message">
            <?= $message; ?>
        </div>
        <div class="text-center mt-3">
            <p>Already have an account? <a href="login.php" class="text-primary">Login here</a></p>
        </div>
    </div>
</body>
</html>
