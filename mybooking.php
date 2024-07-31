<?php
session_start();
require 'db_connection.php'; 

if (!isset($_SESSION['customer_id'])) {
    header('Location: login.php');
    exit();
}

$customer_id = $_SESSION['customer_id'];

// Handle booking cancellation
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cancel_booking_id'])) {
    $cancel_booking_id = $_POST['cancel_booking_id'];

    // Update the booking status to 'cancelled'
    $cancel_booking_query = "UPDATE Rentals SET status = 'cancelled' WHERE rental_id = ? AND customer_id = ?";
    $stmt = $conn->prepare($cancel_booking_query);
    $stmt->bind_param("ii", $cancel_booking_id, $customer_id);
    $stmt->execute();

    // Redirect to avoid form resubmission
    header("Location: mybooking.php");
    exit();
}

// Fetch current bookings
$current_bookings_query = "SELECT r.*, r.created_at 
                          FROM Rentals r 
                          WHERE r.customer_id = ? AND r.status = 'reserved'";
$stmt = $conn->prepare($current_bookings_query);
$stmt->bind_param("i", $customer_id);
$stmt->execute();
$current_bookings = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

// Fetch past bookings
$past_bookings_query = "SELECT r.*, r.created_at 
                       FROM Rentals r 
                       WHERE r.customer_id = ? AND (r.status = 'completed' OR r.status = 'cancelled')";
$stmt = $conn->prepare($past_bookings_query);
$stmt->bind_param("i", $customer_id);
$stmt->execute();
$past_bookings = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Bookings</title>
    <link rel="stylesheet" href="stylesheet.css">
</head>
<body>
    <div class="container my-bookings">
        <h2>My Current Bookings</h2>
        <div class="bookings">
            <?php if (!empty($current_bookings)) : ?>
                <?php foreach ($current_bookings as $booking) : ?>
                    <div class="booking">
                        <h3>Booking ID: <?php echo $booking['rental_id']; ?></h3>
                        <p>Rental Date: <?php echo $booking['rental_date']; ?></p>
                        <p>Pick-up Time: <?php echo $booking['pickup_time']; ?></p>
                        <p>Return Date: <?php echo $booking['return_date']; ?></p>
                        <p>Return Time: <?php echo $booking['return_time']; ?></p>
                        <p>Total Price: $<?php echo $booking['total_price']; ?></p>
                        <p>Booking Created At: <?php echo $booking['created_at']; ?></p>
                        <form method="post" action="mybooking.php">
                            <input type="hidden" name="cancel_booking_id" value="<?php echo $booking['rental_id']; ?>">
                            <button type="submit">Cancel Booking</button>
                        </form>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <p>No current bookings.</p>
            <?php endif; ?>
        </div>

        <h2>My Past Bookings</h2>
        <div class="bookings">
            <?php if (!empty($past_bookings)) : ?>
                <?php foreach ($past_bookings as $booking) : ?>
                    <div class="booking">
                        <h3>Booking ID: <?php echo $booking['rental_id']; ?></h3>
                        <p>Rental Date: <?php echo $booking['rental_date']; ?></p>
                        <p>Pick-up Time: <?php echo $booking['pickup_time']; ?></p>
                        <p>Return Date: <?php echo $booking['return_date']; ?></p>
                        <p>Return Time: <?php echo $booking['return_time']; ?></p>
                        <p>Total Price: $<?php echo $booking['total_price']; ?></p>
                        <p>Booking Created At: <?php echo $booking['created_at']; ?></p>
                        <p>Status: <?php echo ucfirst($booking['status']); ?></p>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <p>No past bookings.</p>
            <?php endif; ?>
        </div>

        <div class="back-to-profile">
            <a href="profile.php"><button>Back to Profile</button></a>
        </div>
    </div>
</body>
</html>


