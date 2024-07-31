<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

session_start();
include "db_connection.php"; // Include the connection script

$errors = array();

if (isset($_POST['check-email'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $check_email = "SELECT * FROM Customer WHERE email='$email'";
    $run_sql = mysqli_query($conn, $check_email);
    if (mysqli_num_rows($run_sql) > 0) {
        $code = rand(999999, 111111);
        $insert_code = "UPDATE Customer SET status = $code WHERE email = '$email'";
        $run_query = mysqli_query($conn, $insert_code);
        if ($run_query) {
            $mail = new PHPMailer(true);
            try {
                // Server settings
                $mail->isSMTP();
                $mail->Host       = 'smtp.gmail.com'; // Set the SMTP server to send through
                $mail->SMTPAuth   = true;
                $mail->Username   = 'your_email@gmail.com'; // Your Gmail address
                $mail->Password   = 'your_password'; // Your Gmail password or app password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port       = 587;

                // Recipients
                $mail->setFrom('your_email@gmail.com', 'Your Name');
                $mail->addAddress($email);

                // Content
                $mail->isHTML(true);
                $mail->Subject = 'Password Reset Code';
                $mail->Body    = "Your password reset code is $code";

                $mail->send();
                $info = "We've sent a password reset OTP to your email - $email";
                $_SESSION['info'] = $info;
                $_SESSION['email'] = $email;
                header('location: reset-code.php');
                exit();
            } catch (Exception $e) {
                $errors['otp-error'] = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        } else {
            $errors['db-error'] = "Something went wrong!";
        }
    } else {
        $errors['email'] = "This email address does not exist!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Forgot Password</title>
    <link rel="stylesheet" href="stylesheet.css">
</head>
<body>
    <div class="forgot-password-container">
        <div class="forgot-password-box">
            <h2>Forgot Password</h2>
            <form action="forgot-password.php" method="POST">
                <input type="email" name="email" placeholder="Enter your email" required>
                <button type="submit" name="check-email">Send Reset Code</button>
            </form>
            <?php
            if (isset($errors) && count($errors) > 0) {
                foreach ($errors as $error) {
                    echo "<div class='error'>$error</div>";
                }
            }
            ?>
        </div>
    </div>
</body>
</html>
