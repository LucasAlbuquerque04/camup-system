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

// Protected Routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Financial Routes (Placeholders for now)
    Route::resource('transactions', \App\Http\Controllers\Financial\TransactionController::class);
    Route::resource('categories', \App\Http\Controllers\Financial\CategoryController::class);
    Route::get('/import', [\App\Http\Controllers\Financial\BankImportController::class, 'index'])->name('import.index');
    Route::post('/import', [\App\Http\Controllers\Financial\BankImportController::class, 'store'])->name('import.store');
});
