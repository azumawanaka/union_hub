<?php

namespace App\Actions;

use App\Models\Report;

class GetAllReportsAction
{
    protected $model;

    public function __construct(Report $model)
    {
        $this->model = $model;
    }

    public function execute()
    {
        $isUser = auth()->user()->role === 0;
        $query = $this->model->query();

        if ($isUser) {
            $query->where('user_id', auth()->user()->id);
        }

        return $query->orderBy('updated_at', 'desc');
    }
}
