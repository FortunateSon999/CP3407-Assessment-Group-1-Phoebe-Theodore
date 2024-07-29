<?php
include 'db_connection.php';
$errors = array();

if (isset($_POST['change-password'])) {
    $_SESSION['info'] = "";
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $cpassword = mysqli_real_escape_string($conn, $_POST['cpassword']);
    if ($password !== $cpassword) {
        $errors['password'] = "Confirm password not matched!";
    } else {
        $email = $_SESSION['email']; //getting this email using session
        $encpass = password_hash($password, PASSWORD_BCRYPT);
        $update_pass = "UPDATE Customer SET status = 0, password = '$encpass' WHERE email = '$email'";
        $run_query = mysqli_query($conn, $update_pass);
        if ($run_query) {
            $info = "Your password changed. Now you can login with your new password.";
            $_SESSION['info'] = $info;
            header('Location: password-changed.php');
        } else {
            $errors['db-error'] = "Failed to change your password!";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Set New Password</title>
</head>
<body>
    <form action="new-password.php" method="POST">
        <input type="password" name="password" placeholder="Enter new password" required>
        <input type="password" name="cpassword" placeholder="Confirm new password" required>
        <button type="submit" name="change-password">Change Password</button>
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
