<?php

namespace App\Services;

use App\Models\Transaction;
use App\Models\Transfer;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class TransactionService
{
    public function createTransfer(User $sender, int $receiverId, float $amount)
    {
        if ($sender->balance < $amount) {
            throw new \Exception(__('messages.insufficient_funds'));
        }

        return DB::transaction(function () use ($sender, $receiverId, $amount) {
            // Cria a Transaction
            $transaction = Transaction::create([
                'user_id' => $sender->id,
                'type'    => Transaction::TYPE_TRANSFER,
                'amount'  => $amount,
            ]);

            // Cria a Transfer vinculada
            $transfer = Transfer::create([
                'transaction_id' => $transaction->id,
                'sender_id'      => $sender->id,
                'receiver_id'    => $receiverId,
                'amount'         => $amount,
            ]);

            // Atualiza saldos
            $this->applyTransaction($transaction);

            return $transfer;
        });
    }

    public function createDeposit(User $user, float $amount)
    {
        return DB::transaction(function () use ($user, $amount) {
            $transaction = Transaction::create([
                'user_id' => $user->id,
                'type'    => Transaction::TYPE_DEPOSIT,
                'amount'  => $amount,
            ]);

            $this->applyTransaction($transaction);

            return $transaction;
        });
    }

    private function applyTransaction(Transaction $transaction)
    {
        switch ($transaction->type) {
            case Transaction::TYPE_TRANSFER:
                $sender   = $transaction->user;
                $transfer = $transaction->transfer;

                $sender->decrement('balance', $transaction->amount);

                $receiver = User::find($transfer->receiver_id);
                $receiver->increment('balance', $transaction->amount);
                break;

            case Transaction::TYPE_DEPOSIT:
                $transaction->user->increment('balance', $transaction->amount);
                break;

            case Transaction::TYPE_REVERSAL:
                $transaction->user->increment('balance', $transaction->amount);
                break;
        }
    }
}
