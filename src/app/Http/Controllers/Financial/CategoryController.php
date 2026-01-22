<?php

namespace App\Http\Controllers\Financial;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::where('user_id', auth()->id())
            ->orderBy('type')
            ->orderBy('name')
            ->get();

        return view('financial.categories.index', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:income,expense',
            'color' => 'nullable|regex:/^#[0-9A-Fa-f]{6}$/',
        ], [
            'name.required' => 'O nome da categoria é obrigatório.',
            'type.required' => 'O tipo da categoria é obrigatório.',
            'type.in' => 'O tipo deve ser Receita ou Despesa.',
            'color.regex' => 'A cor deve estar no formato hexadecimal (#RRGGBB).',
        ]);

        // Set default color if not provided
        if (empty($validated['color'])) {
            $validated['color'] = '#3B82F6'; // Default blue color
        }

        Category::create([
            'user_id' => auth()->id(),
            'name' => $validated['name'],
            'type' => $validated['type'],
            'color' => $validated['color'],
        ]);

        return redirect()->route('categories.index')
            ->with('success', 'Categoria criada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $category->delete();

        return redirect()->route('categories.index')
            ->with('success', 'Categoria excluída com sucesso!');
    }
}
