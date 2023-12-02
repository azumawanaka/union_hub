<?php

namespace App\Actions;

use App\Models\Service;

class UpdateServiceAction
{
    protected $model;

    public function __construct(Service $model)
    {
        $this->model = $model;
    }

    public function execute($id, $data)
    {
        return $this->model->find($id)->update([
            'service_type_id' => $data['service_type_id'],
            'client_id' => $data['client_id'],
            'title' => $data['name'],
            'description' => $data['description'],
        ]);
    }
}
