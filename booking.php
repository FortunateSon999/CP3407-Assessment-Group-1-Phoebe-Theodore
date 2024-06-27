<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking - Rent-A-Wheel</title>
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
                    <li><a href="contactus.php">Contact Us</a></li>
                    <li><a href="login.php">Login</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main>
        <section class="booking-form">
            <div class="container">
                <h2>Car Booking Form</h2>
                <p>Please fill out the form below to book a car.</p>
                <form action="submit_booking.php" method="POST">
                    <div class="form-group">
                        <label for="fullname">Full Name</label>
                        <input type="text" id="fullname" name="fullname" placeholder="Enter your full name" required>
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone Number</label>
                        <input type="tel" id="phone" name="phone" placeholder="Enter your phone number" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" name="email" placeholder="Enter your email address" required>
                    </div>
                    <div class="form-group">
                        <label for="cartype">Select car type</label>
                        <select id="cartype" name="cartype" required>
                            <option value="">Choose car type</option>
                            <option value="compact">Compact</option>
                            <option value="sedan">Sedan</option>
                            <option value="suv">SUV</option>
                            <option value="luxury">Luxury</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="pickup_date">Pickup Date</label>
                        <input type="date" id="pickup_date" name="pickup_date" required>
                    </div>
                    <div class="form-group">
                        <label for="pickup_time">Pickup Time</label>
                        <input type="time" id="pickup_time" name="pickup_time" required>
                    </div>
                    <div class="form-group">
                        <label for="return_date">Return Date</label>
                        <input type="date" id="return_date" name="return_date" required>
                    </div>
                    <div class="form-group">
                        <label for="return_time">Return Time</label>
                        <input type="time" id="return_time" name="return_time" required>
                    </div>
                    <button type="submit">Submit Booking</button>
                </form>
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