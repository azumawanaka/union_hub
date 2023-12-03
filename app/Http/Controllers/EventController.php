<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.admin.events.index');
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function getAllEvents(Request $request): JsonResponse
    {
        $draw = $request->input('draw');
        $start = $request->input('start');
        $length = $request->input('length');
        $order = $request->input('order');
        $search = $request->input('search');

        $query = Event::select(
            'id as event_id',
            'name',
            'description',
            'start_date',
            'end_date',
            'category',
            'status',
            'created_at',
        );

        $this->applySearchConditions($query, $search);
        $this->applyOrdering($query, $order, $request);

        $events = $query->skip($start)->take($length)->get();
        $totalRecords = Event::count();

        return response()->json([
            'draw' => $draw,
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalRecords,
            'data' => $events,
        ]);
    }

    private function applySearchConditions($query, $search)
    {
        if (!empty($search['value'])) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search['value'] . '%')
                    ->orWhere('description', 'like', '%' . $search['value'] . '%')
                    ->orWhere('start_date', 'like', '%' . $search['value'] . '%')
                    ->orWhere('end_date', 'like', '%' . $search['value'] . '%')
                    ->orWhere('category', 'like', '%' . $search['value'] . '%')
                    ->orWhere('status', 'like', '%' . $search['value'] . '%')
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
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * @param string $id
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function updateStatus(
        string $id,
        Request $request
    ): JsonResponse {
        return response()->json($this->responseMsg('Status was successfully', 'success'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
