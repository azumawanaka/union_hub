<?php

namespace App\Actions;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class SelectUserAction
{
    protected $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function execute()
    {
        return $this->model->newQuery()
            ->where('id', '!=', auth()->user()->id)->select(
                'users.id as u_id',
                DB::raw("CONCAT_WS(' ', users.first_name, users.last_name) as f_n"),
                'users.email as u_email',
                'users.address as u_address',
                'users.mobile as u_mobile',
                'users.gender as u_gender',
                'users.role as u_role',
                'users.created_at as u_created_at',
            );
    }
}
