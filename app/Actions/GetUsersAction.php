<?php

namespace App\Actions;

use App\Models\User;

class GetUsersAction
{
    protected $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function execute()
    {
        return $this->model->query()->orderBy('name', 'asc')->get();
    }
}
