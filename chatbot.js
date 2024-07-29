document.addEventListener('DOMContentLoaded', function() {
    const chatBox = document.getElementById('chat-box');
    const userInput = document.getElementById('user-input');

    function sendMessage() {
        const message = userInput.value.trim();
        if (message === '') return;

        // Display user message
        const userMessageDiv = document.createElement('div');
        userMessageDiv.classList.add('user-message');
        userMessageDiv.textContent = message;
        chatBox.appendChild(userMessageDiv);

        // Clear input field
        userInput.value = '';

        // Send message to server
        fetch('chatbot_response.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ message: message })
        })
        .then(response => response.json())
        .then(data => {
            // Display bot response
            const botMessageDiv = document.createElement('div');
            botMessageDiv.classList.add('bot-message');
            botMessageDiv.textContent = data.response;
            chatBox.appendChild(botMessageDiv);

            // Scroll to the bottom of the chat box
            chatBox.scrollTop = chatBox.scrollHeight;
        })
        .catch(error => console.error('Error:', error));
    }

    document.querySelector('button').addEventListener('click', sendMessage);
    userInput.addEventListener('keypress', function(event) {
        if (event.key === 'Enter') {
            sendMessage();
        }
    });
});

// function sendMessage() {
//     const userInput = document.getElementById('user-input');
//     const message = userInput.value.trim();
//     if (message) {
//         displayMessage(message, 'user');
//         userInput.value = '';
//         getBotResponse(message);
//     }
// }



// function displayMessage(message, sender) {
//     const chatBox = document.getElementById('chat-box');
//     const messageElement = document.createElement('div');
//     messageElement.classList.add('message', sender);
//     messageElement.textContent = message;
//     chatBox.appendChild(messageElement);
//     chatBox.scrollTop = chatBox.scrollHeight;
// }

// function getBotResponse(message) {
//     fetch('chatbot_response.php', {
//         method: 'POST',
//         headers: {
//             'Content-Type': 'application/json'
//         },
//         body: JSON.stringify({ message: message })
//     })
//     .then(response => response.json())
//     .then(data => {
//         displayMessage(data.response, 'bot');
//     })
//     .catch(error => {
//         console.error('Error:', error);
//     });
// }

// function displayMenu() {
//     const menuOptions = [
//         '1. Check account balance\n',
//         '2. Transfer money\n',
//         '3. Pay bills\n',
//         '4. Contact support\n'
//     ];
//     const menuMessage = 'Here are some things you can ask me:\n' + menuOptions.join('\n');
//     displayMessage(menuMessage, 'bot');
// }