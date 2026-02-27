<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Http\Requests\DepositRequest;
use App\Services\TransactionService;

class DepositController extends Controller
{
    protected $transactionService;

    public function __construct(TransactionService $transactionService)
    {
        $this->transactionService = $transactionService;
    }

    public function create()
    {
        return view('finance.deposit');
    }

    public function store(DepositRequest $request)
    {
        $this->transactionService->createDeposit(auth()->user(), $request->amount);

        return redirect()
            ->route('finance.deposit.create')
            ->with('success', __('messages.deposit_success'));
    }
}