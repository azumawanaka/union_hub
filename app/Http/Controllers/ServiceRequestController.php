<?php

namespace App\Http\Controllers;

use App\Actions\AvailServiceAction;
use App\Actions\CancelRequestAction;
use App\Actions\CreateNotificationAction;
use App\Actions\DeleteServiceRequestAction;
use App\Actions\GetServiceRequestByIdAction;
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
    public function index(Request $request, SelectServiceRequestAction $selectServiceRequestAction, int|string $limit = 10)
    {
        $search['value'] = $request->get('q');
        $query = $selectServiceRequestAction->execute();
        $this->applySearchConditions($query, $search);

        return view('pages.admin.service_requests.index', [
            'services' => $query->orderBy('sr_created_at', 'desc')->paginate($limit),
        ]);
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
                    ->orWhere('services.rate', 'like', '%' . $search['value'] . '%')
                    ->orWhere('service_requests.id', 'like', '%' . $search['value'] . '%')
                    ->orWhere('service_requests.status', 'like', '%' . $search['value'] . '%')
                    ->orWhere('details', 'like', '%' . $search['value'] . '%')
                    ->orWhere('service_requests.created_at', 'like', '%' . $search['value'] . '%')
                    ->orWhere('preferred_date_time', 'like', '%' . $search['value'] . '%')
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
        UpdateServiceRequestStatusAction $updateServiceRequestStatusAction,
        CreateNotificationAction $createNotificationAction,
        GetServiceRequestByIdAction $getServiceRequestByIdAction
    ): JsonResponse {
        $updateServiceRequestStatusAction->execute($id, $request->status);

        $messageKey = 'service.status';
        $user = $getServiceRequestByIdAction->execute($id)->user;
        $to = $user->id;
        $title = $getServiceRequestByIdAction->execute($id)->service->title;
        $message = trans("notifications.$messageKey", [
            'service' => $title,
            'status' => $request->status,
        ]);
        $createNotificationAction->execute($message, $to);

        return response()->json($this->responseMsg('Status was successfully '.$request->status, 'success'));
    }

    /**
     * @param Request $request
     * @param AvailServiceAction $availServiceAction
     *
     * @return JsonResponse
     */
    public function avail(
        Request $request,
        AvailServiceAction $availServiceAction,
        CreateNotificationAction $createNotificationAction,
        GetServiceRequestByIdAction $getServiceRequestByIdAction
    ): JsonResponse {
        $service = $availServiceAction->execute($request->all());

        $messageKey = 'service.availed';
        $user = $getServiceRequestByIdAction->execute($service->id)->user;
        $title = $getServiceRequestByIdAction->execute($service->id)->service->title;
        $message = trans("notifications.$messageKey", [
            'user' => $user->first_name,
            'service' => $title,
        ]);
        $createNotificationAction->execute($message);

        return response()->json($this->responseMsg('You have successfully avail the service.', 'success'));
    }

    /**
     * @param string|int $id
     * @param CancelRequestAction $cancelRequestAction
     *
     * @return JsonResponse
     */
    public function cancel(
        string|int $id,
        CancelRequestAction $cancelRequestAction
    ): JsonResponse {
        $cancelRequestAction->execute($id);
        return response()->json($this->responseMsg('You have successfully cancelled the service.', 'success'));
    }

    /**
     * @param string $id
     * @param DeleteServiceRequestAction $deleteServiceRequestAction
     *
     * @return JsonResponse
     */
    public function destroy(string $id, DeleteServiceRequestAction $deleteServiceRequestAction): JsonResponse
    {
        $deleteServiceRequestAction->execute($id);
        return response()->json($this->responseMsg('Request was successfully deleted.', 'success'));
    }

    private function responseMsg($msg, $status): array
    {
        return [
            'message' => $msg,
            'status' => $status,
        ];
    }
}
