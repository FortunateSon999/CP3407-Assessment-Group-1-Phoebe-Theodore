<?php


$servername = "localhost";
$username = "root";
$password = "";
$dbname = "rent"; // REMINDER: Need to change db name according to local db name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
