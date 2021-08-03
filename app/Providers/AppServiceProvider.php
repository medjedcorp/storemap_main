<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema; // 追記
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\ServiceProvider;
use Laravel\Cashier\Cashier;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Schema::defaultStringLength(191); // fullcalendarで追記

        // Jobで追記
        $this->app->bind('App\Services\CategoryCsvImportService');
        $this->app->bind('App\Services\ItemCsvImportService');
        $this->app->bind('App\Services\CsvFileImportService');
        $this->app->bind('App\Services\SmCategoryCsvImportService');
        $this->app->bind('App\Services\StoreCsvImportService');

        Cashier::ignoreMigrations();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

    }
}
