<?php

use App\Models\ChatMessage;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LiveStreamController;
use App\Http\Controllers\StreamKeyController;
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


Route::get('/temp', function () {
    return view('lmao');
});


Route::get('/dashboard', function () {
    // Retrieve chat messages, including user information
    $messages = ChatMessage::with('user')->get();

    // Pass the messages to the dashboard view
    return view('dashboard', ['messages' => $messages]);
})->middleware(['auth', 'verified'])->name('dashboard');


//Route::get('/live', function () {
    // Retrieve chat messages, including user information
//    $messages = ChatMessage::with('user')->get();

    // Pass the messages to the dashboard view
//    return view('live', ['messages' => $messages]);
//})->middleware(['auth', 'verified'])->name('live');

Route::get('/live', [LiveStreamController::class, 'index'])->name('live.index');
Route::get('/live/{name}', [LiveStreamController::class, 'show'])->name('live.show');

Route::post('/stream-key/generate', [StreamKeyController::class, 'generate'])->middleware('auth');
Route::post('/stream-key/reset', [StreamKeyController::class, 'reset'])->middleware('auth');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::patch('/stream-key/reset', [StreamKeyController::class, 'reset'])->name('stream-key.reset');

});

// Chat routes
Route::middleware(['auth'])->group(function () {
    Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');
    route::post('/send-message', [ChatController::class, 'store'])->middleware('auth');
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
