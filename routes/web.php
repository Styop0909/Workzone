<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

include __DIR__ . '/blades_route.php';
include __DIR__ . '/chat_route.php';
include __DIR__ . '/jobs_routes.php';
Route::controller(AuthController::class)->middleware('guest')->group(function () {
    Route::get('/login', 'view_login')->name('view_login');
    Route::get('/register', 'view_register')->name('view_register');
    Route::post('/login', 'login')->name('login');
    Route::post('/register', 'register')->name('register');
});
Route::middleware('auth')->group(function () {
    Route::get("/logout", [AuthController::class,'logout'])->name('logout');
});
