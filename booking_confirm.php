<?php
session_start();

include 'db_connection.php';

// Check if customer is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'customer') {
    header("Location: login.php");
    exit();
}

$customer_id = $_SESSION['user_id'];

// Get rental_id from query parameter
$rental_id = isset($_GET['rental_id']) ? intval($_GET['rental_id']) : 0;

// Fetch booking details from Rentals and Car tables
$sql = "SELECT Rentals.*, Car.brand, Car.model, Car.price_per_day FROM Rentals JOIN Car ON Rentals.car_id = Car.car_id WHERE Rentals.rental_id = ? AND Rentals.customer_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $rental_id, $customer_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $booking = $result->fetch_assoc();
} else {
    echo "Booking not found.";
    exit();
}

// Fetch customer details
$sql_customer = "SELECT first_name, last_name, phone, email FROM Customer WHERE customer_id = ?";
$stmt_customer = $conn->prepare($sql_customer);
$stmt_customer->bind_param("i", $customer_id);
$stmt_customer->execute();
$result_customer = $stmt_customer->get_result();

if ($result_customer->num_rows > 0) {
    $customer = $result_customer->fetch_assoc();
} else {
    echo "Customer not found.";
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Confirmation - Rent-A-Wheel</title>
    <link rel="stylesheet" href="stylesheet.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>Rent-A-Wheel</h1>
            <nav>
                <ul>
                    <li><a href="homepage.php">Home</a></li>
                    <li><a href="userprofile.php">Account</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main>
        <section class="booking-confirmation">
            <div class="container">
                <h2>Booking Confirmation</h2>
                <p>Thank you for your booking. Here are your booking details:</p>
                <ul>
                    <li><strong>Name:</strong> <?php echo $customer['first_name'] . " " . $customer['last_name']; ?></li>
                    <li><strong>Contact No:</strong> <?php echo $customer['phone']; ?></li>
                    <li><strong>Email:</strong> <?php echo $customer['email']; ?></li>
                    <li><strong>Car:</strong> <?php echo $booking['brand'] . " " . $booking['model']; ?></li>
                    <li><strong>Pickup Date:</strong> <?php echo $booking['rental_date']; ?></li>
                    <li><strong>Pickup Time:</strong> <?php echo $booking['pickup_time']; ?></li>
                    <li><strong>Return Date:</strong> <?php echo $booking['return_date']; ?></li>
                    <li><strong>Return Time:</strong> <?php echo $booking['return_time']; ?></li>
                    <li><strong>Total Price:</strong> $<?php echo $booking['total_price']; ?></li>
                    <li><strong>Status:</strong> <?php echo $booking['status']; ?></li>
                    <li><strong>Booking Date:</strong> <?php echo date("Y-m-d"); ?></li>
                    <li><strong>Due of Payment:</strong> <?php echo $booking['return_date']; ?></li>
                </ul>
                <a href="bill.php?rental_id=<?php echo $booking['rental_id']; ?>" class="button">View & Print Bill</a>
            </div>
        </section>
    </main>

    <footer>
        <div class="container">
            <p>&copy; 2024 Rent-A-Wheel. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
