<?php

namespace App\Repositories;

use App\DTO\CreateTransactionDTO;
use App\Models\Transaction;
use stdClass;

class TransactionEloquentORM implements TransactionRepositoryInterface
{
    public function __construct(
        protected Transaction $model
    ) {}

    public function getAll(): array
    {
        return $this->model->all()->toArray();
    }

    public function findOne($id): ?stdClass
    {
        $transaction = $this->model->find($id);

        if (! $transaction) {
            return null;
        }

        return (object) $transaction->toArray();
    }

    public function new(CreateTransactionDTO $dto): stdClass
    {
        $transaction = $this->model->create((array) $dto);

        return (object) $transaction->toArray();
    }
}
