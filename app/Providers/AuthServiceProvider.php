<?php

namespace App\Providers;

use App\Models\Admin;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
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
        $this->registerPolicies();

        Gate::define('pegawai', function ($user) {
            return $user->role === Admin::PEGAWAI;
        });

        Gate::define('owner', function ($user) {
            return $user->role === Admin::OWNER;
        });

        Gate::define('cashier', function ($user) {
            return $user->role === Admin::CASHIER;
        });

        Gate::define('chef', function ($user) {
            return $user->role === Admin::CHEF;
        });
    }
}
