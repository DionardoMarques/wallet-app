<?php

namespace Tests\Feature;

use App\Models\Transaction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class TransactionsControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_transactions_endpoint(): void
    {
        $transactions = Transaction::factory(3)->create();

        $response = $this->getJson('/api/transactions');

        $response->assertStatus(200);
        $response->assertJsonCount(3);

        $response->assertJson(function (AssertableJson $json) use ($transactions) {

            $json->hasAll(['0.id', '0.value', '0.payer_id', '0.payee_id', '0.status']);

            $json->whereAllType([
                '0.id' => 'integer',
                '0.value' => 'double',
                '0.payer_id' => 'integer',
                '0.payee_id' => 'integer',
                '0.status' => 'string',
            ]);

            $transaction = $transactions->first();

            $json->whereAll([
                '0.id' => $transaction->id,
                '0.value' => $transaction->value,
                '0.payer_id' => $transaction->payer_id,
                '0.payee_id' => $transaction->payee_id,
                '0.status' => $transaction->status,
            ]);
        });
    }

    public function test_get_void_transactions_return(): void
    {
        $response = $this->getJson('/api/transactions', []);

        $response->assertStatus(404);

        $response->assertJson(function (AssertableJson $json) {

            $json->hasAll('message');

            $json->where('message', 'No transactions found.');
        });
    }

    public function test_get_single_transaction_endpoint(): void
    {
        $transaction = Transaction::factory(1)->createOne();

        $response = $this->getJson('/api/transactions/'.$transaction->id);

        $response->assertStatus(200);

        $response->assertJson(function (AssertableJson $json) use ($transaction) {

            $json->hasAll(['id', 'value', 'payer_id', 'payee_id', 'status'])->etc();

            $json->whereAllType([
                'id' => 'integer',
                'value' => 'double',
                'payer_id' => 'integer',
                'payee_id' => 'integer',
                'status' => 'string',
            ]);

            $json->whereAll([
                'id' => $transaction->id,
                'value' => $transaction->value,
                'payer_id' => $transaction->payer_id,
                'payee_id' => $transaction->payee_id,
                'status' => $transaction->status,
            ]);
        });
    }

    public function test_get_not_found_single_transaction_return(): void
    {
        Transaction::query()->delete();

        $id = 9999;

        $response = $this->getJson('/api/transactions/'.$id);

        $response->assertStatus(404);

        $response->assertJson(function (AssertableJson $json) {

            $json->hasAll('message');

            $json->where('message', 'Transaction not found, please try another ID.');
        });
    }

    public function test_post_transactions_endpoint()
    {
        $transaction = Transaction::factory(1)->makeOne()->toArray();

        $response = $this->postJson('/api/transactions', $transaction);

        $response->assertStatus(201);

        $response->assertJson(function (AssertableJson $json) use ($transaction) {

            $json->hasAll(['id', 'value', 'payer_id', 'payee_id', 'status'])->etc();

            $json->whereAllType([
                'value' => ['integer', 'double'],
                'payer_id' => 'integer',
                'payee_id' => 'integer',
                'status' => 'string',
            ]);

            $json->whereAll([
                'value' => (float) $transaction['value'],
                'payer_id' => $transaction['payer_id'],
                'payee_id' => $transaction['payee_id'],
                'status' => $transaction['status'],
            ])->etc();
        });
    }

    public function test_post_transaction_creation_fails_with_missing_fields()
    {
        $response = $this->postJson('/api/transactions', []);

        $response->assertStatus(422);

        $response->assertJson(function (AssertableJson $json) {

            $json->hasAll(['message', 'errors']);

            $json->where('errors.value.0', 'This field is required.')
                ->where('errors.payer_id.0', 'This field is required.')
                ->where('errors.payee_id.0', 'This field is required.');
        });
    }
}
