<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepositController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\TransferController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => session()->has('customer_id')
    ? redirect()->route('dashboard')
    : view('welcome'))->name('home');

/* ---------- guest ---------- */
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::get('/register', [RegisterController::class, 'showStep1'])->name('register');
Route::post('/register', [RegisterController::class, 'postStep1'])->name('register.post');
Route::get('/register/verification', [RegisterController::class, 'showStep2'])->name('register.step2');
Route::post('/register/verification', [RegisterController::class, 'postStep2'])->name('register.step2.post');
Route::get('/register/security', [RegisterController::class, 'showStep3'])->name('register.step3');
Route::post('/register/security', [RegisterController::class, 'postStep3'])->name('register.step3.post');
Route::get('/register/complete', [RegisterController::class, 'complete'])->name('register.complete');
Route::post('/register/finish', [RegisterController::class, 'finish'])->name('register.finish');

Route::get('/forgot-pin', [AuthController::class, 'showForgotPin'])->name('password.forgot');
Route::post('/forgot-pin', [AuthController::class, 'verifyIdentity'])->name('password.verify');
Route::get('/reset-pin', [AuthController::class, 'showResetPin'])->name('password.reset');
Route::post('/reset-pin', [AuthController::class, 'resetPin'])->name('password.reset.post');

/* ---------- authenticated ---------- */
Route::middleware('customer')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/accounts', [AccountController::class, 'index'])->name('accounts.index');
    Route::get('/accounts/new', [AccountController::class, 'create'])->name('accounts.create');
    Route::post('/accounts', [AccountController::class, 'store'])->name('accounts.store');
    Route::get('/accounts/{account}/created', [AccountController::class, 'created'])->name('accounts.created');
    Route::get('/accounts/{account}', [AccountController::class, 'show'])->name('accounts.show');

    Route::get('/transfers', [TransferController::class, 'initiate'])->name('transfers.initiate');
    Route::post('/transfers/source', [TransferController::class, 'chooseSource'])->name('transfers.source');
    Route::get('/transfers/details', [TransferController::class, 'details'])->name('transfers.details');
    Route::post('/transfers/details', [TransferController::class, 'postDetails'])->name('transfers.details.post');
    Route::get('/transfers/review', [TransferController::class, 'review'])->name('transfers.review');
    Route::post('/transfers/confirm', [TransferController::class, 'confirm'])->name('transfers.confirm');
    Route::get('/transfers/success', [TransferController::class, 'success'])->name('transfers.success');
    Route::get('/transfers/failed', [TransferController::class, 'failed'])->name('transfers.failed');

    Route::get('/deposit', [DepositController::class, 'index'])->name('deposit.index');
    Route::post('/deposit/review', [DepositController::class, 'review'])->name('deposit.review');
    Route::post('/deposit/confirm', [DepositController::class, 'confirm'])->name('deposit.confirm');
    Route::get('/deposit/success', [DepositController::class, 'success'])->name('deposit.success');
    Route::get('/deposit/failed', [DepositController::class, 'failed'])->name('deposit.failed');

    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');

    Route::get('/activity', [ActivityController::class, 'index'])->name('activity.index');
    Route::post('/activity/read-all', [ActivityController::class, 'markAllRead'])->name('activity.read');

    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/settings', [ProfileController::class, 'settings'])->name('settings.index');
    Route::post('/settings', [ProfileController::class, 'update'])->name('settings.update');
});
