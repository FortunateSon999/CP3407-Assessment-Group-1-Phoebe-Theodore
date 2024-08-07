<?php
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $discount_code = $_POST['discount_code'];

    // Query to check if the discount code exists and is valid
    $sql = "SELECT discount_percent FROM Discounts WHERE code = ? AND valid = 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $discount_code);
    $stmt->execute();
    $stmt->bind_result($discount_percent);
    $stmt->fetch();

    if ($discount_percent) {
        // If valid, return the discount percent and a success message
        $response = [
            'success' => true,
            'discount_percent' => $discount_percent,
            'total_price' => 'calculate_total_price_with_discount()', // Placeholder for total price calculation
        ];
    } else {
        // If not valid, return an error message
        $response = [
            'success' => false,
            'message' => 'Invalid or expired discount code',
        ];
    }

    echo json_encode($response);
    $stmt->close();
}
$conn->close();
?>
