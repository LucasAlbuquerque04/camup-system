<?php

namespace App\Http\Controllers\Financial;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Auth::user()->transactions()->with('category')->latest('date')->paginate(10);
        return view('financial.transactions.index', compact('transactions'));
    }

    public function create(Request $request)
    {
        $categories = Auth::user()->categories()->where('type', $request->query('type', 'expense'))->get();
        return view('financial.transactions.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0.01',
            'date' => 'required|date',
            'type' => 'required|in:income,expense',
            'category_id' => 'required|exists:categories,id',
            'paid' => 'boolean',
        ]);

        $transaction = Auth::user()->transactions()->create($validated);

        return redirect()->route('dashboard')->with('status', 'Transação criada com sucesso!');
    }

    public function destroy(Transaction $transaction)
    {
        if ($transaction->user_id !== Auth::id()) {
            abort(403);
        }

        $transaction->delete();

        return back()->with('status', 'Transação excluída.');
    }
}
