<?php
session_start();
require "db_connection.php";

// Function to generate a random OTP
function generateOtp($length = 6) {
    $otp = '';
    for ($i = 0; $i < $length; $i++) {
        $otp .= mt_rand(0, 9);
    }
    return $otp;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['email'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    // Check if the email exists
    $checkEmail = "SELECT * FROM Customer WHERE email = ?";
    $stmt = $conn->prepare($checkEmail);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Generate OTP and expiry time
        $otpCode = generateOtp();
        $expiresAt = date('Y-m-d H:i:s', strtotime('+10 minutes'));

        // Insert OTP into database
        $insertOtp = "INSERT INTO PasswordResetOTP (email, otp_code, expires_at) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($insertOtp);
        $stmt->bind_param("sss", $email, $otpCode, $expiresAt);

        if ($stmt->execute()) {
            // Ideally, you would send the OTP to the user's email here
            echo "OTP generated and sent to $email: $otpCode\n";
        } else {
            echo "Error: " . $stmt->error . "\n";
        }
        $stmt->close();
    } else {
        echo "Email not found!";
    }
}
?>

<!-- HTML form to request OTP -->
<!DOCTYPE html>
<html>
<head>
    <title>Request Password Reset</title>
</head>
<body>
    <form action="request-reset.php" method="POST">
        <input type="email" name="email" placeholder="Enter your email" required>
        <button type="submit">Send OTP</button>
    </form>
</body>
</html>
