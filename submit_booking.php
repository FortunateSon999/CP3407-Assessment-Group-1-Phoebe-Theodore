<?php
session_start();

include 'db_connection.php';

// Check if customer is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'customer') {
    header("Location: login.php");
    exit();
}

$customer_id = $_SESSION['user_id'];

// Get form data
$car_id = $_POST['car_id'];
$fullname = $_POST['fullname'];
$phone = $_POST['phone'];
$email = $_POST['email'];
$pickup_date = $_POST['pickup_date'];
$pickup_time = $_POST['pickup_time'];
$return_date = $_POST['return_date'];
$return_time = $_POST['return_time'];
$payment_method = $_POST['payment_method'];

// Insert booking details into Rentals table
$sql = "INSERT INTO Rentals (customer_id, car_id, rental_date, pickup_time, return_date, return_time, total_price, status) VALUES (?, ?, ?, ?, ?, ?, 0, 'reserved')";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iissss", $customer_id, $car_id, $pickup_date, $pickup_time, $return_date, $return_time);

if ($stmt->execute()) {
    $rental_id = $stmt->insert_id;

    // Insert payment details into Payment table
    $sql_payment = "INSERT INTO Payment (rental_id, amount, payment_date, payment_method) VALUES (?, 0, CURDATE(), ?)";
    $stmt_payment = $conn->prepare($sql_payment);
    $stmt_payment->bind_param("is", $rental_id, $payment_method);

    if ($stmt_payment->execute()) {
        // Update the car status to indicate it is booked (false or 0)
        $sql_update_car_status = "UPDATE Car SET status = 0 WHERE car_id = ?";
        $stmt_update_car_status = $conn->prepare($sql_update_car_status);
        $stmt_update_car_status->bind_param("i", $car_id);
        $stmt_update_car_status->execute();

        // Redirect to booking confirmation page with rental_id
        header("Location: booking_confirm.php?rental_id=" . $rental_id);
        exit();
    } else {
        echo "Error: " . $stmt_payment->error;
    }
} else {
    echo "Error: " . $stmt->error;
}

$conn->close();
?>
