<?php

namespace App\Providers;

use App\Repositories\TransactionEloquentORM;
use App\Repositories\UserEloquentORM;
use App\Repositories\UserRepositoryInterface;
use App\Repositories\WalletEloquentORM;
use App\Repositories\WalletRepositoryInterface;
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

        $this->app->bind(
            UserRepositoryInterface::class,
            UserEloquentORM::class
        );

        $this->app->bind(
            WalletRepositoryInterface::class,
            WalletEloquentORM::class
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
