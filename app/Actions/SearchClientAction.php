<?php

namespace App\Actions;

use App\Models\Client;

class SearchClientAction
{
    protected $model;

    public function __construct(Client $model)
    {
        $this->model = $model;
    }

    public function execute($data = null)
    {
        return $this->model->query()->where('name', 'like', '%'. $data .'%')->get();
    }
}
