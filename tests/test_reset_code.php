<?php
// Mock database connection for testing
$conn = new mysqli('localhost', 'root', '', 'car_db');

// Function for OTP verification (same as in reset-code.php)
function verify_otp($otp_code, $conn) {
    $email = 'test@example.com'; // Ensure this is the test email used

    $check_code = "SELECT * FROM PasswordResetOTP WHERE email = ? AND otp_code = ? AND expires_at > NOW()";
    $stmt = $conn->prepare($check_code);
    $stmt->bind_param("ss", $email, $otp_code);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $info = "Please create a new password that you don't use on any other site.";
        return ['success' => true, 'message' => $info];
    } else {
        $errors['otp-error'] = "You've entered incorrect code or the code has expired!";
        return ['success' => false, 'message' => $errors['otp-error']];
    }
}

// Function to test OTP verification
function test_verify_otp($otp_code, $expected_result, $conn) {
    $result = verify_otp($otp_code, $conn);
    if ($result['message'] === $expected_result) {
        echo "Test Passed: $expected_result\n";
    } else {
        echo "Test Failed: Expected '$expected_result' but got '{$result['message']}'\n";
    }
}

// Set up mock POST request for correct OTP
test_verify_otp('123456', "Please create a new password that you don't use on any other site.", $conn);

// Test with incorrect OTP
test_verify_otp('000000', "You've entered incorrect code or the code has expired!", $conn);

// Clean up
$conn->close();
?>

