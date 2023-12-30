<?php

namespace App\Actions;

use App\Models\Notification;

class GetAllNotificationsAction
{
    protected $model;

    public function __construct(Notification $model)
    {
        $this->model = $model;
    }

    public function execute()
    {
        $isUser = auth()->user()->role === 0;
        if (!$isUser) {
            $query = $this->model->query()
                ->where('is_from_user', !$isUser)
                ->whereNull('to');
        } else {
            $query = $this->model->query()
                ->where('is_from_user', $isUser)
                ->where('to', auth()->user()->id);
        }

        return $query->orderBy('created_at', 'desc')->get();
    }
}
