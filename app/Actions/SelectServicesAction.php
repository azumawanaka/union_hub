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
            ->select(
                'services.id as s_id',
                'services.rate as s_rate',
                'title',
                'description',
                'clients.name as c_name',
                'service_types.name as s_name',
                'services.created_at as added_at'
            )
            ->leftJoin('service_types', 'services.service_type_id', '=', 'service_types.id')
            ->leftJoin('clients','services.client_id', '=', 'clients.id');
    }
}
