<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Intern\InternController;

Route::prefix('intern')->group(function () {
    Route::middleware(['auth:intern'])->group(function () {
        Route::get('/', [InternController::class, 'dashboard'])->name('intern.dashboard');
        Route::post('/logout', [InternController::class, 'logout'])->name('intern.logout');
    });

    Route::middleware(['guest:intern'])->group(function () {
        Route::get('/register', [InternController::class, 'showRegistrationForm'])->name('intern.register');
        Route::post('/register', [InternController::class, 'register'])->name('intern.register.submit');
        Route::get('/login', [InternController::class, 'showLoginForm'])->name('intern.login');
        Route::post('/login', [InternController::class, 'login'])->name('intern.login.submit');
    });
});
