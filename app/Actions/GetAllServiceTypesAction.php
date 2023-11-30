<?php

namespace App\Actions;

use App\Models\ServiceType;

class GetAllServiceTypesAction
{
    protected $model;

    public function __construct(ServiceType $model)
    {
        $this->model = $model;
    }

    public function execute()
    {
        return $this->model->query()->orderBy('name', 'asc')->get();
    }
}
