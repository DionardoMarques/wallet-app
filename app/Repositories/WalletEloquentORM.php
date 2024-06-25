<?php

namespace App\Repositories;

use App\Models\Wallet;

class WalletEloquentORM implements WalletRepositoryInterface
{
    public function __construct(
        protected Wallet $wallet
    ) {}

    public function hasSufficientBalance($payerId, $amount): bool
    {
        $wallet = Wallet::where('user_id', $payerId)->first();

        $balance = $wallet->balance;

        if ($balance >= $amount) {
            return true;
        } else {
            return false;
        }
    }

    public function updateBalancePayer($payerId, $amount): void
    {
        $wallet = Wallet::where('user_id', $payerId)->first();

        $balance = $wallet->balance;

        if ($wallet) {
            $newBalance = $balance - $amount;

            $wallet->balance = $newBalance;

            $wallet->save();
        }
    }

    public function updateBalancePayee($payeeId, $amount): void
    {
        $wallet = Wallet::where('user_id', $payeeId)->first();

        $balance = $wallet->balance;

        if ($wallet) {
            $newBalance = $balance + $amount;

            $wallet->balance = $newBalance;

            $wallet->save();
        }
    }
}
