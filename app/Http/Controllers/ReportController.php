<?php

namespace App\Http\Controllers;

use App\Actions\GetAllReportsAction;
use App\Actions\StoreReportAction;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ReportController extends Controller
{
    public function index(Request $request, GetAllReportsAction $getAllReportsAction, int|string $limit = 10)
    {
        return view('pages.reports.index', [
            'reports' => $getAllReportsAction->execute()->paginate($limit),
        ]);
    }

    public function store(Request $request, StoreReportAction $storeReportAction)
    {
        try {
            $attachedFile = '';
            if ($request->hasFile('report_img') && $request->file('report_img')->isValid()) {
                $file = $request->file('report_img');

                // Generate a unique filename
                $filename = uniqid('report_', true) . '.' . $file->extension();

                // Store the file in the storage directory with the specified filename
                $path = $file->storeAs('reports', $filename, 'public');
                $attachedFile = 'storage/'.$path;
            }

            $payloads = [
                'description' => $request->description,
                'category' => $request->category,
                'attached_file' => $attachedFile,
                'is_anonymous' => !is_null($request->is_anonymous),
            ];

            $storeReportAction->execute($payloads);
            return response()->json($this->responseMsg('Report was successfully sent.', 'success'));
        } catch (\Throwable $th) {
            return response()->json($this->responseMsg($th->getMessage(), 'error'));
        }
    }

    public function accept(Report $report, Request $request)
    {
        if (isset($request->note) && !empty($request->note)) {
            $report->reportNotes()->create(['note' => $request->note]);
        }

        $report->update(['status' => $request->status]);

        return response()->json($this->responseMsg('Response was successfully sent.', 'success'));
    }

    public function destroy(Report $report)
    {
        try {
            $report->delete();
            return response()->json($this->responseMsg('Response was successfully deleted.', 'success'));
        } catch (\Throwable $th) {
            return response()->json($this->responseMsg($th->getMessage(), 'error'));
        }
    }

    private function responseMsg($msg, $status): array
    {
        return [
            'message' => $msg,
            'status' => $status,
        ];
    }
}
