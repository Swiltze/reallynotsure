import './bootstrap';

import Alpine from 'alpinejs';
import Echo from 'laravel-echo';

window.Pusher = require('pusher-js');

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: process.env.MIX_PUSHER_APP_KEY,
    wsHost: window.location.hostname,
    wsPort: 6001,
    disableStats: true,
    forceTLS: false
});

Echo.channel('chat')
    .listen('.ChatMessageSent', (e) => {
        const chatMessages = document.getElementById('chat-messages');
        const newMessage = document.createElement('div');
        newMessage.innerHTML = `${e.username}: ${e.message}`;
        chatMessages.appendChild(newMessage);
    });


window.Alpine = Alpine;

Alpine.start();
