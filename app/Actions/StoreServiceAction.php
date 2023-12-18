<?php

namespace App\Actions;

use App\Models\Service;

class StoreServiceAction
{
    protected $model;

    public function __construct(Service $model)
    {
        $this->model = $model;
    }

    public function execute($data)
    {
        return $this->model->create([
            'service_type_id' => $data['service_type_id'],
            'client_id' => $data['client_id'],
            'title' => $data['name'],
            'description' => $data['description'],
            'added_by' => auth()->user()->id,
            'rate'  => $data['rate'],
        ]);
    }
}
