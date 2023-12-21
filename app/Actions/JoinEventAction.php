<?php

namespace App\Actions;

use App\Models\EventParticipant;

class JoinEventAction
{
    protected $model;

    public function __construct(EventParticipant $model)
    {
        $this->model = $model;
    }

    public function execute($data)
    {
        return $this->model->create([
            'user_id' => auth()->user()->id,
            'event_id' => $data['event_id'],
        ]);
    }
}
