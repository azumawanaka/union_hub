<?php

namespace App\Http\Controllers;

use App\Models\ServiceRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ServiceRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.admin.service_requests.index');
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getAllServiceRequests(Request $request): JsonResponse
    {
        $draw = $request->input('draw');
        $start = $request->input('start');
        $length = $request->input('length');
        $order = $request->input('order');
        $search = $request->input('search');

        $query = ServiceRequest::select(
            'service_requests.id as sr_id',
            'services.title as s_name',
            'budget',
            'preferred_date',
            'preferred_time',
            'location',
            'users.first_name as u_name',
            'service_requests.status as sr_status',
            'details',
            'service_requests.created_at as sr_created_at'
        )
        ->leftJoin('services', 'service_requests.service_id', '=', 'services.id')
        ->leftJoin('users','service_requests.user_id', '=', 'users.id');

        $this->applySearchConditions($query, $search);
        $this->applyOrdering($query, $order, $request);

        $serviceRequests = $query->skip($start)->take($length)->get();
        $totalRecords = ServiceRequest::count();

        return response()->json([
            'draw' => $draw,
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalRecords,
            'data' => $serviceRequests,
        ]);
    }

    private function applySearchConditions($query, $search)
    {
        if (!empty($search['value'])) {
            $query->where(function ($q) use ($search) {
                $q->where('services.title', 'like', '%' . $search['value'] . '%')
                    ->orWhere('service_requests.id', 'like', '%' . $search['value'] . '%')
                    ->orWhere('service_requests.status', 'like', '%' . $search['value'] . '%')
                    ->orWhere('service_requests.created_at', 'like', '%' . $search['value'] . '%')
                    ->orWhere('budget', 'like', '%' . $search['value'] . '%')
                    ->orWhere('preferred_date', 'like', '%' . $search['value'] . '%')
                    ->orWhere('preferred_time', 'like', '%' . $search['value'] . '%')
                    ->orWhere('location', 'like', '%' . $search['value'] . '%')
                    ->orWhere('details', 'like', '%' . $search['value'] . '%')
                    ->orWhere('users.first_name', 'like', '%' . $search['value'] . '%')
                    ->orWhere('users.last_name', 'like', '%' . $search['value'] . '%');
            });
        }
    }

    private function applyOrdering($query, $order, $request)
    {
        if (!empty($order) && count($order) > 0) {
            $columnIndex = $order[0]['column'];
            $columnName = $request->input("columns.$columnIndex.name");
            $columnDirection = $order[0]['dir'];

            $query->orderBy($columnName, $columnDirection);
        }
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
