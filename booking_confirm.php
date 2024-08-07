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

if ($rental_id <= 0) {
    die("Invalid rental ID.");
}

// Fetch booking details from Rentals and Car tables
$sql = "SELECT Rentals.*, Car.brand, Car.model, Car.price_per_day FROM Rentals JOIN Car ON Rentals.car_id = Car.car_id WHERE Rentals.rental_id = ? AND Rentals.customer_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $rental_id, $customer_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $booking = $result->fetch_assoc();
} else {
    die("Booking not found.");
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
    die("Customer not found.");
}

// Calculate total price
$pickup_date = new DateTime($booking['rental_date']);
$return_date = new DateTime($booking['return_date']);
$interval = $pickup_date->diff($return_date);
$days_rented = $interval->days;
$total_price = $days_rented * $booking['price_per_day'];

// Check for discount
$discount_percentage = isset($_SESSION['discount_percentage']) ? $_SESSION['discount_percentage'] : 0;
$discount_amount = ($discount_percentage / 100) * $total_price;
$total_price_after_discount = $total_price - $discount_amount;

// Save total price to the Rentals table
$update_total_price_sql = "UPDATE Rentals SET total_price = ? WHERE rental_id = ?";
$stmt_update = $conn->prepare($update_total_price_sql);
$stmt_update->bind_param("di", $total_price_after_discount, $rental_id);
$stmt_update->execute();

$conn->close();

// Payment method and details
$payment_method = $booking['payment_method'];
$card_last_four = $payment_method === 'credit_card' ? substr($booking['card_number'], -4) : null;
$card_name = $payment_method === 'credit_card' ? htmlspecialchars($booking['card_name']) : null;
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
                    <p>123 Main Street, Cityville, CA 12345</p>
                    <p>(555) 555-5555</p>
                    <p>info@eaglerental.com</p>
                </div>
                <div class="invoice-details">
                    <p><strong>Invoice Number:</strong> NV-<?php echo date("Y-m-d") . "-" . $rental_id; ?></p>
                    <p><strong>Invoice Date:</strong> <?php echo date("Y-m-d"); ?></p>
                </div>
            </div>
            <div class="customer-details">
                <p><strong>Name:</strong> <?php echo htmlspecialchars($customer['first_name'] . " " . $customer['last_name']); ?></p>
                <p><strong>Phone Number:</strong> <?php echo htmlspecialchars($customer['phone']); ?></p>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($customer['email']); ?></p>
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
                            <td><?php echo htmlspecialchars($booking['brand'] . " " . $booking['model']); ?></td>
                            <td><?php echo htmlspecialchars($booking['rental_date'] . " - " . $booking['return_date']); ?></td>
                            <td>$<?php echo number_format($booking['price_per_day'], 2); ?></td>
                            <td><?php echo $days_rented; ?></td>
                            <td>$<?php echo number_format($total_price, 2); ?></td>
                        </tr>
                    </tbody>
                </table>
                <p><strong>Total:</strong> $<?php echo number_format($total_price, 2); ?></p>
                <?php if ($discount_percentage > 0): ?>
                    <p><strong>Discount:</strong> <?php echo $discount_percentage; ?>% (-$<?php echo number_format($discount_amount, 2); ?>)</p>
                    <p><strong>Total After Discount:</strong> $<?php echo number_format($total_price_after_discount, 2); ?></p>
                <?php endif; ?>
            </div>
            <div class="payment-method">
                <p><strong>Payment Method:</strong> <?php echo ucfirst($payment_method); ?></p>
                <?php if ($payment_method === 'credit_card'): ?>
                    <p><strong>Payment Details:</strong></p>
                    <p>Card Number: **** **** **** <?php echo $card_last_four; ?></p>
                    <p>Cardholder Name: <?php echo $card_name; ?></p>
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
