<?php

namespace App\Http\Controllers;

use App\Actions\GetAllReportsAction;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request, GetAllReportsAction $getAllReportsAction, int|string $limit = 5)
    {
        return view('pages.reports.index', [
            'reports' => $getAllReportsAction->execute()->paginate($limit),
        ]);
    }
}
