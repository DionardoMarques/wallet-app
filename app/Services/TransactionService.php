<?php

namespace App\Services;

use App\DTO\CreateTransactionDTO;
use App\Repositories\TransactionRepositoryInterface;
use stdClass;

class TransactionService
{
    public function __construct(
        protected TransactionRepositoryInterface $repository,
    ) {}

    public function getAll(): array
    {
        return $this->repository->getAll();
    }

    public function findOne($id): ?stdClass
    {
        return $this->repository->findOne($id);
    }

    public function new(CreateTransactionDTO $dto): stdClass
    {
        return $this->repository->new($dto);
    }
}
