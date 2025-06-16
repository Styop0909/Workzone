<?php

use App\Http\Controllers\MessageController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->controller(MessageController::class)->group(function () {
    Route::get('/chat/{user_id}', 'index')->name('chat.index');
    Route::get("view/chat", 'view_chat')->name('view_chat');
    Route::post('/send/message', 'sendMessage')->name('send_message');
    Route::post("get_all_chat", 'get_all_chat')->name('get_all_chat');
    Route::post('/chat/get-messages', 'getMessages')->name('get_messages');
    Route::post('/chat/send-file', 'sendFile')->name('send_file_message');
    Route::get('/recent-chats', 'recentChats')->name('recent_chats');
});
