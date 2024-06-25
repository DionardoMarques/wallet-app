<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    public function definition(): array
    {
        return [
            'value' => fake()->randomFloat(2, 0.01, 10000000),
            'payer_id' => fake()->randomDigit(),
            'payee_id' => fake()->randomDigit(),
            'status' => 'in progress',
        ];
    }
}
