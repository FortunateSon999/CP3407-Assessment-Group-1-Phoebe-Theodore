<?php
session_start();
if (!isset($_SESSION['customer_id'])) {
    header("Location: login.php");
    exit();
} else {
    header("Location: userprofile.php");
    exit();
}
?>
// check if user login or not