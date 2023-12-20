<?php

namespace App\Actions;

use App\Models\User;

class UpdateUserAction
{
    protected $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function execute($id, $data)
    {
        $payloads = [
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'address' => $data['address'],
            'mobile' => $data['mobile'],
            'gender' => $data['gender'],
        ];

        if (isset($data['password']) && !empty($data['password'])) {
            $payloads['password'] = \Hash::make($data['password']);
        }
        return $this->model->newQuery()->find($id)->update($payloads);
    }
}
