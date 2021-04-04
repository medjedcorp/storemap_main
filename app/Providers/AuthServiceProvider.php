<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
        'App\Models\Store'    => 'App\Policies\StorePolicy',
        'App\Models\Category' => 'App\Policies\CategoryPolicy',
        'App\Models\Company'  => 'App\Policies\CompanyPolicy',
        'App\Models\Item'  => 'App\Policies\ItemPolicy',
        'App\Models\User'  => 'App\Policies\UserPolicy',
        'App\Models\ItemImage'  => 'App\Policies\ItemImagePolicy',
        'App\Models\StoreImage'  => 'App\Policies\StoreImagePolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('isAdmin', function ($user) {
            return $user->role == 'admin';
        });
        Gate::define('isSeller', function ($user) {
            return ($user->role == 'seller' or $user->role == 'admin');
        });
        Gate::define('isStaff', function ($user) {
            return ($user->role == 'staff' or $user->role == 'seller' or $user->role == 'admin');
        });
        Gate::define('isUser', function ($user) {
            return ($user->role == 'user' or $user->role == 'staff' or $user->role == 'seller' or $user->role == 'admin');
        });
        Gate::define('guest', function () {
            return Auth::guest() == 'true';
        });
        Gate::define('delete-user', function ($user, $company) {
            return $user->id === $company->id;
        });
    }
}
