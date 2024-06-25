<?php

namespace App\Services;

use App\Repositories\WalletRepositoryInterface;

class WalletService
{
    public function __construct(
        protected WalletRepositoryInterface $repository
    ) {}

    public function hasSufficientBalance($payerId, $amount): bool
    {
        return $this->repository->hasSufficientBalance($payerId, $amount);
    }

    public function updateBalancePayer($payerId, $amount): void
    {
        $this->repository->updateBalancePayer($payerId, $amount);
    }

    public function updateBalancePayee($payeeId, $amount): void
    {
        $this->repository->updateBalancePayee($payeeId, $amount);
    }
}
