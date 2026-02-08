<?php

namespace App\Http\Controllers\Financial;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class TransactionController extends Controller
{
    /**
     * Display a listing of transactions with filters.
     */
    public function index(Request $request)
    {
        $query = Auth::user()->transactions()->with('category');

        // Filter by type
        if ($request->filled('type') && in_array($request->type, ['income', 'expense'])) {
            $query->where('type', $request->type);
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('date', '<=', $request->date_to);
        }

        $transactions = $query->orderBy('date', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        // Load categories for the modal form (filtered by user)
        $categories = Category::where('user_id', Auth::id())
            ->orderBy('type')
            ->orderBy('name')
            ->get();

        return view('financial.transactions.index', compact('transactions', 'categories'));
    }

    /**
     * Store a newly created transaction.
     */
    public function store(Request $request)
    {
        $validated = $this->validateTransaction($request);

        // Get type from the selected category
        $category = Category::where('id', $validated['category_id'])
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $validated['type'] = $category->type;

        Auth::user()->transactions()->create($validated);

        return redirect()->route('transactions.index')
            ->with('success', 'Transação criada!');
    }

    /**
     * Get transaction data for editing (AJAX).
     */
    public function edit(string $id)
    {
        $transaction = Auth::user()->transactions()
            ->where('id', $id)
            ->firstOrFail();

        return response()->json($transaction);
    }

    /**
     * Update the specified transaction.
     */
    public function update(Request $request, string $id)
    {
        $transaction = Auth::user()->transactions()
            ->where('id', $id)
            ->firstOrFail();

        $validated = $this->validateTransaction($request);

        // Get type from the selected category
        $category = Category::where('id', $validated['category_id'])
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $validated['type'] = $category->type;

        $transaction->update($validated);

        return redirect()->route('transactions.index')
            ->with('success', 'Transação atualizada!');
    }

    /**
     * Remove the specified transaction.
     */
    public function destroy(string $id)
    {
        $transaction = Auth::user()->transactions()
            ->where('id', $id)
            ->firstOrFail();

        $transaction->delete();

        return redirect()->route('transactions.index')
            ->with('success', 'Transação removida!');
    }

    /**
     * Validate transaction data.
     */
    private function validateTransaction(Request $request): array
    {
        // Trim description like CategoryController does
        $request->merge([
            'description' => trim($request->input('description'))
        ]);

        // Normalize amount: remove formatting (dots as thousands, comma as decimal)
        $amount = $request->input('amount');
        if (is_string($amount)) {
            $amount = str_replace('.', '', $amount); // Remove thousand separators
            $amount = str_replace(',', '.', $amount); // Convert decimal separator
            $request->merge(['amount' => $amount]);
        }

        return $request->validate([
            'description' => [
                'required',
                'string',
                'max:35',
                'regex:/^[\p{L}\s\-\/\&.,]+$/u', // Letters, spaces, and basic punctuation (no numbers)
            ],
            'amount' => [
                'required',
                'numeric',
                'min:0.01',
                'max:9999999.99',
                'regex:/^\d{1,7}(\.\d{1,2})?$/',
            ],
            'date' => [
                'required',
                'date',
            ],
            'category_id' => [
                'required',
                'integer',
                Rule::exists('categories', 'id')->where('user_id', Auth::id()),
            ],
        ], [
            'description.required' => 'A descrição é obrigatória.',
            'description.max' => 'A descrição deve ter no máximo 35 caracteres.',
            'description.regex' => 'A descrição não pode conter números ou caracteres especiais.',
            'amount.required' => 'O valor é obrigatório.',
            'amount.numeric' => 'O valor deve ser um número válido.',
            'amount.min' => 'O valor deve ser maior que zero.',
            'amount.max' => 'O valor máximo permitido é R$ 9.999.999,99.',
            'amount.regex' => 'Use no máximo 7 dígitos antes da vírgula e 2 casas decimais.',
            'date.required' => 'A data é obrigatória.',
            'date.date' => 'A data deve ser válida.',
            'category_id.required' => 'A categoria é obrigatória.',
            'category_id.exists' => 'A categoria selecionada é inválida.',
        ]);
    }
}
