@extends('layouts.app')

@section('title', 'Nova Transação')

@section('sidebar')
    @include('components.sidebar')
@endsection

@section('content')
    <div class="max-w-2xl mx-auto">
        <x-card title="Nova Transação">
            <form action="{{ route('transactions.store') }}" method="POST">
                @csrf
                
                <div class="space-y-4">
                    <!-- Type Selection -->
                    <div class="grid grid-cols-2 gap-4">
                        <label class="cursor-pointer">
                            <input type="radio" name="type" value="income" class="peer sr-only" {{ request('type') == 'income' ? 'checked' : '' }}>
                            <div class="p-4 text-center border rounded-lg hover:bg-gray-50 peer-checked:border-green-500 peer-checked:bg-green-50 peer-checked:text-green-700 dark:peer-checked:bg-green-900/20 dark:peer-checked:text-green-400">
                                Receita
                            </div>
                        </label>
                        <label class="cursor-pointer">
                            <input type="radio" name="type" value="expense" class="peer sr-only" {{ request('type') != 'income' ? 'checked' : '' }}>
                            <div class="p-4 text-center border rounded-lg hover:bg-gray-50 peer-checked:border-red-500 peer-checked:bg-red-50 peer-checked:text-red-700 dark:peer-checked:bg-red-900/20 dark:peer-checked:text-red-400">
                                Despesa
                            </div>
                        </label>
                    </div>

                    <x-input label="Descrição" name="description" placeholder="Ex: Salário, Aluguel..." required />

                    <x-input label="Valor (R$)" name="amount" type="number" step="0.01" placeholder="0,00" required />

                    <x-input label="Data" name="date" type="date" value="{{ date('Y-m-d') }}" required />

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Categoria</label>
                        <select name="category_id" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-purple-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                            @if($categories->isEmpty())
                                <option disabled selected>Nenhuma categoria encontrada</option>
                            @endif
                        </select>
                        @if($categories->isEmpty())
                        <p class="mt-1 text-xs text-red-500">Crie uma categoria antes de adicionar uma transação.</p>
                        @endif
                    </div>

                    <div class="flex items-center">
                        <input type="hidden" name="paid" value="0">
                        <input type="checkbox" name="paid" value="1" id="paid" class="rounded border-gray-300 text-purple-600 focus:ring-purple-500" checked>
                        <label for="paid" class="ml-2 text-sm text-gray-700 dark:text-gray-300">Pago / Recebido</label>
                    </div>

                    <div class="pt-4">
                        <x-button type="submit" class="w-full">Salvar Transação</x-button>
                    </div>
                </div>
            </form>
        </x-card>
    </div>
@endsection
