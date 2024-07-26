<?php
include 'db_connection.php';

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
    <link rel="stylesheet" href="stylesheet.css">
</head>
<body>
    <div class="back-button-container">
        <a href="cars.php" class="back-button">Back to Cars</a>
    </div>
<?php if ($car): ?>
<div class="car-details">
    <img src="image/<?php echo $car['image_path']; ?>" alt="Car Image">
    <div class="car-info">
        <h2><?php echo $car['brand'] . " " . $car['model']; ?></h2>
        <p>Year: <?php echo $car['year']; ?></p>
        <p>Color: <?php echo $car['color']; ?></p>
        <p>Fuel Type: <?php echo $car['fuel_type']; ?></p>
        <p>Seats: <?php echo $car['seat_number']; ?></p>
        <p>Capacity: <?php echo $car['capacity']; ?> L</p>
        <p>Registration: <?php echo $car['registration']; ?></p>
        <p>Status: <?php echo $car['status'] ? 'Available' : 'Not Available'; ?></p>
        <p>Price per Day: $<?php echo $car['price_per_day']; ?></p>
        <a href="review.php?car_id=<?php echo $car['car_id']; ?>" class="button">Review</a>
        <a href="booking.php?car_id=<?php echo $car['car_id']; ?>" class="button">Book Now</a>
    </div>
</div>
<?php else: ?>
    <p>Car details not available.</p>
<?php endif; ?>

<?php $conn->close(); ?>

</body>
</html>
