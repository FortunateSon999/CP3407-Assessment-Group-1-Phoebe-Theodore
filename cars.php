<?php
session_start();

include 'db_connection.php';

// Fetch car data from the Car table
$sql = "SELECT car_id, brand, model, year, color, fuel_type, seat_number, capacity, registration, status, price_per_day, image_path FROM Car";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rent-A-Wheel</title>
    <link rel="stylesheet" href="stylesheet.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>Rent-A-Wheel</h1>
            <nav>
                <ul>
                    <li><a href="homepage.php">Home</a></li>
                    <li><a href="cars.php">Cars</a></li>
                    <li><a href="booking.php">Booking</a></li>
                    <li><a href="aboutus.php">About Us</a></li>
                    <?php if (isset($_SESSION['customer_id'])): ?>
                        <li><a href="userprofile.php">Account</a></li>
                        <li><a href="logout.php">Logout</a></li>
                    <?php else: ?>
                        <li><a href="login.php">Login</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>

    <main>
        <section class="cars-list">
            <div class="container">
                <h2>Available Cars</h2>
                <div class="car-grid">
                <?php
                if ($result->num_rows > 0) {
                    // Output data for each car
                    while($row = $result->fetch_assoc()) {
                        echo "
                        <div class='car-card'>
                            <img src='image/" . $row["image_path"] . "' alt='" . $row["brand"] . " " . $row["model"] . "'>
                            <h3>" . $row["brand"] . " " . $row["model"] . "</h3>
                            <p>$" . $row["price_per_day"] . " per day</p>
                            <a href='car_details.php?car_id=" . $row["car_id"] . "' class='button'>View Details</a>
                        </div>";
                    }
                } else {
                    echo "<p>No cars available.</p>";
                }
                $conn->close();
                ?>
                </div>
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


