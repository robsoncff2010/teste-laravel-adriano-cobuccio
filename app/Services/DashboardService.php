<?php

namespace App\Services;

use App\Repositories\TransactionRepository;
use App\Models\User;

class DashboardService
{
    public function __construct(
        protected TransactionRepository $repository
    ) {}

    public function getData(User $user)
    {
        $balance             = $this->repository->getBalance($user);
        $incomes             = $this->repository->getIncomes($user);
        $expenses            = $this->repository->getExpenses($user);
        $totalTransactions   = $this->repository->getTotalTransactions($user);
        $latestTransactions  = $this->repository->getLatestTransactions($user);
        $chartIncomes        = $this->repository->getMonthlyIncomes($user)->values();
        $chartExpenses       = $this->repository->getMonthlyExpenses($user)->values();
        $chartDepositsTotal  = $this->repository->getTotalDeposits($user);
        $chartTransfersTotal = $this->repository->getTotalTransfers($user);

        return compact(
            'balance',
            'incomes',
            'expenses',
            'totalTransactions',
            'latestTransactions',
            'chartIncomes',
            'chartExpenses',
            'chartDepositsTotal',
            'chartTransfersTotal'
        );
    }
}