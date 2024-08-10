<?php
include 'db_connection.php'; // Your database connection file

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userMessage = strtolower(trim($_POST['message']));

    // Basic keyword-based response logic
    $response = "I'm not sure how to respond to that.";

    // Sample logic to handle common questions
    $query = $conn->prepare("SELECT response_message FROM responses r JOIN questions q ON r.id = q.response_id WHERE q.question = ?");
    $query->bind_param('s', $userMessage);
    $query->execute();
    $query->bind_result($response);
    $query->fetch();
    $query->close();

    // If no response found, log the question to unanswered table
    if (!$response) {
        $stmt = $conn->prepare("INSERT INTO unanswered (question, no_asks) VALUES (?, 1) ON DUPLICATE KEY UPDATE no_asks = no_asks + 1");
        $stmt->bind_param('s', $userMessage);
        $stmt->execute();
        $stmt->close();
        $response = "I'm sorry, I don't have an answer for that yet.";
    }

    echo $response;
}
?>