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

// Fetch car data based on car_id
$car_id = isset($_GET['car_id']) ? intval($_GET['car_id']) : 0;
$sql = "SELECT * FROM Car WHERE car_id = $car_id";
$result = $conn->query($sql);
$car = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Car Details</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php if ($car): ?>
<div class="car-details">
    <img src="images/<?php echo $car['image_path']; ?>" alt="Car Image">
    <div class="car-info">
        <h2><?php echo $car['make'] . " " . $car['model']; ?></h2>
        <p>Year: <?php echo $car['year']; ?></p>
        <p>Color: <?php echo $car['color']; ?></p>
        <p>Registration: <?php echo $car['registration']; ?></p>
        <p>Status: <?php echo $car['status']; ?></p>
        <p>Price per Day: $<?php echo $car['price_per_day']; ?></p>
        <a href="booking.php?car_id=<?php echo $car['car_id']; ?>" class="button">Book Now</a>
    </div>
</div>
<?php else: ?>
<p>Car not found.</p>
<?php endif; ?>

<?php $conn->close(); ?>

</body>
</html>
