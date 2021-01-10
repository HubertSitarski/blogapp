<?php

namespace App\Providers;

use App\Enums\PermissionEnum;
use App\Enums\RoleEnum;
use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        $this->initPassport();
        $this->giveAllPermissionsToSuperAdmin();
        $this->giveManageProfilePermissions();
    }

    private function giveAllPermissionsToSuperAdmin(): void
    {
        Gate::before(function ($user, $ability) {
            return $user->hasRole(RoleEnum::ROLE_SUPER_ADMIN) ? true : null;
        });
    }

    private function giveManageProfilePermissions(): void
    {
        Gate::define(PermissionEnum::MANAGE_PROFILE_PERMISSION, function (User $loggedInUser, User $user) {
            return $user->id === $loggedInUser->id;
        });
    }

    private function initPassport()
    {
        Passport::routes();
    }
}
