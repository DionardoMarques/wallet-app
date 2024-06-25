<?php

namespace App\Repositories;

interface WalletRepositoryInterface
{
    public function hasSufficientBalance($payerId, $amount): bool;

    public function updateBalancePayer($payerId, $amount): void;

    public function updateBalancePayee($payeeId, $amount): void;
}
