<?php

namespace App\Http\Controllers;

use App\Models\User;

class LiveStreamController extends Controller
{
    // Method to show the list of users
    public function index()
    {
        $users = User::all(); // Fetch all users or a subset, depending on your needs
        return view('live.index', compact('users')); // Pass the users to the view
    }

    // Existing method to show an individual user's live stream
    public function show($name)
    {
        $user = User::where('name', $name)->firstOrFail();
        $messages = []; // Fetch messages if necessary
        return view('live.show', compact('user', 'messages'));
    }
}
