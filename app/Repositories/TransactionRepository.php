<?php

namespace App\Repositories;

use App\Models\Transaction;
use App\Models\Transfer;
use App\Models\User;

class TransactionRepository
{
    public function getFormattedTransactions(User $user)
    {
        return Transaction::with(['sender', 'receiver'])
            ->where('user_id', $user->id)
            ->orWhere(function ($q) use ($user) {
                $q->where('type', 'transfer')
                  ->whereHas('receiver', function ($sub) use ($user) {
                      $sub->where('users.id', $user->id);
                  });
            })
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function($t) {
                return [
                    'id'       => $t->id,
                    'date'     => $t->created_at->format('d/m/Y H:i'),
                    'type'     => $t->type,
                    'amount'   => number_format($t->amount, 2, ',', '.'),
                    'sender'   => $t->sender?->name ?? '—',
                    'receiver' => $t->receiver?->name ?? '—',
                    'status'   => match($t->status) {
                        Transaction::STATUS_COMPLETED          => 'completed',
                        Transaction::STATUS_REVERSED           => 'reversed',
                        Transaction::STATUS_REVERSAL_REQUESTED => 'reversal_requested',
                    }
                ];
            });
    }

    public function getBalance(User $user)
    {
        $deposits = Transaction::where('type', Transaction::TYPE_DEPOSIT)
            ->where('status', Transaction::STATUS_COMPLETED)
            ->where('user_id', $user->id)
            ->sum('amount');

        $sentTransfers = Transaction::where('type', Transaction::TYPE_TRANSFER)
            ->whereIn('status', [Transaction::STATUS_COMPLETED, Transaction::STATUS_REVERSAL_REQUESTED])
            ->whereHas('transfer', function ($q) use ($user) {
                $q->where('sender_id', $user->id);
            })
            ->sum('amount');
            
        return $deposits - $sentTransfers;
    }

    public function getIncomes(User $user)
    {
        $deposits = Transaction::where('type', Transaction::TYPE_DEPOSIT)
            ->where('status', Transaction::STATUS_COMPLETED)
            ->where('user_id', $user->id)
            ->sum('amount');

        $receivedTransfers = Transaction::where('type', Transaction::TYPE_TRANSFER)
            ->where('status', Transaction::STATUS_COMPLETED)
            ->whereHas('transfer', function ($q) use ($user) {
                $q->where('receiver_id', $user->id);
            })
            ->sum('amount');

        return $deposits + $receivedTransfers;
    }

    public function getExpenses(User $user)
    {
        return Transaction::where('type', Transaction::TYPE_TRANSFER)
            ->whereIn('status', [Transaction::STATUS_COMPLETED, Transaction::STATUS_REVERSAL_REQUESTED])
            ->where('user_id', $user->id)
            ->sum('amount');
    }

    public function getTotalTransactions(User $user)
    {
        return Transaction::where('user_id', $user->id)->count();
    }

    public function getLatestTransactions(User $user, int $limit = 5)
    {
        return $this->getFormattedTransactions($user)->take($limit);
    }

    public function getMonthlyIncomes(User $user)
    {
        return Transaction::selectRaw('MONTH(created_at) as month, SUM(amount) as total')
            ->where('type', 'deposit')
            ->where('status', Transaction::STATUS_COMPLETED)
            ->where('user_id', $user->id)
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month');
    }

    public function getMonthlyExpenses(User $user)
    {
        return Transfer::selectRaw('MONTH(created_at) as month, SUM(amount) as total')
            ->where('sender_id', $user->id)
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month');
    }

    public function getTotalDeposits(User $user)
    {
        return Transaction::where('type', Transaction::TYPE_DEPOSIT)
            ->where('status', Transaction::STATUS_COMPLETED)
            ->where('user_id', $user->id)
            ->count();
    }

    public function getTotalTransfers(User $user)
    {
        return Transaction::where('type', Transaction::TYPE_TRANSFER)
            ->whereIn('status', [Transaction::STATUS_COMPLETED, Transaction::STATUS_REVERSAL_REQUESTED])
            ->where('user_id', $user->id)
            ->count();
    }
}