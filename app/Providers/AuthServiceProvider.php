<?php

namespace App\Providers;

use App\Enums\AdminRoleEnum;
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

        Gate::define('admin', function ($user) {
            return $user->role === AdminRoleEnum::ADMIN;
        });

        Gate::define('cashier', function ($user) {
            return $user->role === AdminRoleEnum::CASHIER;
        });

        Gate::define('staff', function ($user) {
            return $user->role === AdminRoleEnum::STAFF;
        });
    }
}
