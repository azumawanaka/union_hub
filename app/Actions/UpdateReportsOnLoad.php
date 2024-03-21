<?php

namespace App\Actions;

use App\Models\Report;

class UpdateReportsOnLoad
{
    protected $model;

    public function __construct(Report $model)
    {
        $this->model = $model;
    }

    public function execute()
    {
        $this->model->newQuery()->update(['is_new' => false]);
    }
}
