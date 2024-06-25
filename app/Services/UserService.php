<?php

namespace App\Services;

use App\Repositories\UserRepositoryInterface;

class UserService
{
    public function __construct(
        protected UserRepositoryInterface $repository,
    ) {}

    public function userExists($userId): bool
    {
        return $this->repository->userExists($userId);
    }

    public function userType($userId): bool
    {
        return $this->repository->userType($userId);
    }
}
