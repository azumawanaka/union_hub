<?php

namespace App\Providers;

use App\Actions\GetAllServiceTypesAction;
use App\Actions\SearchClientAction;
use App\Models\Client;
use App\Models\ServiceType;
use Illuminate\Support\ServiceProvider;
use App\Actions\GetAllServicesAction;
use App\Models\Service;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(GetAllServicesAction::class, function ($app) {
            return new GetAllServicesAction($app[Service::class]);
        });
        $this->app->singleton(GetAllServiceTypesAction::class, function ($app) {
            return new GetAllServiceTypesAction($app[ServiceType::class]);
        });
        $this->app->singleton(SearchClientAction::class, function ($app) {
            return new SearchClientAction($app[Client::class]);
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
