<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        /**
         * If necessary dummy data on Transactions table use this:
         *
         * $this->call([UserSeeder::class, TransactionSeeder::class]);
         */
        $this->call(UserSeeder::class);
    }
}
