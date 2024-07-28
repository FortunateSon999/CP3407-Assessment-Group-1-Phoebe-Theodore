<?php
session_start();
require "db_connection.php";
$errors = array();

if (isset($_POST['check-email'])) {
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $check_email = "SELECT * FROM usertable WHERE email='$email'";
    $run_sql = mysqli_query($con, $check_email);
    if (mysqli_num_rows($run_sql) > 0) {
        $code = rand(999999, 111111);
        $insert_code = "UPDATE usertable SET code = $code WHERE email = '$email'";
        $run_query =  mysqli_query($con, $insert_code);
        if ($run_query) {
            $subject = "Password Reset Code";
            $message = "Your password reset code is $code";
            $sender = "From: shahiprem7890@gmail.com";
            if (mail($email, $subject, $message, $sender)) {
                $info = "We've sent a password reset OTP to your email - $email";
                $_SESSION['info'] = $info;
                $_SESSION['email'] = $email;
                header('location: reset-code.php');
                exit();
            } else {
                $errors['otp-error'] = "Failed while sending code!";
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
</head>
<body>
    <form action="forgot-password.php" method="POST">
        <input type="email" name="email" placeholder="Enter your email" required>
        <button type="submit" name="check-email">Send Reset Code</button>
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
