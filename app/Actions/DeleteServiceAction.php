<?php

namespace App\Actions;

use App\Models\Service;

class DeleteServiceAction
{
    protected $model;

    public function __construct(Service $model)
    {
        $this->model = $model;
    }

    public function execute($id)
    {
        return $this->model->query()->find($id)->delete();
    }
}
