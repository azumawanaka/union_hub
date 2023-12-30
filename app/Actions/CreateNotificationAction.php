<?php

namespace App\Actions;

use App\Models\Notification;

class CreateNotificationAction
{
    protected $model;

    public function __construct(Notification $model)
    {
        $this->model = $model;
    }

    public function execute(string $msg, $to = null)
    {
        return $this->model->create([
            'message' => $msg,
            'to' => $to,
        ]);
    }
}
