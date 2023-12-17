<?php

namespace App\Actions;

use App\Models\User;

class UpdateProfilePhotoAction
{
    protected $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function execute(array $data)
    {
        $user = auth()->user()->id;
        return $this->model->newQuery()->find($user)->update([
            'photo' => $data['file'],
        ]);
    }
}
