<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Password Changed</title>
</head>
<body>
    <h2><?php echo $_SESSION['info']; ?></h2>
    <form action="login.php" method="POST">
        <button type="submit" name="login-now">Login Now</button>
    </form>
</body>
</html>
