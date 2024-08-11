<?php
session_start();
include 'C:\xampp\htdocs\ass1\CP3407-Assessment-Group-1-Phoebe-Theodore\db_connection.php';

// Simulate a logged-in user
$_SESSION['customer_id'] = 123; // Example customer_id
$_SESSION['user_type'] = 'customer';

// Output session values before logout
echo "<h2>Before logout:</h2>";
echo "Customer ID: " . $_SESSION['customer_id'] . "<br>";
echo "User Type: " . $_SESSION['user_type'] . "<br>";

// Start output buffering
ob_start();

// Include the logout script
include 'C:\xampp\htdocs\ass1\CP3407-Assessment-Group-1-Phoebe-Theodore\db_connection.php';

// Flush output buffer
ob_end_flush();

// Output session values after logout
echo "<h2>After logout:</h2>";
echo "Customer ID: " . (isset($_SESSION['customer_id']) ? $_SESSION['customer_id'] : 'Not set') . "<br>";
echo "User Type: " . (isset($_SESSION['user_type']) ? $_SESSION['user_type'] : 'Not set') . "<br>";
?>

