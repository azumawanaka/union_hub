<?php

namespace App\Actions;

use App\Models\Service;

class GetServiceCountAction
{
    protected $model;

    public function __construct(Service $model)
    {
        $this->model = $model;
    }

    public function execute()
    {
        return $this->model->count();
    }
}
