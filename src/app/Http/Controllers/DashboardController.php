<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        $currentMonth = now()->month;
        $currentYear = now()->year;

        $income = $user->transactions()
            ->where('type', 'income')
            ->whereMonth('date', $currentMonth)
            ->whereYear('date', $currentYear)
            ->sum('amount');

        $expense = $user->transactions()
            ->where('type', 'expense')
            ->whereMonth('date', $currentMonth)
            ->whereYear('date', $currentYear)
            ->sum('amount');

        $balance = $user->transactions()->sum(\DB::raw("CASE WHEN type = 'income' THEN amount ELSE -amount END"));

        $recentTransactions = $user->transactions()
            ->with('category')
            ->latest('date')
            ->take(5)
            ->get();

        return view('dashboard.home', compact('income', 'expense', 'balance', 'recentTransactions'));
    }
}
