<?php

namespace App\Providers;

use App\Repositories\{TransactionEloquentORM};
use App\Repositories\{TransactionRepositoryInterface};
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            TransactionRepositoryInterface::class,
            TransactionEloquentORM::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
