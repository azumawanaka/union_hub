<?php

namespace App\Actions;

use App\Models\Event;

class DeleteEventAction
{
    protected $model;

    public function __construct(Event $model)
    {
        $this->model = $model;
    }

    public function execute($id)
    {
        return $this->model->query()->find($id)->delete();
    }
}
