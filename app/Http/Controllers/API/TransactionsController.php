<?php

namespace App\Http\Controllers\API;

use App\DTO\CreateTransactionDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTransactionRequest;
use App\Services\TransactionService as ServicesTransactionService;
use Exception;

class TransactionsController extends Controller
{
    public function __construct(
        protected ServicesTransactionService $service
    ) {}

    public function index()
    {
        try {
            $transactions = $this->service->getAll();

            if (! $transactions) {
                return response()->json(['message' => 'No transactions found.'], 404);
            }

            return response()->json($transactions, 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        try {
            $transaction = $this->service->findOne($id);

            if (! $transaction) {
                return response()->json(['message' => 'Transaction not found, please try another ID.'], 404);
            }

            return response()->json($transaction);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function store(StoreTransactionRequest $request)
    {
        try {
            $transaction = $this->service->new(CreateTransactionDTO::makeFromRequest($request));

            return response()->json($transaction, 201);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
