<?php

namespace App\Services;

use App\DTO\CreateTransactionDTO;
use App\Repositories\TransactionRepositoryInterface;
use Exception;
use stdClass;

class TransactionService
{
    public function __construct(
        protected TransactionRepositoryInterface $repository,
        protected TransactionValidationService $validate,
        protected WalletService $wallet,
        protected NotificationService $notificationService,
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
        try {
            $validation = $this->validate->validateTransaction($dto);

            if ($validation) {
                $this->wallet->updateBalancePayer($dto->payer_id, $dto->value);
                $this->wallet->updateBalancePayee($dto->payee_id, $dto->value);

                if (! $this->notificationService->notifyPayment()) {
                }

                $dto->status = 'completed';

                return $this->repository->new($dto);
            }
        } catch (Exception $e) {
            throw $e;
        }
    }
}
