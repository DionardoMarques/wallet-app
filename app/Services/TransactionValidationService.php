<?php

namespace App\Services;

use App\DTO\CreateTransactionDTO;
use Exception;

class TransactionValidationService
{
    public function __construct(
        protected UserService $userService,
        protected WalletService $walletService,
        protected AuthorizationService $authorizationService,
    ) {}

    public function validateTransaction(CreateTransactionDTO $dto): bool
    {
        try {
            if ($dto->payer_id === $dto->payee_id) {
                throw new Exception('Payer and Payee cannot be the same.');
            }

            if (! $this->userService->userExists($dto->payer_id) || ! $this->userService->userExists($dto->payee_id)) {
                throw new Exception('Payer or Payee not found.');
            }

            if (! $this->userService->userType($dto->payer_id)) {
                throw new Exception('Shopkeepers are not allowed to make transactions.');
            }

            if (! $this->walletService->hasSufficientBalance($dto->payer_id, $dto->value)) {
                throw new Exception('Insufficient balance.');
            }

            if (! $this->authorizationService->authorizeTransaction()) {
                throw new Exception('Authorization service unavailable.');
            }

            return true;
        } catch (Exception $e) {
            throw $e;

            return false;
        }
    }
}
