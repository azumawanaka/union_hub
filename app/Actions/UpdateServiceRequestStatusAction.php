<?php

namespace App\Actions;

use App\Models\ServiceRequest;
use Carbon\Carbon;

class UpdateServiceRequestStatusAction
{
    protected $model;

    public function __construct(ServiceRequest $model)
    {
        $this->model = $model;
    }

    public function execute($id, $status)
    {
        return $this->model->find($id)->update([
            'status' => $status,
            'status_updated_at' => Carbon::now()->toDateTimeString(),
        ]);
    }
}
