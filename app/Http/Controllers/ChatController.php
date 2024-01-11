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
        $inputMessage = $request->message;
        
        // Check if the message is a command
        if ($this->isCommand($inputMessage)) {
            // Handle the command
            return $this->handleCommand($inputMessage);
        }

        // If it's not a command, proceed with storing the message
        $message = new ChatMessage();
        $message->user_id = Auth::id(); // or use $request->user()->id;
        $message->message = $inputMessage;
        $message->save();

        // Return the message and user info as JSON
        return response()->json([
            'message' => $message->message,
            'user' => [
                'name' => $message->user->name,
            ],
        ]);
    }

    private function isCommand($message)
    {
        return str_starts_with($message, '/');
    }

    private function handleCommand($command)
    {
        $user = Auth::user();

        // Split the command into parts
        $parts = explode(' ', $command);
        $commandName = strtolower($parts[0] ?? '');

        // Check if the user is an admin
        if ($user->role !== 'admin') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Handle the /prune command
        if ($commandName === '/prune') {
            return $this->handlePruneCommand($parts);
        }

        // If the command is not recognized, return an error
        return response()->json(['error' => 'Command not recognized'], 422);
    }

private function handlePruneCommand($parts)
{
    $count = $parts[1] ?? null;
    $prunedCount = 0; // Variable to keep track of the number of messages pruned

    if ($count === 'all') {
        // Count all messages before deleting
        $prunedCount = ChatMessage::query()->count();
        // Delete all messages
        ChatMessage::query()->delete();
    } elseif (is_numeric($count)) {
        // Delete the last $count messages
        $messages = ChatMessage::latest()->take($count)->pluck('id');
        $prunedCount = $messages->count(); // Count the number of messages to be deleted
        ChatMessage::destroy($messages);
    } else {
        // If the argument is not recognized, return an error
        return response()->json(['error' => 'Invalid prune command'], 422);
    }

    // Broadcast an event or return a response to update the chat
    // Return the number of messages pruned in the response
    return response()->json([
        'success' => true,
        'message' => 'Messages pruned',
        'pruneCount' => $prunedCount // Include the count of pruned messages
    ]);
}
}
