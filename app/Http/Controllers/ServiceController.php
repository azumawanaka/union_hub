<?php

namespace App\Http\Controllers;

use App\Actions\DeleteServiceAction;
use App\Actions\GetAllServicesAction;
use App\Actions\GetAllServiceTypesAction;
use App\Actions\GetServiceByParamAction;
use App\Actions\StoreServiceAction;
use App\Actions\UpdateServiceAction;
use App\Http\Requests\ServiceRequest;
use App\Models\Service;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function __construct()
    {

    }

    public function index(GetAllServiceTypesAction $getAllServiceTypesAction)
    {
        return view('pages.admin.services.index', [
            'serviceTypes'  => $getAllServiceTypesAction->execute(),
        ]);
    }

    public function getAllServices(Request $request, GetAllServicesAction $getAllServicesAction)
    {
        $draw = $request->input('draw');
        $start = $request->input('start');
        $length = $request->input('length');
        $order = $request->input('order');
        $search = $request->input('search');

        $query = Service::select(
                'services.id as s_id',
                'title',
                'description',
                'clients.name as c_name',
                'service_types.name as s_name',
                'services.created_at as added_at')
            ->leftJoin('service_types', 'services.service_type_id', '=', 'service_types.id')
            ->leftJoin('clients','services.client_id', '=', 'clients.id');

        if (!empty($search['value'])) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search['value'] . '%');
                $q->orWhere('services.id', 'like', '%' . $search['value'] . '%');
                $q->orWhere('description', 'like', '%' . $search['value'] . '%');
                $q->orWhere('services.created_at', 'like', '%' . $search['value'] . '%');
                $q->orWhere('service_types.name', 'like', '%' . $search['value'] . '%');
                $q->orWhere('clients.name', 'like', '%' . $search['value'] . '%');
            });
        }

        if (!empty($order) && count($order) > 0) {
            $columnIndex = $order[0]['column'];
            $columnName = $request->input("columns.$columnIndex.name");
            $columnDirection = $order[0]['dir'];

            $query->orderBy($columnName, $columnDirection);
        }

        // Paginate the results
        $services = $query->skip($start)->take($length)->get();

        $totalRecords = Service::count();

        return response()->json([
            'draw' => $draw,
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalRecords,
            'data' => $services,
        ]);
    }

    /**
     * @param ServiceRequest $serviceRequest
     * @param StoreServiceAction $storeServiceAction
     *
     * @return mixed
     */
    public function store(ServiceRequest $serviceRequest, StoreServiceAction $storeServiceAction)
    {
        try {
            $storeServiceAction->execute($serviceRequest->all());
            return redirect()->back()->with('success', 'Service successfully created.');
        } catch (\Throwable $th) {
            $errorMessage = $th->getMessage();
            return redirect()->back()->with('error', $errorMessage);
        }
    }

    /**
     * @param string $id
     * @param GetServiceByParamAction $getParamAction
     *
     * @return JsonResponse
     */
    public function getServiceById(string $id, GetServiceByParamAction $getParamAction): JsonResponse
    {
        $payload = [
            'key' => 'id',
            'value' => $id,
        ];
        $response = $getParamAction->execute($payload);
        return response()->json($response);
    }

    /**
     * @param Request $request
     * @param string $id
     * @param UpdateServiceAction $updateServiceAction
     *
     * @return mixed
     */
    public function updateService(Request $request, string $id, UpdateServiceAction $updateServiceAction)
    {
        try {
            $updateServiceAction->execute($id, $request->all());
            return redirect()->back()->with('success', 'Service successfully updated.');
        } catch (\Throwable $th) {
            $errorMessage = $th->getMessage();
            return redirect()->back()->with('error', $errorMessage);
        }
    }

    /**
     * @param string $id
     * @param DeleteServiceAction $deleteServiceAction
     *
     * @return mixed
     */
    public function destroy(string $id, DeleteServiceAction $deleteServiceAction)
    {
        $response = $deleteServiceAction->execute($id);
        if ($response) {
            return redirect()->back()->with('success', 'Service successfully deleted.');
        }

        return redirect()->back()->with('error', 'Service not successfully deleted. Please try again.');
    }
}
