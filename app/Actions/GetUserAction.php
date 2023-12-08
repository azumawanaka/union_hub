<?php

namespace App\Actions;

use App\Models\User;

class GetUserAction
{
    protected $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function execute($id)
    {
        return $this->model->newQuery()->find($id);
    }
}
