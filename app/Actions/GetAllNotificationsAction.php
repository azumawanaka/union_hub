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
                ->where('to', null);
        } else {
            $query = $this->model->query()
                ->where('is_from_user', false)
                ->orWhere('to', auth()->user()->id);
        }

        return $query->orderBy('created_at', 'desc')->get();
    }
}
