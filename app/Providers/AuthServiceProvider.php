<?php

namespace App\Providers;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        Gate::before(function ($admin, $permission) {
                       return $admin->hasPermission($permission);
          });
    }
    // /**
    //  * Determine the user's role.
    //  *
    //  * @param  mixed  $user
    //  * @return Model|null
    //  */
    // private function getUserRole($user): ?Model
    // {
    //     if ($user instanceof Admin || $user instanceof Intern) {
    //         return $user->role;
    //     }
    //     return null;
    // }
}
