<?php
session_start();
include 'db_connection.php';

if (!isset($_SESSION['customer_id'])) {
    header("Location: login.php");
    exit();
}

$customer_id = $_SESSION['customer_id'];

if (isset($_POST['cancel_booking'])) {
    $rental_id = $_POST['rental_id'];

    // Update the booking status to 'cancelled'
    $sql_cancel = "UPDATE Rentals SET status = 'cancelled' WHERE rental_id = ? AND customer_id = ?";
    $stmt_cancel = $conn->prepare($sql_cancel);
    $stmt_cancel->bind_param("ii", $rental_id, $customer_id);

    if ($stmt_cancel->execute()) {
        // Retrieve the car_id associated with the rental
        $sql_car = "SELECT car_id FROM Rentals WHERE rental_id = ?";
        $stmt_car = $conn->prepare($sql_car);
        $stmt_car->bind_param("i", $rental_id);
        $stmt_car->execute();
        $stmt_car->bind_result($car_id);
        $stmt_car->fetch();
        $stmt_car->close();

        // Update the car status to available
        $sql_update_car_status = "UPDATE Car SET status = 1 WHERE car_id = ?";
        $stmt_update_car_status = $conn->prepare($sql_update_car_status);
        $stmt_update_car_status->bind_param("i", $car_id);
        $stmt_update_car_status->execute();

        // Redirect to a cancellation confirmation page or show a message
        header("Location: cancellation_confirm.php?rental_id=" . $rental_id);
        exit();
    } else {
        echo "Cancellation Error: " . $stmt_cancel->error;
    }
} else {
    die("Invalid request method.");
}

$conn->close();
?>
