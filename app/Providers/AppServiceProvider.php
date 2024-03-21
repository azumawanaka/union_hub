<?php

namespace App\Providers;

use App\Actions\GetAllReportsAction;
use App\Actions\GetTotalNewReportsAction;
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
            $totalReports = app(GetTotalNewReportsAction::class)->execute();
            $view->with([
                'notifications' => $notifications,
                'totalReports' => $totalReports,
            ]);
        });
    }
}
