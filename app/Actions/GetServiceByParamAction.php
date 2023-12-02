<?php

namespace App\Actions;

use App\Models\Service;

class GetServiceByParamAction
{
    protected $model;

    public function __construct(Service $model)
    {
        $this->model = $model;
    }

    public function execute(array $params)
    {
        return $this->model->newQuery()->where($params['key'], $params['value'])->first();
    }
}
