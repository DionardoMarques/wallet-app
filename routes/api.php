<?php

use App\Http\Controllers\API\TransactionsController;
use Illuminate\Support\Facades\Route;

/**
 * A optimized way to set the API routes without web resources (create, edit):
 *
 * Route::apiResource('transactions', TransactionsController::class);
 */
Route::get('transactions', [TransactionsController::class, 'index']);
Route::get('transactions/{id}', [TransactionsController::class, 'show']);

Route::post('transactions', [TransactionsController::class, 'store']);
