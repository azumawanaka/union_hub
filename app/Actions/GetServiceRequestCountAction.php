<?php

namespace App\Actions;

use App\Models\ServiceRequest;

class GetServiceRequestCountAction
{
    protected $model;

    public function __construct(ServiceRequest $model)
    {
        $this->model = $model;
    }

    public function execute()
    {
        return $this->model->count();
    }
}
