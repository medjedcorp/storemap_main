<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use App\Models\Company;
use Log;

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
            return ($user->role == 'seller' or $user->role == 'tester' or $user->role == 'admin');
        });
        Gate::define('isStaff', function ($user) {
            return ($user->role == 'staff' or $user->role == 'seller' or $user->role == 'tester' or $user->role == 'admin');
        });
        Gate::define('isUser', function ($user) {
            return ($user->role == 'user' or $user->role == 'staff' or $user->role == 'tester' or $user->role == 'seller' or $user->role == 'admin');
        });
        Gate::define('guest', function () {
            return Auth::guest() == 'true';
        });
        Gate::define('delete-user', function ($user, $company) {
            return $user->id === $company->id;
        });


        Gate::define('basic', function ($user) {
            // プランを取得
            // $light = config('services.stripe.light');
            $basic = config('services.stripe.basic');
            $premium = config('services.stripe.premium');
            $stores = config('services.stripe.stores');

            $company_id = $user->company_id;
            $company = Company::where('id', $company_id)->first();

            // Log::debug($company);
            // Log::debug($subscriptionItem);
            if (!is_null($company) and !is_null($company->stripe_id)) {
                // プラン名を取得
                // ストア数プラン以外で、引っかかるプランを取得(店舗数)
                $stripePlan = $company->subscription('main')->items->whereNotIn('stripe_plan', $stores)->pluck('stripe_plan')->first();
                return ($stripePlan === $basic or $stripePlan === $premium);
            } else {
                return false;
            }
        });

        Gate::define('premium', function ($user) {
            // プランを取得
            // $light = config('services.stripe.light');
            // $basic = config('services.stripe.basic');
            $premium = config('services.stripe.premium');
            $stores = config('services.stripe.stores');

            $company_id = $user->company_id;
            $company = Company::where('id', $company_id)->first();
            // Log::debug($company);
            if (!is_null($company) and !is_null($company->stripe_id)) {
                // Log::debug($company->subscription('main')->first());
                // プラン名を取得
                // ストア数プラン以外で、引っかかるプランを取得(店舗数)
                $stripePlan = $company->subscription('main')->items->whereNotIn('stripe_plan', $stores)->pluck('stripe_plan')->first();
                return ($stripePlan === $premium);
            } else {
                return false;
            }
        });
    }
}
