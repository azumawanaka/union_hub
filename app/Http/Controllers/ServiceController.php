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

    public function index(GetAllServicesAction $getAllServicesAction, GetAllServiceTypesAction $getAllServiceTypesAction)
    {
        return view('pages.admin.services.index', [
            'services' => $getAllServicesAction->execute(),
            'serviceTypes'  => $getAllServiceTypesAction->execute(),
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
     * @param Service $service
     * @param UpdateServiceAction $updateServiceAction
     *
     * @return mixed
     */
    public function updateService(Request $request, Service $service, UpdateServiceAction $updateServiceAction)
    {
        try {
            $updateServiceAction->execute($service->id, $request->all());
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
