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
    // Sanitize and validate input data
    $car_id = filter_input(INPUT_POST, 'car_id', FILTER_VALIDATE_INT);
    $fullname = filter_input(INPUT_POST, 'fullname', FILTER_SANITIZE_STRING);
    $phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $pickup_date = filter_input(INPUT_POST, 'pickup_date', FILTER_SANITIZE_STRING);
    $pickup_time = filter_input(INPUT_POST, 'pickup_time', FILTER_SANITIZE_STRING);
    $return_date = filter_input(INPUT_POST, 'return_date', FILTER_SANITIZE_STRING);
    $return_time = filter_input(INPUT_POST, 'return_time', FILTER_SANITIZE_STRING);
    $payment_method = filter_input(INPUT_POST, 'payment_method', FILTER_SANITIZE_STRING);
    $discount_code = filter_input(INPUT_POST, 'discount_code', FILTER_SANITIZE_STRING); // New field

    if (!$car_id || !$fullname || !$phone || !$email || !$pickup_date || !$pickup_time || !$return_date || !$return_time || !$payment_method) {
        die("Invalid input data.");
    }

    if ($payment_method === 'credit_card') {
        $card_name = filter_input(INPUT_POST, 'card_name', FILTER_SANITIZE_STRING);
        $card_number = filter_input(INPUT_POST, 'card_number', FILTER_SANITIZE_STRING);
        $card_expiry = filter_input(INPUT_POST, 'card_expiry', FILTER_SANITIZE_STRING);
        $card_cvc = filter_input(INPUT_POST, 'card_cvc', FILTER_SANITIZE_STRING);
        
        // Store the last 4 digits of the card number in the session
        $_SESSION['card_last_four'] = substr($card_number, -4);
    } else {
        $card_name = null;
        $card_number = null;
        $card_expiry = null;
        $card_cvc = null;
    }

    // Fetch the discount percentage from the database if a discount code is provided
    $discount_percentage = 0;
    if ($discount_code) {
        $sql_discount = "SELECT discount_percentage FROM Discounts WHERE discount_code = ?";
        $stmt_discount = $conn->prepare($sql_discount);
        $stmt_discount->bind_param("s", $discount_code);
        $stmt_discount->execute();
        $result_discount = $stmt_discount->get_result();

        if ($result_discount->num_rows > 0) {
            $discount_row = $result_discount->fetch_assoc();
            $discount_percentage = $discount_row['discount_percentage'];
        }
        $stmt_discount->close();
    }

    // Calculate rental period
    $pickup_date = new DateTime($pickup_date);
    $return_date = new DateTime($return_date);
    $interval = $pickup_date->diff($return_date);
    $days_rented = $interval->days;

    // Fetch the price per day
    $sql_price = "SELECT price_per_day FROM Car WHERE car_id = ?";
    $stmt_price = $conn->prepare($sql_price);
    $stmt_price->bind_param("i", $car_id);
    $stmt_price->execute();
    $result_price = $stmt_price->get_result();

    if ($result_price->num_rows > 0) {
        $price_row = $result_price->fetch_assoc();
        $price_per_day = $price_row['price_per_day'];
    } else {
        die("Car not found.");
    }
    $stmt_price->close();

    // Calculate total price
    $total_price = $days_rented * $price_per_day;

    // Apply discount
    $discount_amount = ($discount_percentage / 100) * $total_price;
    $total_price_after_discount = $total_price - $discount_amount;

    // Insert booking details into Rentals table
    $sql = "INSERT INTO Rentals (customer_id, car_id, rental_date, pickup_time, return_date, return_time, total_price, status, payment_method, card_number, card_name) VALUES (?, ?, ?, ?, ?, ?, ?, 'reserved', ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }
    $stmt->bind_param("iisssssss", $customer_id, $car_id, $pickup_date->format('Y-m-d'), $pickup_time, $return_date->format('Y-m-d'), $return_time, $total_price_after_discount, $payment_method, $card_number, $card_name);

    if ($stmt->execute()) {
        $rental_id = $stmt->insert_id;

        // Insert payment details into Payment table
        $sql_payment = "INSERT INTO Payment (rental_id, amount, payment_date, payment_method) VALUES (?, ?, CURDATE(), ?)";
        $stmt_payment = $conn->prepare($sql_payment);
        if ($stmt_payment === false) {
            die("Error preparing payment statement: " . $conn->error);
        }
        $stmt_payment->bind_param("ids", $rental_id, $total_price_after_discount, $payment_method);

        if ($stmt_payment->execute()) {
            // Update the car status to indicate it is booked (false or 0)
            $sql_update_car_status = "UPDATE Car SET status = 0 WHERE car_id = ?";
            $stmt_update_car_status = $conn->prepare($sql_update_car_status);
            if ($stmt_update_car_status === false) {
                die("Error preparing car status update statement: " . $conn->error);
            }
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

    $stmt->close();
    $stmt_payment->close();
    $stmt_update_car_status->close();
} else {
    die("Invalid request method.");
}

$conn->close();
?>
