<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // TODO: Implementar lógica de cálculo de saldos e transações recentes
        
        $balance = 0;
        $income = 0;
        $expense = 0;
        $recentTransactions = [];

        return view('dashboard.home', compact('balance', 'income', 'expense', 'recentTransactions'));
    }
}
