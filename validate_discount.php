<?php
include 'db_connection.php'; // Ensure this file contains correct database connection code

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate input
    $discount_code = filter_input(INPUT_POST, 'discount_code', FILTER_SANITIZE_STRING);
    $discount_id = filter_input(INPUT_POST, 'discount_id', FILTER_VALIDATE_INT);

    if (!$discount_code || !$discount_id) {
        // Invalid input
        echo json_encode(['success' => false, 'message' => 'Invalid input data.']);
        exit;
    }

    // Prepare and execute SQL query
    $sql = "SELECT discount_id, discount_percent 
            FROM discount 
            WHERE discount_id = ? 
            AND discount_code = ? 
            AND NOW() BETWEEN valid_from AND valid_until";
    $stmt = $conn->prepare($sql);
    
    if (!$stmt) {
        echo json_encode(['success' => false, 'message' => 'Database query preparation failed.']);
        exit;
    }

    $stmt->bind_param("is", $discount_id, $discount_code);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $discount = $result->fetch_assoc();
        $response = [
            'success' => true,
            'discount_percent' => floatval($discount['discount_percent']) // Convert to float
        ];
    } else {
        $response = [
            'success' => false,
            'message' => 'Invalid or expired discount code.'
        ];
    }

    echo json_encode($response);
    $stmt->close(); // Close statement
    $conn->close(); // Close connection
}
?>
