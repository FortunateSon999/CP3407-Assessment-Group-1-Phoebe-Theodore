<?php
header('Content-Type: application/json');

// Include the database connection file
// include 'db_connection.php';

$request = json_decode(file_get_contents('php://input'), true);
$message = $request['message'];
$response = "";

// Prepare and bind, a prepared statement is used to prevent SQL injection. The question parameter is bound to the user’s message.
// $stmt = $conn->prepare("SELECT response FROM chatbot_responses WHERE question = ?");
// $stmt->bind_param("s", $message);

// // Execute the statement
// $stmt->execute();
// $stmt->bind_result($response);
// $stmt->fetch();

// // Check if a response was found
// if (empty($response)) {
//     $response = 'Sorry, I did not understand that.';
// }

// // Close the statement and connection
// $stmt->close();
// $conn->close();

switch (strtolower($message)) {
    case 'hello':
        $response = 'Hi there!';
        break;
    case 'how are you?':
        $response = 'I am just a bot, but I am doing great!';
        break;
    case 'what is your name?':
        $response = 'I am Rent-A-Wheel Bot.';
        break;
    case 'what is your purpose?':
        $response = 'I am here to help you with any questions you have about Rent-A-Wheel.';
        break;
    case 'goodbye':
        $response = 'Goodbye!';
        break;
    default:
        $response = 'Sorry, I did not understand that.';
        break;
}

echo json_encode(['response' => $response]);
?>