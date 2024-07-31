<?php
session_start();
include 'db_connection.php';

// Fetch cars with status=1
$sql = "SELECT * FROM Car WHERE status=1 LIMIT 5"; // Adjust the query as needed
$result = $conn->query($sql);

$cars = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $cars[] = $row;
    }
}

// Fetch discounts
$sql = "SELECT * FROM Discount"; // Adjust the query as needed
$result = $conn->query($sql);

$discounts = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $discounts[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
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
                    <li><a href="chatbot.php">Chatbot</a></li>
                    <?php if (isset($_SESSION['customer_id'])): ?>
                        <li><a href="profile.php">Account</a></li>
                        <li><a href="logout.php">Logout</a></li>
                    <?php else: ?>
                        <li><a href="login.php">Login</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>

    <main>
        <section class="hero">
            <div class="container">
                <h1>Welcome to Rent-A-Wheel</h1>
                <p>Find the perfect car for your journey</p>
                <a href="booking.php" class="button">Book Now</a>
            </div>
        </section>

        <section class="search-bar">
            <div class="container">
                <h2>Find Your Perfect Car</h2>
                <input type="text" placeholder="Search for cars..." id="carSearchInput">
                <button onclick="searchCars()">Search</button>
            </div>
        </section>

        <section class="featured-cars">
            <div class="container">
                <h2>Featured Car Rentals</h2>
                <div class="car-carousel">
                    <?php foreach ($cars as $car): ?>
                    <div class="car-card">
                        <img src="image/<?php echo htmlspecialchars($car['image_path']); ?>" alt="<?php echo htmlspecialchars($car['brand'] . ' ' . $car['model']); ?>">
                        <h3><?php echo htmlspecialchars($car['brand'] . ' ' . $car['model']); ?></h3>
                        <p>$<?php echo htmlspecialchars($car['price_per_day']); ?> per day</p>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <section class="discount">
            <div class="container">
                <h2>Seasons Discount!!!</h2>
                <div class="discount-carousel">
                    <?php foreach ($discounts as $discount): ?>
                    <div class="discount-card">
                        <img src="discounts/<?php echo htmlspecialchars($discount['image_path']); ?>" alt="<?php echo htmlspecialchars($discount['discount_code']); ?>">
                        <h3><?php echo htmlspecialchars($discount['discount_code']); ?></h3>
                        <p><?php echo htmlspecialchars($discount['description']); ?></p>
                        <p><?php echo htmlspecialchars($discount['discount_percent']); ?>% off</p>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <section class="testimonials">
            <div class="container">
                <h2>Testimonials</h2>
                <div class="testimonial">
                    <p>"Great service and amazing cars! Highly recommend Rent-A-Wheel."</p>
                    <h3>- John Doe</h3>
                </div>
                <div class="testimonial">
                    <p>"Very convenient and affordable. Will definitely rent again."</p>
                    <h3>- Jane Smith</h3>
                </div>
            </div>
        </section>
    </main>

    <footer>
        <div class="container">
            <p>&copy; 2024 Rent-A-Wheel. All rights reserved.</p>
        </div>
    </footer>

    <script>
        function searchCars() {
            const input = document.getElementById('carSearchInput').value;
            window.location.href = `search.php?query=${input}`;
        }
    </script>
</body>
</html>
