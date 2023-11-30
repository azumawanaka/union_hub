<?php

namespace App\Http\Controllers;

use App\Actions\GetAllServicesAction;
use App\Actions\GetAllServiceTypesAction;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function __construct()
    {

    }

    public function index(GetAllServicesAction $getAllServicesAction, GetAllServiceTypesAction $getAllServiceTypesAction)
    {
        return view('pages.admin.services.index', [
            'services' => $getAllServicesAction->execute(),
            'serviceTypes'  => $getAllServiceTypesAction->execute(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
