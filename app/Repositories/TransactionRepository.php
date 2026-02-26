<?php

namespace App\Repositories;

use App\Models\Transaction;

class TransactionRepository
{
    /**
     * Cria uma nova transação
     */
    public function create(array $data): Transaction
    {
        return Transaction::create($data);
    }

    /**
     * Busca uma transação pelo ID
     */
    public function find(int $id): ?Transaction
    {
        return Transaction::find($id);
    }

    /**
     * Lista todas as transações de um usuário
     */
    public function getByUser(int $userId)
    {
        return Transaction::where('user_id', $userId)->get();
    }

    /**
     * Atualiza uma transação
     */
    public function update(Transaction $transaction, array $data): Transaction
    {
        $transaction->update($data);
        return $transaction;
    }

    /**
     * Remove uma transação
     */
    public function delete(Transaction $transaction): bool
    {
        return $transaction->delete();
    }
}
