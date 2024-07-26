<?php
session_start();

include 'db_connection.php';


if (isset($_SESSION['customer_id']) && $_SESSION['user_type'] === 'customer') {
    $customer_id = $_SESSION['customer_id'];

    // Update status to 0
    $stmt = $conn->prepare("UPDATE Customer SET status = 0 WHERE customer_id = ?");
    $stmt->bind_param("i", $customer_id);
    $stmt->execute();
}

// Destroy session
session_destroy();

header("Location: login.php");
exit();
?>
