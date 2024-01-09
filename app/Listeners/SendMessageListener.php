<?php

// app/Listeners/SendMessageListener.php

namespace App\Listeners;

use App\Events\ChatMessageSent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendMessageListener
{
    public function __construct()
    {
        //
    }

    function handle(ChatMessageSent $event)
        {
    // Create a new chat message record and save it to the database
    $chatMessage = new ChatMessage([
        'username' => $event->username,
        'message' => $event->message,
    ]);

    $chatMessage->save();

    // Perform any other actions you need here, such as broadcasting the event to other users
    }

}