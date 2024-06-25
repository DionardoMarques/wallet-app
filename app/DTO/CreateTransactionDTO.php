<?php

namespace App\DTO;

use App\Http\Requests\StoreTransactionRequest as RequestsStoreTransactionRequest;

class CreateTransactionDTO
{
    public function __construct(
        public float $value,
        public int $payer_id,
        public int $payee_id,
        public string $status,
    ) {}

    public static function makeFromRequest(RequestsStoreTransactionRequest $request): self
    {
        return new self(
            $request->value,
            $request->payer_id,
            $request->payee_id,
            $request->status,
        );
    }
}
