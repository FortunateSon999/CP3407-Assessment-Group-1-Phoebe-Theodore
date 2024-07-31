<?php
session_start();

include 'db_connection.php';

// Check if customer is logged in
if (!isset($_SESSION['customer_id'])) {
    header("Location: login.php");
    exit();
}

$customer_id = $_SESSION['customer_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $car_id = $_POST['car_id'];
    $fullname = $_POST['fullname'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $pickup_date = $_POST['pickup_date'];
    $pickup_time = $_POST['pickup_time'];
    $return_date = $_POST['return_date'];
    $return_time = $_POST['return_time'];
    $payment_method = $_POST['payment_method'];

if ($payment_method === 'credit_card') {
    $card_name = $_POST['card_name'];
    $card_number = $_POST['card_number'];
    $card_expiry = $_POST['card_expiry'];
    $card_cvc = $_POST['card_cvc'];
        
    // Store the last 4 digits of the card number in the session
    $_SESSION['card_last_four'] = substr($card_number, -4);
} else {
    $card_name = null;
    $card_number = null;
}

    // Insert booking details into Rentals table
    $sql = "INSERT INTO Rentals (customer_id, car_id, rental_date, pickup_time, return_date, return_time, total_price, status, payment_method, card_number, card_name) VALUES (?, ?, ?, ?, ?, ?, 0, 'reserved', ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iissssss", $customer_id, $car_id, $pickup_date, $pickup_time, $return_date, $return_time, $payment_method, $card_number, $card_name);

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
            echo "Payment Error: " . $stmt_payment->error;
        }
    } else {
        echo "Booking Error: " . $stmt->error;
    }
} else {
    die("Invalid request method.");
}

$conn->close();
?>