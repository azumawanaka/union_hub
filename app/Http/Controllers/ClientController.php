<?php

namespace App\Http\Controllers;

use App\Actions\DeleteClientAction;
use App\Actions\GetClientAction;
use App\Actions\SearchClientAction;
use App\Actions\StoreClientAction;
use App\Actions\UpdateClientAction;
use App\Http\Requests\ClientRequest;
use App\Models\Client;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.admin.clients.index');
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
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function getAllClients(Request $request): JsonResponse
    {
        $draw = $request->input('draw');
        $start = $request->input('start');
        $length = $request->input('length');
        $order = $request->input('order');
        $search = $request->input('search');

        $query = Client::select(
            'clients.id as c_id',
            'clients.name as c_name',
            'clients.email as c_email',
            'clients.address as c_address',
            'clients.mobile as c_mobile',
            'clients.created_at as c_created_at',
            \DB::raw('COUNT(services.id) as total_services'),
        )
        ->leftJoin('services', 'clients.id', '=', 'services.client_id')
        ->groupBy('clients.id', 'clients.name', 'clients.email', 'clients.address', 'clients.mobile', 'clients.created_at');

        $this->applySearchConditions($query, $search);
        $this->applyOrdering($query, $order, $request);

        $clients = $query->skip($start)->take($length)->get();
        $totalRecords = Client::count();

        return response()->json([
            'draw' => $draw,
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalRecords,
            'data' => $clients,
        ]);
    }

    private function applySearchConditions($query, $search)
    {
        if (!empty($search['value'])) {
            $query->where(function ($q) use ($search) {
                $q->where('id', 'like', '%' . $search['value'] . '%')
                    ->orWhere('name', 'like', '%' . $search['value'] . '%')
                    ->orWhere('email', 'like', '%' . $search['value'] . '%')
                    ->orWhere('address', 'like', '%' . $search['value'] . '%')
                    ->orWhere('mobile', 'like', '%' . $search['value'] . '%')
                    ->orWhere('created_at', 'like', '%' . $search['value'] . '%');
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
     * @param ClientRequest $clientRequest
     * @param StoreClientAction $storeClientAction
     *
     * @return JsonResponse
     */
    public function store(ClientRequest $clientRequest, StoreClientAction $storeClientAction): JsonResponse
    {
        try {
            $storeClientAction->execute($clientRequest->all());
            return response()->json($this->responseMsg('Client was successfully added.', 'success'));
        } catch (\Throwable $th) {
            \Log::info('store error: ', [$th]);
            return response()->json($this->responseMsg($th->getMessage(), 'error'));
        }
    }

    /**
     * @param ClientRequest $clientRequest
     * @param string $id
     * @param UpdateClientAction $updateClientAction
     *
     * @return JsonResponse
     */
    public function updateClient(ClientRequest $clientRequest, string $id, UpdateClientAction $updateClientAction): JsonResponse
    {
        try {
            $updateClientAction->execute($id, $clientRequest->all());
            return response()->json($this->responseMsg('Client was successfully updated.', 'success'));
        } catch (\Throwable $th) {
            return response()->json($this->responseMsg($th->getMessage(), 'error'));
        }
    }

    /**
     * @param string $id
     * @param GetClientAction $getClientAction
     *
     * @return JsonResponse
     */
    public function getClientById(string $id, GetClientAction $getClientAction): JsonResponse
    {
        $data = $getClientAction->execute($id);
        return response()->json($data);
    }

    /**
     * @param string $id
     * @param DeleteClientAction $deleteClientAction
     *
     * @return JsonResponse
     */
    public function destroy(string $id, DeleteClientAction $deleteClientAction): JsonResponse
    {
        $deleteClientAction->execute($id);
        return response()->json($this->responseMsg('Client was successfully deleted.', 'success'));
    }

    private function responseMsg($msg, $status): array
    {
        return [
            'message' => $msg,
            'status' => $status,
        ];
    }
}
