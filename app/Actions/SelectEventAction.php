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
            ->with('eventParticipants')
            ->select(
                'id as event_id',
                'name',
                'description',
                'start_date',
                'end_date',
                'category',
                'status',
                \DB::raw('(SELECT COUNT(*) FROM event_participants WHERE event_participants.event_id = events.id) as participant_count'),
            );
    }
}
