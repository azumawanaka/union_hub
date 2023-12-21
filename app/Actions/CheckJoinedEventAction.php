<?php

namespace App\Actions;

use App\Models\EventParticipant;

class CheckJoinedEventAction

{
    protected $model;

    public function __construct(EventParticipant $model)
    {
        $this->model = $model;
    }

    public function execute($data)
    {
        return $this->model->where('user_id', auth()->user()->id)->where('event_id', $data['event_id'])->first();
    }
}
