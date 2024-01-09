<?php

use App\Models\ChatMessage;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ChatController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::get('/dashboard', function () {
    // Retrieve chat messages, including user information
    $messages = ChatMessage::with('user')->get();

    // Pass the messages to the dashboard view
    return view('dashboard', ['messages' => $messages]);
})->middleware(['auth', 'verified'])->name('dashboard');


Route::get('/live', function () {
    // Retrieve chat messages, including user information
    $messages = ChatMessage::with('user')->get();

    // Pass the messages to the dashboard view
    return view('live', ['messages' => $messages]);
})->middleware(['auth', 'verified'])->name('live');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Chat routes
Route::middleware(['auth'])->group(function () {
    Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');
    route::post('/send-message', [ChatController::class, 'store']);
    Route::post('/messages', [ChatController::class, 'postMessage'])->name('chat.postMessage');
    // ... other chat routes ...
});

// Admin routes
Route::middleware(['auth', 'admin'])->group(function () {
    Route::post('/ban-user', [AdminController::class, 'banUser'])->name('admin.banUser');
    Route::post('/delete-message', [AdminController::class, 'deleteMessage'])->name('admin.deleteMessage');
    // ... other admin routes ...
});


require __DIR__.'/auth.php';
