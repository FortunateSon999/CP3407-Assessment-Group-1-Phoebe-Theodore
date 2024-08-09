<?php
session_start();
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $customer_id = $_SESSION['customer_id'];
        $car_id = $_POST['car_id'];
        $rating = $_POST['rating_data'];
        $review = $_POST['review'];
        $created_at = date('Y-m-d H:i:s');

        // Log received data for debugging
        error_log("Received data: car_id = $car_id, rating = $rating, review = $review");

        $sql = "INSERT INTO Review (customer_id, car_id, rating, comment, created_at) VALUES (:customer_id, :car_id, :rating, :comment, :created_at)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':customer_id', $customer_id);
        $stmt->bindParam(':car_id', $car_id);
        $stmt->bindParam(':rating', $rating);
        $stmt->bindParam(':comment', $review);
        $stmt->bindParam(':created_at', $created_at);

        if ($stmt->execute()) {
            echo "Review submitted successfully.";
        } else {
            $error = $stmt->errorInfo();
            echo "Error submitting review: " . $error[2];
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>


