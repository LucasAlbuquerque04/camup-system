@extends('layouts.app')

@section('title', 'Dashboard')

@section('sidebar')
    @include('components.sidebar')
@endsection

@section('content')
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Visão Geral</h1>
        <p class="mt-2 text-gray-600 dark:text-gray-400">Acompanhe suas finanças e metas.</p>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Card 1: Saldo -->
        <x-card>
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Saldo Atual</p>
                    <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">R$ {{ number_format($balance, 2, ',', '.') }}</p>
                </div>
                <div class="p-3 bg-purple-100 dark:bg-purple-900/30 rounded-lg">
                    <svg class="w-8 h-8 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </x-card>

        <!-- Card 2: Receitas -->
        <x-card>
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Receitas (Mês)</p>
                    <p class="mt-2 text-3xl font-bold text-green-600 dark:text-green-400">+ R$ {{ number_format($income, 2, ',', '.') }}</p>
                </div>
                <div class="p-3 bg-green-100 dark:bg-green-900/30 rounded-lg">
                    <svg class="w-8 h-8 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"></path>
                    </svg>
                </div>
            </div>
        </x-card>

        <!-- Card 3: Despesas -->
        <x-card>
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Despesas (Mês)</p>
                    <p class="mt-2 text-3xl font-bold text-red-600 dark:text-red-400">- R$ {{ number_format($expense, 2, ',', '.') }}</p>
                </div>
                <div class="p-3 bg-red-100 dark:bg-red-900/30 rounded-lg">
                    <svg class="w-8 h-8 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6"></path>
                    </svg>
                </div>
            </div>
        </x-card>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content: Recent Transactions -->
        <div class="lg:col-span-2">
            <x-card title="Transações Recentes">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Descrição</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Categoria</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Valor</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($recentTransactions as $transaction)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">{{ $transaction->description }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-400">{{ $transaction->category->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-right {{ $transaction->type == 'income' ? 'text-green-600' : 'text-red-600' }}">
                                        {{ $transaction->type == 'income' ? '+' : '-' }} R$ {{ number_format($transaction->amount, 2, ',', '.') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">Nenhuma transação recente.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </x-card>
        </div>

        <!-- Sidebar Widgets: Quick Actions -->
        <div>
           <x-card title="Ações Rápidas">
                <div class="grid grid-cols-1 gap-4">
                    <x-quick-action href="{{ route('transactions.index') }}" icon="plus-circle">
                        Nova Transação
                    </x-quick-action>
                    <x-quick-action href="{{ route('transactions.index') }}" icon="chart">
                        Ver Transações
                    </x-quick-action>
                    <x-quick-action href="{{ route('categories.index') }}" icon="tag">
                        Gerenciar Categorias
                    </x-quick-action>
                </div>
            </x-card>
        </div>
    </div>
@endsection
