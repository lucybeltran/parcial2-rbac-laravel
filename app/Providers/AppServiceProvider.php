<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Models\Movement;
use App\Policies\MovementPolicy;

use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Gate::policy(Movement::class, MovementPolicy::class);
    }
}