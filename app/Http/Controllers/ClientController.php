<?php

namespace App\Http\Controllers;

use App\Actions\SearchClientAction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * @param Request $request
     * @param SearchClientAction $searchClientAction
     * @return JsonResponse
     */
    public function search(Request $request, SearchClientAction $searchClientAction): JsonResponse
    {
        $clients = $searchClientAction->execute($request->filter);

        return response()->json($clients);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
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
