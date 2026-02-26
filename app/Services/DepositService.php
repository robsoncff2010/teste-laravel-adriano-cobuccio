<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\TransactionRepository;

class DepositService
{
    protected $transactionRepository;

    public function __construct(TransactionRepository $transactionRepository)
    {
        $this->transactionRepository = $transactionRepository;
    }

    /**
     * Realiza um depósito para o usuário
     */
    public function deposit(User $user, float $amount)
    {
        // Atualiza saldo do usuário
        $user->balance += $amount;
        $user->save();

        // Registra transação
        return $this->transactionRepository->create([
            'user_id' => $user->id,
            'type'    => 'deposit',
            'amount'  => $amount,
            'status'  => 'completed',
        ]);
    }

    /**
     * Reverte um depósito (caso solicitado ou por inconsistência)
     */
    public function revertDeposit(int $transactionId)
    {
        $transaction = $this->transactionRepository->find($transactionId);

        if ($transaction && $transaction->type === 'deposit' && $transaction->status === 'completed') {
            $user = $transaction->user;

            // Remove saldo
            $user->balance -= $transaction->amount;
            $user->save();

            // Atualiza transação
            $transaction->status = 'reversed';
            $transaction->save();

            return $transaction;
        }

        return null;
    }
}