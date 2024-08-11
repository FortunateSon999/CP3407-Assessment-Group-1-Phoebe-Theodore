<?php
session_start();
include 'C:\\xampp\\htdocs\\ass1\\CP3407-Assessment-Group-1-Phoebe-Theodore\\login.php'; // Assuming this is the file you want to test

// Simulate a POST request
$_SERVER['REQUEST_METHOD'] = 'POST';
$_POST['username'] = 'customer@example.com';
$_POST['password'] = 'password'; // The plain text password that corresponds to the hashed password

// Capture the output
ob_start();
include 'C:\\xampp\\htdocs\\ass1\\CP3407-Assessment-Group-1-Phoebe-Theodore\\login.php';
$output = ob_get_clean();

// Check if the login was successful
if (isset($_SESSION['customer_id'])) {
    echo "Customer login successful: Customer ID = " . $_SESSION['customer_id'];
} else if (isset($_SESSION['emp_id'])) {
    echo "Employee login successful: Employee ID = " . $_SESSION['emp_id'];
} else {
    echo "Login failed: " . $output;
}

// Optionally, you can unset session data for further testing
session_unset();
?>
