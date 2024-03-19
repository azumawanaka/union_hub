<?php

namespace App\Actions;

use App\Models\Report;

class StoreReportAction
{
    protected $model;

    public function __construct(Report $model)
    {
        $this->model = $model;
    }

    public function execute($data)
    {
        return $this->model->create([
            'user_id' => auth()->user()->id,
            'description' => $data['description'],
            'category' => $data['category'],
            'attached_file' => $data['attached_file'],
            'is_anonymous' => $data['is_anonymous'],
        ]);
    }
}
