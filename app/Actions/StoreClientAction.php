<?php

namespace App\Actions;

use App\Models\Client;

class StoreClientAction
{
    protected $model;

    public function __construct(Client $model)
    {
        $this->model = $model;
    }

    public function execute($data)
    {
        return $this->model->create([
            'name' => $data['name'],
            'email' => $data['email'],
            'address' => $data['address'],
            'mobile' => $data['mobile'],
        ]);
    }
}
