<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Http\Requests\TransferRequest;
use App\Services\TransactionService;
use App\Services\TransferService;

class TransferController extends Controller
{
    protected $transactionService;
    protected $transferService;

    public function __construct(TransactionService $transactionService, TransferService $transferService)
    {
        $this->transactionService = $transactionService;
        $this->transferService    = $transferService;
    }

    public function create()
    {
        $users = $this->transferService->getAvailableUsers(auth()->id());

        return view('finance.transfer', compact('users'));
    }

    public function store(TransferRequest $request)
    {
        $this->transactionService->createTransfer(
            $request->user(),
            $request->receiver_id,
            $request->amount
        );

        return redirect()
            ->route('finance.transfer.create')
            ->with('success', __('messages.transfer_success'));
    }
}