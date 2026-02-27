<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Services\HistoryService;
use App\Repositories\TransactionRepository;

class HistoryController extends Controller
{
    protected $historyService;

    public function __construct(HistoryService $historyService)
    {
        $this->historyService = $historyService;
    }

    public function index(TransactionRepository $repo)
    {
        $transactions = $repo->getFormattedTransactions(Auth()->user());
        return view('finance.history', compact('transactions'));
    }

    public function revert(Transaction $transaction)
    {
        if ($this->historyService->revert($transaction)) {
            return redirect()->route('finance.history.index')
                             ->with('success', __('messages.reversal_success'));
        }

        return redirect()->route('finance.history.index')
                         ->with('error', __('messages.reversal_failed'));
    }

    public function requestReversal(Transaction $transaction)
    {
        if ($this->historyService->requestReversal($transaction)) {
            return redirect()->route('finance.history.index')
                             ->with('success', __('messages.reversal_request_success'));
        }

        return redirect()->route('finance.history.index')
                         ->with('error', __('messages.reversal_request_failed'));
    }
}
