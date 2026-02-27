<?php

namespace App\Services;

use App\Repositories\TransferRepository;

class TransferService
{
    protected $transferRepository;
    protected $transactionRepository;

    public function __construct(
        TransferRepository $transferRepository,
    ) {
        $this->transferRepository = $transferRepository;
    }

    public function getAvailableUsers(int $currentUserId)
    {
        return $this->transferRepository->getAvailableUsers($currentUserId);
    }
}
