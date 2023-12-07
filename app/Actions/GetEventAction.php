<?php

namespace App\Actions;

use App\Models\Event;

class GetEventAction
{
    protected $model;

    public function __construct(Event $model)
    {
        $this->model = $model;
    }

    public function execute($id)
    {
        return $this->model->newQuery()->find($id);
    }
}
