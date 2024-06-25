<?php

namespace App\Repositories;

use App\Models\User;

class UserEloquentORM implements UserRepositoryInterface
{
    public function __construct(
        protected User $model
    ) {}

    public function userExists($userId): bool
    {
        return $this->model->where('id', $userId)->exists();
    }

    public function userType($userId): bool
    {
        $user = User::find($userId);

        $type = $user->type;

        if ($type === 'common') {
            return true;
        } else {
            return false;
        }
    }
}
