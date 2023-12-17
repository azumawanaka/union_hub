<?php

namespace App\Actions;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CheckOldPasswordAction
{
    protected $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function execute(array $data): bool
    {
        $user = $this->model->newQuery()->find($data['user_id']);

        if (!$user) {
            return false;
        }

        return Hash::check($data['password'], $user->password);
    }
}
