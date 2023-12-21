<?php

namespace App\Http\Controllers;

use App\Actions\CheckJoinedEventAction;
use App\Actions\JoinEventAction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.calendar.index');
    }

    /**
     * @param Request $request
     * @param JoinEventAction $joinEventAction
     *
     * @return JsonResponse
     */
    public function store(Request $request, JoinEventAction $joinEventAction): JsonResponse
    {
        try {
            $joinEventAction->execute($request->all());
            return response()->json($this->responseMsg('You successfully joined the event.', 'success'));
        } catch (\Throwable $th) {
            return response()->json($this->responseMsg($th->getMessage(), 'error'));
        }
    }

    /**
     * @param Request $request
     * @param CheckJoinedEventAction $checkJoinedEventAction
     *
     * @return JsonResponse
     */
    public function check(Request $request, CheckJoinedEventAction $checkJoinedEventAction): JsonResponse
    {
        $response = $checkJoinedEventAction->execute($request->all());
        return response()->json($response);
    }

    private function responseMsg($msg, $status): array
    {
        return [
            'message' => $msg,
            'status' => $status,
        ];
    }
}
