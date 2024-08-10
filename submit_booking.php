<?php
session_start();
include 'db_connection.php';

// Check if customer is logged in
if (!isset($_SESSION['customer_id'])) {
    header("Location: login.php");
    exit();
}

$customer_id = $_SESSION['customer_id'];

function check_and_update_booking_status($conn) {
    // Get current date and time
    $current_date = new DateTime();
    $current_time = $current_date->format('Y-m-d H:i:s');

    // Update bookings that have expired and change their status to 'expired' 
    // and the car status to available (1)
    $sql = "UPDATE Rentals r
            JOIN Car c ON r.car_id = c.car_id
            SET r.status = 'expired', c.status = 1
            WHERE r.return_date < CURDATE() OR (r.return_date = CURDATE() AND r.return_time < CURTIME()) 
            AND r.status = 'reserved'";
    
    if ($conn->query($sql) === TRUE) {
        echo "Expired bookings updated successfully.";
    } else {
        echo "Error updating record: " . $conn->error;
    }

    // Move expired bookings to the past bookings table if required.
    // Assuming you have a past bookings table
    $sql_past = "INSERT INTO Rentals (customer_id, car_id, rental_date, pickup_time, return_date, return_time, total_price, status, payment_method)
                SELECT customer_id, car_id, rental_date, pickup_time, return_date, return_time, total_price, status, payment_method 
                FROM Rentals 
                WHERE status = 'expired'";
    
    if ($conn->query($sql_past) === TRUE) {
        echo "Expired bookings moved to past bookings.";
    } else {
        echo "Error moving expired bookings: " . $conn->error;
    }
    
    // Delete expired bookings from the Rentals table if they have been moved to Past_Rentals
    $sql_delete = "DELETE FROM Rentals WHERE status = 'expired'";
    
    if ($conn->query($sql_delete) === TRUE) {
        echo "Expired bookings deleted from current rentals.";
    } else {
        echo "Error deleting expired bookings: " . $conn->error;
    }
}

// Call the function at the beginning of your script to ensure all statuses are updated before proceeding
check_and_update_booking_status($conn);


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
    $discount_id = $_POST['discount_id'];
    $discount_code = $_POST['discount_code'];

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

    // Calculate the rental duration in days
    $pickup_date_obj = new DateTime($pickup_date);
    $return_date_obj = new DateTime($return_date);
    $interval = $pickup_date_obj->diff($return_date_obj);
    $days_rented = $interval->days;

    // Fetch the car price per day
    $sql_car = "SELECT price_per_day FROM Car WHERE car_id = ?";
    $stmt_car = $conn->prepare($sql_car);
    $stmt_car->bind_param("i", $car_id);
    $stmt_car->execute();
    $result_car = $stmt_car->get_result();
    if ($result_car->num_rows > 0) {
        $car_row = $result_car->fetch_assoc();
        $price_per_day = $car_row['price_per_day'];
    } else {
        die("Car not found.");
    }

    // Calculate the initial total price
    $total_price = $days_rented * $price_per_day;

    // Apply discount if provided
    if ($discount_id && $discount_code) {
        $sql_discount = "SELECT discount_percent FROM discount WHERE discount_id = ? AND discount_code = ?";
        $stmt_discount = $conn->prepare($sql_discount);
        $stmt_discount->bind_param("is", $discount_id, $discount_code);
        $stmt_discount->execute();
        $result_discount = $stmt_discount->get_result();
        if ($result_discount->num_rows > 0) {
            $discount_row = $result_discount->fetch_assoc();
            $discount_percent = $discount_row['discount_percent'];
            $total_price = $total_price - ($total_price * ($discount_percent / 100));
        }
    }

    // Insert booking details into Rentals table
    $sql = "INSERT INTO Rentals (customer_id, car_id, rental_date, pickup_time, return_date, return_time, total_price, status, payment_method, card_number, card_name) VALUES (?, ?, ?, ?, ?, ?, ?, 'reserved', ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iissssisss", $customer_id, $car_id, $pickup_date, $pickup_time, $return_date, $return_time, $total_price, $payment_method, $card_number, $card_name);

    if ($stmt->execute()) {
        $rental_id = $stmt->insert_id;

        // Insert payment details into Payment table
        $sql_payment = "INSERT INTO Payment (rental_id, amount, payment_date, payment_method) VALUES (?, ?, CURDATE(), ?)";
        $stmt_payment = $conn->prepare($sql_payment);
        $stmt_payment->bind_param("ids", $rental_id, $total_price, $payment_method);

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
