<?php

namespace App\Repositories;

interface UserRepositoryInterface
{
    public function userExists($userId): bool;

    public function userType($userId): bool;
}
