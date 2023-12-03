<?php

namespace App\Http\Controllers;

use App\Actions\DeleteServiceRequestAction;
use App\Actions\GetServiceRequestCountAction;
use App\Actions\SelectServiceRequestAction;
use App\Actions\UpdateServiceRequestStatusAction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
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
    public function getAllServiceRequests(
        Request $request,
        SelectServiceRequestAction $selectServiceRequestAction,
        GetServiceRequestCountAction $getServiceRequestCountAction
    ): JsonResponse {
        $draw = $request->input('draw');
        $start = $request->input('start');
        $length = $request->input('length');
        $order = $request->input('order');
        $search = $request->input('search');

        $query = $selectServiceRequestAction->execute();

        $this->applySearchConditions($query, $search);
        $this->applyOrdering($query, $order, $request);

        $serviceRequests = $query->skip($start)->take($length)->get();
        $totalRecords = $getServiceRequestCountAction->execute();

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
     * @param string $id
     * @param Request $request
     * @param UpdateServiceRequestStatusAction $updateServiceRequestStatusAction
     *
     * @return JsonResponse
     */
    public function updateStatus(
        string $id,
        Request $request,
        UpdateServiceRequestStatusAction $updateServiceRequestStatusAction
    ): JsonResponse {
        $response = $updateServiceRequestStatusAction->execute($id, $request->status);
        return response()->json($response);
    }

    /**
     * @param string $id
     * @param DeleteServiceRequestAction $deleteServiceRequestAction
     *
     * @return RedirectResponse
     */
    public function destroy(string $id, DeleteServiceRequestAction $deleteServiceRequestAction): RedirectResponse
    {
        $response = $deleteServiceRequestAction->execute($id);
        if ($response) {
            return redirect()->back()->with('success', 'Request was successfully deleted.');
        }
        return redirect()->back()->with('error', 'Request was not successfully deleted. Please try again.');
    }
}
