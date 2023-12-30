<?php

namespace App\Actions;

use App\Models\ServiceRequest;

class GetServiceRequestByIdAction
{
    protected $model;

    public function __construct(ServiceRequest $model)
    {
        $this->model = $model;
    }

    public function execute($id)
    {
        return $this->model->with('service')->find($id);
    }
}
