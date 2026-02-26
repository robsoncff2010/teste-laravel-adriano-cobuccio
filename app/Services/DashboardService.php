<?php

namespace App\Services;

use App\Repositories\TransactionRepository;

class DashboardService
{
    protected $transactionRepository;

    public function __construct(TransactionRepository $transactionRepository)
    {
        $this->transactionRepository = $transactionRepository;
    }

    /**
     * Retorna os dados do dashboard para o usuário autenticado
     */
    public function getData(): array
    {
        $user = auth()->user();

        return [
            'name'    => $user->name,
            'email'   => $user->email,
            'balance' => $user->balance,
        ];
    }
}