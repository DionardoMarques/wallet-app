<?php

namespace App\Repositories;

use App\DTO\CreateTransactionDTO;
use stdClass;

interface TransactionRepositoryInterface
{
    public function getAll(): array;

    public function findOne($id): ?stdClass;

    public function new(CreateTransactionDTO $dto): stdClass;
}
