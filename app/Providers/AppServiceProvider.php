<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\UserTask;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        UserTask::observe(\App\Observers\UserTaskObserver::class);
    }
}
