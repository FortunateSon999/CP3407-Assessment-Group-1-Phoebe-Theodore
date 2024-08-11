<?php
// Set up the test environment
$server = $_SERVER;
$_SERVER['REQUEST_METHOD'] = 'POST';

// Test case 1: No answer found
$_POST['message'] = 'unknown question';
echo "Test Case 1 - No Answer Found:\n";
include 'chatbot_backend.php';
echo "\n";

// Test case 2: Answer found
// For this, you might need to modify your mock to simulate a successful query
$_POST['message'] = 'Hi';
echo "Test Case 2 - Answer Found (Hi):\n";
include 'chatbot_backend.php';
echo "\n";

// Restore the server environment
$_SERVER = $server;
?>
