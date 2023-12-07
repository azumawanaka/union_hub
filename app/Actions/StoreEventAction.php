<?php

namespace App\Actions;

use App\Models\Event;

class StoreEventAction
{
    protected $model;

    public function __construct(Event $model)
    {
        $this->model = $model;
    }

    public function execute($data)
    {
        return $this->model->create([
            'name' => $data['name'],
            'description' => $data['description'],
            'start_date' => $data['start_date'],
            'end_date' => $data['end_date'],
            'category' => $data['category'],
            'max_participants' => $data['max_participants'],
            'status' => 'ongoing',
            'color' => $data['color'],
        ]);
    }
}
