<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
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

        Gate::define('input-employee-shift', function (User $user) {
            return $user->hasRole('hrd');
        });

        Gate::define('view-my-schedule', function (User $user) {
            return $user->hasRole('employee');
        });

        Gate::define('view-all-schedules', function (User $user) {
            return $user->hasRole('hrd');
        });
    }
}
