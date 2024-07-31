<?php
session_start();

include 'db_connection.php';

// Check if customer is logged in
if (!isset($_SESSION['customer_id'])) {
    header("Location: login.php");
    exit();
}

$customer_id = $_SESSION['customer_id'];

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

// Calculate total price
$pickup_date = new DateTime($booking['rental_date']);
$return_date = new DateTime($booking['return_date']);
$interval = $pickup_date->diff($return_date);
$days_rented = $interval->days;
$total_price = $days_rented * $booking['price_per_day'];

$conn->close();

// Payment method and details
$payment_method = $booking['payment_method'];
$card_last_four = substr($booking['card_number'], -4);
$card_name = $booking['card_name'];
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
                    <li><a href="profile.php">Account</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main>
        <section class="invoice">
            <div class="invoice-header">
                <h2>INVOICE</h2>
                <div class="company-details">
                    <p>123 Main Street Cityville,<br>CA 12345</p>
                    <p>(555) 555-5555</p>
                    <p>info@eaglerental.com</p>
                </div>
                <div class="invoice-details">
                    <p><strong>Invoice Number:</strong> NV-<?php echo date("Y-m-d") . "-" . $rental_id; ?></p>
                    <p><strong>Invoice Date:</strong> <?php echo date("Y-m-d"); ?></p>
                </div>
            </div>
            <div class="customer-details">
                <p><strong>Name:</strong> <?php echo $customer['first_name'] . " " . $customer['last_name']; ?></p>
                <p><strong>Phone Number:</strong> <?php echo $customer['phone']; ?></p>
                <p><strong>Email:</strong> <?php echo $customer['email']; ?></p>
            </div>
            <div class="rental-details">
                <table>
                    <thead>
                        <tr>
                            <th>Car Description</th>
                            <th>Rental Period</th>
                            <th>Rate Per Day</th>
                            <th>Number of Days</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?php echo $booking['brand'] . " " . $booking['model']; ?></td>
                            <td><?php echo $booking['rental_date'] . " - " . $booking['return_date']; ?></td>
                            <td>$<?php echo $booking['price_per_day']; ?></td>
                            <td><?php echo $days_rented; ?></td>
                            <td>$<?php echo $total_price; ?></td>
                        </tr>
                    </tbody>
                </table>
                <p><strong>Total:</strong> $<?php echo $total_price; ?></p>
            </div>
            <div class="payment-method">
                <p><strong>Payment Method:</strong> <?php echo ucfirst($payment_method); ?></p>
                <?php if ($payment_method === 'credit_card'): ?>
                    <p><strong>Payment Details:</strong></p>
                    <p>Card Number: **** **** **** <?php echo $card_last_four; ?></p>
                    <p>Cardholder Name: <?php echo htmlspecialchars($card_name); ?></p>
                <?php endif; ?>
            </div>
            <button onclick="window.print()">Print Invoice</button>
        </section>
    </main>

    <footer>
        <div class="container">
            <p>&copy; 2024 Rent-A-Wheel. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
