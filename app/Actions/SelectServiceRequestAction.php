<?php

namespace App\Actions;

use App\Models\ServiceRequest;

class SelectServiceRequestAction
{
    protected $model;

    public function __construct(ServiceRequest $model)
    {
        $this->model = $model;
    }

    public function execute()
    {
        return $this->model->newQuery()
            ->select(
                'service_requests.id as sr_id',
                'services.title as s_name',
                'budget',
                'preferred_date',
                'preferred_time',
                'location',
                'users.first_name as u_name',
                'service_requests.status as sr_status',
                'details',
                'service_requests.created_at as sr_created_at'
            )
            ->leftJoin('services', 'service_requests.service_id', '=', 'services.id')
            ->leftJoin('users','service_requests.user_id', '=', 'users.id');
    }
}
