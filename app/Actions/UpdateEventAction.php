<?php

namespace App\Actions;

use App\Models\Event;

class UpdateEventAction
{
    protected $model;

    public function __construct(Event $model)
    {
        $this->model = $model;
    }

    public function execute($id, $data)
    {
        return $this->model->newQuery()->find($id)->update([
            'name' => $data['name'],
            'description' => $data['description'],
            'start_date' => $data['start_date'],
            'end_date' => $data['end_date'],
            'category' => $data['category'],
            'max_participants' => $data['max_participants'],
            'status' => $data['status'],
        ]);
    }
}
