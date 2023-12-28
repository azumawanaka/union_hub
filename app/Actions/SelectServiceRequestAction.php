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
                'services.service_type_id as s_type_id',
                'services.title as s_name',
                'services.title as sr_title',
                'services.description as sr_description',
                'services.rate as sr_rate',
                'service_requests.id as sr_id',
                'service_requests.status as sr_status',
                'service_requests.created_at as sr_created_at',
                'service_requests.status_updated_at as sr_status_updated_at',
                'preferred_date_time',
                'location',
                'users.first_name as u_name',
                'details',
            )
            ->leftJoin('services', 'service_requests.service_id', '=', 'services.id')
            ->leftJoin('users','service_requests.user_id', '=', 'users.id');
    }
}
