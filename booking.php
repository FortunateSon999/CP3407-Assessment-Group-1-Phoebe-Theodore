<?php
session_start();
include 'db_connection.php';

// Check if customer is logged in
if (!isset($_SESSION['customer_id'])) {
    header("Location: login.php");
    exit();
}

// include 'login_restriction.php';

// Fetch available cars
$sql = "SELECT car_id, brand, model, price_per_day FROM Car WHERE status = 1";
$result = $conn->query($sql);
if ($result === FALSE) {
    echo "Error fetching cars: " . $conn->error;
}

// Fetch available discounts
$discountSql = "SELECT discount_id, discount_percent FROM discount";
$discountResult = $conn->query($discountSql);
if ($discountResult === FALSE) {
    echo "Error fetching discounts: " . $conn->error;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking - Rent-A-Wheel</title>
    <link rel="stylesheet" href="stylesheet.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
        <section class="booking-form">
            <div class="container">
                <h2>Car Booking Form</h2>
                <p>Please fill out the form below to book a car.</p>
                <form action="submit_booking.php" method="POST">
                    <input type="hidden" name="customer_id" value="<?php echo $_SESSION['customer_id']; ?>">
                    <div class="form-group">
                        <label for="car_id">Select Car</label>
                        <select id="car_id" name="car_id" required>
                            <option value="">Select a car</option>
                            <?php
                            if ($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                    echo "<option value='" . $row['car_id'] . "'>" . $row['brand'] . " " . $row['model'] . " - $" . $row['price_per_day'] . " per day</option>";
                                }
                            } else {
                                echo "<option value=''>No cars available</option>";
                            }
                            ?>
                        </select>
                    </div>
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
                    <div class="form-group">
                        <label for="discount_id">Select Discount</label>
                        <select id="discount_id" name="discount_id">
                            <option value="">No Discount</option>
                            <?php
                            if ($discountResult->num_rows > 0) {
                                while($discountRow = $discountResult->fetch_assoc()) {
                                    echo "<option value='" . $discountRow['discount_id'] . "'>" . $discountRow['discount_percent'] . "% off</option>";
                                }
                            } else {
                                echo "<option value=''>No discounts available</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="discount_code">Discount Code</label>
                        <input type="text" id="discount_code" name="discount_code" placeholder="Enter discount code if applicable">
                        <button type="button" id="apply_discount">Apply Discount</button>
                        <p id="discount_message"></p>
                    </div>
                    <div class="form-group">
                        <label for="payment_method">Payment Method</label>
                        <select id="payment_method" name="payment_method" required>
                            <option value="">Select a payment method</option>
                            <option value="credit_card">Credit Card</option>
                            <option value="cash">Cash</option>
                        </select>
                    </div>
                    <div id="credit_card_details" style="display: none;" class="form-group">
                        <div class="form-group">
                            <label for="card_name">Name on Card</label>
                            <input type="text" id="card_name" name="card_name" placeholder="Enter the name on your card">
                        </div>
                        <div class="form-group">
                            <label for="card_number">Card Number</label>
                            <input type="text" id="card_number" name="card_number" placeholder="Enter your card number">
                        </div>
                        <div class="form-group">
                            <label for="card_expiry">Expiry Date</label>
                            <input type="month" id="card_expiry" name="card_expiry">
                        </div>
                        <div class="form-group">
                            <label for="card_cvc">CVC</label>
                            <input type="text" id="card_cvc" name="card_cvc" placeholder="Enter your card CVC">
                        </div>
                    </div>
                    <button type="submit">Submit Booking</button>
                </form>
            </div>
        </section>
    </main>
    <script>
        // JavaScript for handling discount code application
        document.getElementById('apply_discount').addEventListener('click', function() {
            var discountCode = document.getElementById('discount_code').value;
            var discountId = document.getElementById('discount_id').value;
            if (discountCode && discountId) {
                var xhr = new XMLHttpRequest();
                xhr.open('POST', 'validate_discount.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        var response = JSON.parse(xhr.responseText);
                        var discountMessage = document.getElementById('discount_message');
                        if (response.success) {
                            discountMessage.textContent = 'Discount applied: ' + response.discount_percent + '% off';
                            discountMessage.style.color = 'green';
                            document.querySelector('form').insertAdjacentHTML('beforeend', '<input type="hidden" name="discount_percent" value="' + response.discount_percent + '">');
                        } else {
                            discountMessage.textContent = response.message;
                            discountMessage.style.color = 'red';
                        }
                    }
                };
                xhr.send('discount_code=' + discountCode + '&discount_id=' + discountId);
            } else {
                alert("Please select a discount and enter the discount code.");
            }
        });
        
        function toggleCreditCardDetails() {
            var paymentMethod = document.getElementById('payment_method').value;
            var creditCardDetails = document.getElementById('credit_card_details');
            if (paymentMethod === 'credit_card') {
                creditCardDetails.style.display = 'block';
            } else {
                creditCardDetails.style.display = 'none';
            }
        }
        // Add event listener to call toggleCreditCardDetails on page load
        document.addEventListener('DOMContentLoaded', function() {
            var paymentMethodDropdown = document.getElementById('payment_method');
            paymentMethodDropdown.addEventListener('change', toggleCreditCardDetails);
        });

        function validateDates(event) {
            var pickupDate = new Date(document.getElementById('pickup_date').value);
            var returnDate = new Date(document.getElementById('return_date').value);
            var currentDate = new Date();
            currentDate.setHours(0, 0, 0, 0); // Set to start of the day
            if (pickupDate < currentDate) {
                alert("Pickup date cannot be before the current date.");
                event.preventDefault();
                return false;
            }
            if (returnDate < currentDate) {
                alert("Return date cannot be before the current date.");
                event.preventDefault();
                return false;
            }
            if (returnDate < pickupDate) {
                alert("Return date cannot be before the pickup date.");
                event.preventDefault();
                return false;
            }
            return true;
        }
        // Add event listener to validate dates on form submission
        document.querySelector('form').addEventListener('submit', validateDates);
    </script>
    <footer>
        <div class="container">
            <p>&copy; 2024 Rent-A-Wheel. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
<?php
$conn->close();
?>
