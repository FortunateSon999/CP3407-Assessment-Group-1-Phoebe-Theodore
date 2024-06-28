<?php
// Database connection settings
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ass1";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch car data from the Car table
$sql = "SELECT car_id, make, model, year, color, registration, status, price_per_day, image_path FROM Car";
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
                    <li><a href="login.php">Login</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main>
        <h1>Car Listings</h1>

        <div class="car-list">
        <?php
        if ($result->num_rows > 0) {
            // Output data for each car
            while($row = $result->fetch_assoc()) {
                echo "<div class='car'>";
                echo "<img src='image/" . $row["image_path"] . "' alt='Car Image'>";
                echo "<div class='car-info'>";
                echo "<h2>" . $row["make"] . " " . $row["model"] . "</h2>";
                echo "<p>Year: " . $row["year"] . "</p>";
                echo "<p>Price per Day: $" . $row["price_per_day"] . "</p>";
                echo "<a href='car_details.php?car_id=" . $row["car_id"] . "' class='button'>View Details</a>";
                echo "</div>";
                echo "</div>";
            }
        } else {
            echo "No cars available.";
        }
        $conn->close();
        ?>
        </div>
    </main>

    <footer>
        <div class="container">
            <p>&copy; 2024 Rent-A-Wheel. All rights reserved.</p>
        </div>
    </footer>

</body>
</html>
