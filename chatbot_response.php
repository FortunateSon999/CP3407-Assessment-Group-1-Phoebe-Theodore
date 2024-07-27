<?php
header('Content-Type: application/json');

$request = json_decode(file_get_contents('php://input'), true);
$message = $request['message'];

$response = 'Hello, here are some things you can ask me about: \n 1) How do I book a car \n 2) Who can I contact';

switch (strtolower($message)) {
    case 'hello':
        $response = 'Hi there!';
        break;
    case 'how are you?':
        $response = 'I am just a bot, but I am doing great!';
        break;
    default:
        $response = 'Sorry, I did not understand that.';
        break;
}

echo json_encode(['response' => $response]);
?>