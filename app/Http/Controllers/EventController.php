<?php

namespace App\Http\Controllers;

use App\Actions\DeleteEventAction;
use App\Actions\GetEventAction;
use App\Actions\GetEventCountAction;
use App\Actions\SelectEventAction;
use App\Actions\StoreEventAction;
use App\Actions\UpdateEventAction;
use App\Models\Event;
use Carbon\Carbon;
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
     * @param SelectEventAction $selectEventActio
     * @param GetEventCountAction $getEventCountAction
     *
     * @return JsonResponse
     */
    public function getAllEvents(
        Request $request,
        SelectEventAction $selectEventAction,
        GetEventCountAction $getEventCountAction
    ): JsonResponse {
        $draw = $request->input('draw');
        $start = $request->input('start');
        $length = $request->input('length');
        $order = $request->input('order');
        $search = $request->input('search');

        $query = $selectEventAction->execute();

        $this->applySearchConditions($query, $search);
        $this->applyOrdering($query, $order, $request);

        $events = $query->skip($start)->take($length)->get();
        $totalRecords = $getEventCountAction->execute();

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
                    ->orWhere('status', 'like', '%' . $search['value'] . '%');
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
    public function store(Request $request, StoreEventAction $storeEventAction)
    {
        $dateRange = $request->input('start_end_date');
        $splitDates = explode(' - ', $dateRange);
        $startDate = $this->convertDateTimeFormat(trim($splitDates[0]));
        $endDate = $this->convertDateTimeFormat(trim($splitDates[1]));
        $data = [
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'start_date' => $startDate,
            'end_date' => $endDate,
            'category' => $request->input('category'),
            'max_participants' => $request->input('max_participants'),
            'color' => $this->generateRandomColor(),
        ];

        try {
            $storeEventAction->execute($data);

            $key = 'success';
            $msg = 'Event was successfully added.';
        } catch (\Throwable $th) {
            $key = 'error';
            $msg = 'Exception thrown during store event: ' . $th->getMessage();
        }
        return redirect()->back()->with($key, $msg);
    }

    public function updateEvent(string $id, Request $request, UpdateEventAction $updateEventAction)
    {
        $dateRange = $request->input('start_end_date');
        $splitDates = explode(' - ', $dateRange);
        $startDate = $this->convertDateTimeFormat(trim($splitDates[0]));
        $endDate = $this->convertDateTimeFormat(trim($splitDates[1]));
        $data = [
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'start_date' => $startDate,
            'end_date' => $endDate,
            'category' => $request->input('category'),
            'max_participants' => $request->input('max_participants'),
            'color' => $this->generateRandomColor(),
            'status' => $request->input('status'),
        ];

        try {
            $updateEventAction->execute($id, $data);

            $key = 'info';
            $msg = 'Event was successfully updated.';
        } catch (\Throwable $th) {
            $key = 'error';
            $msg = 'Exception thrown during update event: ' . $th->getMessage();
        }

        return redirect()->back()->with($key, $msg);
    }

    private function convertDateTimeFormat($dateTime)
    {
        return Carbon::parse($dateTime)->format('Y-m-d H:i');
    }

    private function generateRandomColor()
    {
        // Generate random RGB values
        $red = mt_rand(0, 255);
        $green = mt_rand(0, 255);
        $blue = mt_rand(0, 255);

        // Format the RGB values as a hexadecimal color code
        $hexColor = sprintf("#%02X%02X%02X", $red, $green, $blue);

        return $hexColor;
    }

    /**
     * @param string $id
     * @param GetEventAction $getEventAction
     *
     * @return JsonResponse
     */
    public function show(string $id, GetEventAction $getEventAction): JsonResponse
    {
        $data = $getEventAction->execute($id);
        return response()->json($data);
    }

    public function getJsonTypeEvents(): JsonResponse
    {
        $data = Event::with([
            'eventParticipants' => function ($query) {
                $query->where('user_id', auth()->user()->id);
            },
        ])
        ->get();
        return response()->json($data);
    }

    /**
     * @param string $id
     * @param DeleteEventAction $deleteEventAction
     *
     * @return JsonResponse
     */
    public function destroy(string $id, DeleteEventAction $deleteEventAction): JsonResponse
    {
        $response = $deleteEventAction->execute($id);
        if ($response) {
            return response()->json(['message' => 'Event was successfully deleted.']);
        }
        return response()->json(['message' => 'Event not successfully deleted. Please try again.']);
    }
}
