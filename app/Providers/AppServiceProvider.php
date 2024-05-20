<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\TodoRepository;
use App\Repositories\TodoRepositoryInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(TodoRepositoryInterface::class, TodoRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
