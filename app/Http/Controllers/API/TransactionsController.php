<?php

namespace App\Http\Controllers\API;

use App\DTO\CreateTransactionDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTransactionRequest;
use App\Services\TransactionService as ServicesTransactionService;
use Exception;

/**
 * @OA\Info(
 *     version="1.0.0",
 *     title="Wallet App API",
 *     description="API documentation with Swagger"
 * )
 */
class TransactionsController extends Controller
{
    public function __construct(
        protected ServicesTransactionService $service
    ) {}

    /**
     * @OA\Get(
     *     path="/api/transactions",
     *     tags={"Transactions"},
     *     summary="List all transactions",
     *
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No transactions found"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error"
     *     )
     * )
     */
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

    /**
     * @OA\Get(
     *     path="/api/transactions/{id}",
     *     tags={"Transactions"},
     *     summary="Get transaction by ID",
     *
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Transaction not found"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error"
     *     )
     * )
     */
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

    /**
     * @OA\Post(
     *     path="/api/transactions",
     *     tags={"Transactions"},
     *     summary="Create a new transaction",
     *
     *     @OA\RequestBody(
     *         required=true,
     *
     *         @OA\JsonContent(
     *             type="object",
     *
     *             @OA\Property(
     *                 property="value",
     *                 type="number",
     *                 format="float",
     *                 default=100.00,
     *                 description="Transaction amount to be sent"
     *             ),
     *             @OA\Property(
     *                 property="payer_id",
     *                 type="integer",
     *                 default=4,
     *                 description="Id of who is sending the amount in this transaction"
     *             ),
     *             @OA\Property(
     *                 property="payee_id",
     *                 default=15,
     *                 type="integer",
     *                 description="Id of who is receiving the value in this transaction"
     *             ),
     *             @OA\Property(
     *                 property="status",
     *                 type="string",
     *                 default="in progress",
     *                 description="Transaction status"
     *             ),
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=201,
     *         description="Transaction created successfully"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error"
     *     )
     * )
     */
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
