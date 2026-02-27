<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Finance\DepositController;
use App\Http\Controllers\Finance\TransferController;
use App\Http\Controllers\Finance\HistoryController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->prefix('financeiro')->group(function () {
    Route::get('/deposito', [DepositController::class, 'create'])->name('finance.deposit.create');
    Route::post('/deposito', [DepositController::class, 'store'])->name('finance.deposit.store');

    Route::get('/transferencia', [TransferController::class, 'create'])->name('finance.transfer.create');
    Route::post('/transferencia', [TransferController::class, 'store'])->name('finance.transfer.store');

    Route::get('/historico', [HistoryController::class, 'index'])->name('finance.history.index');
    Route::post('/{transaction}/revert', [HistoryController::class, 'revert'])->name('finance.history.revert');
    Route::post('/{transaction}/request-reversal', [HistoryController::class, 'requestReversal'])->name('finance.history.requestReversal');
});


Route::post('/theme-switch', function (Request $request) {
    session(['theme' => $request->theme === 'dark' ? 'dark' : 'light']);

    return back();
})->name('theme.switch');

Route::post('/language-switch', function (Request $request) {
    $locale = $request->locale === 'en' ? 'en' : 'pt';
    session(['locale' => $locale]);

    return back();
})->name('language.switch');


require __DIR__.'/auth.php';
