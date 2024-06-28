<?php
session_start();

// Database connection settings
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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $customer_id = intval($_POST['customer_id']);
    $car_id = intval($_POST['car_id']);
    $fullname = $conn->real_escape_string($_POST['fullname']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $email = $conn->real_escape_string($_POST['email']);
    $pickup_date = $_POST['pickup_date'];
    $pickup_time = $_POST['pickup_time'];
    $return_date = $_POST['return_date'];
    $return_time = $_POST['return_time'];

    // Calculate rental date and return date
    $rental_date = $pickup_date . ' ' . $pickup_time;
    $return_date = $return_date . ' ' . $return_time;

    // Calculate the total price
    $car_query = $conn->prepare("SELECT price_per_day FROM Car WHERE car_id = ?");
    $car_query->bind_param("i", $car_id);
    $car_query->execute();
    $car_query->bind_result($price_per_day);
    $car_query->fetch();
    $car_query->close();

    $datetime1 = new DateTime($pickup_date);
    $datetime2 = new DateTime($return_date);
    $interval = $datetime1->diff($datetime2);
    $days = $interval->days;
    $total_price = $days * $price_per_day;

    // Insert booking into Rentals table
    $stmt = $conn->prepare("INSERT INTO Rentals (customer_id, car_id, rental_date, return_date, total_price, status) VALUES (?, ?, ?, ?, ?, 'reserved')");
    $stmt->bind_param("iissd", $customer_id, $car_id, $pickup_date, $return_date, $total_price);

    if ($stmt->execute()) {
        echo "Booking successful.";
        // Redirect to confirmation or payment page
        header("Location: confirmation.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
