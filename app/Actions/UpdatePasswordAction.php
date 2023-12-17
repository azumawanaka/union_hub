<?php

namespace App\Actions;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UpdatePasswordAction
{
    protected $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function execute($id, $data)
    {
        return $this->model->newQuery()->find($id)->update([
            'password' => Hash::make($data['new_password']),
        ]);
    }
}
