<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\GeoInterface;
use App\Services\YandexGeoService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(GeoInterface::class, YandexGeoService::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
