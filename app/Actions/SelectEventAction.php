<?php

namespace App\Actions;

use App\Models\Event;

class SelectEventAction
{
    protected $model;

    public function __construct(Event $model)
    {
        $this->model = $model;
    }

    public function execute()
    {
        return $this->model->newQuery()
            ->select(
                'id as event_id',
                'name',
                'description',
                'start_date',
                'end_date',
                'category',
                'status',
            );
    }
}
