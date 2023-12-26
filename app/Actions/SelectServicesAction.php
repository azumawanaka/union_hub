<?php

namespace App\Actions;

use App\Models\Service;

class SelectServicesAction
{
    protected $model;

    public function __construct(Service $model)
    {
        $this->model = $model;
    }

    public function execute()
    {
        return $this->model->newQuery()
            ->with([
                'serviceRequests' => function ($query) {
                    $query->where('user_id', auth()->user()->id);
                },
            ])
            ->select(
                'services.id as s_id',
                'services.rate as s_rate',
                'title',
                'description',
                'clients.name as c_name',
                'services.service_type_id as service_type_id',
                'service_types.name as s_name',
                'services.created_at as added_at',
                'services.updated_at as updated_at',
                'service_requests.id as sr_id',
                'service_requests.preferred_date_time as sr_dt',
                'service_requests.status as sr_status',
            )
            ->leftJoin('service_types', 'services.service_type_id', '=', 'service_types.id')
            ->leftJoin('clients','services.client_id', '=', 'clients.id')
            ->leftJoin('service_requests','services.id', '=', 'service_requests.service_id');
    }
}
