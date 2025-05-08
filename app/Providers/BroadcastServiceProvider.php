<?php

namespace App\Providers;

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

class BroadcastServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Broadcast::routes(['middleware' => ['web', 'auth:admin,intern']]);
        Broadcast::channel('chat.intern.*', function ($user, $internId) {
            dd($user, $internId, auth()->guard('admin')->check(), auth()->guard('admin')->id());
            return auth()->guard('admin')->check() && auth()->guard('admin')->id() === (int)$internId;
        });

        Broadcast::channel('chat.admin.*', function ($user, $adminId) {
            // Example: Only the intern can listen to this admin's channel
            return auth()->guard('intern')->check() && auth()->guard('intern')->id() === (int)$adminId;
        });
    }
}
