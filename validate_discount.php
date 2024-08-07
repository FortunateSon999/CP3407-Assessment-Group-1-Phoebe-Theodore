<?php
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $discount_code = $_POST['discount_code'];
    $discount_id = $_POST['discount_id'];

    // Check if the discount code is valid
    $sql = "SELECT discount_id, discount_percent FROM discount WHERE discount_id = ? AND code = ? AND is_active = 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $discount_id, $discount_code);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $discount = $result->fetch_assoc();
        $response = array(
            'success' => true,
            'discount_percent' => $discount['discount_percent']
        );
    } else {
        $response = array(
            'success' => false,
            'message' => 'Invalid discount code.'
        );
    }

    echo json_encode($response);
    $conn->close();
}
?>
