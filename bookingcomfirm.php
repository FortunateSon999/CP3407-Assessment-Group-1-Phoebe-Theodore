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

// Get booking details from session or URL parameters
$rental_id = isset($_GET['rental_id']) ? intval($_GET['rental_id']) : 0;

// Fetch booking details from the Rentals table
$sql = "SELECT Rentals.*, Customer.first_name, Customer.last_name, Car.brand, Car.model, Car.registration 
        FROM Rentals
        JOIN Customer ON Rentals.customer_id = Customer.customer_id
        JOIN Car ON Rentals.car_id = Car.car_id
        WHERE Rentals.rental_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $rental_id);
$stmt->execute();
$result = $stmt->get_result();
$booking = $result->fetch_assoc();

if (!$booking) {
    echo "Booking not found.";
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Confirmation</title>
    <link rel="stylesheet" href="stylessheet.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>Rent_A_Wheel</h1>
            <nav>
                <ul>
                    <li><a href="cars.php">Cars</a></li>
                    <li><a href="abooutus.php">Contact Us</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <main>
        <div class="confirmation-container">
            <div class="confirmation-box">
                <h2>Booking Confirmation</h2>
                <p>Thank you for your booking! Here are your booking details:</p>
                <div class="confirmation-details">
                    <p><strong>Booking ID:</strong> #123456</p>
                    <p><strong>Car:</strong> Tesla Model 3</p>
                    <p><strong>Pickup Date:</strong> 2023-06-30</p>
                    <p><strong>Dropoff Date:</strong> 2023-07-05</p>
                    <p><strong>Total Cost:</strong> $500</p>
                </div>
                <a href="bill.php?rental_id=<?php echo $booking['rental_id']; ?>" class="button">View & Print Bill</a>
                <a href="index.php" class="button">Go to Home</a>
            </div>
        </div>
    </main>
    <footer>
        <div class="container">
            <p>&copy; 2024 Rent_A_Wheel. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
