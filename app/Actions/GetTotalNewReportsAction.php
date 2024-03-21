<?php

namespace App\Actions;

use App\Models\Report;
use App\Models\User;

class GetTotalNewReportsAction
{
    protected $model;

    public function __construct(Report $model)
    {
        $this->model = $model;
    }

    public function execute()
    {
        $isAdmin = auth()->user()->role === User::ROLES['admin'];
        $query = $this->model->query();

        if ($isAdmin) {
            $count = $query->whereIsNew(true)->count();
        } else {
            $count = $query->where('user_id', auth()->user()->id)->count();
        }

        return $count;
    }
}
