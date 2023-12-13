<?php

namespace App\Actions;

use App\Models\Client;

class UpdateClientAction
{
    protected $model;

    public function __construct(Client $model)
    {
        $this->model = $model;
    }

    public function execute($id, $data)
    {
        return $this->model->newQuery()->find($id)->update([
            'name' => $data['name'],
            'email' => $data['email'],
            'address' => $data['address'],
            'mobile' => $data['mobile'],
        ]);
    }
}
