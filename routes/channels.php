<?php

use Illuminate\Support\Facades\Broadcast;

// Admin channel
Broadcast::channel('admin.{id}', function ($admin, $id) {
    return (int) $admin->id === (int) $id;
}, ['guards' => ['admin']]);

// Intern channel
Broadcast::channel('intern.{id}', function ($intern, $id) {
    return (int) $intern->id === (int) $id;
}, ['guards' => ['intern']]);
