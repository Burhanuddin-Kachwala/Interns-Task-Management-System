<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Tasks\TaskController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\InternController;
use App\Http\Controllers\Chat\ChatController;

Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [AdminController::class, 'login'])->name('admin.login.submit');

    Route::middleware(['auth:admin'])->group(function () {
        Route::get('/', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::post('/logout', [AdminController::class, 'logout'])->name('admin.logout');
        Route::resource('tasks', TaskController::class)->names([
            'index' => 'admin.tasks.index',
            'create' => 'admin.tasks.create',
            'store' => 'admin.tasks.store',
            'show' => 'admin.tasks.show',
            'edit' => 'admin.tasks.edit',
            'update' => 'admin.tasks.update',
            'destroy' => 'admin.tasks.destroy'
        ]);
        Route::resource('interns', InternController::class)->names([
            'index' => 'admin.interns.index',
            'create' => 'admin.interns.create',
            'store' => 'admin.interns.store',
            'show' => 'admin.interns.show',
            'edit' => 'admin.interns.edit',
            'update' => 'admin.interns.update',
            'destroy' => 'admin.interns.destroy'
        ]);

        // Admin chat route to show the list of interns
        Route::get('chat', [ChatController::class, 'index'])->name('admin.chat.index');

        // Admin chat route to show the messages for a specific intern
        Route::get('chat/{intern_id}', [ChatController::class, 'show'])->name('admin.chat.show');

        Route::get('chat/{intern}', [ChatController::class, 'adminView'])->name('admin.chat');
        Route::post('chat/send/{intern_id}', [ChatController::class, 'send'])->name('admin.chat.send');
    });
});
