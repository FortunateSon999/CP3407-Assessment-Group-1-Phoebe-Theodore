// document.addEventListener('DOMContentLoaded', function() {
//     const chatBox = document.querySelector('.chat-box');

//     function displayMenu() {
//         const menuOptions = [
//             'Option 1: Get weather',
//             'Option 2: Get news',
//             'Option 3: Get a joke'
//         ];

//         const menuDiv = document.createElement('div');
//         menuDiv.classList.add('menu-options');

//         menuOptions.forEach(option => {
//             const optionDiv = document.createElement('div');
//             optionDiv.classList.add('menu-option');
//             optionDiv.textContent = option;
//             optionDiv.addEventListener('click', () => handleMenuSelection(option));
//             menuDiv.appendChild(optionDiv);
//         });

//         chatBox.appendChild(menuDiv);
//         chatBox.scrollTop = chatBox.scrollHeight;
//     }

//     function handleMenuSelection(option) {
//         // Clear previous menu options
//         const menuDiv = document.querySelector('.menu-options');
//         if (menuDiv) {
//             menuDiv.remove();
//         }

//         // Display selected option
//         const userMessageDiv = document.createElement('div');
//         userMessageDiv.classList.add('user-message');
//         userMessageDiv.textContent = option;
//         chatBox.appendChild(userMessageDiv);

//         // Send the selected option to the server
//         fetch('chatbot_response.php', {
//             method: 'POST',
//             headers: {
//                 'Content-Type': 'application/json'
//             },
//             body: JSON.stringify({ selection: option.toLowerCase().split(': ')[1] })
//         })
//         .then(response => response.json())
//         .then(data => {
//             // Display bot response
//             const botMessageDiv = document.createElement('div');
//             botMessageDiv.classList.add('bot-message');
//             botMessageDiv.textContent = data.response;
//             chatBox.appendChild(botMessageDiv);

//             // Scroll to the bottom of the chat box
//             chatBox.scrollTop = chatBox.scrollHeight;

//             // Display menu again for the next interaction
//             displayMenu();
//         })
//         .catch(error => {
//             console.error('Error:', error);
//         });
//     }

//     // Initialize the chat with the menu
//     displayMenu();
// });