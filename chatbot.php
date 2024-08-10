<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chatbot - Rent-A-Wheel</title>
    <link rel="stylesheet" href="stylesheet.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
                    <li><a href="chatbot.php">Chatbot</a></li>
                    <?php if (isset($_SESSION['customer_id'])): ?>
                        <li><a href="profile.php">Account</a></li>
                        <li><a href="logout.php">Logout</a></li>
                    <?php else: ?>
                        <li><a href="login.php">Login</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>

    <div class="chat-container">
        <h2>Welcome to Rent-A-Wheel Chatbot!</h2>
        <p>How can I assist you today?</p>
        <div id="chat-box"></div>
        <div class="input-area">
            <input type="text" id="user-input" placeholder="Type a message...">
            <button id="send-button"><i class="fas fa-paper-plane"></i></button>
        </div>
    </div>

    <footer>
        <div class="container">
            <p>&copy; 2024 Rent-A-Wheel. All rights reserved.</p>
        </div>
    </footer>

    <script>
        $(document).ready(function(){
            function scrollToBottom() {
                $('#chat-box').scrollTop($('#chat-box')[0].scrollHeight);
            }

            function sendMessage() {
                var userInput = $('#user-input').val().trim();
                if (userInput) {
                    $('#chat-box').append('<div class="user-message"><i class="fas fa-user-circle"></i><div class="message">' + userInput + '</div></div>');
                    scrollToBottom();
                    $.ajax({
                        url: 'chatbot_backend.php',
                        method: 'POST',
                        data: {message: userInput},
                        beforeSend: function() {
                            // Optional: Show a typing indicator
                            $('#chat-box').append('<div class="bot-response typing-indicator"><i class="fas fa-robot"></i><div class="message">Bot is typing...</div></div>');
                            scrollToBottom();
                        },
                        success: function(response){
                            // Remove the typing indicator
                            $('.typing-indicator').remove();

                            // Append the bot response
                            $('#chat-box').append('<div class="bot-response"><i class="fas fa-robot"></i><div class="message">' + response + '</div></div>');
                            $('#user-input').val('');
                            scrollToBottom();
                        },
                        error: function() {
                            // Optional: Handle any errors
                            $('.typing-indicator').remove();
                            $('#chat-box').append('<div class="bot-response"><i class="fas fa-robot"></i><div class="message">Sorry, something went wrong. Please try again.</div></div>');
                            scrollToBottom();
                        }
                    });
                }
            }

            // Trigger send on button click
            $('#send-button').on('click', function(){
                sendMessage();
            });

            // Trigger send on pressing "Enter" key
            $('#user-input').on('keypress', function(e){
                if(e.which == 13) {
                    sendMessage();
                }
            });
        });

    </script>
</body>
</html>

