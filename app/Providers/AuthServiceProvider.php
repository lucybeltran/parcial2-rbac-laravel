<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\Movement;
use App\Policies\MovementPolicy;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Movement::class => MovementPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();
    }
}