<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $currentMonth = Carbon::now();

        // Calculate totals for current month
        $income = $user->transactions()
            ->where('type', 'income')
            ->whereMonth('date', $currentMonth->month)
            ->whereYear('date', $currentMonth->year)
            ->sum('amount');

        $expense = $user->transactions()
            ->where('type', 'expense')
            ->whereMonth('date', $currentMonth->month)
            ->whereYear('date', $currentMonth->year)
            ->sum('amount');

        // Calculate overall balance (all time)
        $totalIncome = $user->transactions()->where('type', 'income')->sum('amount');
        $totalExpense = $user->transactions()->where('type', 'expense')->sum('amount');
        $balance = $totalIncome - $totalExpense;

        // Get recent transactions (last 5)
        $recentTransactions = $user->transactions()
            ->with('category')
            ->orderBy('date', 'desc')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('dashboard.home', compact('balance', 'income', 'expense', 'recentTransactions'));
    }
}
