<?php

use App\Models\Admin;
use App\Models\Intern;
use Illuminate\Support\Facades\Broadcast;

// Admin channel
Broadcast::channel('chat.admin.{id}', function (Admin $admin, $id) {
    return $admin->id === (int) $id;
}, ['guards' => ['admin']]);

// Intern channel
Broadcast::channel('chat.intern.{id}', function (Intern $intern, $id) {
    return $intern->id === (int) $id;
}, ['guards' => ['intern']]);
