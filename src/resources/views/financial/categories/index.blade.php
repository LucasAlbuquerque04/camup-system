@extends('layouts.app')

@section('title', 'Categorias')

@section('sidebar')
    @include('components.sidebar')
@endsection

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Gerenciar Categorias</h1>
        <p class="mt-2 text-gray-600 dark:text-gray-400">Organize seus lançamentos financeiros por categoria</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Category Creation Form -->
        <div class="lg:col-span-1">
            <x-card title="Nova Categoria">
                <form method="POST" action="{{ route('categories.store') }}" id="categoryForm">
                    @csrf
                    
                    <x-input 
                        label="Nome" 
                        name="name" 
                        type="text" 
                        :required="true"
                        placeholder="Ex: Alimentação, Transporte"
                        value="{{ old('name') }}"
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
                            <option value="income" {{ old('type') == 'income' ? 'selected' : '' }}>Receita</option>
                            <option value="expense" {{ old('type') == 'expense' ? 'selected' : '' }}>Despesa</option>
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
                                value="{{ old('color', '#3B82F6') }}"
                                class="h-10 w-20 border border-gray-300 dark:border-gray-600 rounded cursor-pointer"
                            >
                            <span class="text-sm text-gray-600 dark:text-gray-400" id="colorValue">{{ old('color', '#3B82F6') }}</span>
                        </div>
                        @error('color')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <x-button type="submit" variant="primary" class="w-full">
                        Criar Categoria
                    </x-button>
                </form>
            </x-card>
        </div>

        <!-- Categories List -->
        <div class="lg:col-span-2">
            <x-card title="Minhas Categorias">
                @if($categories->isEmpty())
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">Nenhuma categoria</h3>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Comece criando sua primeira categoria.</p>
                    </div>
                @else
                    <div class="space-y-3">
                        @foreach($categories as $category)
                            <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg border border-gray-200 dark:border-gray-600 hover:shadow-md transition">
                                <div class="flex items-center gap-3 flex-1">
                                    <!-- Color Indicator -->
                                    <div 
                                        class="w-4 h-4 rounded-full border-2 border-white dark:border-gray-800 shadow-sm" 
                                        style="background-color: {{ $category->color }}"
                                    ></div>
                                    
                                    <!-- Category Info -->
                                    <div class="flex-1">
                                        <h4 class="font-semibold text-gray-900 dark:text-white">{{ $category->name }}</h4>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">
                                            @if($category->type === 'income')
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                                                    Receita
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400">
                                                    Despesa
                                                </span>
                                            @endif
                                        </p>
                                    </div>
                                </div>

                                <!-- Edit Button -->
                                <a href="{{ route('categories.edit', $category->id) }}" 
                                   class="p-2 text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded-lg transition mr-1"
                                   title="Editar categoria">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>

                                <!-- Delete Button -->
                                <form method="POST" action="{{ route('categories.destroy', $category->id) }}" class="inline delete-form" data-category-name="{{ $category->name }}">
                                    @csrf
                                    @method('DELETE')
                                    <button 
                                        type="submit" 
                                        class="p-2 text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition"
                                        title="Excluir categoria"
                                    >
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                @endif
            </x-card>
        </div>
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
    // SweetAlert2 para confirmação de exclusão
    document.querySelectorAll('.delete-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const categoryName = this.dataset.categoryName;
            
            window.confirmDelete(
                () => this.submit(),
                'Tem certeza?',
                `Deseja excluir a categoria <strong>${categoryName}</strong>?<br>Esta ação não poderá ser revertida!`
            );
        });
    });
    </script>
@endpush
@endsection
