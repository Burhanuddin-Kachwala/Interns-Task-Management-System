<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Tasks\TaskController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\InternController;

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
    });
});