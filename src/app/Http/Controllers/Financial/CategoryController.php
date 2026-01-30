<?php

namespace App\Http\Controllers\Financial;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::where('user_id', auth()->id())
            ->orderBy('type')
            ->orderBy('name')
            ->get();

        return view('financial.categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $this->validateCategory($request);

        Category::create([
            'user_id' => auth()->id(),
            ...$validated,
        ]);

        return redirect()->route('categories.index')
            ->with('success', 'Categoria criada com sucesso!');
    }

    public function edit(string $id)
    {
        $category = Category::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        return view('financial.categories.edit', compact('category'));
    }

    public function update(Request $request, string $id)
    {
        $category = Category::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $validated = $this->validateCategory($request, $id);

        $category->update($validated);

        return redirect()->route('categories.index')
            ->with('success', 'Categoria atualizada com sucesso!');
    }

    public function destroy(string $id)
    {
        $category = Category::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $category->delete();

        return redirect()->route('categories.index')
            ->with('success', 'Categoria excluída com sucesso!');
    }

    private function validateCategory(Request $request, ?string $categoryId = null): array
    {
        $request->merge([
            'name' => trim($request->input('name'))
        ]);

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:35',
                'regex:/^[\p{L}0-9\s\-\/\&.,]+$/u',
                Rule::unique('categories', 'name')
                    ->where('user_id', auth()->id())
                    ->ignore($categoryId),
            ],
            'type' => 'required|in:income,expense',
            'color' => 'nullable|regex:/^#[0-9A-Fa-f]{6}$/',
        ], [
            'name.required' => 'O nome da categoria é obrigatório.',
            'name.regex' => 'O nome da categoria não pode conter emojis ou caracteres especiais.',
            'name.max' => 'O nome da categoria deve ter no máximo 35 caracteres.',
            'name.unique' => 'Já existe uma categoria com este nome.',
            'type.required' => 'O tipo da categoria é obrigatório.',
            'type.in' => 'O tipo deve ser Receita ou Despesa.',
            'color.regex' => 'A cor deve estar no formato hexadecimal (#RRGGBB).',
        ]);

        $validated['color'] ??= '#3B82F6';

        return $validated;
    }
}
