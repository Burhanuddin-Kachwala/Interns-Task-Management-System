<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ChatController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Tasks\TaskController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\InternController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\AdminUserController;

Route::prefix('admin')->group(function () {
    Route::middleware(['guest:admin'])->group (function(){
        Route::get('/login', [AdminController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [AdminController::class, 'login'])->name('admin.login.submit');
    });
    

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
        ])->middleware('can:manage-tasks');

        Route::resource('interns', InternController::class)->names([
            'index' => 'admin.interns.index',
            'create' => 'admin.interns.create',
            'store' => 'admin.interns.store',
            'show' => 'admin.interns.show',
            'edit' => 'admin.interns.edit',
            'update' => 'admin.interns.update',
            'destroy' => 'admin.interns.destroy'
        ])->middleware('can:manage-interns');

        // Admin Chat Routes
        Route::prefix('chat')->group(function () {
            Route::get('/', [ChatController::class, 'index'])->name('admin.chat.index');
            Route::get('/with/{internId}', [ChatController::class, 'show'])->name('admin.chat.show');
            Route::post('/send/{internId}', [ChatController::class, 'send'])->name('admin.chat.send');
        })->middleware('can:chat');


        Route::resource('roles', RoleController::class)->names([
            'index' => 'admin.roles.index',
            'create' => 'admin.roles.create',
            'store' => 'admin.roles.store',
            'show' => 'admin.roles.show',
            'edit' => 'admin.roles.edit',
            'update' => 'admin.roles.update',
            'destroy' => 'admin.roles.destroy'
        ])->middleware('can:manage-roles');

        Route::resource('permissions', PermissionController::class)->names([
            'index' => 'admin.permissions.index',
            'create' => 'admin.permissions.create',
            'store' => 'admin.permissions.store',
            'show' => 'admin.permissions.show',
            'edit' => 'admin.permissions.edit',
            'update' => 'admin.permissions.update',
            'destroy' => 'admin.permissions.destroy'
        ])->middleware('can:manage-permissions');

        Route::resource('admin-users',AdminUserController::class)->middleware('can:manage-admin');
    });
});
