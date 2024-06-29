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

// Get rental ID from URL parameters
$rental_id = isset($_GET['rental_id']) ? intval($_GET['rental_id']) : 0;

// Fetch booking and payment details from the database
$sql = "SELECT Rentals.*, Payment.amount, Customer.first_name, Customer.last_name, Car.brand, Car.model, Car.registration 
        FROM Rentals
        JOIN Payment ON Rentals.rental_id = Payment.rental_id
        JOIN Customer ON Rentals.customer_id = Customer.customer_id
        JOIN Car ON Rentals.car_id = Car.car_id
        WHERE Rentals.rental_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $rental_id);
$stmt->execute();
$result = $stmt->get_result();
$booking = $result->fetch_assoc();

if (!$booking) {
    echo "Bill not found.";
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bill - Rent-A-Wheel</title>
    <link rel="stylesheet" href="stylesheet.css">
</head>
<body>
    <main>
        <section class="bill">
            <div class="container">
                <h2>Bill</h2>
                <div class="bill-details">
                    <p><strong>Rental ID:</strong> <?php echo $booking['rental_id']; ?></p>
                    <p><strong>Customer:</strong> <?php echo $booking['first_name'] . ' ' . $booking['last_name']; ?></p>
                    <p><strong>Car:</strong> <?php echo $booking['brand'] . ' ' . $booking['model']; ?> (<?php echo $booking['registration']; ?>)</p>
                    <p><strong>Rental Date:</strong> <?php echo $booking['rental_date']; ?></p>
                    <p><strong>Return Date:</strong> <?php echo $booking['return_date']; ?></p>
                    <p><strong>Total Price:</strong> $<?php echo $booking['total_price']; ?></p>
                    <p><strong>Amount Paid:</strong> $<?php echo $booking['amount']; ?></p>
                </div>
                <button onclick="window.print()">Print Bill</button>
            </div>
        </section>
    </main>
</body>
</html>


<!-- todo -->
 <!-- 1. addn payment method, 2. payment date, 3. add the design -->