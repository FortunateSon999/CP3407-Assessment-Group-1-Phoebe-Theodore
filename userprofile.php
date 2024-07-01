<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile - Rent-A-Wheel</title>
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
        <section class="profile">
            <div class="container">
                <h2>User Profile</h2>
                <?php
                session_start();
                if (!isset($_SESSION['customer_id'])) {
                    header("Location: login.php");
                    exit();
                }

                // Database connection
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "rent";

                $conn = new mysqli($servername, $username, $password, $dbname);

                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                $customer_id = $_SESSION['customer_id'];
                $sql = "SELECT * FROM Customer WHERE customer_id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $customer_id);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                ?>
                <form action="update_profile.php" method="POST" enctype="multipart/form-data">
                    <div>
                        <label for="first_name">First Name:</label>
                        <input type="text" id="first_name" name="first_name" value="<?php echo $row['first_name']; ?>" required>
                    </div>
                    <div>
                        <label for="last_name">Last Name:</label>
                        <input type="text" id="last_name" name="last_name" value="<?php echo $row['last_name']; ?>" required>
                    </div>
                    <div>
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" value="<?php echo $row['email']; ?>" required>
                    </div>
                    <div>
                        <label for="phone">Phone:</label>
                        <input type="text" id="phone" name="phone" value="<?php echo $row['phone']; ?>" required>
                    </div>
                    <div>
                        <label for="age">Age:</label>
                        <input type="number" id="age" name="age" value="<?php echo $row['age']; ?>" required>
                    </div>
                    <div>
                        <label for="profile_picture">Profile Picture:</label>
                        <input type="file" id="profile_picture" name="profile_picture" accept="image/*">
                        <?php
                        $default_image = 'image/dprofile.png'; // handle defalt pic
                        $profile_picture = !empty($row['profile_picture']) ? $row['profile_picture'] : $default_image;
                        ?>
                        <img src="<?php echo htmlspecialchars($profile_picture); ?>" alt="Profile Picture" style="max-width: 100px;">
                    </div>
                    <button type="submit">Update Profile</button>
                </form>
                <?php
                } else {
                    echo "<p>User not found.</p>";
                }

                $conn->close();
                ?>
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
