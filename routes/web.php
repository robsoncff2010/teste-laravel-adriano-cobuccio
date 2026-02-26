<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DepositController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'create'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->prefix('financeiro')->group(function () {
    Route::get('/deposito', [DepositController::class, 'create'])->name('finance.deposit.create');
    Route::post('/deposito', [DepositController::class, 'store'])->name('finance.deposit.store');

    Route::get('/transferencia', [TransferController::class, 'create'])->name('financeiro.transferencia');
    Route::get('/transferencia', [TransactionController::class, 'store'])->name('financeiro.historico');
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
