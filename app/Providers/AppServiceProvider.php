<?php

namespace App\Providers;

use App\Repositories\Contracts\TaskRepositoryInterface;
use App\Repositories\TaskRepository;
use App\Services\Contracts\TaskPolicyServiceInterface;
use App\Services\Contracts\TaskServiceInterface;
use App\Services\TaskPolicyService;
use App\Services\TaskService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(TaskRepositoryInterface::class, TaskRepository::class);
        $this->app->bind(TaskServiceInterface::class, TaskService::class);
        $this->app->bind(TaskPolicyServiceInterface::class, TaskPolicyService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
