<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return redirect()->route('login');
});

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'loginView'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'registerView'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Email Verification Routes
Route::middleware('auth')->group(function () {
    Route::get('/email/verify', [\App\Http\Controllers\Auth\VerificationController::class, 'notice'])
        ->name('verification.notice');

    Route::get('/email/verify/{id}/{hash}', [\App\Http\Controllers\Auth\VerificationController::class, 'verify'])
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('/email/verification-notification', [\App\Http\Controllers\Auth\VerificationController::class, 'resend'])
        ->middleware(['throttle:1,1'])
        ->name('verification.resend');
});

// Protected Routes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Financial Routes (Placeholders for now)
    Route::resource('transactions', \App\Http\Controllers\Financial\TransactionController::class);
    Route::resource('categories', \App\Http\Controllers\Financial\CategoryController::class);
    Route::get('/import', [\App\Http\Controllers\Financial\BankImportController::class, 'index'])->name('import.index');
    Route::post('/import', [\App\Http\Controllers\Financial\BankImportController::class, 'store'])->name('import.store');
});
