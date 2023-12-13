<?php

namespace App\Actions;

use App\Models\Client;

class GetClientAction
{
    protected $model;

    public function __construct(Client $model)
    {
        $this->model = $model;
    }

    public function execute($id)
    {
        return $this->model->newQuery()->find($id);
    }
}
