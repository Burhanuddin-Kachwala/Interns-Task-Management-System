<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Intern\ChatController;
use App\Http\Controllers\Intern\TaskController;
use App\Http\Controllers\Intern\InternController;

Route::get('/', [InternController::class, 'dashboard'])
->name('intern.dashboard')
->middleware(['auth:intern']);
Route::prefix('intern')->group(function () {
    Route::middleware(['auth:intern'])->group(function () {
        // Route::get('/', [InternController::class, 'dashboard'])->name('intern.dashboard');
        Route::post('/logout', [InternController::class, 'logout'])->name('intern.logout');
        Route::get('/tasks', [TaskController::class, 'index'])->name('intern.tasks.index');
        Route::get('/tasks/{task}', [TaskController::class, 'show'])->name('intern.tasks.show');
        Route::post('/tasks/{task}/comment', [TaskController::class, 'storeComment'])->name('intern.tasks.comment');

       // Intern Chat Routes
Route::prefix('chat')->group(function () {
    Route::get('/', [ChatController::class, 'index'])->name('intern.chat.index');
    Route::get('/with/{adminId}', [ChatController::class, 'show'])->name('intern.chat.show');
    Route::post('/send/{adminId}', [ChatController::class, 'send'])->name('intern.chat.send');
});
    });

    Route::middleware(['guest:intern'])->group(function () {
        Route::get('/register', [InternController::class, 'showRegistrationForm'])->name('intern.register');
        Route::post('/register', [InternController::class, 'register'])->name('intern.register.submit');
        Route::get('/login', [InternController::class, 'showLoginForm'])->name('intern.login');
        Route::post('/login', [InternController::class, 'login'])->name('intern.login.submit');
    });
});
