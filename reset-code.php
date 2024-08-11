<?php
session_start();
require "db_connection.php";

$errors = array();
date_default_timezone_set('UTC');

// Function for OTP verification
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

// Handle the form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['check-reset-otp'])) {
    $otp_code = $_POST['otp'];
    $result = verify_otp($otp_code, $conn);

    if ($result['success']) {
        header('Location: new-password.php');
        exit();
    } else {
        $errors['otp-error'] = $result['message'];
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Verify Reset Code</title>
</head>
<body>
    <form action="reset-code.php" method="POST">
        <input type="text" name="otp" placeholder="Enter OTP" required>
        <button type="submit" name="check-reset-otp">Verify OTP</button>
    </form>
    <?php
    if (count($errors) > 0) {
        foreach ($errors as $error) {
            echo "<div>$error</div>";
        }
    }
    ?>
</body>
</html>
