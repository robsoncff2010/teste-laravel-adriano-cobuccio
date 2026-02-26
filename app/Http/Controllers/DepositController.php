<?php

namespace App\Http\Controllers;
use App\Http\Requests\DepositRequest;
use App\Services\DepositService;

class DepositController extends Controller
{
    protected $depositService;

    public function __construct(DepositService $depositService)
    {
        $this->depositService = $depositService;
    }

    public function create()
    {
        return view('finance.deposit');
    }

    public function store(DepositRequest $request)
    {
        $this->depositService->deposit(auth()->user(), $request->amount);

        return redirect()
            ->route('finance.deposit.create')
            ->with('success', __('messages.deposit_success'));
    }
}
