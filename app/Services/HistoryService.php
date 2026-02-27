<?php

namespace App\Services;

use App\Models\Transaction;

class HistoryService
{
    public function revert(Transaction $transaction): bool
    {
        if ($transaction->type === Transaction::TYPE_DEPOSIT 
            && $transaction->status === Transaction::STATUS_COMPLETED) {

            $transaction->user->decrement('balance', $transaction->amount);
            $transaction->update(['status' => Transaction::STATUS_REVERSED]);

            return true;
        }

        return false;
    }

    public function requestReversal(Transaction $transaction): bool
    {
        if ($transaction->type === Transaction::TYPE_TRANSFER 
            && $transaction->status === Transaction::STATUS_COMPLETED) {

            $transaction->update(['status' => Transaction::STATUS_REVERSAL_REQUESTED]);
            return true;
        }

        return false;
    }
}
