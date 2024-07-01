<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "rent";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_SESSION['user_id']) && $_SESSION['user_type'] === 'customer') {
    $customer_id = $_SESSION['user_id'];

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
