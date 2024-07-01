<?php
session_start(); // Start the session

// Database connection settings
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "rent";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$error_message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check in Customer table
    $stmt = $conn->prepare("SELECT customer_id, password FROM Customer WHERE email = ?");
    if ($stmt) {
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($customer_id, $hashed_password);
        $stmt->fetch();

        if ($stmt->num_rows > 0 && password_verify($password, $hashed_password)) {
            // Customer login successful
            $_SESSION['customer_id'] = $customer_id;
            $_SESSION['user_type'] = 'customer';

            // Update status to 1
            $update_stmt = $conn->prepare("UPDATE Customer SET status = 1 WHERE customer_id = ?");
            if ($update_stmt) {
                $update_stmt->bind_param("i", $customer_id);
                $update_stmt->execute();
                $update_stmt->close();
            }

            header("Location: homepage.php");
            exit();
        }
        $stmt->close();
    }

    // Check in Employee table
    $stmt = $conn->prepare("SELECT emp_id, password FROM Employee WHERE email = ?");
    if ($stmt) {
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($emp_id, $hashed_password);
        $stmt->fetch();

        if ($stmt->num_rows > 0 && password_verify($password, $hashed_password)) {
            // Employee login successful
            $_SESSION['emp_id'] = $emp_id;
            $_SESSION['user_type'] = 'employee';

            header("Location: homepage.php");
            exit();
        } else {
            $error_message = "Invalid username or password.";
        }
        $stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Rent-A-Wheel</title>
    <link rel="stylesheet" href="stylesheet.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>Rent-A-Wheel</h1>
            <nav>
                <ul>
                    <li><a href="homepage.php">Home</a></li>
                    <li><a href="cars.php">Cars</a></li>
                    <li><a href="booking.php">Booking</a></li>
                    <li><a href="aboutus.php">About Us</a></li>
                    <?php if (isset($_SESSION['customer_id'])): ?>
                        <li><a href="userprofile.php">Account</a></li>
                        <li><a href="logout.php">Logout</a></li>
                    <?php else: ?>
                        <li><a href="login.php">Login</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>

    <div class="login-container">
        <div class="login-box">
            <h2>Login</h2>
            <?php if ($error_message): ?>
                <p class="error"><?php echo htmlspecialchars($error_message); ?></p>
            <?php endif; ?>
            <form action="login.php" method="POST">
                <input type="text" name="username" placeholder="Username (email address)" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit">Login</button>
            </form>
            <a href="forgot_password.php">Forgot Password?</a>
            <a href="register.php">Don't have an account? Register</a>
        </div>
    </div>

    <footer>
        <div class="container">
            <p>&copy; 2024 Rent-A-Wheel. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
