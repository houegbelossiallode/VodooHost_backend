<?php

namespace App\Providers;

use App\Models\Ritual;
use App\Policies\RitualPolicy;
use Illuminate\Support\Facades\Gate;
use App\Models\LogementDisponibilite;
use App\Policies\LogementDisponibilitePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
       // Ritual::class => RitualPolicy::class,
        LogementDisponibilite::class => LogementDisponibilitePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
    }
}
