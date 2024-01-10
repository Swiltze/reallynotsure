<div class="flex flex-col h-full">
    <div id="chat-messages" class="flex-1 overflow-y-auto p-4">
        @foreach ($messages as $message)
            <div class="mb-4">
                <span class="font-bold text-white">{{ $message->user->name }}:</span>
                <span class="text-gray-300">{{ $message->message }}</span>
            </div>
        @endforeach
    </div>
    <div class="mt-auto bg-gray-700 border-t border-gray-600 p-2">
        <div class="flex">
            <input type="text" id="chat-input" class="flex-1 bg-gray-800 text-white p-2 rounded focus:outline-none" placeholder="Type your message here...">
            <button onclick="sendMessage()" class="ml-2 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none">
                Send
            </button>
        </div>
    </div>
</div>
<style>
    #chat-container {
        position: relative;
        /* Adjust the height as needed, or make it full height */
        height: 100vh;
    }

    #chat {
        position: relative;
        right: 0;
        bottom: 0;
        height: 100%; /* Full height of the container */
        background-color: #f9f9f9; /* Light grey background */
        border-left: 1px solid #ddd; /* Separator line */
        display: flex;
        flex-direction: column;
    }

    #chat-messages {
        overflow-y: auto;
        padding: 10px;
        margin: 0;
        list-style: none;
        flex-grow: 1; /* Take up available space */
    }

    #chat-messages li {
        margin-bottom: 10px;
        line-height: 1.4;
    }

    #chat-input {
        border: none;
        padding: 10px;
        width: calc(100% - 20px); /* Full width minus padding */
        margin: 10px;
    }

    button {
        background-color: #007bff; /* Bootstrap primary color */
        color: white;
        padding: 10px 20px;
        border: none;
        cursor: pointer;
    }

    button:hover {
        background-color: #0056b3; /* Darken on hover */
    }
</style>
<script>
function handleEnter(event) {
        // Check if the Enter key was pressed
        if (event.key === 'Enter') {
            // Prevent the default action to avoid form submission
            event.preventDefault();
            // Call the sendMessage function
            sendMessage();
        }
    }
    // JavaScript to send a message
    function sendMessage() {
    var input = document.getElementById('chat-input');
    var message = input.value;

    // Check if the message is not empty
    if (message.trim() === '') {
        alert('Please enter a message.');
        return;
    }





    // Prepare the data to be sent in the request
    var data = new FormData();
    data.append('message', message);

    // Send the message using the Fetch API
    fetch('/send-message', { // Replace '/send-message' with the correct URL endpoint
        method: 'POST',
        body: data,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') // Add CSRF token for Laravel
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.error) {
            alert(data.error);
        } else {
            // Check if the message was a command
            if (message.startsWith('/prune')) {
                // Handle the prune command response
                handlePruneResponse(data);
            } else {
                // Handle a regular message response
                addMessageToChat(data);
            }
        }
        input.value = '';
    })
    .catch((error) => {
        console.error('Error:', error);
    });
}
    function handlePruneResponse(data) {
    if (data.success) {
        // If the prune was successful, clear the chat messages
        var chatMessagesList = document.getElementById('chat-messages');
        while (chatMessagesList.firstChild) {
            chatMessagesList.removeChild(chatMessagesList.firstChild);
        }
        // Optionally, display a system message indicating messages were pruned
        var systemMessage = 'Messages have been pruned by an admin.';
        addSystemMessageToChat(systemMessage);
    }
}

function addMessageToChat(data) {
    var chatMessagesList = document.getElementById('chat-messages');
    var newMessageItem = document.createElement('li');
    newMessageItem.textContent = data.user.name + ': ' + data.message; // Adjust if your response data structure is different
    chatMessagesList.appendChild(newMessageItem);
    chatMessagesList.scrollTop = chatMessagesList.scrollHeight;
}

function addSystemMessageToChat(message) {
    var chatMessagesList = document.getElementById('chat-messages');
    var newMessageItem = document.createElement('li');
    newMessageItem.textContent = message;
    newMessageItem.style.color = 'red'; // Style the system message differently
    chatMessagesList.appendChild(newMessageItem);
    chatMessagesList.scrollTop = chatMessagesList.scrollHeight;
}

document.getElementById('chat-input').addEventListener('keydown', handleEnter);

document.addEventListener('DOMContentLoaded', (event) => {
    var chatMessagesList = document.getElementById('chat-messages');
    chatMessagesList.scrollTop = chatMessagesList.scrollHeight;
});


</script>
