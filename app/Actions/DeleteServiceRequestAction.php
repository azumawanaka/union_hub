<?php

namespace App\Actions;

use App\Models\ServiceRequest;

class DeleteServiceRequestAction
{
    protected $model;

    public function __construct(ServiceRequest $model)
    {
        $this->model = $model;
    }

    public function execute($id)
    {
        return $this->model->query()->find($id)->delete();
    }
}
