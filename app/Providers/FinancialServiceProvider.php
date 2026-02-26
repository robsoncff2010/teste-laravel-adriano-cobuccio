<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\DepositService;
use App\Repositories\TransactionRepository;

class FinanceiroServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Bind Repository
        $this->app->singleton(TransactionRepository::class, function ($app) {
            return new TransactionRepository();
        });

        // Bind Service
        $this->app->singleton(DepositService::class, function ($app) {
            return new DepositService($app->make(TransactionRepository::class));
        });
    }

    public function boot()
    {
        //
    }
}


