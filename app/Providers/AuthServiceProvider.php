<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // definiti gate 'manage-app' e 'not-manage-app' per adminlte menu configuration (item menu diversi per Admin e Users ('can' => '...'))
        Gate::define('manage-app', function ($user) {

            return Auth::user()->is_admin;  // true/false
        });
        Gate::define('not-manage-app', function ($user) {

            return !Auth::user()->is_admin;  // true/false
        });

    }
}
