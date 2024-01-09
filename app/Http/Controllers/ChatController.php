<?php

// app/Http/Controllers/ChatController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ChatMessage;
use Auth;

class ChatController extends Controller
{
    public function store(Request $request)
    {
        $message = new ChatMessage();
        $message->user_id = Auth::id(); // or use $request->user()->id;
        $message->message = $request->message;
        $message->save();

        // Return the message and user info as JSON
        return response()->json([
            'message' => $message->message,
            'user' => [
                'name' => $message->user->name,
            ],
        ]);
    }
}
