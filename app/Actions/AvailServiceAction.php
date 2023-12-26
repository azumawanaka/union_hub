<?php

namespace App\Actions;

use App\Models\ServiceRequest;
use Carbon\Carbon;

class AvailServiceAction
{
    protected $model;

    public function __construct(ServiceRequest $model)
    {
        $this->model = $model;
    }

    public function execute($data)
    {
        return $this->model->create([
            'service_id' => $data['service_id'],
            'preferred_date_time' => Carbon::parse($data['preferred_date_time'])->toDateTimeString(),
            'location' => $data['location'],
            'details' => $data['details'],
            'user_id' => auth()->user()->id,
            'status_updated_at' => Carbon::now()->toDateTimeString(),
        ]);
    }
}
