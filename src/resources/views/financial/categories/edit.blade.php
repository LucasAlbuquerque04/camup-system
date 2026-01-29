@extends('layouts.app')

@section('title', 'Editar Categoria')

@section('sidebar')
    @include('components.sidebar')
@endsection

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Editar Categoria</h1>
        <p class="mt-2 text-gray-600 dark:text-gray-400">Atualize as informações da categoria</p>
    </div>

    <div class="max-w-lg mx-auto">
        <x-card title="Editar Categoria">
            <form method="POST" action="{{ route('categories.update', $category->id) }}" id="categoryForm">
                @csrf
                @method('PUT')
                
                <x-input 
                    label="Nome" 
                    name="name" 
                    type="text" 
                    :required="true"
                    placeholder="Ex: Alimentação, Transporte"
                    value="{{ old('name', $category->name) }}"
                />

                <div class="mb-4">
                    <label for="type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Tipo <span class="text-red-500">*</span>
                    </label>
                    <select 
                        id="type" 
                        name="type" 
                        required
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                    >
                        <option value="">Selecione o tipo</option>
                        <option value="income" {{ old('type', $category->type) == 'income' ? 'selected' : '' }}>Receita</option>
                        <option value="expense" {{ old('type', $category->type) == 'expense' ? 'selected' : '' }}>Despesa</option>
                    </select>
                    @error('type')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="color" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Cor
                    </label>
                    <div class="flex items-center gap-3">
                        <input 
                            type="color" 
                            id="color" 
                            name="color" 
                            value="{{ old('color', $category->color) }}"
                            class="h-10 w-20 border border-gray-300 dark:border-gray-600 rounded cursor-pointer"
                        >
                        <span class="text-sm text-gray-600 dark:text-gray-400" id="colorValue">{{ old('color', $category->color) }}</span>
                    </div>
                    @error('color')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center gap-4">
                    <a href="{{ route('categories.index') }}" class="w-full py-2 px-4 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 text-center transition">
                        Cancelar
                    </a>
                    <x-button type="submit" variant="primary" class="w-full">
                        Salvar Alterações
                    </x-button>
                </div>
            </form>
        </x-card>
    </div>
</div>

@push('scripts')
<script>
    // Update color value display
    const colorInput = document.getElementById('color');
    const colorValue = document.getElementById('colorValue');
    
    if (colorInput && colorValue) {
        colorInput.addEventListener('input', function() {
            colorValue.textContent = this.value.toUpperCase();
        });
    }
</script>
@endpush
@endsection
