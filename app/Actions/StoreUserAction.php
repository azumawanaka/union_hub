<?php

namespace App\Actions;

use App\Models\User;

class StoreUserAction
{
    protected $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function execute($data)
    {
        return $this->model->create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'password' => \Hash::make($data['password']),
            'address' => $data['address'],
            'mobile' => $data['mobile'],
            'gender' => $data['gender'],
        ]);
    }
}
