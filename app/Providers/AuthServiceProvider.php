<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use App\Models\Task;
use App\Models\User;
use App\Policies\TaskPolicy;
use Illuminate\Auth\Access\Response;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Task::class => TaskPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        /**
         * Verify that the user from the route matches the authorized user.
         */
        Gate::define('check-user-from-route', function (User $user, User $routeUser) {
            return $user->id == $routeUser->id
                ? Response::allow()
                : Response::deny(__('api.auth.forbidden'), 403);
        });
    }
}
