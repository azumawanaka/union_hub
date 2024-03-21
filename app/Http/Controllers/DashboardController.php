<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Event;
use App\Models\Report;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function index()
    {
        return view('pages.dashboard.index', [
            'total_users' => User::count(),
            'total_events' => Event::count(),
            'total_services' => Service::count(),
            'total_clients' => Client::count(),
            'total_reports' => Report::count(),
        ]);
    }
}
