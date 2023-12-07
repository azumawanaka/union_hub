<?php

namespace App\Actions;

use App\Models\Event;

class GetEventCountAction
{
    protected $model;

    public function __construct(Event $model)
    {
        $this->model = $model;
    }

    public function execute()
    {
        return $this->model->count();
    }
}
