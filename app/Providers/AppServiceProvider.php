<?php

namespace App\Providers;

use App\Actions\GetAllReportsAction;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Actions\GetAllNotificationsAction;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer(['layouts.app', 'layouts.calendar', 'layouts.dashboard', 'layouts.event', 'layouts.service', 'layouts.user'], function ($view) {
            $notifications = app(GetAllNotificationsAction::class)->execute();
            $reports = app(GetAllReportsAction::class)->execute();
            $view->with([
                'notifications' => $notifications,
                'reports' => $reports,
            ]);
        });
    }
}
