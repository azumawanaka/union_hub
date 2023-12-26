<?php

namespace App\Http\Controllers;

use App\Actions\DeleteServiceAction;
use App\Actions\GetAllServiceTypesAction;
use App\Actions\GetServiceByParamAction;
use App\Actions\GetServiceCountAction;
use App\Actions\SelectServicesAction;
use App\Actions\StoreServiceAction;
use App\Actions\UpdateServiceAction;
use App\Http\Requests\ServiceRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    private $selectServicesAction;
    private $getServiceCountAction;

    public function __construct(
        SelectServicesAction $selectServicesAction,
        GetServiceCountAction $getServiceCountAction
    ) {
        $this->selectServicesAction = $selectServicesAction;
        $this->getServiceCountAction = $getServiceCountAction;
    }

    public function index(GetAllServiceTypesAction $getAllServiceTypesAction, int|string $limit = 8)
    {
        $services = $this->selectServicesAction->execute()->paginate($limit);
        return view('pages.services.index', [
            'services' => $services,
            'serviceTypes'  => $getAllServiceTypesAction->execute(),
        ]);
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function getAllServices(Request $request): JsonResponse
    {
        $draw = $request->input('draw');
        $start = $request->input('start');
        $length = $request->input('length');
        $order = $request->input('order');
        $search = $request->input('search');

        $query = $this->selectServicesAction->execute();
        $this->applySearchConditions($query, $search);
        $this->applyOrdering($query, $order, $request);

        $services = $query->skip($start)->take($length)->get();
        $totalRecords = $this->getServiceCountAction->execute();

        return response()->json([
            'draw' => $draw,
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalRecords,
            'data' => $services,
        ]);
    }

    private function applySearchConditions($query, $search)
    {
        if (!empty($search['value'])) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search['value'] . '%')
                    ->orWhere('services.id', 'like', '%' . $search['value'] . '%')
                    ->orWhere('services.rate', 'like', '%' . $search['value'] . '%')
                    ->orWhere('description', 'like', '%' . $search['value'] . '%')
                    ->orWhere('services.created_at', 'like', '%' . $search['value'] . '%')
                    ->orWhere('service_types.name', 'like', '%' . $search['value'] . '%')
                    ->orWhere('clients.name', 'like', '%' . $search['value'] . '%');
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
     * @return JsonResponse
     */
    public function destroy(string $id, DeleteServiceAction $deleteServiceAction): JsonResponse
    {
        $response = $deleteServiceAction->execute($id);
        if ($response) {
            return response()->json(['message' => 'Service was successfully deleted.']);
        }
        return response()->json(['message' => 'Service not successfully deleted. Please try again.']);
    }
}
