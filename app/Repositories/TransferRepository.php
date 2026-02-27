<?php

namespace App\Repositories;

use App\Models\Transfer;
use App\Models\User;

class TransferRepository
{
    public function getAvailableUsers(int $currentUserId)
    {
        return User::whereKeyNot(auth()->id())->get();
    }

    public function create(array $data)
    {
        return Transfer::create($data);
    }

    public function findByUser($userId)
    {
        return Transfer::where('sender_id', $userId)
            ->orWhere('receiver_id', $userId)
            ->with(['sender', 'receiver', 'transaction'])
            ->get();
    }
}
