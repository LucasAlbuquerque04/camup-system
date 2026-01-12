@extends('layouts.app')

@section('title', 'Categorias')

@section('sidebar')
    @include('components.sidebar')
@endsection

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- List Categories -->
        <div class="md:col-span-2">
            <x-card title="Suas Categorias">
                <div class="space-y-4">
                    @forelse($categories as $category)
                        <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                            <div class="flex items-center">
                                <div class="w-3 h-3 rounded-full mr-3" style="background-color: {{ $category->color ?? '#ccc' }}"></div>
                                <div>
                                    <p class="font-medium text-gray-900 dark:text-white">{{ $category->name }}</p>
                                    <p class="text-xs text-gray-500 uppercase">{{ $category->type == 'income' ? 'Receita' : 'Despesa' }}</p>
                                </div>
                            </div>
                            <form action="{{ route('categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Tem certeza?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    @empty
                        <p class="text-gray-500 text-center py-4">Nenhuma categoria cadastrada.</p>
                    @endforelse
                </div>
            </x-card>
        </div>

        <!-- Create Category -->
        <div>
            <x-card title="Nova Categoria">
                <form action="{{ route('categories.store') }}" method="POST">
                    @csrf
                    <div class="space-y-4">
                        <x-input label="Nome" name="name" placeholder="Ex: Alimentação" required />

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Tipo</label>
                            <select name="type" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-purple-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                                <option value="expense">Despesa</option>
                                <option value="income">Receita</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Cor</label>
                            <input type="color" name="color" class="w-full h-10 p-1 rounded border border-gray-300 cursor-pointer" value="#6200EA">
                        </div>

                        <x-button type="submit" class="w-full">Adicionar</x-button>
                    </div>
                </form>
            </x-card>
        </div>
    </div>
@endsection
