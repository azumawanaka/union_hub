<?php

namespace App\Http\Controllers;

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
        return view('pages.dashboard');
    }
}
