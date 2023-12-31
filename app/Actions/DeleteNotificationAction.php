<?php

namespace App\Actions;

use App\Models\Notification;

class DeleteNotificationAction
{
    protected $model;

    public function __construct(Notification $model)
    {
        $this->model = $model;
    }

    public function execute(int|string $id): bool
    {
        return $this->model->query()->find($id)->delete();
    }
}
