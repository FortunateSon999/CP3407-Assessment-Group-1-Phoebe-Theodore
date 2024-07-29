<?php
session_start();
require "db_connection.php";
$errors = array();

if (isset($_POST['check-reset-otp'])) {
    $_SESSION['info'] = "";
    $otp_code = mysqli_real_escape_string($conn, $_POST['otp']);
    $check_code = "SELECT * FROM Customer WHERE status = $otp_code";
    $code_res = mysqli_query($conn, $check_code);
    if (mysqli_num_rows($code_res) > 0) {
        $fetch_data = mysqli_fetch_assoc($code_res);
        $email = $fetch_data['email'];
        $_SESSION['email'] = $email;
        $info = "Please create a new password that you don't use on any other site.";
        $_SESSION['info'] = $info;
        header('location: new-password.php');
        exit();
    } else {
        $errors['otp-error'] = "You've entered incorrect code!";
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
